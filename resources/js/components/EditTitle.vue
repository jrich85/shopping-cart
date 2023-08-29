<template>
    {{ title }}
    <v-btn class="btn-edit" size="small" flat :rounded="0" @click="open = true">
        <edit-icon />
    </v-btn>
    <v-dialog v-model="open" class="edit-title-modal">
        <v-card flat :rounded="0">
            <v-card-title class="branded-title">Edit Title</v-card-title>
            <v-card-text>
                <v-text-field
                    variant="underlined"
                    v-model="newTitle"
                    label="title"
                    :error-messages="errors"
                ></v-text-field>
            </v-card-text>
            <v-card-actions>
                <v-container>
                    <v-row no-gutters>
                        <v-col cols="2">
                            <v-btn flat @click="open = false"> Cancel </v-btn>
                        </v-col>
                        <v-spacer />
                        <v-col cols="2">
                            <v-btn class="btn-primary" @click="saveNewTitle">
                                Confirm
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup>
import api from "../api/api";
import { onMounted, ref, reactive } from "vue";

const newTitle = ref("");
const open = ref(false);
const errors = reactive([]);

onMounted(() => {
    newTitle.value = props.title;
});

const emit = defineEmits(["newTitle"]);
const props = defineProps({
    title: "string",
    type: "string",
    id: "string",
    listId: "string|null",
});

const saveNewTitle = () => {
    let success = false;
    errors.length = 0;
    if (props.type === "list") {
        api.updateList(props.id, newTitle.value)
            .then((data) => {
                console.log(data);
                if (data.errors) {
                    const errorToShow = data.errors.name;
                    Object.keys(errorToShow).forEach((key) =>
                        errors.push(errorToShow[key])
                    );
                } else {
                    success = true;
                    emit("newTitle", newTitle.value);
                }
            })
            .then(() => (open.value = !success));
    } else if (props.type === "list-item") {
        api.updateListItem(props.id, props.listId, newTitle.value)
            .then((data) => {
                if (data.errors) {
                    const errorToShow = data.errors.name;
                    Object.keys(errorToShow).forEach((key) =>
                        errors.push(errorToShow[key])
                    );
                } else {
                    success = true;
                    emit("newTitle", newTitle.value, props.id);
                }
            })
            .then(() => (open.value = !success));
    }
};
</script>
