import { useState } from "react";
import { createRoot } from "react-dom/client";
import axios from "axios";
import showToast from "./utils/Toast";

const cart = bladeCart;
const cartItems = bladeCartItems;

const CheckoutPage = () => {
    const [email, setEmail] = useState("");
    const [address, setAddress] = useState("");
    const [city, setCity] = useState("");
    const [zip, setZip] = useState("");

    const [currentStep, setCurrentStep] = useState("shipping"); // "shipping" and "summary"

    const taxPrice = (parseFloat(cart.total_price) * (10 / 100)).toFixed(2);

    const handleShippingFormSubmit = (e) => {
        e.preventDefault();
        setCurrentStep("summary");
    };

    const handlePlaceOrder = () => {
        axios
            .post("/api/place-order", {
                email: email,
                address: address,
                city: city,
                zip: zip,
                tax_price: parseFloat(taxPrice),
                total_price:
                    parseFloat(taxPrice) + parseFloat(cart.total_price),
            })
            .then((res) => {
                if (res.data.success) {
                    showToast(
                        "Order Created. Redirecting to order...",
                        "green"
                    );
                    setTimeout(() => {
                        window.location.replace(res.data.redirect_url);
                    }, 2000);
                }
            })
            .catch((err) => {
                console.log(err);
            });
    };

    return (
        <div className="md:w-[80%] w-full mx-auto p-6">
            <div>
                <div className="overflow-hidden rounded-full bg-gray-200">
                    <div
                        className={`h-2 ${
                            currentStep === "shipping" ? "w-1/2" : "w-full"
                        } rounded-full bg-blue-500`}
                    ></div>
                </div>

                <ol className="mt-4 grid grid-cols-3 text-sm font-medium text-gray-500">
                    <li className="flex items-center justify-start text-blue-600 sm:gap-1.5">
                        <span className="hidden sm:inline"> Cart </span>

                        <svg
                            fill="rgb(37 99 235)"
                            className="w-5 h-5"
                            version="1.1"
                            id="Capa_1"
                            xmlns="http://www.w3.org/2000/svg"
                            xmlnsXlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 902.86 902.86"
                            xmlSpace="preserve"
                        >
                            <g id="SVGRepo_bgCarrier" strokeWidth="2"></g>
                            <g
                                id="SVGRepo_tracerCarrier"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                stroke="currentColor"
                            ></g>
                            <g id="SVGRepo_iconCarrier">
                                {" "}
                                <g>
                                    {" "}
                                    <g>
                                        {" "}
                                        <path d="M671.504,577.829l110.485-432.609H902.86v-68H729.174L703.128,179.2L0,178.697l74.753,399.129h596.751V577.829z M685.766,247.188l-67.077,262.64H131.199L81.928,246.756L685.766,247.188z"></path>{" "}
                                        <path d="M578.418,825.641c59.961,0,108.743-48.783,108.743-108.744s-48.782-108.742-108.743-108.742H168.717 c-59.961,0-108.744,48.781-108.744,108.742s48.782,108.744,108.744,108.744c59.962,0,108.743-48.783,108.743-108.744 c0-14.4-2.821-28.152-7.927-40.742h208.069c-5.107,12.59-7.928,26.342-7.928,40.742 C469.675,776.858,518.457,825.641,578.418,825.641z M209.46,716.897c0,22.467-18.277,40.744-40.743,40.744 c-22.466,0-40.744-18.277-40.744-40.744c0-22.465,18.277-40.742,40.744-40.742C191.183,676.155,209.46,694.432,209.46,716.897z M619.162,716.897c0,22.467-18.277,40.744-40.743,40.744s-40.743-18.277-40.743-40.744c0-22.465,18.277-40.742,40.743-40.742 S619.162,694.432,619.162,716.897z"></path>{" "}
                                    </g>{" "}
                                </g>{" "}
                            </g>
                        </svg>
                    </li>

                    <li className="flex items-center justify-center text-blue-600 sm:gap-1.5">
                        <span className="hidden sm:inline"> Shipping </span>

                        <svg
                            className="size-6 sm:size-5"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            strokeWidth="2"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                            />
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                        </svg>
                    </li>

                    <li
                        className={`flex items-center justify-end sm:gap-1.5 ${
                            currentStep === "summary" ? "text-blue-600" : ""
                        }`}
                    >
                        <span className="hidden sm:inline"> Summary </span>

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            xmlns="http://www.w3.org/2000/svg"
                            className="w-6 h-6"
                        >
                            <g id="SVGRepo_bgCarrier" strokeWidth="0"></g>
                            <g
                                id="SVGRepo_tracerCarrier"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                            ></g>
                            <g id="SVGRepo_iconCarrier">
                                {" "}
                                <path
                                    d="M8 5.00005C7.01165 5.00082 6.49359 5.01338 6.09202 5.21799C5.71569 5.40973 5.40973 5.71569 5.21799 6.09202C5 6.51984 5 7.07989 5 8.2V17.8C5 18.9201 5 19.4802 5.21799 19.908C5.40973 20.2843 5.71569 20.5903 6.09202 20.782C6.51984 21 7.07989 21 8.2 21H15.8C16.9201 21 17.4802 21 17.908 20.782C18.2843 20.5903 18.5903 20.2843 18.782 19.908C19 19.4802 19 18.9201 19 17.8V8.2C19 7.07989 19 6.51984 18.782 6.09202C18.5903 5.71569 18.2843 5.40973 17.908 5.21799C17.5064 5.01338 16.9884 5.00082 16 5.00005M8 5.00005V7H16V5.00005M8 5.00005V4.70711C8 4.25435 8.17986 3.82014 8.5 3.5C8.82014 3.17986 9.25435 3 9.70711 3H14.2929C14.7456 3 15.1799 3.17986 15.5 3.5C15.8201 3.82014 16 4.25435 16 4.70711V5.00005M16 11H14M16 16H14M8 11L9 12L11 10M8 16L9 17L11 15"
                                    stroke="currentColor"
                                    strokeWidth="2"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                ></path>{" "}
                            </g>
                        </svg>
                    </li>
                </ol>
            </div>

            <div className="mt-6 text-black dark:text-white">
                <div className="flex gap-4 items-center mb-8">
                    {currentStep === "summary" && (
                        <button onClick={() => setCurrentStep("shipping")}>
                            <i className="fa-solid fa-arrow-left"></i>
                        </button>
                    )}
                    <h1 className="text-2xl font-extrabold">
                        {currentStep === "shipping"
                            ? "Shipping"
                            : "Order Summary"}
                    </h1>
                </div>
                {currentStep === "shipping" ? (
                    <form onSubmit={handleShippingFormSubmit}>
                        <label className="flex flex-col gap-2 text-sm mb-4">
                            <span className="text-gray-700 dark:text-gray-400">
                                Email to contact
                            </span>
                            <input
                                className="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input px-3 py-2 rounded-md dark:focus:outline-white focus:outline-black bg-slate-200"
                                type="email"
                                name="email"
                                aria-label="email"
                                required
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                            />
                        </label>
                        <label className="flex flex-col gap-2 text-sm mb-4">
                            <span className="text-gray-700 dark:text-gray-400">
                                Address
                            </span>
                            <input
                                className="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input px-3 py-2 rounded-md dark:focus:outline-white focus:outline-black bg-slate-200"
                                type="text"
                                name="address"
                                aria-label="address"
                                required
                                value={address}
                                onChange={(e) => setAddress(e.target.value)}
                            />
                        </label>

                        <label className="flex flex-col gap-2 text-sm mb-4">
                            <span className="text-gray-700 dark:text-gray-400">
                                Zip Code
                            </span>
                            <input
                                className="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input px-3 py-2 rounded-md dark:focus:outline-white focus:outline-black bg-slate-200"
                                type="text"
                                name="zip"
                                aria-label="zip code"
                                required
                                value={zip}
                                onChange={(e) => setZip(e.target.value)}
                            />
                        </label>
                        <label className="flex flex-col gap-2 text-sm mb-4">
                            <span className="text-gray-700 dark:text-gray-400">
                                City
                            </span>
                            <input
                                className="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input px-3 py-2 rounded-md dark:focus:outline-white focus:outline-black bg-slate-200"
                                type="text"
                                name="city"
                                aria-label="city"
                                required
                                value={city}
                                onChange={(e) => setCity(e.target.value)}
                            />
                        </label>
                        <label className="flex flex-col gap-2 text-sm mb-4">
                            <span className="text-gray-700 dark:text-gray-400">
                                Payment method
                            </span>
                            <div className="flex items-center gap-1">
                                <input
                                    type="radio"
                                    name="payment_method"
                                    checked
                                    readOnly
                                />{" "}
                                Paypal
                            </div>
                        </label>
                        <button
                            type="submit"
                            className="px-4 mt-3 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple w-full lg:w-fit"
                        >
                            Continue
                        </button>
                    </form>
                ) : (
                    <>
                        <div className="w-full overflow-hidden rounded-md">
                            <div className="w-full overflow-x-auto">
                                <table className="w-full whitespace-no-wrap">
                                    <thead>
                                        <tr className="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                            <th className="px-4 py-3">image</th>
                                            <th className="px-4 py-3">
                                                product name
                                            </th>
                                            <th className="px-4 py-3">
                                                quantity
                                            </th>
                                            <th className="px-4 py-3">price</th>
                                            <th className="px-4 py-3">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody className="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                        {cartItems.map((item) => (
                                            <tr
                                                key={item.product.title}
                                                className="text-gray-700 dark:text-gray-400 user-row"
                                            >
                                                <td className="px-4 py-3">
                                                    <div className="flex items-center text-sm w-[120px]">
                                                        {item.product.image.startsWith(
                                                            "https"
                                                        ) ? (
                                                            <img
                                                                src={
                                                                    item.product
                                                                        .image
                                                                }
                                                                alt={
                                                                    item.product
                                                                        .title
                                                                }
                                                                className="w-full h-full object-cover"
                                                            />
                                                        ) : (
                                                            <img
                                                                src={
                                                                    "/images/" +
                                                                    item.product
                                                                        .image
                                                                }
                                                                alt={
                                                                    item.product
                                                                        .title
                                                                }
                                                                className="w-full h-full object-cover"
                                                            />
                                                        )}
                                                    </div>
                                                </td>
                                                <td className="px-4 py-3 text-sm text-wrap">
                                                    {item.product.title}
                                                </td>
                                                <td className="px-4 py-3 text-sm text-wrap">
                                                    {item.quantity}
                                                </td>
                                                <td className="px-4 py-3 text-sm">
                                                    {item.product.price}
                                                </td>
                                                <td className="px-4 py-3 text-sm">
                                                    {(
                                                        parseFloat(
                                                            item.product.price
                                                        ) *
                                                        parseFloat(
                                                            item.quantity
                                                        )
                                                    ).toFixed(2)}
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div className="dark:bg-gray-800 w-full bg-white rounded-md my-6 flex justify-between p-7">
                            <div className="flex flex-col gap-2">
                                <p>
                                    <span>Items:</span> ${cart.total_price}
                                </p>
                                <p>
                                    <span>Shipping:</span> $0.00
                                </p>
                                <p>
                                    <span>Tax:</span> ${taxPrice}
                                </p>
                                <p>
                                    <span>Total:</span> $
                                    {parseFloat(taxPrice) +
                                        parseFloat(cart.total_price)}
                                </p>
                            </div>
                            <div className="flex flex-col gap-2">
                                <h1 className="dark:text-white text-black text-xl font-bold mb-4">
                                    Shipping
                                </h1>
                                <p>
                                    <span>Email:</span> {email}
                                </p>
                                <p>
                                    <span>Address:</span> {address}
                                </p>
                                <p>
                                    <span>Zip code:</span> {zip}
                                </p>
                                <p>
                                    <span>City:</span> {city}
                                </p>
                            </div>
                            <div className="flex flex-col gap-2">
                                <h1 className="dark:text-white text-black text-xl font-bold mb-4">
                                    Payment
                                </h1>
                                <p>
                                    <span>Method:</span> Paypal
                                </p>
                            </div>
                        </div>
                        <button
                            className="px-4 mt-3 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-full active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple w-full"
                            onClick={handlePlaceOrder}
                        >
                            Place Order
                        </button>
                    </>
                )}
            </div>
        </div>
    );
};

createRoot(document.getElementById("checkout")).render(<CheckoutPage />);
