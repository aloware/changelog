<template>
    <div>
        <b-form @submit.stop.prevent="submitForm">
            <b-form-group
                label="Background color"
            >
                <v-swatches
                    v-model="category.bg_color"
                    show-fallback
                    fallback-input-type="color"
                    popover-x="right"
                ></v-swatches>
            </b-form-group>

            <b-form-group
                label="Text color"
            >
                <v-swatches
                    v-model="category.text_color"
                    show-fallback
                    fallback-input-type="color"
                    popover-x="right"
                ></v-swatches>
            </b-form-group>

            <b-form-group label="Label">
                <b-form-input
                    v-model="category.label"
                    placeholder="Label"
                    required
                ></b-form-input>
            </b-form-group>

            <b-button type="submit" variant="primary" :disabled="submissionInProgress">
                <font-awesome-icon :icon="['fas', 'check']" v-if="!submissionInProgress" />
                <b-spinner small v-if="submissionInProgress" ></b-spinner>
                {{ submissionInProgress ? 'Please wait..' : 'Submit' }}
            </b-button>
            <b-button type="button" variant="danger" v-on:click="cancelForm" :disabled="submissionInProgress">
                <font-awesome-icon :icon="['fas', 'times']"/>
                Cancel
            </b-button>
        </b-form>
        <hr/>
    </div>
</template>

<script>
    import VSwatches from 'vue-swatches'
    import 'vue-swatches/dist/vue-swatches.css'
    import { mapGetters, mapActions } from 'vuex'
    import { error_handling_mixin } from '../mixins'

    export default {
        name: "CategoryFormComponent",
        mixins: [error_handling_mixin],
        props : {
            companyid : String,
        },
        components: { VSwatches },
        computed : {
            ...mapGetters(['category'])
        },
        data : function(){
            return {
                submissionInProgress : false
                // bg_color : '#A463BF',
                // text_color : '#fff',
                // label : ''
            }
        },
        methods : {
            ...mapActions(['storeCategory', 'updateCategory']),
            cancelForm : function(){
                this.$store.commit('cancelCategoryForm', this.$store.state);
            },
            submitForm : function(){
                this.submissionInProgress = true;
                if (this.category.id) {
                    this.updateCategory(this.category).then(response => {
                        this.handleErrors(response);
                    }).catch(error => {
                        this.handleSubmissionFailure(error);
                    }).then(() => {
                        this.submissionInProgress = false;
                    });
                } else {
                    this.category.company_id = this.companyid
                    this.storeCategory(this.category).then(response => {
                        this.handleErrors(response);
                    }).catch(error => {
                        this.handleSubmissionFailure(error);
                    }).then(() => {
                        this.submissionInProgress = false;
                    });
                }
            },
        },
        mounted (){

        },
    }
</script>

<style scoped>

</style>
