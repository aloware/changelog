@extends('layouts.app')

@section('title', 'Categories | ')
@section('css')

@endsection

@section('content')
    <div class="container mt-5">
        <categories-component companyId="{{ $company->id }}" lists="{{ $company->categories }}"></categories-component>
    </div>
@endsection
