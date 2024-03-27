import { createRoot } from "react-dom/client";
import ProductCard from "./components/ProductCard";
import { useState } from "react";
import { Provider } from "react-redux";
import { store } from "./store";

const bookmarkedProducts = bladeBookmarkedProducts;
const bookmarkedProductsID = bookmarkedProducts.map(
    (product) => product.product.id
);
const cart = bladeCart;

const BookmarkedProducts = () => {
    const [bookmarkedProductsList, setBookmarkedProductsList] =
        useState(bookmarkedProducts);
    return (
        <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
            {bookmarkedProductsList.map((product, index) => (
                <ProductCard
                    key={index}
                    title={product.product.title}
                    id={product.product.id}
                    price={product.product.price}
                    image={product.product.image}
                    bookmarkedProducts={bookmarkedProductsID}
                    changeProductsList={setBookmarkedProductsList}
                    currentProductList={bookmarkedProducts}
                    cart={cart}
                />
            ))}
        </div>
    );
};

createRoot(document.getElementById("bookmarked__products")).render(
    <Provider store={store}>
        <BookmarkedProducts />
    </Provider>
);
