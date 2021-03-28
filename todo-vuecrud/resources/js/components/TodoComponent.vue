<template>
    <div class="component-container ">
        <form action="">    
            <div class="input-group mb-3">
                <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-success" type="button">Add this your list</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {

            }
        },
        mounted() {
            console.log('To-do component :)')
        }
    }
</script>
