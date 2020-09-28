import EditProfile from "../views/profile/EditProfile";
import ViewProfile from "../views/profile/ViewProfile";


export default [
    {
        path: '/profile/edit',
        name: 'editProfile',
        component: EditProfile,
        meta: {requiresAuth: true}
    },
    {
        path: '/profile',
        name: 'viewProfile',
        component: ViewProfile,
        meta: {requiresAuth: true}
    }
]
