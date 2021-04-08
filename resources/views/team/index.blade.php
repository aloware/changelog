@extends('layouts.app')
@section('title', 'Team Management | ')

@section('content')
    <div class="container mt-5">
        <team-list-component :users_data="{{ $user->teammates() }}" :auth_user="{{ $user }}"></team-list-component>
    </div>
@endsection
