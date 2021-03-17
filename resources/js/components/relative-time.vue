<template>
    <span v-html="relative_time"></span>
</template>

<script>
    export default {
        name: "RelativeTimeComponent",
        props : {
            from_time: {
                type: String,
                required: true
            },

            update_interval: {
                type: Number,
                required: false,
                default: 1000
            },

            humanized: {
                type: Boolean,
                required: false,
                default: false
            }
        },
        data : function(){
            return {
                relative_time : null
            }
        },
        created() {
            this.getRelativeTime();
            setInterval(this.getRelativeTime, this.update_interval);
        },
        destroyed() {
            clearInterval(this.getRelativeTime);
        },
        methods : {
            getRelativeTime(){
                if (this.humanized) {
                    this.relative_time = this.$options.filters.fixDurationHumanize(this.from_time) + ' ago'
                } else {
                    this.relative_time = this.$options.filters.fixDurationUTCRelative(this.from_time)
                }
            }
        }
    }
</script>

<style scoped>

</style>
