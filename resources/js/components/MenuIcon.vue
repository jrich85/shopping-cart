<template>
    <svg-icon type="mdi" :path="path"></svg-icon>
</template>

<script>
import SvgIcon from "@jamescoyle/vue-icon";
import { mdiMenu } from "@mdi/js";

export default {
    name: "menu-icon",
    components: {
        SvgIcon,
    },
    data() {
        return {
            path: mdiMenu,
        };
    },
};
</script>
