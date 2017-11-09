<span><div data-id="74" class="notification-wrapper" style="transition: all 300ms;"><div class="custom-template"><div
        class="custom-template-icon"><i class="icon ion-android-checkmark-circle"></i></div> <div
        class="custom-template-content"><div class="custom-template-title">
            Test  notification #74
          </div> <div class="custom-template-text">This is notification text!<br>Date: Thu Nov 09 2017 11:49:13 GMT+0100 (CET)</div></div> <div
        class="custom-template-close"><i class="icon ion-android-close"></i></div></div></div></span>

<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <notifications group="notifications"
                               position="top center"
                               animation-type="velocity"
                               width="100%">
                </notifications>

                <div class="panel panel-default">

                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-sm-4">
                                <a class="btn btn-primary" href="#" data-toggle="modal"
                                   data-target="#add_project_model"><i class="icon-plus"></i></a>
                                <a class="btn btn-info" href="#" data-toggle="modal" data-target="#update_project_model"
                                   v-bind:class="{disabled: disableButtonProject}"><i class="icon-pencil"></i></a>
                                <a class="btn btn-danger" href="#" @click="deleteProject()"
                                   v-bind:class="{disabled: disableButtonProject}"><i class="icon-remove"></i></a>
                            </div>
                            <div class="col-sm-4" v-if="Object.keys(this.update_project).length  > 0">
                                <a class="btn btn-primary" href="#" data-toggle="modal"
                                   data-target="#add_property_model"><i class="icon-plus"></i></a>
                                <a class="btn btn-info" href="#" data-toggle="modal"
                                   data-target="#update_property_model"
                                   v-bind:class="{disabled: disableButtonProperty}"><i class="icon-pencil"></i></a>
                                <a class="btn btn-danger" href="#" @click="initDeleteProperty()"
                                   v-bind:class="{disabled: disableButtonProperty}"><i class="icon-remove"></i></a>
                            </div>
                            <div class="col-sm-4" v-if="this.showButtonCredentials">
                                <a class="btn btn-primary" href="#" data-toggle="modal"
                                   data-target="#add_credentials_model"><i class="icon-plus"></i></a>
                                <a class="btn btn-info" href="#" data-toggle="modal"
                                   data-target="#update_credentials_model"
                                   v-bind:class="{disabled: disableButtonCredential}"><i class="icon-pencil"></i></a>
                                <a class="btn btn-danger" href="#" @click="initDeleteCredential()"
                                   v-bind:class="{disabled: disableButtonCredential}"><i class="icon-remove"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <input type="text" name="project" placeholder="Cerca..." class="form-control mb20"
                                       v-model="searchProject" v-on:keyup="fillProjectsList"/>
                                <span v-if="!projects.length">Nessun risultato</span>
                                <div v-for="(project, index) in projects" class="pt5 project cursor-pointer"
                                     v-on:click="selectedProject(index)"
                                     v-bind:class="{ active: isActive(project.id) }">
                                    <span>{{project.name}}</span>
                                    <hr class="mt0 mb0">
                                </div>
                            </div>

                            <div class="col-sm-8">
                                <properties ref="properties" :properties="this.properties"></properties>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal project Create -->
            <div class="modal fade" tabindex="-1" role="dialog" id="add_project_model">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Crea un nuovo progetto</h4>
                        </div>
                        <div class="modal-body">

                            <div class="alert alert-danger" v-if="errors.length > 0">
                                <ul>
                                    <li v-for="error in errors">{{ error }}</li>
                                </ul>
                            </div>

                            <div class="form-group">
                                <label for="nome">Nome progetto:</label>
                                <input type="text" class="form-control" v-model="project.name">
                            </div>
                            <div class="form-group">
                                <label for="descrizione">Descrizione:</label>
                                <textarea cols="30" rows="5" class="form-control"
                                          v-model="project.description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" @click="createProject" class="btn btn-primary">Crea</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <!-- Modal project Update -->
            <div class="modal fade" tabindex="-1" role="dialog" id="update_project_model">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Modifica il progetto</h4>
                        </div>
                        <div class="modal-body">

                            <div class="alert alert-danger" v-if="errors.length > 0">
                                <ul>
                                    <li v-for="error in errors">{{ error }}</li>
                                </ul>
                            </div>

                            <div class="form-group">
                                <label for="nome">Nome progetto:</label>
                                <input type="text" class="form-control" v-model="update_project.name">
                            </div>
                            <div class="form-group">
                                <label for="descrizione">Descrizione:</label>
                                <textarea cols="30" rows="5" class="form-control"
                                          v-model="update_project.description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" @click="updateProject" class="btn btn-primary">Modifica</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                project: {
                    name: '',
                    description: ''
                },
                searchProject: "",
                errors: [],
                projects: [],
                message: '',
                update_project: {},
                update_project_index: "",
                properties: [],
                showButtonCredentials: false
            }
        },
        updated: function () {
            if (typeof this.$refs.properties !== 'undefined') {
                return this.showButtonCredentials = Object.keys(this.$refs.properties.update_property).length > 0
            }
        },
        computed: {
            disableButtonProject: function () {
                return Object.keys(this.update_project).length == 0
            }
            ,
            disableButtonProperty: function () {
                return Object.keys(this.$refs.properties.update_property).length == 0
            },
            disableButtonCredential: function () {
                return Object.keys(this.$refs.properties.$refs.credentials.update_credential).length == 0
            }
        },
        methods: {
            isActive(projectId) {
                return projectId == this.update_project.id;
            }
            ,
            createProject() {
                axios.post('project', {
                    name: this.project.name,
                    description: this.project.description,
                })
                    .then(response => {
                        this.projects.push(response.data.project);
                        this.renderSuccessMessage(response.data.message);
                        $("#add_project_model").modal("hide");
                        this.project = {};
                    })
                    .catch(error => {
                        this.errors = [];
                        if (error.response.data.errors.name) {
                            this.errors.push(error.response.data.errors.name[0]);
                        }
                    });
            }
            ,
            initSelectProject(index) {
                this.errors = [];
                this.update_project_index = index;
                this.update_project = this.projects[index];
            }
            ,
            updateProject() {
                axios.patch('project/' + this.update_project.id, {
                    name: this.update_project.name,
                    description: this.update_project.description,
                })
                    .then(response => {
                        this.renderSuccessMessage(response.data.message);
                        $("#update_project_model").modal("hide");
                    })
                    .catch(error => {
                        this.errors = [];
                        if (error.response.data.errors.name) {
                            this.errors.push(error.response.data.errors.name[0]);
                        }
                    });
            }
            ,
            deleteProject() {
                let conf = confirm("Vuoi cancellare questo progetto?");
                if (conf === true) {
                    axios.delete('project/' + this.update_project.id)
                        .then(response => {
                            this.projects.splice(this.update_project_index, 1);
                            this.reset();
                            this.renderSuccessMessage(response.data.message);
                        })
                        .catch(error => {
                        });
                }
            }
            ,
            reset() {
                this.update_project = [];
                this.update_project_index = "";
                this.$refs.properties.update_property = [];
                this.$refs.properties.update_property_index = "";
                this.$refs.properties.credentials = [];
                this.project.name = '';
                this.project.description = '';
                this.properties = [];
            }
            ,
            renderSuccessMessage(message) {
                this.$notify({
                    group: 'notifications',
                    title: 'SUCCESS!',
                    text: '<i class="fa fa-check"></i>' + message,
                    type: 'success'
                });
            }
            ,
            selectedProject(index) {
                this.reset();
                this.initSelectProject(index);
                this.getProperties(this.update_project.id);
            }
            ,
            getProperties(projectId) {
                axios.get('property/' + projectId + '/list').then((response) => {
                    this.properties = response.data.properties;
                }).catch(error => {
                    console.log(error.response);
                });
            }
            ,
            fillProjectsList() {
                axios.get('project?q=' + this.searchProject).then((response) => {
                    this.reset();
                    response.error ? this.errors = response.error : this.projects = response.data.projects;
                });
            }
            ,
            initDeleteProperty() {
                return this.$refs.properties.deleteProperty();
            },
            initDeleteCredential() {
                return this.$refs.properties.$refs.credentials.deleteCredential();
            }
        }
    }
</script>
