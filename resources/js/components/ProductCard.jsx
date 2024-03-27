import { useState } from "react";
import { useDispatch } from "react-redux";
import { addToCart, handleBookmark } from "../utils/productApi";

const ProductCard = ({
    id,
    title,
    price,
    image,
    bookmarkedProducts,
    changeProductsList = null,
    currentProductList = [],
    cart,
}) => {
    const [isBookmarked, setIsBookmarked] = useState(
        bookmarkedProducts.includes(id)
    );
    const [isInCart, setIsInCart] = useState(
        cart ? cart.cart_items.some((c) => c.product_id === id) : false
    );
    const dispatch = useDispatch();

    return (
        <div className="flex flex-col py-4 items-center gap-5 bg-white dark:bg-gray-700 shadow-lg rounded-lg group text-center relative w-fit h-fit">
            <button
                className="absolute top-5 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out"
                onClick={() =>
                    handleBookmark(
                        id,
                        isBookmarked,
                        setIsBookmarked,
                        changeProductsList,
                        currentProductList
                    )
                }
            >
                {isBookmarked ? (
                    <i className="fa-solid fa-bookmark"></i>
                ) : (
                    <i className="fa-regular fa-bookmark"></i>
                )}
            </button>
            <div className="px-6">
                <h1 className="mb-2 text-2xl font-bold">{title}</h1>
                <h2>
                    <span className="font-bold text-blue-400">Price:</span> $
                    {price}
                </h2>
            </div>

            {image.startsWith("http") ? (
                <img src={image} alt={`${title}`} />
            ) : (
                <img src={`images/${image}`} alt={`${title}`} />
            )}

            <div className="flex gap-10">
                {isInCart ? (
                    <span className="font-bold text-md">
                        Already in the cart
                    </span>
                ) : (
                    <button
                        onClick={() => addToCart(id, setIsInCart, dispatch)}
                        className="text-blue-400 font-semibold transition duration-300 ease-in-out dark:hover:text-white hover:text-black"
                    >
                        Add to cart
                    </button>
                )}

                <a
                    href={`/products/${id}`}
                    className="dark:text-white text-black font-semibold transition duration-300 ease-in-out hover:text-blue-400 dark:hover:text-blue-400"
                >
                    View Details
                </a>
            </div>
        </div>
    );
};

export default ProductCard;
