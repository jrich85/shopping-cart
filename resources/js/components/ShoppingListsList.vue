<template>
    <v-list class="shopping-lists">
        <v-list-item
            v-for="list in lists"
            class="shopping-list"
            :key="list.id"
            :title="list.name"
            :subtitle="`created ${list.created_at}`"
            @click="$router.push(`/lists/${list.id}`)"
        />
    </v-list>

</template>

<script setup>


const props = defineProps(['lists']);


</script>
