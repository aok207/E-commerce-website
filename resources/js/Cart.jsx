import { createRoot } from "react-dom/client";
import CartItem from "./components/CartItem";
import { useState } from "react";
import { Provider } from "react-redux";
import { store } from "./store";

const cartItems = bladeCartItems;

const Cart = () => {
    const [items, setItems] = useState(cartItems);
    const [cart, setCart] = useState(bladeCart);

    return (
        <div className="flex flex-col gap-4 w-full mb-6">
            {items.length === 0 ? (
                <p className="text-md font-bold text-slate-500">
                    There is nothing in your cart right now.
                </p>
            ) : (
                items.map((item, index) => (
                    <CartItem
                        item={item}
                        key={index}
                        setItems={setItems}
                        setCart={setCart}
                    />
                ))
            )}

            <div className="mt-4 text-center lg:text-left text-black dark:text-gray-100 text-lg flex flex-col gap-3">
                <div>
                    <span className="text-purple-600 font-bold">
                        Total items:
                    </span>{" "}
                    {cart.total_items}
                </div>
                <div>
                    <span className="text-purple-600 font-bold">
                        Total price:
                    </span>{" "}
                    ${cart.total_price}
                </div>

                {items.length > 0 && (
                    <div className="mt-4 flex lg:block mb-10">
                        <a
                            href="/checkout"
                            className="rounded-full w-full px-4 py-2 text-lg font-semibold bg-purple-600 hover:bg-purple-700 dark:hover:bg-purple-700 text-white"
                        >
                            Proceed to Checkout
                        </a>
                    </div>
                )}
            </div>
        </div>
    );
};

createRoot(document.getElementById("cart")).render(
    <Provider store={store}>
        <Cart />
    </Provider>
);
