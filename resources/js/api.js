import axios from "axios";

export default {
    changelog : {
        index : function(projectUuid){
            return axios.get("/api/" + projectUuid + "/changelogs");
        },
        published : function(projectUuid, nextPage){
            return axios.get("/api/" + projectUuid + "/published/changelogs" + nextPage );
        },
        store : function(uuid, changelog){
            return axios.post("/project/" + uuid + "/changelogs", changelog);
        },
        update : function(id, changelog){
            return axios.put("/project/changelogs/" + id, changelog);
        },
        delete : function(id){
            return axios.delete("/project/changelogs/" + id);
        },
        uploadImage : function(uuid, formData){
            return axios.post( '/project/'+ uuid +'/changelogs/upload/image', formData)
        }
    },

    category : {
        index : function(companyId){
            return axios.get("/api/company/" + companyId + "/categories");
        },
        store : function(companyId, category){
            return axios.post("/company/"+ companyId +"/category", category);
        },
        update : function(id, category){
            return axios.put("/company/category/" + id, category);
        },
        delete : function(id){
            return  axios.delete("/company/category/" + id);
        }
    },

    user : {
        index : function(){
            return axios.get('/users');
        },
        store : function (user) {
            return axios.post('/user', user);
        },
        delete : function(id){
            return axios.delete('/user/' + id)
        },
        update : function(user){
            return axios.put('/user/' + user.id, user)
        },
        sendInvitationLink : function(id){
            return axios.post('/user/'+ id +'/invitation/send');
        }
    },

    project : {
        store : function(companyId, project){
            return axios.post('/company/'+ companyId +'/project', project)
        },
        update : function(uuid, project){
            return axios.put('/project/' + uuid, project)
        },
        delete : function(uuid){
            return axios.delete('/project/' + uuid);
        }
    }
}
