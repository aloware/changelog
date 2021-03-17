let error_handling_mixin = {
    methods : {
        handleErrors : function(response) {
            if ( typeof response !== 'undefined') {
                let message = '';
                switch (true) {
                    case response.data.status === 'error' && response.status === 200 :
                        message = response.data.message;
                        break;
                    default:
                }

                this.$toastr.e("Error", response.data.message);
            }
        },
        handleSubmissionFailure : function(error){
            this.$toastr.e("Error", Object.values(error.response.data.errors)[0][0]);
        }
    }
}

export {
    error_handling_mixin
}
