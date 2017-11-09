<template>
    <div class="row">
        <div class="col-sm-6">
            <div v-for="(credential, index) in credentials" class="cursor-pointer"
                 v-bind:class="{ active: isActive(credential.id) }" v-on:click="selectedCredential(index)">
                <span><strong>{{ credential.name }}</strong></span><br/>
                <span>{{ credential.value }}</span>
                <hr style="margin-bottom: 0;margin-top: 0">
            </div>
        </div>

        <!-- Modal Create -->
        <div class="modal fade" tabindex="-1" role="dialog" id="add_credentials_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Crea una nuova credenziale</h4>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="nome">Nome credenziale:</label>
                            <input type="text" class="form-control" v-model="credential.name">
                        </div>
                        <div class="form-group">
                            <label for="valore">Valore credenziale:</label>
                            <input type="text" class="form-control" v-model="credential.value">
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
        <div class="modal fade" tabindex="-1" role="dialog" id="update_credentials_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Modifica credenziale</h4>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="nome">Nome credenziale:</label>
                            <input type="text" class="form-control" v-model="update_credential.name">
                        </div>
                        <div class="form-group">
                            <label for="descrizione">valore credenziale:</label>
                            <input type="text" class="form-control" v-model="update_credential.value">
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
                    value: this.credential.value,
                    property_id: this.$parent.update_property.id
                })
                    .then(response => {
                        this.reset();
                        this.credentials.push(response.data.credential);
                        this.$parent.$parent.renderSuccessMessage(response.data.message);
                        $("#add_credentials_model").modal("hide");
                    })
                    .catch(error => {
                        this.errors = [];

                        if (error.response.data.errors.name) {
                            this.errors.push(error.response.data.errors.name[0]);
                        }

                        if (error.response.data.errors.value) {
                            this.errors.push(error.response.data.errors.value[0]);
                        }
                    });
            },
            updateCredential() {
                axios.patch('credential/' + this.update_credential.id, {
                    name: this.update_credential.name,
                    value: this.update_credential.value,
                })
                    .then(response => {
                        this.$parent.$parent.renderSuccessMessage(response.data.message);
                        $("#update_credentials_model").modal("hide");
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
                let conf = confirm("Vuoi cancellare questa credenziale?");
                if (conf === true) {
                    axios.delete('credential/' + this.update_credential.id)
                        .then(response => {
                            this.credentials.splice(this.update_credential_index, 1);
                            this.$parent.$parent.renderSuccessMessage(response.data.message);
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
            selectedCredential(index) {
                this.errors = [];
                this.update_credential_index = index;
                this.update_credential = this.credentials[index];
            },
        }
    }

</script>