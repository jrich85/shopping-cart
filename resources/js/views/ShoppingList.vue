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
                        <edit-title
                            :title="list.value.name"
                            type="list"
                            :id="list.value.id"
                            v-on:newTitle="
                                (newTitle) => (list.value.name = newTitle)
                            "
                        />
                    </v-col>
                    <v-spacer />
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
            v-if="!!listItems"
            v-model="listItems"
            @start="drag = true"
            @end="drag = false"
            v-on:change="reorder"
            item-key="id"
        >
            <template #item="{ element }">
                <v-container>
                    <v-row>
                        <v-col cols="1"> <menu-icon></menu-icon> </v-col>
                        <v-col>
                            <edit-title
                                :title="element.name"
                                :id="element.id"
                                :listId="list.value.id"
                                type="list-item"
                                v-on:newTitle="updateListItemTitle"
                            />
                        </v-col>
                        <v-col cols="1">
                            <delete-list-item
                                :name="element.name"
                                :itemId="element.id"
                                :listId="list.value.id"
                                v-on:deletedItem="listItems.splice(index, 1)"
                            />
                        </v-col>
                    </v-row>
                </v-container>
            </template>
        </draggable>

        <v-card-text v-else>Enter a new item to get started</v-card-text>

        <v-card-text>
            Created: {{ dateFormat(list.value.created_at) }}
        </v-card-text>

        <v-card-actions>
            <v-container>
                <v-row no-gutters align="center">
                    <v-col cols="11">
                        <v-text-field
                            variant="underlined"
                            label="Enter an item"
                            v-model="newItem"
                            v-on:keyup.enter="addNewItem"
                            :error-messages="newItemErrors"
                            hint="Must be a unique item"
                        />
                    </v-col>
                    <v-col cols="1">
                        <v-btn @click="addNewItem">
                            <save-icon></save-icon>
                        </v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </v-card-actions>
    </v-card>
</template>

<script setup>
import api from "../api/api";
import draggable from "vuedraggable";
import { dateFormat } from "../utils/helpers";
import { onMounted, reactive, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import DeleteListItem from "../components/DeleteListItem.vue";
import EditTitle from "../components/EditTitle.vue";
import SaveIcon from "../components/SaveIcon.vue";

const route = useRoute();
const router = useRouter();

const editTitleOpen = ref(false);
const drag = ref(false);
const newItem = ref("");
const newItemErrors = reactive([]);

const list = reactive({});

const listItems = reactive([]);

onMounted(() => {
    getList();
    getListItems();
});

const updateListItemTitle = (title, id) => {
    listItems.map((listItem) =>
        listItem.id === id ? (listItem.name = title) : listItem
    );
};

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
    const element = event.moved.element;
    const oldIndex = event.moved.oldIndex;
    let newIndex = event.moved.newIndex;

    const newOrder = [];

    const listIdsOrder = [];
    if (newIndex === 0) {
        listIdsOrder.push(element.id);
        listItems.forEach((listItem) => {
            if (listItem.id !== element.id) {
                listIdsOrder.push(listItem.id);
            }
        })
    } else {
        listItems.forEach((listItem, index) => {
            if (index === oldIndex) {
                return;
            }
            listIdsOrder.push(listItem.id);
            if (index === newIndex) {
                listIdsOrder.push(element.id);
                return;
            }
        });
        if (!listIdsOrder.includes(element.id)) {
            listIdsOrder.push(element.id);
        }
    }

    api.reorder(list.value.id, listIdsOrder)
        .then((reorderedList) => {
            listItems.forEach((listItem, index) => {
                listItem.value = { ...reorderedList[index] };
            });
        })
        .then(() => getListItems());
};

const addNewItem = () => {
    newItemErrors.length = 0;
    if (newItem.value.trim() === "") {
        newItemErrors.push("Required field");
        return;
    }
    api.addItemToList(route.params.id, newItem.value).then((addedItem) => {
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
