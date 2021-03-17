<template>
    <div>
        <h5>Public Page</h5>
        <hr/>
        <b-form>
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

            <b-form-group id="input-group-2" label="URL">
                <b-form-input
                    v-model="form.url"
                    placeholder="Changelog Page URL"
                    required
                    disabled
                ></b-form-input>
            </b-form-group>

            <b-form-group label="Entries Per Page Limit">
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
        name: "PageComponent",
        props : {
            projectuuid : String,
        },
        components: { VSwatches },
        data : function(){
            return {
                form : {
                    color : '#A463BF',
                    url : '',
                    limit : 5
                }
            }
        },
        mounted (){
            this.form.url  = '/' + this.projectuuid + '/changelogs'
        }
    }
</script>

<style scoped>

</style>
