<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Review;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $faker = \Faker\Factory::create();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('admin'),
            'is_admin' => true
        ]);

        User::create([
            'name' => 'Aung Aung',
            'email' => 'aung@email.com',
            'password' => bcrypt('aung')
        ]);

        // Seed users table
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'email' => $faker->email,
                'name' => $faker->name,
                'password' => bcrypt('password')
            ]);
        }

        // Seed products table
        for ($i = 0; $i < 20; $i++) {
            Product::create([
                'image' => $faker->imageUrl(),
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'price' => $faker->randomFloat(2, 10, 100),
                'quantity_in_stock' => $faker->numberBetween(0, 100),
                'average_rating' => $faker->randomFloat(2, 1, 5),
                'reviews_count' => $faker->numberBetween(0, 10),
            ]);
        }

        // Seed categories table
        $initialCategories = [
            'Books',
            'Camera & Photo',
            'Cell Phones & Accessories',
            'Clothing, Shoes & Jewelry',
            'Computers & Accessories',
            'Electronics',
            'Exercise & Fitness Equipment'
        ];

        foreach ($initialCategories as $category) {
            Category::create([
                "name" => $category,
                "slug" => Str::slug($category)
            ]);
        }

        // Seed product_category pivot table
        $products = Product::pluck('id')->toArray();
        $categories = Category::pluck('id')->toArray();
        foreach ($products as $product) {
            $category = $faker->randomElement($categories);
            DB::table('product_category')->insert([
                'product_id' => $product,
                'category_id' => $category
            ]);
        }

        // Seed carts table
        for ($i = 0; $i < 5; $i++) {
            Cart::create([
                'user_id' => $faker->randomElement(User::pluck('id')->toArray()),
                'total_price' => $faker->randomFloat(2, 10, 500),
                'total_items' => $faker->numberBetween(1, 10)
            ]);
        }

        // Seed cart_items table
        $carts = Cart::pluck('id')->toArray();
        foreach ($carts as $cart) {
            CartItem::create([
                'cart_id' => $cart,
                'product_id' => $faker->randomElement($products),
                'quantity' => $faker->numberBetween(1, 5)
            ]);
        }

        // Seed orders table
        for ($i = 0; $i < 5; $i++) {
            Order::create([
                'user_id' => $faker->randomElement(User::pluck('id')->toArray()),
                'total_items' => $faker->numberBetween(1, 10),
                'total_price' => $faker->randomFloat(2, 10, 500),
                'order_status' => $faker->randomElement(['pending', 'delivered']),
            ]);
        }

        // Seed order_items table
        $orders = Order::pluck('id')->toArray();
        $orders_total_price = Order::pluck('total_price')->toArray();
        foreach ($orders as $order) {
            OrderItem::create([
                'order_id' => $order,
                'product_id' => $faker->randomElement($products),
                'quantity' => $faker->numberBetween(1, 5)
            ]);
        }

        // Seed payment table
        for ($i = 0; $i < count($orders); $i++) {
            Payment::create([
                'order_id' => $orders[$i],
                'payment_type' => 'paypal',
                'payment_status' => $faker->randomElement(['paid', 'unpaid']),
                'email' => $faker->email,
                'shipping_address' => $faker->address(),
                'city' => $faker->city(),
                'tax_fees' => 10.00,
                'zip_code' => '11011',
                'shipping_fees' => 0,
                'total_items_price' => $orders_total_price[$i],
                'final_amount' => $orders_total_price[$i] + 10,
            ]);
        }

        // Seed Review table
        $users = User::pluck('id')->toArray();

        foreach ($products as $product) {
            $reviews_count = Product::where('id', $product)->first()->reviews_count;
            for ($i = 0; $i < $reviews_count; $i++) {
                Review::create([
                    'user_id' => $faker->randomElement($users),
                    'product_id' => $product,
                    'rating' => $faker->numberBetween(1, 5),
                    'feedback' => $faker->paragraph()
                ]);
            }
        }
    }
}
