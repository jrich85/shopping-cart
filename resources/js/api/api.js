const api = {
    getShoppingLists: async () => {
        try {
            const lists = await window.axios.get('api/grocery-list');

            return lists;
        } catch (error) {
            console.error(error);
        }

        return
    },
    createShoppingList: async (name) => {
        try {
            const newList = await window.axios.post('api/grocery-list', {name: name});
        } catch (error) {
            console.error(error);
        }
    }
};

export default api;
