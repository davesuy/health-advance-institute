<template>
    <div class="search-container">
        <h2>Search Here..</h2>
        <input v-model="query" @input="search" placeholder="Search...">
        <ul>
            <li v-for="result in results" :key="result.id">{{ result.title }}</li>
        </ul>
        <nav>
            <router-link to="/all-posts">View All Posts</router-link>
        </nav>
    </div>
</template>

<script>
import { ref } from 'vue';

export default {
    setup() {
        const query = ref('');
        const results = ref([]);

        const search = () => {
            if (query.value.length > 2) {
                fetch(`/api/search?q=${query.value}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        results.value = data;
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            } else {
                results.value = [];
            }
        };

        return {
            query,
            results,
            search
        };
    }
};
</script>

<style scoped>
.search-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    max-width: 600px;
    margin: 0 auto;
}

.search-container h2 {
    margin: 20px 0;
    font-weight: bold;
    font-size: 30px;
}

input {
    width: 100%;
    padding: 15px;
    font-size: 18px;
    border: 2px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: border-color 0.3s, box-shadow 0.3s;
}

input:focus {
    border-color: #007BFF;
    box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
    outline: none;
}

ul {
    list-style-type: none;
    padding: 0;
    margin-top: 10px;
    width: 100%;
}

li {
    padding: 10px;
    border-bottom: 1px solid #ccc;
}

nav {
    margin-top: 20px;
}

router-link {
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border: none;
    border-radius: 5px;
    background-color: #007BFF;
    color: white;
    text-decoration: none;
    transition: background-color 0.3s;
}

router-link:hover {
    background-color: #0056b3;
}
</style>
