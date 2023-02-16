<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $mailTemplate->header }}</title>
</head>
<body style="background: #cccccc">
<div style="background:#fff; width:100%;margin:auto; word-break: break-all">
    <div style="padding:20px">
        <p>{{ $data['first_name'] }}様</p>
        <p>{!! \App\Helpers\StringHelper::formatContent($mailTemplate->header) !!}</p>
        <p>{!! str_replace(['{no}','{url}'],
                            [\App\Helpers\ProjectHelper::formatId($project->id),\App\Helpers\UrlHelper::getProjectlink($project)],
                            \App\Helpers\StringHelper::formatContent($mailTemplate->content) ) !!}</p>
        <p>{!! \App\Helpers\StringHelper::formatContent($mailTemplate->contact) !!}</p>
    </div>
</div>
</body>
</html>
