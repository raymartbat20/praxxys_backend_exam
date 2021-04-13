import Dashboard from './Vue/Containers/Dashboard'
import Login from './Vue/Containers/Login'
import Products from './Vue/Components/Products/Products'
import EditProduct from './Vue/Components/Products/Edit'
import CreateProduct from './Vue/Components/Products/Create'
import VideosLink from './Vue/Containers/VideoLink'

export const routes = [
    {
        path:'/',
        component: Login,
        name: 'Login',
    },
    {
        path: '/dashboard',
        component: Dashboard,
        name: 'Dashboard',
        children:
        [
            {
                path: '/product/list',
                component: Products,
                name: 'product-list',
            },
            {
                path: '/product/create',
                component: CreateProduct,
                name: 'product-create',
            },
            {
                path: '/product/edit/:id',
                component: EditProduct,
                name: 'product-edit',
            },
            {
                path: '/videos-link',
                component: VideosLink,
                name: 'videos-link',
            }
        ]
    },
];