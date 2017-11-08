<template>
    <div class="row">
        <div class="col-sm-6">
            <div v-for="(property, index) in properties" class="pt5 pb5 project"
                 v-bind:class="{ active: isActive(property.id) }">
                <span class="cursor-pointer" v-on:click="selectedProperty(index)">{{property.name}}</span>
            </div>
        </div>
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
            isActive(projectId) {
                //return projectId == this.update_project.id;
            },
            selectedProperty(index) {

            }
        }
    }

</script>