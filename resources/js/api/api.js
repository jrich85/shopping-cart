const api = {
    getShoppingLists: async () => {
        try {
            const lists = await window.axios.get("api/grocery-list");

            return lists.data;
        } catch (error) {
            const messages = error.response.data.errors;

            return {
                errors: messages
            };
        }
    },
    createShoppingList: async (name) => {
        try {
            const newList = await window.axios.post("api/grocery-list", {
                name: name,
            });

            return newList.data;
        } catch (error) {
            const messages = error.response.data.errors;

            return {
                errors: messages
            };
        }
    },
};

export default api;
