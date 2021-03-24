<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <style>
            body {
                overflow: hidden;
            }
        </style>
    </head>
    <body>
        <div id="app">
            <published-changelog-widget-component :project="{{ $project }}" :changelogs="{{ $changelogs }}"></published-changelog-widget-component>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/quill-image-resize-vue@1.0.4/image-resize-vue.min.js"></script>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
