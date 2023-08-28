<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">Shopping Lists</div>

            <div class="card-body">
                Are there lists? {{ lists.length? 'yes' : 'no' }}
            </div>

            <button @click="getLists">click to get lists</button>
        </div>
    </div>
</template>

<script setup>
import api from '../api/api'
import { onMounted } from 'vue'

let lists = Array();

onMounted(() => {
    // lists = api.getShoppingLists();
})

const getLists = () => lists = api.getShoppingLists();

</script>
