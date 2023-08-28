<template>
    <v-card
        class="shopping-list-container"
        v-if="!!list.value?.name"
        flat
        :rounded="0"
    >
        <v-card-title class="branded-title">
            <v-container class="no-gutters">
                <v-row justify="space-between" :align="'center'" no-gutters>
                    <v-col>
                        {{ list.value.name }}
                    </v-col>
                    <v-spacer/>
                    <v-col cols="1" align-self="end">
                        <v-btn
                            class="btn-close"
                            flat
                            :rounded="0"
                            @click="router.push('/lists')"
                        >
                        </v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </v-card-title>

        <draggable
            v-if="listItems.length"
            v-model="listItems"
            v-on:updated="(event) => console.log(event)"
            @start="drag = true"
            @end="drag = false"
            v-on:change="reorder"
            item-key="id"
        >
            <template #item="{ element }">
                <v-container>
                    <v-row>
                        <v-col cols="1"> <menu-icon></menu-icon> </v-col>
                        <v-col>{{ element?.name ?? "" }}</v-col>
                        <v-col cols="1">
                            <delete-list-item
                                :name="element?.name ?? ''"
                                :itemId="element?.id ?? ''"
                                :listId="list.value.id"
                                v-on:deletedItem="listItems.splice(index, 1)"
                            />
                        </v-col>
                    </v-row>
                </v-container>
            </template>
        </draggable>

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
import draggable from "vuedraggable";
import { onMounted, reactive, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import DeleteListItem from "./DeleteListItem.vue";
const route = useRoute();
const router = useRouter();

const drag = ref(false);
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
        listItems.length = 0;
        apiListItems.data
            .sort((a, b) => {
                return a.order < b.order;
            })
            .forEach((item) => {
                if (listItems) listItems.push({ ...item });
            });
    });
};

const reorder = (event) => {
    console.log(event);

    const element = event.moved.element;
    const oldIndex = event.moved.oldIndex;
    let newIndex = event.moved.newIndex;

    const newOrder = [];

    console.log(element, oldIndex, newIndex);

    listItems.splice(oldIndex, 1);
    listItems.splice(newIndex, 0, element);

    api.reorder(
        list.value.id,
        listItems.map((item) => item.id)
    ).then(() => getListItems());
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
