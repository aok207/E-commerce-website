import React, { useEffect, useState } from "react";
import { createRoot } from "react-dom/client";
import { Provider } from "react-redux";
import { store } from "./store";
import { useSelector } from "react-redux";

const user = bladeUser;

const NavBarLink = ({ href, icon, text, isMobile, cartCount }) => {
    const currentPath = window.location.pathname;
    return (
        <>
            {isMobile ? (
                <>
                    {text === "Orders" ? (
                        <>
                            {user && (
                                <a href={href}>
                                    <li
                                        className={`mb-1 block p-4 text-sm font-semibold ${
                                            currentPath === href
                                                ? "bg-blue-600 text-white"
                                                : "text-gray-400 dark:text-white"
                                        } hover:bg-blue-500 hover:text-white rounded nav-link cursor-pointer`}
                                    >
                                        <i
                                            className={`fa-solid ${icon} ${
                                                text === "Cart"
                                                    ? "relative"
                                                    : ""
                                            }`}
                                        >
                                            {text === "Cart" && (
                                                <div className="rounded-full flex justify-center items-center p-1 px-[6px] bg-red-600 text-[9px] text-white absolute bottom-full left-[88%]">
                                                    {cartCount}
                                                </div>
                                            )}
                                        </i>{" "}
                                        <span>{text}</span>
                                    </li>
                                </a>
                            )}
                        </>
                    ) : (
                        <a href={href}>
                            <li
                                className={`mb-1 block p-4 text-sm font-semibold ${
                                    currentPath === href
                                        ? "bg-blue-600 text-white"
                                        : "text-gray-400 dark:text-white"
                                } hover:bg-blue-500 hover:text-white rounded nav-link cursor-pointer`}
                            >
                                <i
                                    className={`fa-solid ${icon} ${
                                        text === "Cart" ? "relative" : ""
                                    }`}
                                >
                                    {text === "Cart" && (
                                        <div className="rounded-full flex justify-center items-center p-1 px-[6px] bg-red-600 text-[9px] text-white absolute bottom-full left-[88%]">
                                            {cartCount}
                                        </div>
                                    )}
                                </i>{" "}
                                <span>{text}</span>
                            </li>
                        </a>
                    )}
                </>
            ) : (
                <li
                    className={`group cursor-pointer ${
                        currentPath === href
                            ? "text-blue-600 font-bold"
                            : "text-gray-400 hover:text-gray-500"
                    } nav-link`}
                >
                    <a href={href}>
                        <i
                            className={`fa-solid ${icon} ${
                                text === "Cart" ? "relative" : ""
                            }`}
                        >
                            {text === "Cart" && (
                                <div className="rounded-full flex justify-center items-center p-1 px-[6px] bg-red-600 text-[9px] text-white absolute -top-4 left-[88%]">
                                    {cartCount}
                                </div>
                            )}
                        </i>{" "}
                        <span className="text-sm" href={href}>
                            {text}
                        </span>
                    </a>
                </li>
            )}
        </>
    );
};

const navLinks = [
    { href: "/", icon: "fa-house", text: "Home" },
    { href: "/shop", icon: "fa-shop", text: "Shop" },
    { href: "/cart", icon: "fa-cart-shopping", text: "Cart" },
    { href: "/bookmarks", icon: "fa-bookmark", text: "Bookmarks" },
];

const mobileNavLinks = [
    ...navLinks,
    { href: "/orders", icon: "fa-clipboard-list", text: "Orders" },
];

const NavBar = () => {
    const [isMenuOpened, setIsMenuOpened] = useState(false);
    const [isProfileDropdownOpen, setIsProfileDropdownOpen] = useState(false);
    const [isMobileProfileDropdownOpen, setIsMobileProfileDropdownOpen] =
        useState(false);
    const cartCount = useSelector((state) => state.cart.count);

    useEffect(() => {
        const handleClickOutside = (event) => {
            if (!event.target.matches("#profile-toggle")) {
                setIsProfileDropdownOpen(false);
            }
            if (!event.target.matches("#profile-toggle-mobile")) {
                setIsMobileProfileDropdownOpen(false);
            }
        };

        window.addEventListener("click", handleClickOutside);

        return () => {
            window.removeEventListener("click", handleClickOutside);
        };
    }, []);

    const toggleProfileDropdown = () => {
        setIsProfileDropdownOpen(!isProfileDropdownOpen);
    };

    const toggleMobileProfileDropdown = () => {
        setIsMobileProfileDropdownOpen(!isMobileProfileDropdownOpen);
    };

    return (
        <>
            <nav className="relative px-4 py-4 flex justify-between items-center dark:bg-nav-black bg-white">
                <a className="text-3xl font-bold leading-none" href="/">
                    <img className="w-40" src="/logo.png" alt="" />
                </a>
                <div className="lg:hidden">
                    <button
                        className="navbar-burger flex items-center text-blue-600 dark:text-white p-3"
                        onClick={() =>
                            setIsMenuOpened((prevState) => !prevState)
                        }
                    >
                        <svg
                            className="block h-4 w-4 fill-current"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <title>Mobile menu</title>
                            <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                        </svg>
                    </button>
                </div>
                {/* Destop nav link */}
                <ul className="hidden absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2 lg:flex lg:mx-auto lg:items-center lg:w-auto lg:space-x-6">
                    {navLinks.map((navLink, index) => (
                        <NavBarLink
                            key={index}
                            href={navLink.href}
                            icon={navLink.icon}
                            text={navLink.text}
                            isMobile={false}
                            cartCount={cartCount}
                        />
                    ))}
                </ul>
                {user ? (
                    <div className="hidden lg:flex lg:items-center">
                        {user.is_admin === 1 && (
                            <a
                                href="/admin"
                                className="hidden lg:inline-block lg:ml-auto lg:mr-3 py-2 px-6 text-sm text-white dark:bg-blue-600 bg-black shadow-lg rounded-xl transition duration-200 hover:transform hover:-translate-x-1"
                            >
                                <i className="fa-solid fa-gauge"></i> Dashboard
                            </a>
                        )}

                        <a
                            href="/orders"
                            className="hidden lg:inline-block lg:ml-auto lg:mr-3 py-2 px-6 bg-blue-200 dark:bg-transparent dark:text-white dark:border dark:border-blue-600 hover:bg-blue-300 dark:hover:bg-blue-600 text-sm text-black font-bold  rounded-xl transition duration-200"
                        >
                            <i className="fa-solid fa-clipboard-list"></i>{" "}
                            Orders
                        </a>
                        <button
                            className="hidden lg:inline-flex p-2 rounded-full gap-2 items-center h-fit dark:text-gray-50"
                            onClick={toggleProfileDropdown}
                            id="profile-toggle"
                        >
                            <i className="fa-solid fa-user"></i> {user.name}{" "}
                            <i className="fa-solid fa-angle-down"></i>
                        </button>

                        <ul
                            className={`${
                                isProfileDropdownOpen ? "block" : "hidden"
                            } absolute w-32 right-6 top-14 flex items-center flex-col gap-2 bg-slate-200 dark:bg-dropdown-black dark:text-gray-50 rounded-lg shadow-md z-50`}
                        >
                            <li className="w-full hover:bg-gray-400 px-4 py-2 hover:text-white text-center rounded-t-lg">
                                <a href="/profile">
                                    <i className="fa-solid fa-user"></i> Profile
                                </a>
                            </li>
                            <li className="w-full hover:bg-gray-400 px-4 py-2 hover:text-white text-center rounded-b-lg">
                                <a href="/logout">
                                    <i className="fa-solid fa-arrow-right-from-bracket"></i>{" "}
                                    Log out
                                </a>
                            </li>
                        </ul>
                    </div>
                ) : (
                    <>
                        <a
                            className="hidden lg:inline-block lg:ml-auto lg:mr-3 py-2 px-6 bg-gray-50 hover:bg-gray-100 text-sm text-gray-900 font-bold  rounded-xl transition duration-200"
                            href="/login"
                        >
                            Log In
                        </a>
                        <a
                            className="hidden lg:inline-block py-2 px-6 bg-blue-500 hover:bg-blue-600 text-sm text-white font-bold rounded-xl transition duration-200"
                            href="/register"
                        >
                            Register
                        </a>
                    </>
                )}
            </nav>
            <div
                className={`navbar-menu relative z-50 ${
                    !isMenuOpened ? "hidden" : ""
                }`}
            >
                <div
                    className="navbar-backdrop fixed inset-0 bg-gray-800 opacity-25"
                    onClick={() => setIsMenuOpened((prevState) => !prevState)}
                ></div>
                <nav className="fixed top-0 left-0 bottom-0 flex flex-col w-5/6 max-w-sm py-6 px-6 bg-white dark:bg-nav-black border-r dark:border-r-0 overflow-y-auto">
                    <div className="flex items-center mb-8">
                        <a className="text-3xl font-bold leading-none" href="/">
                            <img className="w-40" src="/logo.png" alt="" />
                        </a>
                        <button
                            className="navbar-close"
                            onClick={() =>
                                setIsMenuOpened((prevState) => !prevState)
                            }
                        >
                            <svg
                                className="h-6 w-6 text-gray-400 cursor-pointer hover:text-gray-500"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="2"
                                    d="M6 18L18 6M6 6l12 12"
                                ></path>
                            </svg>
                        </button>
                    </div>
                    <div>
                        <ul>
                            {mobileNavLinks.map((link, index) => (
                                <NavBarLink
                                    key={index}
                                    href={link.href}
                                    icon={link.icon}
                                    text={link.text}
                                    isMobile={true}
                                    cartCount={cartCount}
                                />
                            ))}
                        </ul>
                    </div>
                    <div className="mt-auto">
                        <div className="pt-6">
                            {user ? (
                                <>
                                    <button
                                        className="w-full justify-start p-2 rounded-full flex gap-2 items-center h-fit mb-3 dark:text-white"
                                        onClick={toggleMobileProfileDropdown}
                                        id="profile-toggle-mobile"
                                    >
                                        <i className="fa-solid fa-user"></i>
                                        {user.name}
                                        <i className="fa-solid fa-angle-down"></i>
                                    </button>

                                    <ul
                                        className={`${
                                            isMobileProfileDropdownOpen
                                                ? "block"
                                                : "hidden"
                                        } absolute w-32 left-6 bottom-24 flex items-center flex-col gap-2 bg-slate-200 rounded-lg shadow-md dark:bg-dropdown-black dark:text-gray-50`}
                                    >
                                        <li className="w-full hover:bg-gray-400 px-4 py-2 hover:text-white text-center rounded-t-lg">
                                            <a href="/profile">
                                                <i className="fa-solid fa-user"></i>{" "}
                                                Profile
                                            </a>
                                        </li>
                                        <li className="w-full hover:bg-gray-400 px-4 py-2 hover:text-white text-center rounded-b-lg">
                                            <a href="/logout">
                                                <i className="fa-solid fa-arrow-right-from-bracket"></i>{" "}
                                                Log out
                                            </a>
                                        </li>
                                    </ul>

                                    {user.is_admin === 1 && (
                                        <a
                                            href="/admin"
                                            className="py-2 px-6 text-sm text-white bg-black shadow-lg rounded-xl transition duration-200 hover:bg-slate-700 dark:bg-blue-600 dark:hover:bg-blue-700"
                                        >
                                            <i className="fa-solid fa-gauge"></i>{" "}
                                            Dashboard
                                        </a>
                                    )}
                                </>
                            ) : (
                                <>
                                    <a
                                        className="block px-4 py-3 mb-3 text-xs text-center font-semibold leading-none bg-gray-50 hover:bg-gray-100 rounded-xl"
                                        href="/login"
                                    >
                                        Log in
                                    </a>
                                    <a
                                        className="block px-4 py-3 mb-2 leading-loose text-xs text-center text-white font-semibold bg-blue-600 hover:bg-blue-700  rounded-xl"
                                        href="register"
                                    >
                                        Register
                                    </a>
                                </>
                            )}
                        </div>
                    </div>
                </nav>
            </div>
        </>
    );
};

createRoot(document.getElementById("navbar")).render(
    <Provider store={store}>
        <NavBar />
    </Provider>
);
