<template>
    <div class="component-container ">
        <form 
            @submit.prevent="saveData">    

            <div class="input-group mb-3">
                <input                     
                    type="text" 
                    class="form-control form-control-lg"
                    v-model="form.title"
                >
                <div class="input-group-append">
                    <button class="btn btn-success" type="submit">Add this your list</button>
                </div>
            </div>

        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: new Form({
                    title: ''
                })
            }
        },
        methods: {
            saveData() {
                let data = new FormData();
                data.append('title', this.form.title);
                console.log(data);
            }
        },
        mounted() {
            console.log('To-do component :)')
        }
    }
</script>
