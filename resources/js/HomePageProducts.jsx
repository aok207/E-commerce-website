import { createRoot } from "react-dom/client";
import ProductCard from "./components/ProductCard";
import { Provider } from "react-redux";
import { store } from "./store";

const bookmarkedProducts = bladeBookmarkedProducts;
const products = bladeRecommendedProducts;
const cart = bladeCart;

const HomePageProducts = () => {
    return (
        <div className="my-8 grid grid-cols-1 gap-6 md:grid-cols-3 max-w-[80%] mx-auto text-black dark:text-white">
            {products.map((product) => (
                <ProductCard
                    key={product.id}
                    id={product.id}
                    title={product.title}
                    image={product.image}
                    price={product.price}
                    bookmarkedProducts={bookmarkedProducts}
                    cart={cart}
                />
            ))}
        </div>
    );
};

createRoot(document.getElementById("recommended-products")).render(
    <Provider store={store}>
        <HomePageProducts />
    </Provider>
);
