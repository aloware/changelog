<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Montserrat', sans-serif !important;
                overflow: hidden;
            }
            .callout {
                padding: 20px;
                margin: 20px 0;
                border: 1px solid #eee;
                border-left-width: 5px;
                border-radius: 3px;
            }
            .callout h4 {
                margin-top: 0;
                margin-bottom: 5px;
            }
            .callout p:last-child {
                margin-bottom: 0;
            }
            .callout code {
                border-radius: 3px;
            }
            .callout + .bs-callout {
                margin-top: -5px;
            }

            .callout-default {
                border-left-color: #777;
            }
            .callout-default h4 {
                color: #777;
            }

            .callout-primary {
                border-left-color: #428bca;
            }
            .callout-primary h4 {
                color: #428bca;
            }

            .callout-success {
                border-left-color: #5cb85c;
            }
            .callout-success h4 {
                color: #5cb85c;
            }

            .callout-danger {
                border-left-color: #d9534f;
            }
            .callout-danger h4 {
                color: #d9534f;
            }

            .callout-warning {
                border-left-color: #f0ad4e;
            }
            .callout-warning h4 {
                color: #f0ad4e;
            }

            .callout-info {
                border-left-color: #5bc0de;
            }
            .callout-info h4 {
                color: #5bc0de;
            }

            .callout-bdc {
                border-left-color: #29527a;
            }
            .callout-bdc h4 {
                color: #29527a;
            }

            .badge {
                display: inline-block;
                padding: .25em .4em;
                font-size: 75%;
                font-weight: 700;
                line-height: 1;
                text-align: center;
                white-space: nowrap;
                vertical-align: baseline;
                border-radius: .25rem;
                transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out
            }
            @media (prefers-reduced-motion:reduce) {
                .badge {
                    transition: none
                }
            }
            a.badge:focus, a.badge:hover {
                text-decoration: none
            }
            .badge:empty {
                display: none
            }
            .btn .badge {
                position: relative;
                top: -1px
            }
            .badge-pill {
                padding-right: .6em;
                padding-left: .6em;
                border-radius: 10rem
            }
            .badge-primary {
                color: #fff;
                background-color: #007bff
            }
            a.badge-primary:focus, a.badge-primary:hover {
                color: #fff;
                background-color: #0062cc
            }
            a.badge-primary.focus, a.badge-primary:focus {
                outline: 0;
                box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .5)
            }
            .badge-secondary {
                color: #fff;
                background-color: #6c757d
            }
            a.badge-secondary:focus, a.badge-secondary:hover {
                color: #fff;
                background-color: #545b62
            }
            a.badge-secondary.focus, a.badge-secondary:focus {
                outline: 0;
                box-shadow: 0 0 0 .2rem rgba(108, 117, 125, .5)
            }
            .badge-success {
                color: #fff;
                background-color: #28a745
            }
            a.badge-success:focus, a.badge-success:hover {
                color: #fff;
                background-color: #1e7e34
            }
            a.badge-success.focus, a.badge-success:focus {
                outline: 0;
                box-shadow: 0 0 0 .2rem rgba(40, 167, 69, .5)
            }
            .badge-info {
                color: #fff;
                background-color: #17a2b8
            }
            a.badge-info:focus, a.badge-info:hover {
                color: #fff;
                background-color: #117a8b
            }
            a.badge-info.focus, a.badge-info:focus {
                outline: 0;
                box-shadow: 0 0 0 .2rem rgba(23, 162, 184, .5)
            }
            .badge-warning {
                color: #212529;
                background-color: #ffc107
            }
            a.badge-warning:focus, a.badge-warning:hover {
                color: #212529;
                background-color: #d39e00
            }
            a.badge-warning.focus, a.badge-warning:focus {
                outline: 0;
                box-shadow: 0 0 0 .2rem rgba(255, 193, 7, .5)
            }
            .badge-danger {
                color: #fff;
                background-color: #dc3545
            }
            a.badge-danger:focus, a.badge-danger:hover {
                color: #fff;
                background-color: #bd2130
            }
            a.badge-danger.focus, a.badge-danger:focus {
                outline: 0;
                box-shadow: 0 0 0 .2rem rgba(220, 53, 69, .5)
            }
            .badge-light {
                color: #212529;
                background-color: #f8f9fa
            }
            a.badge-light:focus, a.badge-light:hover {
                color: #212529;
                background-color: #dae0e5
            }
            a.badge-light.focus, a.badge-light:focus {
                outline: 0;
                box-shadow: 0 0 0 .2rem rgba(248, 249, 250, .5)
            }
            .badge-dark {
                color: #fff;
                background-color: #343a40
            }
            a.badge-dark:focus, a.badge-dark:hover {
                color: #fff;
                background-color: #1d2124
            }
            a.badge-dark.focus, a.badge-dark:focus {
                outline: 0;
                box-shadow: 0 0 0 .2rem rgba(52, 58, 64, .5)
            }

            .text-center {
                text-align: center;
            }

            .changelogs-container {
                height: 84vh;
                overflow-y: auto;
                overflow-x: hidden;
                border-top: 1px solid lightgrey;
                border-bottom: 1px solid lightgrey;
            }

            .mt-10 {
                margin-top: 10px;
            }

            .mt-5 {
                margin-top: 5px;
            }

            .text-muted {
                color: #6c757d !important;
            }

            pre.ql-syntax {
                background: rgba(0,0,0,.05) !important;
                padding: 2px !important;
            }

            .changelogs-container blockquote {
                border-left: 4px solid #ccc;
                margin-bottom: 5px;
                margin-top: 5px;
                padding-left: 16px;
            }

            .ql-indent-1 {
                padding-left: 3rem;
            }

            img {
                max-width: 100%;
                height: auto;
            }

            .header-label {
                margin: 10px 0;
            }
        </style>
    </head>
    <body>
        <div id="app">
            <h6 class="text-center header-label">Latest Changes</h6>
            <div class="changelogs-container">
                @foreach($project->published()->limit($project->widget_entry_limit)->get() as $changelog)
                    <published-changelog-widget-component :changelog="{{ $changelog }}"></published-changelog-widget-component>
                @endforeach
            </div>
            <h6 class="text-center mt-1" style="font-size: 0.75rem;"><a href="/{{$project->slug}}/changelogs" class="text-muted" target="_blank">Read more...</a></h6>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/quill-image-resize-vue@1.0.4/image-resize-vue.min.js"></script>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
