<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $project->name }} | {{ $project->getTerminology() }}</title>

        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Montserrat', sans-serif !important;
            }

            .branding-text {
                margin-left: 56px;
                margin-top: -48px;
            }

            @media (max-width: 576px) {
                .branding-text {
                    font-size: 0.95rem;
                }
            }
        </style>
    </head>
    <body>
        <div id="app">
            <b-navbar id="navbar" type="light" variant="light" v-bind:sticky="true">
                <b-navbar-brand class="d-md-none">
                    <img class="navbar-logo" src="../img/logo/tryvium.png" alt="Tryvium Logo" height="50" width="50">
                    <div class="branding-text">
                        {{ $project->name }} <small class="text-muted">changelog</small><br/>
                        <small class="text-muted">{{ $project->url }}</small>
                    </div>
                </b-navbar-brand>

                <b-collapse id="collapse-area" is-nav="">
                    <b-navbar-nav class="d-none d-md-block mx-auto">
                        <b-nav-text>
                            <img class="navbar-logo" src="../img/logo/tryvium.png" alt="Tryvium Logo" height="50" width="50">
                            <div class="branding-text">
                                {{ $project->name }} <small class="text-muted">changelog</small><br>
                                <small class="text-muted"><a href="{{ $project->url }}">{{ $project->url }}</a></small>
                            </div>
                        </b-nav-text>
                    </b-navbar-nav>
                </b-collapse>
            </b-navbar>
            <published-changelog-component project="{{ $project }}" initial_data="{{ $project->published()->paginate(\App\Models\Project::DEFAULT_CHANGELOG_LIST_COUNT)->toJson() }}"></published-changelog-component>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/quill-image-resize-vue@1.0.4/image-resize-vue.min.js"></script>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
