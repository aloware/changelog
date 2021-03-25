@extends('layouts.app')
@section('title', $project->id ? 'Project Settings | ' . $project->name . ' | ' : 'Add Project | ')
@section('css')

@endsection

@section('content')
    <div class="container mt-5">
        <project-settings-component company_id="{{ $user->company_id }}" project_data="{{ $project }}"></project-settings-component>
    </div>
@endsection
