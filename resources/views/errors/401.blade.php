@extends('errors.illustrated-layout')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', $exception->getMessage() ?? __('Unauthorized'))
