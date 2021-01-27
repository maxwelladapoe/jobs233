import CreateProject from "../views/projects/CreateProject";
import EditProject from "../views/projects/EditProject";
import ViewAllProjects from "../views/projects/ViewAllProjects";
import Project from "../views/projects/Project";
import AssignedProject from "../views/projects/AssignedProject";
import ViewAssignedProjects from "../views/projects/ViewAssignedProjects";


export default [
    {
        path: '/project/create',
        name: 'createProject',
        component: CreateProject,
        meta: {requiresAuth: true, requiresHire: true},
    },
    {
        path: '/jobs',
        name: 'Jobs',
        component: ViewAllProjects,
        meta: {requiresAuth: false}
    },
    {
        path: '/projects',
        name: 'Projects',
        component: ViewAllProjects,
        meta: {requiresAuth: false}
    },
    {
        path: '/projects/:id',
        name: 'singleProject',
        component: Project,
        meta: {requiresAuth: true}
    },
    {
        path: '/projects/edit/:id',
        name: 'editProject',
        component: EditProject,
        meta: {requiresAuth: true}
    },
    {
        path: '/projects/assigned/',
        name: 'ViewAssignedProjects',
        component: ViewAssignedProjects,
        meta: {requiresAuth: true}
    },
    {
        path: '/projects/assigned/:id/',
        name: 'assignedProject',
        component: AssignedProject,
        meta: {requiresAuth: true}
    }
]
