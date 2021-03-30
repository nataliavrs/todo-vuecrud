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
                    class="far fa-square text-danger"
                    v-on:click="toggleTodo(todo)"
                    v-if="todo.completed == false" 
                >
                </i>
                 <i  
                    class="far fa-check-square text-success"
                    v-on:click="toggleTodo(todo)"
                    v-if="todo.completed == true" 
                >
                </i>
                
                <!-- To-do title -->
                <div>
                    <span v-if="editmode != todo.id || editmode == false">
                        {{todo.title}}
                    </span>
                    <input 
                        type="text"
                        v-model="todo.title"
                        v-if="editmode == todo.id"
                    >
                    <!-- Error window -->
                    <span 
                        class="text-danger pt-3"
                        v-if="error != false"
                    >
                        Sorry, invalid title.
                    </span>
                </div>

                <i 
                    class="fas fa-trash"
                    v-on:click="deleteTodo(todo)"
                >
                </i>
                <!-- Edit title -->
                <i 
                    class="far fa-edit"
                    v-on:click="editmode = todo.id"
                    v-if="editmode != todo.id"
                >
                </i>
                <!-- Save edited title -->
                <i 
                    class="fas fa-save"
                    v-on:click="updateTodo(todo)"
                    v-if="editmode == todo.id"
                >
                </i>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                // Toggle edit icon
                editmode: false,
                todos: '',
                form: new Form({
                    title: ''
                }),
                // Error
                error: false,
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
            },
            // Edit title
            updateTodo(todo) {
                // Input disappears
                if (todo.title != '') {
                    this.editmode = false;
         
                    // Update to-do title in database
                    let data = new FormData();
                    data.append('_method', 'PATCH');                
                    data.append('title', todo.title);
                    
                    // Send request to database
                    axios.post('/api/todo/'+todo.id, data)
                    .then(() => {}).catch((error) => {
                        console.log(error);              
                    })
                } else {
                   this.error = 'error'
                }                
            },
            deleteTodo(todo) {    
                // Update to-do checked value in the database
                let data = new FormData();
                data.append('_method', 'DELETE');                                 
                // Send request to database
                axios.post('/api/todo/'+todo.id, data)
                .then((answer) => {
                    // Show all to-dos list updated
                    this.todos = answer.data;
                }).catch((error) => {
                    this.form.errors.record(error.response.data.errors)
                })  
            },
        },
        // Show all to-dos when page is loaded
        mounted() {
            this.getTodos()
        }
    }
</script>
