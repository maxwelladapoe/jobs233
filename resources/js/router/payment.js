import MakeDeposit from "../views/payments/MakeDeposit";
import MakeDepositCallback from "../views/payments/MakeDepositCallback";
import Account from "../views/payments/Account";
import Wallet from "../views/payments/Wallet";
import WithdrawFunds from "../views/payments/WithdrawFunds";


export default [
    {
        path: '/payments/make-deposit/:project_id',
        name: 'MakeDeposit',
        component: MakeDeposit,
        meta: {requiresAuth: true, requiresHire:true},
        props: true
    },
    {
        path: '/payments/make-deposit-callback/',
        name: 'MakeDepositCallback',
        component: MakeDepositCallback,
        props: {trxref: null, reference: null}
    },
    {
        path: '/account',
        name: 'Account',
        component: Account,
        meta: {requiresAuth: true, requiresHire: true},
        props: true
    },
    {
        path: '/wallet',
        name: 'Wallet',
        component: Wallet,
        meta: {requiresAuth: true,requiresWork:true},
        props: true
    },
    {
        path: '/withdraw-funds',
        name: 'WithdrawFunds',
        component: WithdrawFunds,
        meta: {requiresAuth: true},
        props: true
    },

]
