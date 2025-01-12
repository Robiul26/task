import { createBrowserRouter } from "react-router-dom";
import NotFound from "./views/NotFound";
import GuestLayout from "./components/GuestLayout";
import Customers from "./views/Customers";
import AddCustomer from "./views/AddCustomer";

const router = createBrowserRouter([


    {
        path: '/',
        element: <GuestLayout />,
        children: [
            {
                path: '/',
                element: <Customers />
            },
            {
                path: '/customers',
                element: <Customers />
            },
            {
                path: '/add-customer',
                element: <AddCustomer />
            },
        ]
    },

    {
        path: '*',
        element: <NotFound />
    }

]);

export default router;