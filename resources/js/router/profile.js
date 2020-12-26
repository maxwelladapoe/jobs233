import EditProfile from "../views/profile/EditProfile";
import ViewProfile from "../views/profile/ViewProfile";


export default [
    {
        path: '/profile/edit',
        name: 'EditProfile',
        component: EditProfile,
        meta: {requiresAuth: true}
    },
    {
        path: '/profile/:username',
        name: 'ViewProfile',
        component: ViewProfile,
        props: true
    }
]
