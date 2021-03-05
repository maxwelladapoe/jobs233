import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Dashboard from '../views/DashBoard.vue'
import Login from '../views/auth/Login.vue'
import store from "../store";
import project from "./project";
import profile from "./profile";
import payment from "./payment";
import SignUp from "../views/auth/SignUp";
import Messages from "../views/messages/MessageArea";
import HowItWorks from "../views/others/HowItWorks";
import Categories from "../views/others/Categories";
import Contact from "../views/others/Contact";
import About from "../views/others/About";
import ForgotPassword from "../views/auth/ForgotPassword";
import Blog from "../views/others/Blog";
import EmailVerified from "../views/auth/EmailVerified";
import Forbidden from "../views/errors/Forbidden";
import NotFound from "../views/errors/NotFound";
import ConditionsOfUse from "../views/legal/ConditionsOfUse";
import PrivacyPolicy from "../views/legal/PrivacyPolicy";

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
        path: '/how-it-works',
        name: 'HowItWorks',
        component: HowItWorks,
        meta: {requiresAuth: false}

    }, {
        path: '/categories',
        name: 'Categories',
        component: Categories,
        meta: {requiresAuth: false}

    }, {
        path: '/contact',
        name: 'Contact',
        component: Contact,
        meta: {requiresAuth: false}

    }, {
        path: '/blog',
        name: 'Blog',
        component: Blog,
        meta: {requiresAuth: false}

    }, {
        path: '/conditions-of-use',
        name: 'ConditionsOfUse',
        component: ConditionsOfUse,
        meta: {requiresAuth: false}

    },{
        path: '/privacy-policy',
        name: 'PrivacyPolicy',
        component: PrivacyPolicy,
        meta: {requiresAuth: false}

    }, {
        path: '/about',
        name: 'About',
        component: About,
        meta: {requiresAuth: false}

    }, {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: {requiresAuth: false,mustNotBeAuthenticated:true}

    }, {
        path: '/signup',
        name: 'SignUp',
        component: SignUp,
        meta: {requiresAuth: false, mustNotBeAuthenticated:true}

    }, {
        path: '/forgot-password',
        name: 'ForgotPassword',
        component: ForgotPassword,
        meta: {requiresAuth: false}

    }, {
        path: '/messages',
        name: 'Messages',
        component: Messages,
        meta: {requiresAuth: true}

    }, {
        path: '/email-verified',
        name: 'EmailVerified',
        component: Home,
        meta: {requiresAuth: false}

    }, {
        path: '/email-already-verified',
        name: 'EmailAlreadyVerified',
        component: Home,
        meta: {requiresAuth: false}

    },
    {
        path: '/forbidden',
        name: 'Forbidden',
        component: Forbidden,
        meta: {requiresAuth: false}

    },


    ...project,
    ...profile,
    ...payment,



    {
        path: '*',
        name: 'Not Found',
        component: NotFound
    }
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

    if (to.matched.some(record => record.meta.mustNotBeAuthenticated)) {
        if (store.state.auth.authenticated) {
            next('/dashboard');
            return
        }else{
            next();
        }

    }

    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.state.auth.authenticated) {
            next();
            return
        }
        next('/login')
    } else if (to.matched.some(record => record.meta.requiresHire)) {
        if (store.state.auth.preference === 'hire' || store.state.auth.preference === 'work&hire') {
            next();
            return
        }
        next('/dashboard')
    } else if (to.matched.some(record => record.meta.requiresWork)) {
        if (store.state.auth.preference === 'work' || store.state.auth.preference === 'work&hire') {
            next();
            return
        }
        next('/dashboard')
    } else {
        next()
    }


});

export default router
