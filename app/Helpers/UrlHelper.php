<?php

namespace App\Helpers;

class UrlHelper
{
    /**
     * Get project url
     *
     * @param $project
     * @return string
     */
    public static function getProjectUrl($project)
    {
        return route('user.project.detail', [$project, rawurlencode($project->title)]);
    }

    public static function getChangeForgotPasswordUrl($data)
    {
        $url = route('user.auth.get_view_rest_password', ['token' => $data['token'], 'email' => $data['email']]);
        $html = '<a href="' . $url . '">'. $url .'</a>';

        return $html;
    }

    public static function getProjectlink($project)
    {
        $link = route('user.project.detail', [$project, rawurlencode($project->title)]);
        $html = '<a href="' . $link . '">'. $link .'</a>';

        return $html;
    }

    public static function getProjectAdminlink($project)
    {
        $link = route('admin.projects.detail', $project);
        $html = '<a href="' . $link . '">'. $link .'</a>';

        return $html;
    }
}
