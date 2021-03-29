<template>
    <div class="component-container ">
        <form 
            @submit.prevent="saveData">

            <div class="input-group mb-3">
                <input                     
                    type="text" 
                    class="form-control form-control-lg"
                    v-model="form.title"
                    :class="{'is-invalid' : form.errors.has('title')}"
                    @keydown="form.errors.clear('title')"
                >
                <div class="input-group-append">
                    <button class="btn btn-success" type="submit">Add this your list</button>
                </div>
            </div>

            <!-- Error window -->
            <span 
                class="text-danger pt-3"
                v-if="form.errors.has('title')"
                v-text="form.errors.get('title')"
            >
            </span>
        </form>
                
        <!-- To-dos -->
        <ul style="list-style: none;">
            <li 
                class="bg-light"
                style="background-color: white; margin: 3px;"
                v-for="todo in todos" 
                :key="todo.id"                 
            >                
                <i  
                    class="far fa-square"
                    v-on:click="toggleTodo(todo)"
                    v-if="todo.completed == false" 
                >
                </i>
                 <i  
                    class="far fa-check-square"
                    v-on:click="toggleTodo(todo)"
                    v-if="todo.completed == true" 
                >
                </i>
                {{todo.title}}
                <i class="fas fa-trash"></i>
                <i class="far fa-edit"></i>
            </li>
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
            // Toggle check to-do
            toggleTodo(todo) {     
                // Toggle checkbox icon @ click
                todo.completed = !todo.completed           
                // Update to-do checked value in the database
                let data = new FormData();
                data.append('_method', 'PATCH');
                if (todo.completed == true) {
                    data.append('completed', 1)
                } 
                if (todo.completed == false) {
                    data.append('completed', 0)
                    console.log(data);
                }
                // Send request to database
                axios.post('/api/todo/'+todo.id, data)
                
            },
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
