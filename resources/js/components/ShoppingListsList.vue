<template>
    <v-list class="shopping-lists">
        <v-list-item v-if="lists.length"
            v-for="(list, index) in lists"
            class="shopping-list"
            :key="list.id"
            :title="list.name"
            :subtitle="dateFormat(list.created_at)"
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
import { dateFormat } from '../utils/helpers';
const props = defineProps(["lists"]);
</script>
