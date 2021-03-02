@extends('layouts.app')

@section('content')
    <changelogs-component companyId="{{ $user->company->id }}" projectUuid="{{ $project->uuid }}"></changelogs-component>
@endsection
