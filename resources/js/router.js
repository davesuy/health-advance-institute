import { createRouter, createWebHistory } from 'vue-router';
import SearchComponent from './components/SearchComponent.vue';
import AllPostsComponent from './components/AllPostsComponent.vue';

const routes = [
    { path: '/', component: SearchComponent },
    { path: '/all-posts', component: AllPostsComponent }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
