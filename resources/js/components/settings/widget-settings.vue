<template>
    <div>
        <h5>Widget</h5>
        <hr/>
        <b-form>
            <b-form-group>
                <h6>Your widget code</h6>
                <b-card class="pb-5">
                    <b-card-text>
                        <code>
                            &lt;script&gt;
                            <br/>  let changelog_config = {
                            <br/>&emsp;     container : '__REPLACE_WITH_YOUR_WIDGET_DOM_CONTAINER', // optional - default to body
                            <br/>&emsp;        uuid : {{ projectuuid }},
                            <br/>&emsp;        translations : {
                            <br/>&emsp;&ensp;        placeholderLabel : 'Release Notes',
<!--                            <br/>&emsp;&ensp;       position : 'cl_bottom'-->
                            <br/>&emsp;        }
                            <br/>    }
                            <br/>&lt;/script&gt;
                            <br/>&lt;script async src="http://localhost/js/widget.js"&gt;&lt;/script&gt;
                            <br/>
                        </code>
                    </b-card-text>
                </b-card>
            </b-form-group>


            <b-form-group
                label="Color accent"
            >
                <v-swatches
                    v-model="form.color"
                    show-fallback
                    fallback-input-type="color"
                    popover-x="right"
                ></v-swatches>
            </b-form-group>

            <b-form-group label="Entries Limit">
                <b-form-input
                    v-model="form.limit"
                    placeholder="No. of changelogs to be shown per page"
                    required
                ></b-form-input>
            </b-form-group>

            <b-button type="submit" variant="primary">Submit</b-button>
        </b-form>
    </div>
</template>

<script>
import VSwatches from 'vue-swatches'
import 'vue-swatches/dist/vue-swatches.css'
export default {
    name: "WidgetComponent",
    props : {
        projectuuid : String,
    },
    components: { VSwatches },
    data : function(){
        return {
            form : {
                color : '#A463BF',
                limit : 5
            }
        }
    },
    mounted (){
    }
}
</script>

<style scoped>

</style>
