<template>
    <svg-icon size="1rem" type="mdi" :path="path"></svg-icon>
</template>

<script>
import SvgIcon from "@jamescoyle/vue-icon";
import { mdiPencil } from "@mdi/js";

export default {
    name: "my-component",
    components: {
        SvgIcon,
    },
    data() {
        return {
            path: mdiPencil,
        };
    },
};
</script>
