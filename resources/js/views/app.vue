<template>
    <div class="container-fluid h-100">
        <v-card>
            <v-card-title> Shopping Lists </v-card-title>

            <v-card-text>
                Are there lists? {{ lists.length ? "yes" : "no" }}
            </v-card-text>

            <v-card-actions>
                <v-text-field
                    label="Give your new list a title"
                    v-model="newListTitle"
                    v-on:keyup.enter="newList"
                    :disabled="disableNewList"
                    :error-messages="newListErrors"
                    hint="Must be a unique title"
                />
                <v-btn @click="newList">Create New List</v-btn>
            </v-card-actions>
        </v-card>

        {{ newListErrors }}
        {{ newListTitle }}
    </div>
</template>

<script setup>
import api from "../api/api";
import { computed, onMounted, ref, reactive } from "vue";

onMounted(() => {
    getLists();
});

// region data
let lists = reactive([]);
let newListTitle = ref("");
let newListErrors = reactive([]);
// endregion data

// region computed vars
const disableNewList = computed(
    () => newListTitle !== "" && newListErrors === []
);
// region computed vars

// region api actions
const getLists = () =>
    api.getShoppingLists().then((sourceLists) => {
        lists.length = 0;
        if (sourceLists.data.length) {
            sourceLists.data.forEach((list) => {
                lists.push(list);
            });
        }
    });

const newList = () => {
    newListErrors.length = 0;
    if (newListTitle.value.trim() === "") {
        newListErrors.push();
        return;
    }
    api.createShoppingList(newListTitle.value).then((newList) => {
        if (newList.errors) {
            const errorToShow = newList.errors.name;
            Object.keys(errorToShow).forEach((key) =>
                newListErrors.push(errorToShow[key])
            );
        } else {
            getLists();
        }
    });
};
// endregion api actions
</script>
