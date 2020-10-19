import AddFunds from "../views/payments/AddFunds";


export default [
    {
        path: '/payments/add-funds',
        name: 'AddFunds',
        component: AddFunds,
        meta: {requiresAuth: true},
        props:{trxref:null,reference:null}
    },

]
