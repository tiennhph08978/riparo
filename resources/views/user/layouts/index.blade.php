@extends('user.layouts.default')

@section('title', 'Home Title')

@section('head')

@endsection

@section('bread-crumb')
    <div class="bread-crumb">
        @foreach(['ホームページ' => 'path', 'イベント会社「JUMP」の設立 ' => 'path'] as $page => $link)
            <span>
                <a href="{{$link}}">{{$page}}</a>
            </span>
            ・
        @endforeach
    </div>
@endsection
@section('banner')
    <div class="banner">
        <img src="https://th.bing.com/th/id/OIP.EZbCDLhugsUfbpEWktI7bQHaE3?pid=ImgDet&rs=1">
    </div>
@endsection
@section('content')
    <p>This is my body content.</p>
@endsection
