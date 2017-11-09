<template>
    <div class="row">
        <div class="col-sm-6">
            <div v-for="(credential, index) in credentials" class="pt5 pb5 project"
                 v-bind:class="{ active: isActive(credential.id) }">
                <span class="cursor-pointer"
                      v-on:click="selectedCredential(index)">{{ credential.name }}: {{ credential.value }}</span>
            </div>
        </div>

        <!-- Modal Create -->
        <div class="modal fade" tabindex="-1" role="dialog" id="add_credential_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Crea una nuova properietà</h4>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="nome">Nome properietà:</label>
                            <input type="text" class="form-control" v-model="credential.name">
                        </div>
                        <div class="form-group">
                            <label for="descrizione">Descrizione:</label>
                            <textarea cols="30" rows="5" class="form-control"
                                      v-model="credential.description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                        <button type="button" @click="createCredential" class="btn btn-primary">Crea</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- Modal Update -->
        <div class="modal fade" tabindex="-1" role="dialog" id="update_credential_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Modifica proprietà</h4>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="nome">Nome proprietà:</label>
                            <input type="text" class="form-control" v-model="update_credential.name">
                        </div>
                        <div class="form-group">
                            <label for="descrizione">Descrizione:</label>
                            <textarea cols="30" rows="5" class="form-control"
                                      v-model="update_credential.description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="updateCredential" class="btn btn-primary">Modifica</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</template>

<script>

    export default {
        props: ['credentials'],
        data() {
            return {
                credential: {
                    name: '',
                    value: ''
                },
                errors: [],
                update_credential: {},
                update_credential_index: ""
            }
        },
        methods: {
            createCredential() {
                axios.post('credential', {
                    name: this.credential.name,
                    description: this.credential.description,
                    project_id: this.$parent.update_project.id
                })
                    .then(response => {
                        this.reset();
                        this.properties.push(response.data.credential);
                        this.$parent.message = response.data.message;
                        $("#add_credential_model").modal("hide");
                    })
                    .catch(error => {
                        console.log(error.response);
                        this.errors = [];

                        if (error.response.data.errors.name) {
                            this.errors.push(error.response.data.errors.name[0]);
                        }

                        if (error.response.data.errors.description) {
                            this.errors.push(error.response.data.errors.description[0]);
                        }
                    });
            },
            updateCredential() {
                axios.patch('credential/' + this.update_credential.id, {
                    name: this.update_credential.name,
                    value: this.update_credential.value,
                })
                    .then(response => {
                        this.$parent.message = response.data.message;
                        $("#update_credential_model").modal("hide");
                    })
                    .catch(error => {
                        this.errors = [];
                        if (error.response.data.errors.name) {
                            this.errors.push(error.response.data.errors.name[0]);
                        }

                        if (error.response.data.errors.description) {
                            this.errors.push(error.response.data.errors.description[0]);
                        }
                    });
            },
            deleteCredential() {
                let conf = confirm("Vuoi cancellare questa proprietà?");
                if (conf === true) {
                    axios.delete('credential/' + this.update_credential.id)
                        .then(response => {
                            this.properties.splice(this.update_credential_index, 1);
                            this.$parent.message = response.data.message;
                        })
                        .catch(error => {
                        });
                }
            },
            reset() {
                this.update_credential = [];
                this.update_credential_index = "";
                this.credential.name = '';
                this.credential.value = '';
            },
            isActive(credentialId) {
                if (Object.keys(this.update_credential).length > 0) {
                    return credentialId == this.update_credential.id;
                }
                return false;
            },
            initSelectCredential(index) {
                this.errors = [];
                this.update_crede_index = index;
                this.update_credential = this.credentials[index];
            },
            selectedCredential(index) {
                this.initSelectCredential(index);
            },
        }
    }

</script>