@extends('layouts.app')
@section('title', 'Profile Settings | ')
@section('css')

@endsection

@section('content')
    <div class="container mt-5">
        <user-profile-component user_data="{{ $user }}"></user-profile-component>
    </div>
@endsection
