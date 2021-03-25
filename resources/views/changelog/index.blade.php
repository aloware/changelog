@extends('layouts.app')
@section('title', 'Changelogs | ' . $project->name . ' | ')
@section('css')

@endsection

@section('content')
    <changelogs-component unparsed_project="{{ $project }}"></changelogs-component>
@endsection
