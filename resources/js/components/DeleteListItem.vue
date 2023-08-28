<template>
    <svg-icon type="mdi" :path="path" @click="deleteListItem"></svg-icon>
    <v-dialog v-model="modalOpen"> hey I'm a modal</v-dialog>
</template>

<script>
import SvgIcon from "@jamescoyle/vue-icon";
import { mdiDeleteCircle } from "@mdi/js";

export default {
    data: () => ({
        modalOpen: false,
    }),
    name: "delete-list-item",
    components: {
        SvgIcon,
    },
    data() {
        return {
            path: mdiDeleteCircle,
        };
    },
    methods: {
        deleteListItem: () => {
            this.modalOpen = true;
        },
    },
};
</script>
