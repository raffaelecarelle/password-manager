<template>

    <div class="col-sm-6">
        <div class="pt5 pb5 project">

        </div>
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
                console.log(index);
            }
        }
    }

</script>