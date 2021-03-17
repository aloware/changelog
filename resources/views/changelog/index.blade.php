@extends('layouts.app')

@section('css')

@endsection

@section('content')
    <changelogs-component unparsed_project="{{ $project }}"></changelogs-component>
@endsection
