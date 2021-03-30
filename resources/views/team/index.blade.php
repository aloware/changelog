@extends('layouts.app')
@section('title', 'Team Management | ')

@section('content')
    <div class="container mt-5">
        <team-list-component :user_data="{{ $user->teammates() }}"></team-list-component>
    </div>
@endsection
