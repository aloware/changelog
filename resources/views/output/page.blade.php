<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $project->name }} | {{ $project->getTerminology() }}</title>
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <b-navbar id="navbar" type="light" variant="light" v-bind:sticky="true">
                <b-navbar-brand class="d-md-none">
                    <div class="branding-text">
                        <div>
                            @if($project->logo)
                                <img class="navbar-logo" src="{{ route('project-logo', ['uuid' => $project->uuid, 'filename' => $project->logo]) }}" alt="Logo" height="50" width="50">
                            @endif
                        </div>
                        <div class="details-container">
                            {{ $project->name }} <small class="text-muted">changelog</small><br>
                            <small class="text-muted"><a href="{{ $project->url }}">{{ $project->url }}</a></small>
                        </div>
                    </div>
                </b-navbar-brand>

                <b-collapse id="collapse-area" is-nav="">
                    <b-navbar-nav class="d-none d-md-block mx-auto">
                        <b-nav-text>
                            <div class="branding-text">
                                <div>
                                    @if($project->logo)
                                        <img class="navbar-logo" src="{{ route('project-logo', ['uuid' => $project->uuid, 'filename' => $project->logo]) }}" alt="Logo" height="50" width="50">
                                    @endif
                                </div>
                                <div class="details-container">
                                    {{ $project->name }} <small class="text-muted">changelog</small><br>
                                    <small class="text-muted"><a href="{{ $project->url }}">{{ $project->url }}</a></small>
                                </div>
                            </div>
                        </b-nav-text>
                    </b-navbar-nav>
                </b-collapse>
            </b-navbar>
            <published-changelog-page-list-component project="{{ $project }}"></published-changelog-page-list-component>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/quill-image-resize-vue@1.0.4/image-resize-vue.min.js"></script>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
