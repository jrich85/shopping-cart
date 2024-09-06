<template>
    <div class="container-fluid application">
        <div class="application">
            <v-toolbar
                class="app-bar"
                title="FSE Coding Exercise - Shopping Lists"
            />
            <router-view></router-view>
        </div>
    </div>
</template>

<style lang="scss">
@import "../../sass/app.scss";
</style>

<script setup>
import { RouterView } from "vue-router";
</script>
