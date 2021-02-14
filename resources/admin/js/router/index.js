import Vue from 'vue'
import VueRouter from 'vue-router'

import store from "../store";
import AdminDashboard from "../views/AdminDashboard";
import AdminLogin from "../views/auth/AdminLogin";
import NotFound from "../../../js/views/errors/NotFound";


Vue.use(VueRouter);

const adminRoutes = [
    {
        path: '/back_end_service/',
        component: AdminDashboard,
        meta: {requiresAdminAuth: true}
    },
    {
        path: '/back_end_service/home',
        name: 'AdminDashboard',
        component: AdminDashboard,
        meta: {requiresAdminAuth: true}
    },
    {
        path: '/back_end_service/admin-login',
        name: 'AdminLogin',
        component: AdminLogin,
        meta: {requiresAdminAuth: false,mustNotBeAdminAuthenticated:true,noNav:true}

    },


    {
        path: '*',
        name: 'Not Found',
        component: NotFound
    }
];

const adminRouter = new VueRouter({
    routes:adminRoutes,
    mode: 'history',
    scrollBehavior(to, from, savedPosition) {
        return {x: 0, y: 0}
    }

});


let entryUrl = null;


adminRouter.beforeEach((to, from, next) => {

    if (to.matched.some(record => record.meta.mustNotBeAdminAuthenticated)) {
        if (store.state.auth.authenticated) {
            next({name:'AdminDashboard'});
            return
        }else{
            next();
        }

    }


    if (to.matched.some(record => record.meta.requiresAdminAuth)) {

        if (store.state.auth.authenticated) {
            next();
            return
        }
        next({name:'AdminLogin'});
    } else {
        next()
    }


});

export default adminRouter
