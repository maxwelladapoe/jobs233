import CreateProject from "../views/projects/CreateProject";
import ViewAllProjects from "../views/projects/ViewAllProjects";


export default [
    {
        path: '/project/create',
        name: 'createProject',
        component: CreateProject,
        meta: {requiresAuth: true}
    },
    {
        path: '/projects',
        name: 'projects',
        component: ViewAllProjects,
        meta: {requiresAuth: true}
    }
]
