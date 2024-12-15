@extends('admin.layout.app')
@section('title')
    @lang('nav.dashboard')
@endsection
@section('content')
    @if (auth('admin')->user()->getRoleNames()[0] == 'Super Admin')
        admin
    @elseif(auth('admin')->user()->getRoleNames()[0] == 'Supervisor')
        supervisor
    @endif
@endsection
