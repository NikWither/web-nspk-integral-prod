@extends('layouts.app')

@section('body_class', trim('with-sidebar ' . $__env->yieldContent('extra_body_class', '')))

@section('sidebar')
    @yield('sidebar-content')
@endsection
