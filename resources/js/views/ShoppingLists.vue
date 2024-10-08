<template>
    <div>
        <v-card class="shopping-lists" flat :rounded="0">
            <v-card-title class="branded-title"> Shopping Lists </v-card-title>

            <v-card-text>
                <shopping-lists-list v-if="lists.length" :lists="lists" />
                <span v-else>Get started by entering a title for your first list.</span>
            </v-card-text>

            <v-card-actions>
                <v-container>
                    <v-row no-gutters align="center">
                        <v-col cols="11">
                            <v-text-field
                                variant="underlined"
                                label="Give your new list a title"
                                v-model="newListTitle"
                                v-on:keyup.enter="newList"
                                :disabled="disableNewList"
                                :error-messages="newListErrors"
                                hint="Must be a unique title"
                            />
                        </v-col>
                        <v-col cols="1">
                            <v-btn @click="newList">
                                <save-icon></save-icon>
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-actions>
        </v-card>
    </div>
</template>

<style scoped>
.application {
    height: 100vh;
}
</style>

<script setup>
import api from "../api/api";
import { computed, onMounted, ref, reactive } from "vue";
import { useRouter } from "vue-router";
import SaveIcon from "../components/SaveIcon.vue";

onMounted(() => {
    getLists();
});

// region data
let lists = reactive([]);
let newListTitle = ref("");
let newListErrors = reactive([]);
const router = useRouter();
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
        newListErrors.push("Required field");
        return;
    }
    api.createShoppingList(newListTitle.value).then((newList) => {
        if (newList.errors) {
            const errorToShow = newList.errors.name;
            Object.keys(errorToShow).forEach((key) =>
                newListErrors.push(errorToShow[key])
            );
        } else {
            router.push(`/lists/${newList.data.id}`);
        }
    });
};
// endregion api actions
</script>
