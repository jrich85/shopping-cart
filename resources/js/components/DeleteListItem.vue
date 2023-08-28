<template>
    <svg-icon type="mdi" :path="path" @click="modalOpen = true"></svg-icon>
    <v-dialog v-model="modalOpen" class="delete-modal">
        <v-card>
            <v-card-title class="branded-title">Are you sure?</v-card-title>
            <v-card-text>
                Please confirm you want to delete item [{{ name }}] from your
                list.
            </v-card-text>
            <v-card-actions>
                <v-container>
                    <v-row no-gutters>
                        <v-col cols="2">
                            <v-btn flat @click="modalOpen = false">
                                Cancel
                            </v-btn>
                        </v-col>
                        <v-spacer />
                        <v-col cols="2">
                            <v-btn class="btn-primary" @click="deleteListItem">
                                Confirm
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import api from "../api/api";
import SvgIcon from "@jamescoyle/vue-icon";
import { mdiDeleteCircle } from "@mdi/js";

export default {
    name: "delete-list-item",
    components: {
        SvgIcon,
    },
    props: {
        name: "string",
        listId: "string",
        itemId: "string",
    },
    emits: ["deletedItem"],
    data() {
        return {
            path: mdiDeleteCircle,
            modalOpen: false,
        };
    },
    methods: {
        deleteListItem() {
            api.deleteItemFromList(this.listId, this.itemId)
                .then(() => {
                    this.$emit("deletedItem");
                })
                .then(() => {
                    this.modalOpen = false;
                });
        },
    },
};
</script>
