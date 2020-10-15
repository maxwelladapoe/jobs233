import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Dashboard from '../views/DashBoard.vue'
import Login from '../views/auth/Login.vue'
import store from "../store";
import project from "./project";
import profile from "./profile";
import SignUp from "../views/auth/SignUp";
import Messages from "../views/messages/MessageArea";

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    }, {
        path: '/home',
        component: Home
    }, {
        path: '/dashboard',
        name: 'Dashboard',
        component: Dashboard,
        meta: {requiresAuth: true}

    }, {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: {requiresAuth: false}

    }, {
        path: '/signup',
        name: 'SignUp',
        component: SignUp,
        meta: {requiresAuth: false}

    }, {
        path: '/messages',
        name: 'Messages',
        component: Messages,
        meta: {requiresAuth: true}

    },
    ...project,
    ...profile,
];

const router = new VueRouter({
    routes,
    mode: 'history',
    scrollBehavior(to, from, savedPosition) {
        return {x: 0, y: 0}
    }

});


let entryUrl = null;

router.beforeEach((to, from, next) => {

    entryUrl = to.path;
    console.log(entryUrl);
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.state.auth.authenticated) {
            next();
            return
        }
        next('/login')
    } else {
        next()
    }


});

export default router
