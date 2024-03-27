@extends('admin.layout.master')

@section('css')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection

@section('desktop-sidebar')
    <div class="flex flex-col h-full justify-between py-4 text-gray-500 dark:text-gray-400">
        <div>

            <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="{{ route('admin.dashboard') }}">
                ShopNest Admin
            </a>
            <ul class="mt-6">
                <li class="relative px-6 py-3">

                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 "
                        href="{{ route('admin.dashboard') }}">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="ml-4">Dashboard</span>
                    </a>
                </li>
            </ul>
            <ul>
                <li class="relative px-6 py-3">

                    <a class=" inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        href="{{ route('admin.users.index') }}">
                        <svg class="w-6 h-6" viewBox="0 -0.5 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"
                            stroke="currentColor">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M14.875 7.375C14.875 8.68668 13.8117 9.75 12.5 9.75C11.1883 9.75 10.125 8.68668 10.125 7.375C10.125 6.06332 11.1883 5 12.5 5C13.8117 5 14.875 6.06332 14.875 7.375Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M17.25 15.775C17.25 17.575 15.123 19.042 12.5 19.042C9.877 19.042 7.75 17.579 7.75 15.775C7.75 13.971 9.877 12.509 12.5 12.509C15.123 12.509 17.25 13.971 17.25 15.775Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M19.9 9.55301C19.9101 10.1315 19.5695 10.6588 19.0379 10.8872C18.5063 11.1157 17.8893 11 17.4765 10.5945C17.0638 10.189 16.9372 9.57418 17.1562 9.03861C17.3753 8.50305 17.8964 8.1531 18.475 8.15301C19.255 8.14635 19.8928 8.77301 19.9 9.55301V9.55301Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5.10001 9.55301C5.08986 10.1315 5.43054 10.6588 5.96214 10.8872C6.49375 11.1157 7.11072 11 7.52347 10.5945C7.93621 10.189 8.06278 9.57418 7.84376 9.03861C7.62475 8.50305 7.10363 8.1531 6.52501 8.15301C5.74501 8.14635 5.10716 8.77301 5.10001 9.55301Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                                <path
                                    d="M19.2169 17.362C18.8043 17.325 18.4399 17.6295 18.403 18.0421C18.366 18.4547 18.6705 18.8191 19.0831 18.856L19.2169 17.362ZM22 15.775L22.7455 15.8567C22.7515 15.8023 22.7515 15.7474 22.7455 15.693L22 15.775ZM19.0831 12.695C18.6705 12.7319 18.366 13.0963 18.403 13.5089C18.4399 13.9215 18.8044 14.226 19.2169 14.189L19.0831 12.695ZM5.91689 18.856C6.32945 18.8191 6.63395 18.4547 6.59701 18.0421C6.56007 17.6295 6.19567 17.325 5.78311 17.362L5.91689 18.856ZM3 15.775L2.25449 15.693C2.24851 15.7474 2.2485 15.8023 2.25446 15.8567L3 15.775ZM5.78308 14.189C6.19564 14.226 6.56005 13.9215 6.59701 13.5089C6.63397 13.0963 6.32948 12.7319 5.91692 12.695L5.78308 14.189ZM19.0831 18.856C20.9169 19.0202 22.545 17.6869 22.7455 15.8567L21.2545 15.6933C21.1429 16.7115 20.2371 17.4533 19.2169 17.362L19.0831 18.856ZM22.7455 15.693C22.5444 13.8633 20.9165 12.5307 19.0831 12.695L19.2169 14.189C20.2369 14.0976 21.1426 14.839 21.2545 15.8569L22.7455 15.693ZM5.78311 17.362C4.76287 17.4533 3.85709 16.7115 3.74554 15.6933L2.25446 15.8567C2.45496 17.6869 4.08306 19.0202 5.91689 18.856L5.78311 17.362ZM3.74551 15.8569C3.85742 14.839 4.76309 14.0976 5.78308 14.189L5.91692 12.695C4.08354 12.5307 2.45564 13.8633 2.25449 15.693L3.74551 15.8569Z"
                                    fill="currentColor"></path>
                            </g>
                        </svg>
                        <span class="ml-4">Users</span>
                    </a>
                <li class="relative px-6 py-3">

                    <a class=" inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        href="{{ route('admin.products.index') }}">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class="ml-4">Products</span>
                    </a>
                </li>
                </li>
                <li class="relative px-6 py-3">

                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        href="{{ route('admin.categories.index') }}">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            stroke="currentColor">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M17 10H19C21 10 22 9 22 7V5C22 3 21 2 19 2H17C15 2 14 3 14 5V7C14 9 15 10 17 10Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path d="M5 22H7C9 22 10 21 10 19V17C10 15 9 14 7 14H5C3 14 2 15 2 17V19C2 21 3 22 5 22Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path
                                    d="M6 10C8.20914 10 10 8.20914 10 6C10 3.79086 8.20914 2 6 2C3.79086 2 2 3.79086 2 6C2 8.20914 3.79086 10 6 10Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path
                                    d="M18 22C20.2091 22 22 20.2091 22 18C22 15.7909 20.2091 14 18 14C15.7909 14 14 15.7909 14 18C14 20.2091 15.7909 22 18 22Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </g>
                        </svg>
                        <span class="ml-4">Categories</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
                        href="{{ route('admin.orders.index') }}">
                        <svg version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" xml:space="preserve"
                            class="w-5 h- 5" fill="none">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <style type="text/css">
                                    .st0 {
                                        fill: none;
                                        stroke: currentColor;
                                        stroke-width: 2;
                                        stroke-linecap: round;
                                        stroke-linejoin: round;
                                        stroke-miterlimit: 10;
                                    }

                                    .st1 {
                                        fill: none;
                                        stroke: currentColor;
                                        stroke-width: 2;
                                        stroke-linecap: round;
                                        stroke-linejoin: round;
                                        stroke-miterlimit: 10;
                                        stroke-dasharray: 3;
                                    }

                                    .st2 {
                                        fill: none;
                                        stroke: currentColor;
                                        stroke-width: 2;
                                        stroke-linejoin: round;
                                        stroke-miterlimit: 10;
                                    }

                                    .st3 {
                                        fill: none;
                                    }
                                </style>
                                <line class="st0" x1="9" y1="29" x2="23" y2="29">
                                </line>
                                <path class="st0" d="M13,23c0,2.1-0.7,4.6-1.8,6"></path>
                                <path class="st0" d="M20.8,29c-1.1-1.4-1.8-3.9-1.8-6"></path>
                                <path class="st0"
                                    d="M13,18h5V7H3V6c0-1.1,0.9-2,2-2h22c1.1,0,2,0.9,2,2v15c0,1.1-0.9,2-2,2H5c-1.1,0-2-0.9-2-2v-8">
                                </path>
                                <circle class="st0" cx="22" cy="18" r="2"></circle>
                                <circle class="st0" cx="11" cy="18" r="2"></circle>
                                <polyline class="st0" points="18,18 18,10 23,10 26,14 26,18 24,18 ">
                                </polyline>
                                <line class="st0" x1="4" y1="10" x2="13" y2="10">
                                </line>
                                <line class="st0" x1="2" y1="13" x2="11" y2="13">
                                </line>
                                <rect x="-288" y="-576" class="st3" width="536" height="680"></rect>
                            </g>
                        </svg>
                        <span class="ml-4">Orders</span>
                    </a>
                </li>

            </ul>
        </div>
        <div class="px-6 my-6">
            <a class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                href="{{ route('home') }}">
                Go to home page
                <span class="ml-2" aria-hidden="true">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M7 17L17 7M17 7H8M17 7V16" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                </span>
            </a>
        </div>
    </div>
@endsection

@section('mobile-sidebar')
    <div class="flex flex-col h-full justify-between py-4 text-gray-500 dark:text-gray-400">
        <div>
            <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="{{ route('admin.dashboard') }}">
                ShopNest Admin
            </a>
            <ul class="mt-6">
                <li class="relative px-6 py-3">

                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        href="{{ route('admin.dashboard') }}">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="ml-4">Dashboard</span>
                    </a>
                </li>
            </ul>
            <ul>
                <li class="relative px-6 py-3">

                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        href="{{ route('admin.users.index') }}">
                        <svg class="w-6 h-6" viewBox="0 -0.5 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"
                            stroke="currentColor">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M14.875 7.375C14.875 8.68668 13.8117 9.75 12.5 9.75C11.1883 9.75 10.125 8.68668 10.125 7.375C10.125 6.06332 11.1883 5 12.5 5C13.8117 5 14.875 6.06332 14.875 7.375Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                </path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M17.25 15.775C17.25 17.575 15.123 19.042 12.5 19.042C9.877 19.042 7.75 17.579 7.75 15.775C7.75 13.971 9.877 12.509 12.5 12.509C15.123 12.509 17.25 13.971 17.25 15.775Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                </path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M19.9 9.55301C19.9101 10.1315 19.5695 10.6588 19.0379 10.8872C18.5063 11.1157 17.8893 11 17.4765 10.5945C17.0638 10.189 16.9372 9.57418 17.1562 9.03861C17.3753 8.50305 17.8964 8.1531 18.475 8.15301C19.255 8.14635 19.8928 8.77301 19.9 9.55301V9.55301Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                </path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5.10001 9.55301C5.08986 10.1315 5.43054 10.6588 5.96214 10.8872C6.49375 11.1157 7.11072 11 7.52347 10.5945C7.93621 10.189 8.06278 9.57418 7.84376 9.03861C7.62475 8.50305 7.10363 8.1531 6.52501 8.15301C5.74501 8.14635 5.10716 8.77301 5.10001 9.55301Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                </path>
                                <path
                                    d="M19.2169 17.362C18.8043 17.325 18.4399 17.6295 18.403 18.0421C18.366 18.4547 18.6705 18.8191 19.0831 18.856L19.2169 17.362ZM22 15.775L22.7455 15.8567C22.7515 15.8023 22.7515 15.7474 22.7455 15.693L22 15.775ZM19.0831 12.695C18.6705 12.7319 18.366 13.0963 18.403 13.5089C18.4399 13.9215 18.8044 14.226 19.2169 14.189L19.0831 12.695ZM5.91689 18.856C6.32945 18.8191 6.63395 18.4547 6.59701 18.0421C6.56007 17.6295 6.19567 17.325 5.78311 17.362L5.91689 18.856ZM3 15.775L2.25449 15.693C2.24851 15.7474 2.2485 15.8023 2.25446 15.8567L3 15.775ZM5.78308 14.189C6.19564 14.226 6.56005 13.9215 6.59701 13.5089C6.63397 13.0963 6.32948 12.7319 5.91692 12.695L5.78308 14.189ZM19.0831 18.856C20.9169 19.0202 22.545 17.6869 22.7455 15.8567L21.2545 15.6933C21.1429 16.7115 20.2371 17.4533 19.2169 17.362L19.0831 18.856ZM22.7455 15.693C22.5444 13.8633 20.9165 12.5307 19.0831 12.695L19.2169 14.189C20.2369 14.0976 21.1426 14.839 21.2545 15.8569L22.7455 15.693ZM5.78311 17.362C4.76287 17.4533 3.85709 16.7115 3.74554 15.6933L2.25446 15.8567C2.45496 17.6869 4.08306 19.0202 5.91689 18.856L5.78311 17.362ZM3.74551 15.8569C3.85742 14.839 4.76309 14.0976 5.78308 14.189L5.91692 12.695C4.08354 12.5307 2.45564 13.8633 2.25449 15.693L3.74551 15.8569Z"
                                    fill="currentColor"></path>
                            </g>
                        </svg>
                        <span class="ml-4">Users</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">

                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        href="{{ route('admin.products.index') }}">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class="ml-4">Products</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">

                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        href="{{ route('admin.categories.index') }}">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            stroke="currentColor">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M17 10H19C21 10 22 9 22 7V5C22 3 21 2 19 2H17C15 2 14 3 14 5V7C14 9 15 10 17 10Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M5 22H7C9 22 10 21 10 19V17C10 15 9 14 7 14H5C3 14 2 15 2 17V19C2 21 3 22 5 22Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                <path
                                    d="M6 10C8.20914 10 10 8.20914 10 6C10 3.79086 8.20914 2 6 2C3.79086 2 2 3.79086 2 6C2 8.20914 3.79086 10 6 10Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                <path
                                    d="M18 22C20.2091 22 22 20.2091 22 18C22 15.7909 20.2091 14 18 14C15.7909 14 14 15.7909 14 18C14 20.2091 15.7909 22 18 22Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>
                        <span class="ml-4">Categories</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100 "
                        href="{{ route('admin.orders.index') }}">
                        <svg version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" xml:space="preserve"
                            class="w-5 h- 5" fill="none">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <style type="text/css">
                                    .st0 {
                                        fill: none;
                                        stroke: currentColor;
                                        stroke-width: 2;
                                        stroke-linecap: round;
                                        stroke-linejoin: round;
                                        stroke-miterlimit: 10;
                                    }

                                    .st1 {
                                        fill: none;
                                        stroke: currentColor;
                                        stroke-width: 2;
                                        stroke-linecap: round;
                                        stroke-linejoin: round;
                                        stroke-miterlimit: 10;
                                        stroke-dasharray: 3;
                                    }

                                    .st2 {
                                        fill: none;
                                        stroke: currentColor;
                                        stroke-width: 2;
                                        stroke-linejoin: round;
                                        stroke-miterlimit: 10;
                                    }

                                    .st3 {
                                        fill: none;
                                    }
                                </style>
                                <line class="st0" x1="9" y1="29" x2="23" y2="29">
                                </line>
                                <path class="st0" d="M13,23c0,2.1-0.7,4.6-1.8,6"></path>
                                <path class="st0" d="M20.8,29c-1.1-1.4-1.8-3.9-1.8-6"></path>
                                <path class="st0"
                                    d="M13,18h5V7H3V6c0-1.1,0.9-2,2-2h22c1.1,0,2,0.9,2,2v15c0,1.1-0.9,2-2,2H5c-1.1,0-2-0.9-2-2v-8">
                                </path>
                                <circle class="st0" cx="22" cy="18" r="2"></circle>
                                <circle class="st0" cx="11" cy="18" r="2"></circle>
                                <polyline class="st0" points="18,18 18,10 23,10 26,14 26,18 24,18 ">
                                </polyline>
                                <line class="st0" x1="4" y1="10" x2="13" y2="10">
                                </line>
                                <line class="st0" x1="2" y1="13" x2="11" y2="13">
                                </line>
                                <rect x="-288" y="-576" class="st3" width="536" height="680"></rect>
                            </g>
                        </svg>
                        <span class="ml-4">Orders</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="px-6">
            <a class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                href="{{ route('home') }}">
                Go to home page
                <span class="ml-2" aria-hidden="true">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M7 17L17 7M17 7H8M17 7V16" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                </span>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="min-w-0 p-4 m-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <h4 class="mb-4 text-2xl font-bold text-gray-600 dark:text-gray-300">
            Order id {{ $order->id }}
        </h4>
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-4 mb-4">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">
                                image
                            </th>
                            <th class="px-4 py-3">product name</th>
                            <th class="px-4 py-3">price</th>
                            <th class="px-4 py-3">quantity</th>
                            <th class="px-4 py-3">total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach ($order_items as $order_item)
                            <tr class="text-gray-700 dark:text-gray-400 user-row">
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm w-[120px]">
                                        @if (str_starts_with($order_item->product->image, 'https:'))
                                            <img src="{{ $order_item->product->image }}"
                                                alt="{{ $order_item->product->image }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <img src="{{ asset('images/' . $order_item->product->image) }}"
                                                alt="">
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-wrap">
                                    {{ $order_item->product->title }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    ${{ $order_item->product->price }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $order_item->quantity }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    ${{ $order_item->quantity * $order_item->product->price }}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <h4 class="mb-4 text-2xl font-bold text-gray-600 dark:text-gray-300">
            Shipping
        </h4>

        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-4 mb-4 p-4">
            <div class="text-black text-md dark:text-white">
                <span class="text-purple-600 font-semibold">Order: </span>
                {{ $order->id }}
            </div>
            <div class="text-black text-md dark:text-white">
                <span class="text-purple-600 font-semibold">Name: </span>
                {{ $order->user->name }}
            </div>
            <div class="text-black text-md dark:text-white">
                <span class="text-purple-600 font-semibold">Email: </span>
                {{ $order->payment->email }}
            </div>
            <div class="text-black text-md dark:text-white">
                <span class="text-purple-600 font-semibold">Shipping Address: </span>
                {{ $order->payment->shipping_address }}
            </div>
            <div class="text-black text-md dark:text-white">
                <span class="text-purple-600 font-semibold">Zip Code: </span>
                {{ $order->payment->zip_code }}
            </div>
            <div class="text-black text-md dark:text-white">
                <span class="text-purple-600 font-semibold">City: </span>
                {{ $order->payment->city }}
            </div>
            <div class="text-black text-md dark:text-white">
                <span class="text-purple-600 font-semibold">Method: </span>
                {{ $order->payment->payment_type }}
            </div>
        </div>
        @if ($order->payment->payment_status === 'paid')
            <div class="w-full bg-green-500 text-sm rounded-md flex items-center text-white p-2">Paid on
                {{ $order->payment->updated_at }}</div>
        @else
            <div class="w-full text-sm bg-red-500 rounded-md flex items-center text-white p-2">Haven't paid yet.</div>
        @endif

        <h4 class="mb-4 text-2xl font-bold text-gray-600 dark:text-gray-300 mt-6">
            Order Summary
        </h4>

        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-4 mb-4 p-4">
            <div class="text-black text-md flex justify-between w-[50%] dark:text-white">
                <span class="text-black dark:text-white font-semibold">Items: </span>
                ${{ $order->payment->total_items_price }}
            </div>
            <div class="text-black text-md flex justify-between w-[50%] dark:text-white">
                <span class="text-black dark:text-white font-semibold">Shipping: </span>
                ${{ $order->payment->shipping_fees }}
            </div>
            <div class="text-black text-md flex justify-between w-[50%] dark:text-white">
                <span class="text-black dark:text-white font-semibold">Tax: </span>
                ${{ $order->payment->tax_fees }}
            </div>
            <hr class="my-4">
            <div class="text-black text-md flex justify-between w-[50%] dark:text-white">
                <span class="text-black dark:text-white font-semibold">Total: </span>
                ${{ $order->payment->final_amount }}
            </div>
        </div>

        @if ($order->order_status === 'pending')
            <form action="{{ route('admin.orders.markAsDelivered', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <button
                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-purple md:w-fit w-full"
                    type="submit">Mark
                    as Delivered</button>
            </form>
        @else
            <div class="w-full text-sm bg-blue-300 rounded-md flex items-center text-black p-2">Marked as delivered.</div>
        @endif


    </div>
@endsection

@section('js')
    @if (session()->has('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}",
                duration: 2000,

                newWindow: true,
                close: true,
                gravity: "top",
                position: "center",
                stopOnFocus: true,
                style: {
                    background: "green",
                    color: "#fff",
                    fontSize: "16px",
                    textAlign: "center"
                },
            }).showToast();
        </script>
    @endif
@endsection
