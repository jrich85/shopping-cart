<template>
    <div class="container-fluid application">
        <div class="application">
            <router-view></router-view>
        </div>
    </div>
</template>

<style scoped>
.application {
    height: 100vh;
}
</style>


<script setup>
import { RouterView } from 'vue-router'
</script>
