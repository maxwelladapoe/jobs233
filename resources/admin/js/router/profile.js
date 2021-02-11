import EditProfile from "../views/profile/EditProfile";
import ViewProfile from "../views/profile/ViewProfile";
import ViewPortfolioItem from "../views/profile/ViewPortfolioItem";


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
    },
    {
        path: '/portfolio/:userId/:portfolioItemId',
        name: 'ViewPortfolioItem',
        component: ViewPortfolioItem,
        props: true
    }
]
