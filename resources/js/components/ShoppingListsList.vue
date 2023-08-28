<template>
    <v-list class="shopping-lists">
        <v-list-item v-if="lists.length"
            v-for="(list, index) in lists"
            class="shopping-list"
            :key="list.id"
            :title="list.name"
            :subtitle="`created ${list.created_at}`"
            @click="$router.push(`/lists/${list.id}`)"
        >
            <template v-slot:append>
                <delete-list
                    :name="list.name"
                    :id="list.id"
                    @click.stop
                    v-on:deletedList="lists.splice(index, 1)"
                />
            </template>
        </v-list-item>
    </v-list>
</template>

<script setup>
const props = defineProps(["lists"]);
</script>
