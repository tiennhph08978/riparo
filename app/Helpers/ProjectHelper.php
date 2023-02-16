<?php

namespace App\Helpers;

use App\Models\ProjectUser;
use Carbon\Carbon;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use App\Models\Project;

class ProjectHelper
{
    /**
     * @param int $industryType
     * @return mixed|void
     */
    public static function getIndustry(int $industryType)
    {
        $industryValue = config('master_data.industries');
        if (isset($industryValue[$industryType])) {
            return $industryValue[$industryType];
        }

        return '';
    }

    /**
     * @param int $status
     * @return string|void
     */
    public static function getClassColor(int $status)
    {
        if ($status === Project::STATUS_RECRUITING) {
            return 'approved-color';
        }

        if ($status === Project::STATUS_PENDING) {
            return 'warning-color';
        }

        if ($status === Project::STATUS_ACTIVE) {
            return 'start-color';
        }

        if ($status === Project::STATUS_END) {
            return 'end-color';
        }

        return '';
    }

    /**
     * @param int $status
     * @return mixed|void
     */
    public static function getStatusStr(int $status)
    {
        $statusValue = config('master_data.m_projects');

        if (isset($statusValue[$status])) {
            return $statusValue[$status];
        }

        return '';
    }

    /**
     * @param int $status
     * @param int|null $result
     * @return mixed|string
     */
    public static function getResult($status, $result)
    {
        $resultValue = config('master_data.results');

        if ($result === Project::RESULT_DISSOLUTION && $status === Project::STATUS_END) {
            return $resultValue[$result];
        }

        if ($result === Project::RESULT_LEGALIZATION && $status === Project::STATUS_END) {
            return $resultValue[$result];
        }

        return '';
    }

    /**
     * True is 7 days ago
     *
     * @param $project
     * @return bool
     */
    public static function isNew($project)
    {
        if ($project->start_date) {
            $time = $project->start_date;
        } else {
            return false;
        }

        if (now()->diffInDays($time) < config('validate.date_is_new')) {
            return true;
        }

        return false;
    }

    /**
     * Get role in project
     *
     * @param $project
     * @param $user
     * @return int
     */
    public static function getProjectRole($project, $user)
    {
        if ($project->user_id == $user->id) {
            return ProjectUser::ROLE_OWNER;
        }

        $member = $project->projectUsers
            ->where('user_id', $user->id)
            ->whereIn('status', [ProjectUser::STATUS_PENDING, ProjectUser::STATUS_WAITING_INTERVIEW, ProjectUser::STATUS_APPROVED])
            ->count();
        if ($member) {
            return ProjectUser::ROLE_MEMBER;
        }

        return ProjectUser::ROLE_GUEST;
    }

    /**
     * Get role name
     *
     * @param $roleType
     * @return Repository|Application|mixed
     */
    public static function getRoleName($roleType)
    {
        return config('project.role.' . $roleType);
    }

    /**
     * Get total turnover or cost
     *
     * @param $data
     * @return float|int
     */
    public static function getTurnoverOrCost($data)
    {
        $total = 0;

        if (!count($data)) {
            return $total;
        }

        foreach ($data as $item) {
            $total += $item->quantity * $item->unit_price;
        }

        return $total;
    }

    /**
     * Get project profit
     *
     * @param $projectTurnover
     * @param $projectCost
     * @return float|int
     */
    public static function getProfit($projectTurnover, $projectCost)
    {
        $turnover = ProjectHelper::getTurnoverOrCost($projectTurnover);
        $cost = ProjectHelper::getTurnoverOrCost($projectCost);

        return $turnover - $cost;
    }

    /**
     * Convert date to date japan
     *
     * @param $date
     * @return string
     */
    public static function convertDateToJapan($date)
    {
        $date = Carbon::parse($date);

        return $date->format('Y') . '年' . $date->format('m') . '月' . $date->format('d') . '日';
    }

    public static function formatId($id)
    {
        return str_pad($id, 5, '0', STR_PAD_LEFT);
    }

    public static function substrWords($body, $maxLength)
    {
        $chars = mb_str_split($body);
        $response = '';
        foreach ($chars as $key => $item) {
            if ($key + 1 <= $maxLength) {
                $response .= $item;
            }
        }
        if (count($chars) > $maxLength) {
            $response .= '...';
        }

        return $response;
    }

    public static function countMember($projectId, $status)
    {
        if ($status === Project::STATUS_PENDING) {
            return 1;
        }

        $countMember =  ProjectUser::query()
            ->with('projects')
            ->where('status', '!=', ProjectUser::STATUS_PENDING)
            ->where('project_id', $projectId)
            ->count();

        return ++$countMember;
    }

    /**
     * Get total profit
     *
     * @param $project
     * @return bool
     */
    public static function getTotalProfit($project)
    {
        $totalCost = 0;
        $totalTurnover = 0;
        $totalProfit = 0;
        $target = $project->target_amount;

        foreach ($project->costs as $cost) {
            $totalCost += $cost->quantity * $cost->unit_price;
        }

        foreach ($project->turnovers as $turnover) {
            $totalTurnover += $turnover->quantity * $turnover->unit_price;
        }

        $totalProfit = $totalTurnover - $totalCost;

        if ($totalProfit >= $target) {
            return true;
        }

        return false;
    }

    public static function getDissolutionAndLegalization($project)
    {
        $totalCost = 0;
        foreach ($project->costs as $cot) {
            $totalCost += ($cot->quantity * $cot->unit_price);
        }

        $totalTurnOver = 0;
        foreach ($project->turnovers as $turnover) {
            $totalTurnOver += ($turnover->quantity * $turnover->unit_price);
        }

        $profit = $totalTurnOver - $totalCost;
        if ($project->status === Project::STATUS_END) {
            if ($profit >= $project->target_amount) {
                return trans('my-page.information_table.legalization');
            }

            return trans('my-page.information_table.dissolution');
        }

        return '';
    }
}
