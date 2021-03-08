@extends('layouts.app')

@section('css')

@endsection

@section('content')
    <div class="container mt-5">
        <b-tabs pills card vertical>
            <b-tab title="Company" active><b-card-text>Public Page</b-card-text></b-tab>
            <b-tab title="Public Page" active><b-card-text>Public Page</b-card-text></b-tab>
            <b-tab title="Widget"><b-card-text>Widget</b-card-text></b-tab>
            <b-tab title="Categories"><b-card-text>Categories</b-card-text></b-tab>
        </b-tabs>
    </div>
@endsection
