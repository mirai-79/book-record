@extends('errors::minimal')

@section('title', __('無許可'))
@section('code', '401')
@section('message', __('アクセス権がない、または認証に失敗しています。'))
