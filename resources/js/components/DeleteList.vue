<template>
    <svg-icon type="mdi" :path="path" @click.stop="modalOpen = true"></svg-icon>
    <v-dialog v-model="modalOpen" class="delete-modal">
        <v-card>
            <v-card-title>Are you sure?</v-card-title>
            <v-card-text>
                Please confirm you want to delete shopping list [{{ name }}].
            </v-card-text>
            <v-card-actions>
                <v-btn @click="modalOpen = false">Cancel</v-btn>
                <v-btn @click="deleteList">Confirm</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import api from '../api/api';
import SvgIcon from "@jamescoyle/vue-icon";
import { mdiDeleteCircle } from "@mdi/js";

export default {
    name: "delete-list-item",
    components: {
        SvgIcon,
    },
    props: {
        name: 'string',
        id: 'string',
    },
    emits: ['deletedList'],
    data() {
        return {
            path: mdiDeleteCircle,
            modalOpen: false,
        };
    },
    methods: {
        deleteList() {
            api.deleteList(this.id).then(() => {
                this.$emit('deletedList');
            }).then(() => {
                this.modalOpen = false;
            });
        },
    },
};
</script>
