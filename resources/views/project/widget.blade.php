@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <b-card no-body>
                    <b-tabs pills card vertical>
                        <b-tab title="Basic Widget Usage" active>
                            <h5>Basic Widget Usage</h5>
                            <hr>
                            <p>
                                Paste the code anywhere on your website (preferably HEAD or before closing BODY tag).
                            </p>
                            <b-card>

                                    &lt;script&gt;
                                <br/>&emsp;let changelog_config = {
                                <br/> &emsp;&emsp;       uuid : 'PROJECT_UUID',
                                <br/> &emsp;&emsp;}
                                <br/>&lt;/script&gt;
                                <br/>&lt;script async src="http://localhost/js/widget.js"&gt;&lt;/script&gt;

                            </b-card>
                            <br>
                            <p>
                                For example, if you have a DOM container like below
                            </p>
                            <b-card>
                                &lt;div class="cl-container"&gt;&lt;/div&gt;
                            </b-card>
                            <br>
                            <p>
                                You can set the code to inject the badge in the div container with class cl-container:
                            </p>

                            <b-card>
                                <br/>&emsp;let changelog_config = {
                                <br/> &emsp;&emsp;        container : '.cl-container',
                                <br/> &emsp;&emsp;       uuid : 'PROJECT_UUID',
                                <br/> &emsp;&emsp;&emsp;       translations : {
                                <br/> &emsp;&emsp;&emsp;&emsp;          placeholderLabel : 'Release Notes',
                                <br/> &emsp;&emsp;&emsp;    },
                                <br/> &emsp;&emsp;}
                            </b-card>

                            <br>
                            <h6>
                                Options
                            </h6>
                            <hr/>
                            <ul>
                                <li><i>uuid</i> (required) - your project uuid.</li>
                                <li><i>container</i> - CSS Selector where the badge can be injected. Please note that skipping this option would make the badge injected into the BODY.</li>
                                <li><i>triggerElement</i> - CSS Selector that would trigger display of the widget.</li>
                                <li><i>translations</i> - see Translations below.</li>
                            </ul>
                            <h6>
                                Widget text translations
                            </h6>
                            <hr/>
                            <ul>
                                <li><i>placeholderLabel</i> - text label beside the badge.</li>
                                <li><i>headerLabel</i> - replaces the widget's header label.</li>
                            </ul>
                            <b-card>
                                <br/>&emsp;let changelog_config = {
                                <br/> &emsp;&emsp;        container : '.cl-container',
                                <br/> &emsp;&emsp;       uuid : 'PROJECT_UUID',
                                <br/> &emsp;&emsp;&emsp;       translations : {
                                <br/> &emsp;&emsp;&emsp;&emsp;          placeholderLabel : 'Release Notes',
                                <br/> &emsp;&emsp;&emsp;&emsp;          headerLabel : 'Latest News',
                                <br/> &emsp;&emsp;&emsp;    },
                                <br/> &emsp;&emsp;}
                            </b-card>
                        </b-tab>
                    </b-tabs>
                </b-card>
            </div>
        </div>
    </div>
@endsection
