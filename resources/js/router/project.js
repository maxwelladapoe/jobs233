import CreateProject from "../views/projects/CreateProject";
import ViewAllProjects from "../views/projects/ViewAllProjects";
import Project from "../views/projects/Project";


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
        meta: {requiresAuth: false}
    },
    {
        path: '/projects/:id',
        name: 'singleProject',
        component: Project,
        meta: {requiresAuth: false}
    }
]
