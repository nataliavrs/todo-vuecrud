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
        
        <!-- To-dos -->
        <ul>
            <li v-for="todo in todos" :key="todo.id">{{todo.title}}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                todos: '',
                form: new Form({
                    title: ''
                })
            }
        },
        methods: {
            // Get to-dos from database
            getTodos() {
                axios.get('/api/todo')
                .then((response)=>{
                    this.todos = response.data;
                }).catch((error) => {
                    console.log(error);
                })
            },
            // Create to-do
            saveData() {
                let data = new FormData();
                data.append('title', this.form.title);
                axios.post('/api/todo', data)                
                .then((response) => {
                    // Form.js method: clears input field
                    this.form.reset()
                    // If our call is succesful fetch all from DB again
                    this.getTodos();
                }).catch((error) => {
                    this.form.errors.record(error.response.data.errors)
                })                
            }
        },
        mounted() {
            this.getTodos()
        }
    }
</script>
