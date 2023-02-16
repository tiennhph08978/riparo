<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $mailTemplate['header'] }}</title>
</head>
<body style="background: #cccccc">
<div style="background:#fff; width:100%;margin:auto; word-break: break-all">
    <div style="padding:20px">
        @if (array_search($mailTemplate['id'], \App\Models\Email::MAIL_ADMIN) === false)
            <p>{{ $data['first_name'] }}様</p>
            <p>{!! \App\Helpers\StringHelper::formatContent($mailTemplate['header']) !!}</p>
        @endif
        <p style="white-space: pre;">{!! $mailTemplate['content'] !!}</p>
        @if($mailTemplate['contact'])
            <p style="white-space: pre;">{!! $mailTemplate['contact'] !!}</p>
        @endif
    </div>
</div>
</body>
</html>
