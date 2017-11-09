<template>
    <div class="row">
        <div class="col-sm-6">
            <div v-for="(property, index) in properties" class="pt5 pb5 project"
                 v-bind:class="{ active: isActive(property.id) }">
                <span class="cursor-pointer" v-on:click="selectedProperty(index)">{{property.name}}</span>
            </div>
        </div>

        <!-- Modal Create -->
        <div class="modal fade" tabindex="-1" role="dialog" id="add_property_model">
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
                            <input type="text" class="form-control" v-model="property.name">
                        </div>
                        <div class="form-group">
                            <label for="descrizione">Descrizione:</label>
                            <textarea cols="30" rows="5" class="form-control"
                                      v-model="property.description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                        <button type="button" @click="createProperty" class="btn btn-primary">Crea</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- Modal Update -->
        <div class="modal fade" tabindex="-1" role="dialog" id="update_property_model">
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
                            <input type="text" class="form-control" v-model="update_property.name">
                        </div>
                        <div class="form-group">
                            <label for="descrizione">Descrizione:</label>
                            <textarea cols="30" rows="5" class="form-control"
                                      v-model="update_property.description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="updateProperty" class="btn btn-primary">Modifica</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <credentials></credentials>
    </div>
</template>

<script>

    export default {
        props: ['properties'],
        data() {
            return {
                property: {
                    name: '',
                    description: ''
                },
                errors: [],
                update_property: {},
                update_property_index: ""
            }
        },
        methods: {
            createProperty() {
                axios.post('property', {
                    name: this.property.name,
                    description: this.property.description,
                    project_id: this.$parent.update_project.id
                })
                    .then(response => {
                        this.reset();
                        this.properties.push(response.data.property);
                        this.$parent.message = response.data.message;
                        $("#add_property_model").modal("hide");
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
            updateProperty() {
                axios.patch('property/' + this.update_property.id, {
                    name: this.update_property.name,
                    description: this.update_property.description,
                })
                    .then(response => {
                        this.$parent.message = response.data.message;
                        $("#update_property_model").modal("hide");
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
            deleteProperty() {
                let conf = confirm("Vuoi cancellare questa proprietà?");
                if (conf === true) {
                    axios.delete('property/' + this.update_property.id)
                        .then(response => {
                            this.properties.splice(this.update_property_index, 1);
                        })
                        .catch(error => {
                        });
                }
            },
            reset() {
                this.properties.update_property = [];
                this.properties.update_property_index = "";
                this.property.name = '';
                this.property.description = '';
            },
            isActive(propertyId) {
                if (Object.keys(this.update_property).length > 0) {
                    return propertyId == this.update_property.id;
                }
                return false;
            },
            initSelectProject(index) {
                this.errors = [];
                this.update_property_index = index;
                this.update_property = this.properties[index];
            },
            selectedProperty(index) {
                this.initSelectProject(index);
                //this.getCredential(this.update_project.id);
            },
        }
    }

</script>