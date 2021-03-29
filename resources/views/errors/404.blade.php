@extends('errors.illustrated-layout')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __($exception->getMessage() ?: 'The requested resource is not available or not found.'))
