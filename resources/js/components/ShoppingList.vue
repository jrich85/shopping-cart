<template>
    <v-card class="shopping-list-container" v-if="!!list.value?.name">
        <v-card-title>
            <v-container>
                <v-row justify="space-between" no-gutters>
                    <v-col>
                        {{ list.value.name }}
                    </v-col>
                    <v-col cols="1">
                        <v-btn @click="router.push('/lists')">x</v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </v-card-title>
        <v-list v-if="listItems.length">
            <v-list-item
                v-for="(item, index) in listItems"
                :key="item.id"
                :title="item.name"
                :subtitle="index"
            >
                <template v-slot:append>
                    <delete-list-item
                        :name="item.name"
                        :itemId="item.id"
                        :listId="list.value.id"
                        v-on:deletedItem="listItems.splice(index, 1)"
                    />
                </template>
            </v-list-item>
        </v-list>

        <v-card-text v-else>Enter a new item to get started</v-card-text>

        <v-card-text>Created: {{ list.value.created_at }}</v-card-text>

        <v-card-actions>
            <v-text-field
                label="Enter an item"
                v-model="newItem"
                v-on:keyup.enter="addNewItem"
                :error-messages="newItemErrors"
                hint="Must be a unique item"
            />
            <v-btn @click="addNewItem">Add Item</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script setup>
import api from "../api/api";
import { onMounted, reactive, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import DeleteListItem from "./DeleteListItem.vue";
const route = useRoute();
const router = useRouter();

const newItem = ref("");
const newItemErrors = reactive([]);

const list = reactive({});

const listItems = reactive([]);

onMounted(() => {
    getList();
    getListItems();
});

// region api actions
const getList = () => {
    api.getList(route.params.id).then((listData) => {
        list.value = { ...listData.data };
    });
};

const getListItems = () => {
    api.getListItems(route.params.id).then((apiListItems) => {
        apiListItems.data.forEach((item) => {
            if (listItems) listItems.push(item);
        });
    });
};

const addNewItem = () => {
    newItemErrors.length = 0;
    if (newItem.value.trim() === "") {
        newItemErrors.push("Required field");
        return;
    }
    api.addItemToList(route.params.id, newItem.value).then((addedItem) => {
        console.log(addedItem);
        if (addedItem.errors) {
            const errorToShow = addedItem.errors.name;
            Object.keys(errorToShow).forEach((key) =>
                newItemErrors.push(errorToShow[key])
            );
        } else {
            listItems.push({ ...addedItem.data });
            newItem.value = "";
        }
    });
};
// endregion api actions
</script>
