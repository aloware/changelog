@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 5rem;">
    <div class="row">
        <div class="col-md-12">
            <h4>Overview</h4>
            <hr/>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card card-stats mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">
                                Projects
                            </h5>
                            <span class="h2 font-weight-bold mb-0">
                           {{ $user->company->projects->count() }}
                        </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape text-white rounded-circle shadow bg-gradient-red">
                                <i class="ni ni-active-40">
                                </i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2">

                    </span>
                        <span class="text-nowrap">
                    </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card card-stats mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">
                                Changelogs
                            </h5>
                            <span class="h2 font-weight-bold mb-0">
                            {{ $user->company->getChangelogsCount() }}
                        </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape text-white rounded-circle shadow bg-gradient-orange">
                                <i class="ni ni-chart-pie-35">
                                </i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2">
                    </span>
                        <span class="text-nowrap">

                    </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
