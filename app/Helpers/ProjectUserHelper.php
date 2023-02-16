<?php

namespace App\Helpers;

use App\Models\ProjectUser;

class ProjectUserHelper
{
    /**
     * @param int $status
     * @return string|void
     */
    public static function getClassColor(int $status)
    {
        if ($status === ProjectUser::STATUS_PENDING) {
            return 'approved-color';
        }

        if ($status === ProjectUser::STATUS_WAITING_INTERVIEW) {
            return 'warning-color';
        }

        if ($status === ProjectUser::STATUS_APPROVED) {
            return 'start-color';
        }

        if ($status === ProjectUser::STATUS_END) {
            return 'end-color';
        }

        return '';
    }

    /**
     * @param int $status
     * @param array $industryValue
     * @return mixed|string
     */
    public static function getStatusStr($status)
    {
        $statusValue = config('master_data.m_project_users');
        if (isset($statusValue[$status])) {
            return $statusValue[$status];
        }

        return '';
    }

    /**
     * @param int $status
     * @return string|null
     */
    public static function getResult(int $status)
    {
        if ($status === ProjectUser::STATUS_END) {
            return trans('my-page.result');
        }

        return '';
    }
}
