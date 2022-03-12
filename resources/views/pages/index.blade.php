@extends('layouts/layout')

@section('content')
    <h1>index</h1>
    @if(session('manager'))
        歡迎， {{session('manager')}}
        <a href="logout">登出</a>
    @else
        <a href="{{ route('loginPage')}}">登入</a>
        <a href="{{ route('register')}}">註冊</a>
    @endif
@stop