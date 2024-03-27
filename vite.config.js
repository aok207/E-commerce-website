import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
 
export default defineConfig({
    plugins: [
        laravel(['resources/js/NavBar.jsx', 'resources/js/HomePageProducts.jsx', 'resources/js/BookmarkedProducts.jsx', 'resources/js/Cart.jsx', 'resources/js/Shop.jsx', 'resources/js/ProductPage.jsx', 'resources/js/CheckoutPage.jsx']),
        react(),
    ],
});