<template>
    <div>
        <div class="mb-2">
            <h5>Basic Widget Usage</h5>
            <hr>
            <p>
                Paste the code anywhere on your website (preferably HEAD or before closing BODY tag).
            </p>
            <div class="highlighter-container">
                <div class="content-copy">
                    <b-button variant="light" size="sm" v-on:click="copyBasicCode">
                        <font-awesome-icon :icon="['far', 'copy']" />
                    </b-button>
                </div>
                <vue-code-highlight language="javascript" class="basic-code">
                    <pre>
                        <code>
&lt;script&gt;
    let changelog_config = {
         uuid : '{{ project.uuid }}'
    }
&lt;/script&gt;
&lt;script async src="{{ serverUrl }}/js/widget.js" id="cl-script"&gt;&lt;/script&gt;
                        </code>
                    </pre>
                </vue-code-highlight>
                <i>The code above will inject the badge right into the BODY element.</i>
            </div>

            <br>
            <p>
                If you prefer to have a badge injected into a DOM container, you can add <code>container</code> option like below.
            </p>
            <vue-code-highlight language="javascript" class="basic-code">
                <pre>
                    <code>
&lt;div class="cl-container"&gt;&lt;/div&gt;

&lt;script&gt;
    let changelog_config = {
        container : '.cl-container',
        uuid : '{{ project.uuid }}'
    }
&lt;/script&gt;
&lt;script async src="{{ serverUrl }}/js/widget.js" id="cl-script"&gt;&lt;/script&gt;
                    </code>
                </pre>
            </vue-code-highlight>

            <br>
            <p>
                To place a label beside the badge, you can set the translations <code>placeholderLabel</code> value like below.
            </p>

            <vue-code-highlight language="javascript" class="basic-code">
                <pre>
                    <code>
&lt;div class="cl-container"&gt;&lt;/div&gt;

&lt;script&gt;
    let changelog_config = {
        container : '.cl-container',
        uuid : '{{ project.uuid }}',
        translations : {
            placeholderLabel : 'Release Notes'
        }
    }
&lt;/script&gt;
&lt;script async src="{{ serverUrl }}/js/widget.js" id="cl-script"&gt;&lt;/script&gt;
                    </code>
                </pre>
            </vue-code-highlight>
            <br>
            <p>
                You can also set the <code>triggerElement</code> option if you prefer to have an external selector to trigger the widget.
                Please take note that the widget will now be anchored to the trigger element and would also totally ignore the badge, <code>container</code> and the <code>placeholderLabel</code> option.
            </p>

            <vue-code-highlight language="javascript" class="basic-code">
                <pre>
                    <code>
&lt;i class="fa fa-bell"&gt;&lt;/i&gt;

&lt;script&gt;
    let changelog_config = {
        uuid : '{{ project.uuid }}',
        triggerElement : '.fa-bell'
    }
&lt;/script&gt;
&lt;script async src="{{ serverUrl }}/js/widget.js" id="cl-script"&gt;&lt;/script&gt;
                    </code>
                </pre>
            </vue-code-highlight>

            <br>
            <h6>
                Options
            </h6>
            <hr/>
            <ul>
                <li><i>uuid</i> (required) - your project uuid.</li>
                <li><i>container</i> - CSS Selector where the badge can be injected. Please note that skipping this option would make the badge injected into the BODY.</li>
                <li><i>triggerElement</i> - CSS Selector that would trigger display of the widget. <i>Enabling this option would totally ignore <code>container</code> and <code>placeholderLabel</code> option.</i></li>
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

            <vue-code-highlight language="javascript" class="basic-code">
                <pre>
                    <code>
&lt;div class="cl-container"&gt;&lt;/div&gt;
&lt;script&gt;
    let changelog_config = {
        container : '.cl-container',
        uuid : '{{ project.uuid }}',
        translations : {
            placeholderLabel : 'Release Notes',
            headerLabel : 'Latest News',
        }
    }
&lt;/script&gt;
&lt;script async src="{{ serverUrl }}/js/widget.js" id="cl-script"&gt;&lt;/script&gt;
                    </code>
                </pre>
            </vue-code-highlight>
        </div>
    </div>
</template>

<script>
import { component as VueCodeHighlight } from 'vue-code-highlight';
import "vue-code-highlight/themes/duotone-sea.css";
import "vue-code-highlight/themes/window.css";
export default {
    name: "WidgetComponent",
    props : {
        project : Object,
    },
    components: { VueCodeHighlight },
    data : function(){
        return {
            form : {
                color : '#A463BF',
                limit : 5
            },
            serverUrl : location.origin
        }
    },
    methods : {
        copyBasicCode : function(){
            let container = document.querySelector('.basic-code').firstElementChild;
            this.$copyText(container.firstElementChild.innerText).then(e => {
                this.$toastr.s("Success", 'Copied to the clipboard.');
            }, e => {
                this.$toastr.s("Success", 'Unable to copy to the clipboard.');
            });
        }
    },
    mounted (){
    }
}
</script>

<style scoped>
    .highlighter-container {
        position: relative;
    }

    .content-copy {
        display: block;
        position: absolute;
        right: 10px;
        top: 16px;
    }

    .highlighter pre {
        width: 100%;
    }
</style>
<style>
    div pre[class*="language-"] {
        width: 100%;
    }
</style>
