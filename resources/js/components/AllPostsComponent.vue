<template>
    <div class="all-posts-container">
        <h2>All Posts</h2>
        <ul>
            <li v-for="post in posts" :key="post.id">{{ post.title }}</li>
        </ul>
        <nav class="router-link">
            <router-link to="/">Back to Search</router-link>
        </nav>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';

export default {
    setup() {
        const posts = ref([]);

        const fetchAllPosts = () => {
            fetch('/api/posts')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    posts.value = data;
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        };

        onMounted(fetchAllPosts);

        return {
            posts
        };
    }
};
</script>

<style scoped>
.all-posts-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    max-width: 600px;
    margin: 0 auto;
}

.all-posts-container h2 {
    margin: 20px 0;
    font-weight: bold;
    font-size: 30px;
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

.router-link {
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

.router-link:hover {
    background-color: #0056b3;
}
</style>
