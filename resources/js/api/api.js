const api = {
    getShoppingLists: async () => {
        try {
            const lists = await window.axios.get("api/grocery-list");

            return lists.data;
        } catch (error) {
            const messages = error.response.data.errors;

            return {
                errors: messages,
            };
        }
    },
    getList: async (listId) => {
        try {
            const list = await window.axios.get(`api/grocery-list/${listId}`);

            return list.data;
        } catch (error) {
            const messages = error.response.data.errors;

            return {
                errors: messages,
            };
        }
    },
    getListItems: async (listId) => {
        try {
            const listItems = await window.axios.get(
                `api/grocery-list/${listId}/items`
            );

            return listItems.data;
        } catch (error) {
            const messages = error.response.data.errors;

            return {
                errors: messages,
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
                errors: messages,
            };
        }
    },
    addItemToList: async (listId, name) => {
        try {
            const newItem = await window.axios.post(
                `api/grocery-list/${listId}/items`,
                {
                    name: name,
                }
            );

            console.log('newItem??', newItem);

            return newItem.data;
        } catch (error) {

            console.log('error??', error);
            const messages = error.response.data.errors;

            return {
                errors: messages,
            };
        }
    },
};

export default api;
