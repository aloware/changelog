@extends('layouts.app')

@section('css')

@endsection

@section('content')
    <changelogs-component companyId="{{ $user->company->id }}" projectUuid="{{ $project->uuid }}"></changelogs-component>
@endsection
