<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="background: #cccccc">
<div style="background:#fff; width:100%;margin:auto; word-break: break-all">
    <div style="padding:20px">
        <p>{{ $data['first_name'] }}様</p>
        <p>{{ $emailTemplate->header }}</p>
        <p>{!! str_replace('{url}',
                            \App\Helpers\UrlHelper::getChangeForgotPasswordUrl($data),
                            \App\Helpers\StringHelper::formatContent($emailTemplate->content) ) !!}</p>
        <p>{!! \App\Helpers\StringHelper::formatContent($emailTemplate->contact) !!}</p>
    </div>
</div>
</body>
</html>
