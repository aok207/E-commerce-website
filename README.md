# Shop Nest: E-Commerce Website with Admin Panel

Welcome to Shop Nest, an E-Commerce Website with Admin Panel! This project combines the power of Laravel and React to deliver a robust online shopping experience, complemented by a comprehensive admin panel for seamless management. Below you'll find an overview of the project's features and functionalities:

## Features:

### User Features:
- **Authentication:** Users can securely register, log in, and manage their accounts.
- **Authorization:** Different user roles are enforced, granting appropriate access levels.
- **OAuth Integration:** Seamless login/signup with Google and GitHub accounts.
- **Product Browsing:** Users can explore all available products.
- **Product Filtering:** Dynamic filtering options enable users to narrow down product searches by price and categories.
- **Bookmarking/Favoriting:** Users can mark their favorite products for future reference.
- **Shopping Cart:** Conveniently add products to the cart for streamlined checkout.
- **Order Placement:** Securely place orders, with payment facilitated through PayPal's sandbox environment.
- **Profile Management:** Users have the ability to edit and manage their profiles.

### Admin Features:
- **Comprehensive Control:** Admins have full control over the system.
- **User Management:** Admins can view and manage user accounts, including listing and updating user information.
- **Product Management:** Admins can perform CRUD (Create, Read, Update, Delete) operations on products and categories.
- **Order Management:** Admins have visibility into all orders within the application and can mark orders as delivered if necessary.

## Technologies Used:
- **Backend:** Laravel
- **Frontend:** React and Blade templates
- **Database:** MySQL
- **Authentication:** OAuth with Google and GitHub
- **Payment:** PayPal (sandbox)

## Setup Instructions:
1. Clone the repository.
2. Run `composer install` in your terminal, to install Laravel dependencies.
3. Copy `.env.example` to `.env` and configure your database settings.
4. Run `php artisan migrate` to migrate the database schema.
5. Run `npm install` to install React dependencies.
6. Start the Laravel server by running `php artisan serve` in the root directory.
7. Start the React frontend server by running `npm run dev` in the root directory.
8. Access the application in your web browser in localhost:8000.
