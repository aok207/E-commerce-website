import { createRoot } from "react-dom/client";
import { Provider } from "react-redux";
import { store } from "./store";
import { useDispatch } from "react-redux";
import { useState } from "react";
import { addToCart, handleBookmark } from "./utils/productApi";
import ReviewCard from "./components/ReviewCard";
import axios from "axios";
import showToast from "./utils/Toast";
import ProductCard from "./components/ProductCard";

const cart = bladeCart;
const bookmarkedProducts = bladeBookmarkedProducts;
const relatedProducts = bladeRelatedProducts;

const ProductPage = () => {
    const [product, setProduct] = useState(bladeProduct);
    const [isInCart, setIsInCart] = useState(
        cart ? cart.cart_items.some((c) => c.product_id === product.id) : false
    );
    const [isBookmarked, setIsBookmarked] = useState(
        bookmarkedProducts.includes(product.id)
    );
    const [currentSection, setCurrentSection] = useState("reviews"); // reviews || relatedProducts
    const [reviews, setReviews] = useState(bladeReviews);

    const [feedback, setFeedBack] = useState("");
    const dispatch = useDispatch();

    const stars = [];

    for (let i = 0; i < 5; i++) {
        stars.push(
            i < product.average_rating ? (
                <i className="fa-solid fa-star" key={i}></i>
            ) : (
                <i className="fa-regular fa-star" key={i}></i>
            )
        );
    }

    const submitReview = (e) => {
        e.preventDefault();

        const ratingEle = e.target.rating;
        axios
            .post("/api/create-review", {
                rating: parseInt(ratingEle.value),
                feedback: feedback,
                product_id: product.id,
            })
            .then((res) => {
                setReviews([res.data.review, ...reviews]);
                setProduct(res.data.product);
                setFeedBack("");
                ratingEle.value = "default";
                showToast(res.data.message, "green");
            })
            .catch((err) => {
                showToast(err.response.data.message, "red");
            });
    };

    return (
        <div className="dark:text-white text-black px-4 pt-4 w-[90%] lg:w-[80%] mx-auto mb-10">
            <button
                onClick={() => window.history.back()}
                id="go-back-btn"
                className="font-semibold mb-4"
            >
                <i className="fa-solid fa-arrow-left"></i> Go Back
            </button>

            <div className="flex flex-col items-center lg:items-start lg:flex-row w-full gap-10">
                <div className="lg:w-1/3 md:w-1/2">
                    {product.image.startsWith("https") ? (
                        <img
                            src={`${product.image}`}
                            alt={product.title}
                            className="object-cover w-full h-full"
                        />
                    ) : (
                        <img
                            src={`/images/${product.image}`}
                            alt={product.title}
                            className="object-cover w-full h-full"
                        />
                    )}
                </div>
                <div className="w-2/3 flex flex-col gap-4 text-center items-center lg:items-start lg:text-start">
                    <h1 className="font-bold text-2xl">{product.title}</h1>
                    <p className="text-lg leading-relaxed">
                        {product.description}
                    </p>
                    <div className="mt-6 flex flex-col gap-4">
                        <h1 className="font-extrabold text-4xl">
                            ${product.price}
                        </h1>
                        <div className="flex gap-10 lg:justify-between w-full lg:w-1/2 ">
                            <span>
                                <i className="fa-regular fa-calendar"></i>{" "}
                                Added: {diffForHuman}
                            </span>
                            <span>
                                <i className="fa-solid fa-star"></i> Rating:{" "}
                                {product.average_rating}
                            </span>
                        </div>
                        <div className="flex gap-10 lg:justify-between w-full lg:w-1/2">
                            <span>
                                <i className="fa-solid fa-star"></i> Reviews:{" "}
                                {product.reviews_count}
                            </span>
                            <span>
                                <i className="fa-solid fa-box"></i> Quantity in
                                stock: {product.quantity_in_stock}
                            </span>
                        </div>
                    </div>
                    <div className="flex gap-2 items-center">
                        {stars}({product.reviews_count}) reviews
                    </div>
                    <div className="flex gap-3">
                        {isInCart ? (
                            <span className="font-bold text-md">
                                Already in the cart
                            </span>
                        ) : (
                            <button
                                onClick={() =>
                                    addToCart(product.id, setIsInCart, dispatch)
                                }
                                className="text-blue-400 font-semibold transition duration-300 ease-in-out dark:hover:text-white hover:text-black"
                            >
                                Add to cart
                            </button>
                        )}

                        <button
                            onClick={() =>
                                handleBookmark(
                                    product.id,
                                    isBookmarked,
                                    setIsBookmarked,
                                    null,
                                    []
                                )
                            }
                        >
                            {isBookmarked ? (
                                <i className="fa-solid fa-bookmark"></i>
                            ) : (
                                <i className="fa-regular fa-bookmark"></i>
                            )}
                        </button>
                    </div>
                </div>
            </div>

            <div className="mx-auto mt-8 w-[80%] flex flex-col md:flex-row gap-10">
                <div className="flex md:flex-col gap-6 items-start">
                    <button
                        className={`text-lg ${
                            currentSection === "reviews"
                                ? "font-bold"
                                : "font-light"
                        }`}
                        onClick={() => setCurrentSection("reviews")}
                    >
                        Reviews
                    </button>
                    <button
                        className={`text-lg ${
                            currentSection === "relatedProducts"
                                ? "font-bold"
                                : "font-light"
                        }`}
                        onClick={() => setCurrentSection("relatedProducts")}
                    >
                        Related Products
                    </button>
                </div>
                {currentSection === "reviews" ? (
                    <div className="w-full">
                        {!bladeUser ? (
                            <div>
                                <h2 class="font-semibold text-2xl mb-4">
                                    Log in first to leave a review.
                                </h2>
                                <a
                                    href="/login"
                                    class="py-2 px-6 text-sm text-white dark:bg-blue-600 bg-black shadow-lg rounded-xl transition duration-200 hover:bg-blue-800 dark:hover:bg-blue-800"
                                >
                                    Login
                                </a>
                            </div>
                        ) : (
                            <form
                                className="flex flex-col w-full"
                                onSubmit={submitReview}
                            >
                                <label htmlFor="rating">Rating</label>
                                <select
                                    name="rating"
                                    id="rating"
                                    className="w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input px-4 py-2 rounded-md focus:outline-black dark:focus:outline-white bg-slate-200"
                                    required
                                    defaultValue="default"
                                >
                                    <option value="default" disabled>
                                        Please select a rating.
                                    </option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                                <label htmlFor="feedback" className="mt-2">
                                    Comment
                                </label>
                                <textarea
                                    name="feedback"
                                    required
                                    id="feedback"
                                    className="w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input px-4 py-2 rounded-md focus:outline-black dark:focus:outline-white h-20 bg-slate-200"
                                    onChange={(e) =>
                                        setFeedBack(e.target.value)
                                    }
                                    value={feedback}
                                ></textarea>

                                <button
                                    type="submit"
                                    className="bg-sky-400 rounded-md hover:bg-sky-500 dark:hover:bg-sky-500 text-white px-3 py-2 mt-4 w-fit"
                                >
                                    Submit
                                </button>
                            </form>
                        )}
                        <h1 className="my-4 font-extrabold text-3xl text-black dark:text-white">
                            Reviews
                        </h1>
                        <div className="w-full flex flex-col gap-4">
                            {reviews.map((review, index) => (
                                <ReviewCard review={review} key={index} />
                            ))}
                        </div>
                    </div>
                ) : (
                    <div className="w-full">
                        <h1 className="my-4 font-extrabold text-3xl text-black dark:text-white">
                            Related Products
                        </h1>
                        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            {relatedProducts.map((product, index) => (
                                <ProductCard
                                    key={index}
                                    id={product.id}
                                    title={product.title}
                                    price={product.price}
                                    image={product.image}
                                    bookmarkedProducts={bookmarkedProducts}
                                    cart={cart}
                                />
                            ))}
                        </div>
                    </div>
                )}
            </div>
        </div>
    );
};

createRoot(document.getElementById("product")).render(
    <Provider store={store}>
        <ProductPage />
    </Provider>
);
