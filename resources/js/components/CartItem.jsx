import axios from "axios";
import showToast from "../utils/Toast";
import { useDispatch } from "react-redux";
import { changeCartCount } from "../store";
import { useRef, useState } from "react";
import Loader from "./Loader";

const CartItem = ({ item, setItems, setCart }) => {
    const dispatch = useDispatch();
    const [itemCount, setItemCount] = useState(item.quantity);
    const [loading, setLoading] = useState(false);
    const [confirmDisabled, setConfirmDisabled] = useState(true);
    const quantityRef = useRef();

    function removeFromCart() {
        axios
            .post("/api/remove-from-cart", { item_id: item.id })
            .then((res) => {
                setItems((prev) =>
                    prev.filter((cartItem) => cartItem.id !== item.id)
                );
                dispatch(changeCartCount(res.data.new_cart.total_items));
                setCart(res.data.new_cart);
                showToast(res.data.message, "green");
                setItemCount(item.quantity);
            })
            .catch((err) => {
                showToast(err.response.data.message, "red");
            });
    }

    function handleOnChange() {
        if (parseInt(quantityRef.current.value) === item.quantity) {
            setConfirmDisabled(true);
        } else {
            setConfirmDisabled(false);
        }
        setItemCount(quantityRef.current.value);
    }

    function changeItemCount() {
        setConfirmDisabled(true);
        setLoading(true);
        axios
            .post("/api/update-cart-items-count", {
                item_id: item.id,
                new_quantity: itemCount,
            })
            .then((res) => {
                setCart(res.data.new_cart);
                setLoading(false);
                dispatch(changeCartCount(res.data.new_cart.total_items));
                showToast(res.data.message, "green");
            })
            .catch((err) => {
                showToast(err.response.data.message, "red");
                setLoading(false);
            });
    }

    return (
        <div className="flex w-full md:items-center md:justify-between flex-col items-center lg:flex-row gap-4 lg:gap-0">
            <div className="flex flex-col lg:flex-row items-center gap-4">
                {item.product.image.startsWith("http") ? (
                    <img
                        src={`${item.product.image}`}
                        alt={`${item.product.title}`}
                        width={128}
                        height={128}
                    />
                ) : (
                    <img
                        src={`/images/${item.product.image}`}
                        alt={`${item.product.title}`}
                        width={128}
                        height={128}
                    />
                )}

                <span className="text-xl font-bold text-purple-500">
                    {item.product.title}
                </span>
            </div>
            <div className="flex flex-col lg:flex-row gap-4">
                <input
                    type="number"
                    step={"any"}
                    className="text-black dark:text-white dark:bg-inherit border border-white bg-gray-300 rounded-full px-4 py-2 lg:py-0"
                    min="1"
                    max={`${item.product.quantity_in_stock}`}
                    ref={quantityRef}
                    value={itemCount}
                    onChange={handleOnChange}
                />
                <button
                    className="bg-green-500 hover:bg-green-600 dark:hover:bg-green-600 py-2 px-3 rounded-md text-white disabled:bg-gray-700 disabled:hover:bg-gray-700 disabled:dark:hover:bg-gray-700 disabled:cursor-not-allowed relative flex gap-2 items-center"
                    disabled={confirmDisabled}
                    onClick={changeItemCount}
                >
                    {loading && (
                        <Loader color={"#ffffff"} loading={loading} size={15} />
                    )}{" "}
                    Confirm items count
                </button>
                <button
                    className="bg-red-500 hover:bg-red-600 dark:hover:bg-red-600 py-2 px-3 rounded-md text-white"
                    onClick={removeFromCart}
                >
                    <i className="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    );
};

export default CartItem;
