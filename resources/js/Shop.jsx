import { useEffect, useState } from "react";
import { createRoot } from "react-dom/client";
import axios from "axios";
import ProductCard from "./components/ProductCard";
import Loader from "./components/Loader";
import { Provider } from "react-redux";
import { store } from "./store";
import showToast from "./utils/Toast";

const categories = bladeCategories;
const bookmarkedProducts = bladeBookmarkedProducts;
const cart = bladeCart;

const Shop = () => {
    const [checkedState, setCheckedState] = useState(
        new Array(categories.length).fill(false)
    );

    const [minPrice, setMinPrice] = useState(0);
    const [maxPrice, setMaxPrice] = useState(0);

    const [isLoading, setIsLoading] = useState(false);
    const [products, setProducts] = useState([]);
    const [nextPage, setNextPage] = useState("/api/get-products");
    const [hasReset, setHasReset] = useState(false);

    // Mobile filter modal visibility
    const [isModalVisible, setIsModalVisible] = useState(false);

    const handleScroll = () => {
        if (
            window.scrollY + window.innerHeight >=
                document.body.offsetHeight - 50 &&
            !isLoading
        ) {
            getProducts();
        }
    };

    // For initial load
    useEffect(() => {
        getProducts();
    }, []);

    // For filtered products
    useEffect(() => {
        if (
            (nextPage &&
                (nextPage.startsWith("/api/get-products?categories=") ||
                    nextPage.startsWith("/api/get-products?min_price=") ||
                    nextPage.startsWith("/api/get-products?max_price="))) ||
            hasReset
        ) {
            getProducts();
        }
    }, [nextPage]);

    const getProducts = () => {
        if (!isLoading && nextPage) {
            setIsLoading(true);
            setHasReset(false);
            axios
                .get(nextPage)
                .then((response) => {
                    const paginator = response.data;

                    const newProducts = paginator.products.data;

                    const nextPageUrl = paginator.products.next_page_url;

                    if (newProducts && newProducts.length) {
                        setProducts([...products, ...newProducts]);

                        let updatedNextPage = nextPageUrl ? nextPageUrl : null;

                        let queryParams = [];

                        if (
                            checkedState.includes(true) ||
                            minPrice >= 1 ||
                            maxPrice >= 1
                        ) {
                            if (checkedState.includes(true)) {
                                queryParams.push(
                                    `categories=${returnEncodedCategories()}`
                                );
                            }

                            if (minPrice >= 1)
                                queryParams.push(`min_price=${minPrice}`);
                            if (maxPrice >= 1)
                                queryParams.push(`max_price=${maxPrice}`);

                            updatedNextPage = nextPageUrl
                                ? nextPageUrl + "&" + queryParams.join("&")
                                : nextPageUrl;
                        }

                        setNextPage(updatedNextPage);
                    } else {
                        setNextPage(null);
                    }

                    setIsLoading(false);
                })
                .catch((error) => {
                    showToast("Error fetching products: " + error, "red");
                    setIsLoading(false);
                });
        }
    };

    // Handle on change in categories checkboxes
    const handleOnChange = (position) => {
        const newCheckedState = checkedState.map((state, index) =>
            index === position ? !state : state
        );

        setCheckedState(newCheckedState);
    };

    const filter = () => {
        if (!checkedState.includes(true) && minPrice < 1 && maxPrice < 1) {
            return;
        }

        let uri = `/api/get-products`;

        if (checkedState.includes(true)) {
            const encodedCategories = returnEncodedCategories();
            uri = uri + `?categories=${encodedCategories}`;
        }

        if (isNaN(minPrice) || isNaN(maxPrice)) {
            showToast("Minimum and maximum prices must be numbers", "red");
            return;
        }

        if (minPrice >= 1) {
            uri =
                uri +
                `${
                    checkedState.includes(true) ? "&" : "?"
                }min_price=${minPrice}`;
        }

        if (maxPrice >= 1) {
            uri =
                uri +
                `${
                    checkedState.includes(true) || minPrice >= 1 ? "&" : "?"
                }max_price=${maxPrice}`;
        }

        setProducts([]);
        setNextPage(uri);
    };

    // Reset the filters
    const reset = () => {
        setProducts([]);
        setCheckedState(new Array(categories.length).fill(false));
        setHasReset(true);
        setMaxPrice(0);
        setMinPrice(0);
        setNextPage("/api/get-products");
    };

    // Encode the categories array as a valid URI
    const returnEncodedCategories = () => {
        const checkedCategories = [];

        for (let i = 0; i < checkedState.length; i++) {
            if (checkedState[i] === true) {
                checkedCategories.push(categories[i].id);
            }
        }

        return encodeURIComponent(JSON.stringify(checkedCategories));
    };

    // Modal
    const toggleModal = () => {
        setIsModalVisible((prevState) => !prevState);
    };

    // Close modal when clicked away
    useEffect(() => {
        // handle click away from modal
        const handleClick = (e) => {
            if (e.target.classList.contains("modal-element")) {
                return;
            }

            setIsModalVisible(false);
        };
        window.addEventListener("click", handleClick);

        return () => window.removeEventListener("click", handleClick);
    }, []);

    return (
        <div
            className="flex flex-col h-full overflow-hidden lg:overflow-auto items-center lg:items-start lg:flex-row w-full lg:px-16 md:px-10 px-6 text-black dark:text-white"
            onScroll={handleScroll}
        >
            {/* mobile filter */}
            <div className="flex justify-end lg:hidden w-[80%] my-4 fixed">
                <button
                    onClick={toggleModal}
                    className="rounded-full px-6 py-2 bg-sky-400 text-white dark:bg-slate-500 hover:bg-sky-500 dark:hover:bg-slate-700 transition duration-150 modal-element"
                >
                    <i className="fa-solid fa-filter modal-element"></i> Filters
                </button>
            </div>
            {/* Modal backdrop */}
            <div
                className={`modal-element fixed inset-0 z-30 items-end bg-black bg-opacity-50 sm:items-center sm:justify-center ${
                    isModalVisible ? "opacity-100 flex" : "opacity-0 hidden"
                }`}
            >
                <div className="w-full px-6 py-4 h-[calc(100vh-72px)] overflow-auto bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl modal-element">
                    <header className="flex justify-end modal-element">
                        <button
                            className="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700 modal-element"
                            aria-label="close"
                            onClick={toggleModal}
                        >
                            <svg
                                className="w-4 h-4 modal-element"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                role="img"
                                aria-hidden="true"
                            >
                                <path
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clipRule="evenodd"
                                    fillRule="evenodd"
                                ></path>
                            </svg>
                        </button>
                    </header>
                    {/* Modal body */}
                    <div className="mt-4 mb-6 modal-element">
                        {/* Modal title */}
                        <div className="px-4 py-3 rounded-full text-center bg-gray-50 dark:bg-black modal-element">
                            Filter by Categories
                        </div>
                        <div className="modal-element flex flex-col gap-1 my-4 px-2">
                            {categories.map((category, index) => (
                                <label
                                    className="modal-element relative flex gap-3 cursor-pointer items-center rounded-full p-1"
                                    htmlFor={`checkbox-${index}`}
                                    key={index}
                                    data-ripple-dark="true"
                                >
                                    <input
                                        type="checkbox"
                                        className="modal-element before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-md border border-blue-gray-200 transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-500 before:opacity-0 before:transition-opacity checked:border-purple-500 checked:bg-purple-500 checked:before:bg-purple-500 hover:before:opacity-10"
                                        id={`checkbox-${index}`}
                                        checked={checkedState[index]}
                                        onChange={() => handleOnChange(index)}
                                    />
                                    <div className="modal-element pointer-events-none absolute top-2/4 left-[7px] -translate-y-2/4 text-white opacity-0 transition-opacity peer-checked:opacity-100">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            className="modal-element h-3.5 w-3.5"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                            stroke="currentColor"
                                            strokeWidth="1"
                                        >
                                            <path
                                                fillRule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clipRule="evenodd"
                                            ></path>
                                        </svg>
                                    </div>
                                    {category.name}
                                </label>
                            ))}
                        </div>
                        <div className="px-4 py-3 rounded-full text-center bg-gray-50 dark:bg-black mb-4 modal-element">
                            Filter by Price
                        </div>
                        <div className="w-full mb-4 flex flex-col gap-2 modal-element">
                            <label
                                htmlFor="min-price"
                                className="modal-element"
                            >
                                Minimum price:
                            </label>
                            <input
                                type="number"
                                id="min-price"
                                step="any"
                                min={0}
                                className="modal-element w-full rounded-full dark:bg-black bg-gray-50 border px-4 py-1"
                                placeholder="Min price"
                                value={minPrice}
                                onChange={(e) =>
                                    setMinPrice(parseFloat(e.target.value))
                                }
                            />
                            <label
                                htmlFor="max-price"
                                className="modal-element"
                            >
                                Maximum price:
                            </label>
                            <input
                                type="number"
                                id="max-price"
                                step="any"
                                min={0}
                                className="modal-element w-full rounded-full dark:bg-black bg-gray-50 border px-4 py-1"
                                placeholder="Max price"
                                value={maxPrice}
                                onChange={(e) =>
                                    setMaxPrice(parseFloat(e.target.value))
                                }
                            />
                        </div>
                        <button
                            onClick={filter}
                            className="px-3 py-2 bg-purple-600 hover:bg-purple-700 dark:hover:bg-purple-700 w-full rounded-lg disabled:bg-opacity-50
                    disabled:hover:bg-opacity-50 text-white dark:disabled:hover:bg-opacity-50 disabled:bg-slate-700 disabled:hover:bg-slate-700 dark:disabled:hover:bg-slate-700 disabled:cursor-not-allowed transition duration-200"
                            disabled={
                                !checkedState.includes(true) &&
                                minPrice < 1 &&
                                maxPrice < 1
                            }
                        >
                            Filter
                        </button>
                        <button
                            onClick={reset}
                            className="text-white px-3 py-2 mt-4 bg-blue-600 hover:bg-blue-700 dark:hover:bg-blue-700 w-full rounded-lg disabled:bg-slate-700 disabled:hover:bg-slate-700 dark:disabled:hover:bg-slate-700 disabled:cursor-not-allowed transition duration-200"
                        >
                            Reset
                        </button>
                    </div>
                </div>
            </div>
            <aside className="fixed hidden lg:block max-w-1/4 p-3 overflow-auto h-[calc(100vh-72px)] rounded-md bg-white shadow-md dark:bg-slate-800">
                <div className="px-4 py-3 rounded-full text-center bg-gray-50 dark:bg-black">
                    Filter by Categories
                </div>
                <div className="flex flex-col gap-1 my-4 px-2">
                    {categories.map((category, index) => (
                        <label
                            className="relative flex gap-3 cursor-pointer items-center rounded-full p-1"
                            htmlFor={`checkbox-${index}`}
                            key={index}
                            data-ripple-dark="true"
                        >
                            <input
                                type="checkbox"
                                className="before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-md border border-blue-gray-200 transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-500 before:opacity-0 before:transition-opacity checked:border-purple-500 checked:bg-purple-500 checked:before:bg-purple-500 hover:before:opacity-10"
                                id={`checkbox-${index}`}
                                checked={checkedState[index]}
                                onChange={() => handleOnChange(index)}
                            />
                            <div className="pointer-events-none absolute top-2/4 left-[7px] -translate-y-2/4 text-white opacity-0 transition-opacity peer-checked:opacity-100">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    className="h-3.5 w-3.5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    stroke="currentColor"
                                    strokeWidth="1"
                                >
                                    <path
                                        fillRule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clipRule="evenodd"
                                    ></path>
                                </svg>
                            </div>
                            {category.name}
                        </label>
                    ))}
                </div>
                <div className="px-4 py-3 rounded-full text-center bg-gray-50 dark:bg-black mb-4">
                    Filter by Price
                </div>
                <div className="w-full mb-4 flex flex-col gap-2">
                    <label htmlFor="min-price">Minimum price:</label>
                    <input
                        type="number"
                        id="min-price"
                        step="any"
                        min={0}
                        className="w-full rounded-full dark:bg-black bg-gray-50 border px-4 py-1"
                        placeholder="Min price"
                        value={minPrice}
                        onChange={(e) =>
                            setMinPrice(parseFloat(e.target.value))
                        }
                    />
                    <label htmlFor="max-price">Maximum price:</label>
                    <input
                        type="number"
                        id="max-price"
                        step="any"
                        min={0}
                        className="w-full rounded-full dark:bg-black bg-gray-50 border px-4 py-1"
                        placeholder="Max price"
                        value={maxPrice}
                        onChange={(e) =>
                            setMaxPrice(parseFloat(e.target.value))
                        }
                    />
                </div>
                <button
                    onClick={filter}
                    className="px-3 py-2 bg-purple-600 hover:bg-purple-700 dark:hover:bg-purple-700 w-full rounded-lg disabled:bg-opacity-50
                    disabled:hover:bg-opacity-50 text-white dark:disabled:hover:bg-opacity-50 disabled:bg-slate-700 disabled:hover:bg-slate-700 dark:disabled:hover:bg-slate-700 disabled:cursor-not-allowed transition duration-200"
                    disabled={
                        !checkedState.includes(true) &&
                        minPrice < 1 &&
                        maxPrice < 1
                    }
                >
                    Filter
                </button>
                <button
                    onClick={reset}
                    className="text-white px-3 py-2 mt-4 bg-blue-600 hover:bg-blue-700 dark:hover:bg-blue-700 w-full rounded-lg disabled:bg-slate-700 disabled:hover:bg-slate-700 dark:disabled:hover:bg-slate-700 disabled:cursor-not-allowed transition duration-200"
                >
                    Reset
                </button>
            </aside>

            <div
                className="flex flex-col overflow-auto gap-6 items-center w-screen lg:ml-[35%] xl:ml-[25%] mt-16 lg:mt-4 ml-0"
                onScroll={handleScroll}
            >
                <div className="grid grid-cols-1 xl:grid-cols-3 md:grid-cols-2 w-2/3 lg:w-full gap-6">
                    {products.map((product, index) => (
                        <ProductCard
                            key={index}
                            id={product.id}
                            title={product.title}
                            image={product.image}
                            price={product.price}
                            bookmarkedProducts={bookmarkedProducts}
                            cart={cart}
                        />
                    ))}
                </div>
                {isLoading &&
                    nextPage &&
                    !nextPage.startsWith(
                        location.origin + "/api/get-products?page"
                    ) && (
                        <Loader
                            size={150}
                            color={"purple"}
                            loading={isLoading}
                        />
                    )}
            </div>
        </div>
    );
};

createRoot(document.getElementById("shop")).render(
    <Provider store={store}>
        <Shop />
    </Provider>
);
