@extends('layout.master')

@section('content')
    <div
        class="min-w-0 h-full overflow-auto sm:w-3/4 w-full sm:mx-auto p-8 sm:p-4 sm:my-10 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div class="flex justify-between items-center">

            <h4 class="mb-4 text-xl font-semibold text-gray-600 dark:text-gray-300">
                Edit your profile
            </h4>
        </div>
        <div class="w-full overflow-hidden rounded-lg mt-4 shadow-xs">
            <div class="w-full overflow-x-auto">
                <form action="{{ route('profile') }}" method="POST"
                    class="px-4 py-3 bg-white rounded-lg shadow-md dark:bg-gray-800" enctype="multipart/form-data">
                    @csrf
                    <label class="flex flex-col gap-4 text-sm mb-4">
                        <span class="text-gray-700 dark:text-gray-400">Username</span>
                        <input
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input px-3 py-2 rounded-md focus:outline-black dark:focus:outline-white bg-slate-200"
                            name="name" aria-label="Username" required aria-required="true"
                            value="{{ auth()->user()->name }}" />
                    </label>

                    <label class="flex flex-col gap-4 text-sm mb-4">
                        <span class="text-gray-700 dark:text-gray-400">Email</span>
                        <input
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input px-3 py-2 rounded-md dark:focus:outline-white focus:outline-black bg-slate-200"
                            name="email" aria-label="Email" required aria-required="true"
                            value="{{ auth()->user()->email }}" />
                    </label>

                    <label class="flex flex-col gap-4 text-sm mb-4">
                        <span class="text-gray-700 dark:text-gray-400">Old Password</span>
                        <span class="text-gray-700 dark:text-gray-400">* To change your password, you need to provide your
                            current password first. If you're logged in with Github or Google don't provide any.</span>
                        <input
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input px-3 py-2 rounded-md dark:focus:outline-white focus:outline-black bg-slate-200"
                            name="old_password" aria-label="old password" type="password" />
                    </label>

                    <label class="flex flex-col gap-4 text-sm mb-4">
                        <span class="text-gray-700 dark:text-gray-400">New Password</span>
                        <input
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input px-3 py-2 rounded-md dark:focus:outline-white focus:outline-black bg-slate-200"
                            name="new_password" aria-label="new password" type="password" />
                    </label>

                    <label class="flex flex-col gap-4 text-sm mb-4">
                        <span class="text-gray-700 dark:text-gray-400">Confirm Password</span>
                        <input
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input px-3 py-2 rounded-md dark:focus:outline-white focus:outline-black bg-slate-200"
                            type="password" name="new_password_confirmation" aria-label="confirm password" />
                    </label>

                    <button type="submit"
                        class="px-4 mt-3 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple w-full lg:w-fit">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const bladeBookmarkedProducts = @json($bookmarked_products);
        bladeCart = @json($cart);
    </script>
    <script>
        @if (session()->has('success'))

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
        @endif
        @if (session()->has('error'))

            Toastify({
                text: "{{ session('error') }}",
                duration: 2000,

                newWindow: true,
                close: true,
                gravity: "top",
                position: "center",
                stopOnFocus: true,
                style: {
                    background: "red",
                    color: "#fff",
                    fontSize: "16px",
                    textAlign: "center"
                },
            }).showToast();
        @endif
    </script>
    @error('name')
        @section('js')
            <script>
                Toastify({
                    text: "{{ $message }}",
                    duration: 2000,

                    newWindow: true,
                    close: true,
                    gravity: "top",
                    position: "center",
                    stopOnFocus: true,
                    style: {
                        background: "red",
                        color: "#fff",
                        fontSize: "16px",
                        textAlign: "center"
                    },
                }).showToast();
            </script>
        @endsection
    @enderror
    @error('email')
        @section('js')
            <script>
                Toastify({
                    text: "{{ $message }}",
                    duration: 2000,

                    newWindow: true,
                    close: true,
                    gravity: "top",
                    position: "center",
                    stopOnFocus: true,
                    style: {
                        background: "red",
                        color: "#fff",
                        fontSize: "16px",
                        textAlign: "center"
                    },
                }).showToast();
            </script>
        @endsection
    @enderror
    @error('new_password')
        @section('js')
            <script>
                Toastify({
                    text: "{{ $message }}",
                    duration: 2000,

                    newWindow: true,
                    close: true,
                    gravity: "top",
                    position: "center",
                    stopOnFocus: true,
                    style: {
                        background: "red",
                        color: "#fff",
                        fontSize: "16px",
                        textAlign: "center"
                    },
                }).showToast();
            </script>
        @endsection
    @enderror
    @error('password_confirmation')
        @section('js')
            <script>
                Toastify({
                    text: "{{ $message }}",
                    duration: 2000,

                    newWindow: true,
                    close: true,
                    gravity: "top",
                    position: "center",
                    stopOnFocus: true,
                    style: {
                        background: "red",
                        color: "#fff",
                        fontSize: "16px",
                        textAlign: "center"
                    },
                }).showToast();
            </script>
        @endsection
    @enderror
@endsection
