@extends('layout.master')

@section('js')
    <script>
        document.querySelectorAll('.register-btns').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (btn.id === 'register' && (document.getElementById('email').value === "" || document
                        .getElementById('password').value === "" || document.getElementById('name')
                        .value === "" || document.getElementById('password_confirmation').value === "")) {
                    return;
                }
                document.getElementById('loading').classList.remove('hidden', 'opacity-0');
                document.getElementById('loading').classList.add('flex', 'opacity-100');
            });
        });
    </script>
    @error('name')
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
    @enderror
    @error('email')
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
    @enderror
    @error('password')
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
    @enderror
    @error('password_confirmation')
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
    @enderror
@endsection

@section('content')
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-10 w-auto" src="{{ asset('favicon.png') }}" alt="Your Company">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900 dark:text-gray-50">Create
                a new account
            </h2>
        </div>

        <div class="mx-auto my-8">
            <a href="{{ route('auth.redirect', ['provider' => 'github']) }}"
                class="text-white bg-[#24292F] hover:bg-[#24292F]/90 focus:ring-4 focus:outline-none focus:ring-[#24292F]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-500 dark:hover:bg-[#24292F]/80 active:bg-[#24292F] dark:active:bg-[#24292F] me-2 mb-2 register-btns">
                <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 .333A9.911 9.911 0 0 0 6.866 19.65c.5.092.678-.215.678-.477 0-.237-.01-1.017-.014-1.845-2.757.6-3.338-1.169-3.338-1.169a2.627 2.627 0 0 0-1.1-1.451c-.9-.615.07-.6.07-.6a2.084 2.084 0 0 1 1.518 1.021 2.11 2.11 0 0 0 2.884.823c.044-.503.268-.973.63-1.325-2.2-.25-4.516-1.1-4.516-4.9A3.832 3.832 0 0 1 4.7 7.068a3.56 3.56 0 0 1 .095-2.623s.832-.266 2.726 1.016a9.409 9.409 0 0 1 4.962 0c1.89-1.282 2.717-1.016 2.717-1.016.366.83.402 1.768.1 2.623a3.827 3.827 0 0 1 1.02 2.659c0 3.807-2.319 4.644-4.525 4.889a2.366 2.366 0 0 1 .673 1.834c0 1.326-.012 2.394-.012 2.72 0 .263.18.572.681.475A9.911 9.911 0 0 0 10 .333Z"
                        clip-rule="evenodd" />
                </svg>
                Register with Github
            </a>

            <a href="{{ route('auth.redirect', ['provider' => 'google']) }}"
                class="text-white bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#4285F4]/55 me-2 mb-2 register-btns">
                <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 18 19">
                    <path fill-rule="evenodd"
                        d="M8.842 18.083a8.8 8.8 0 0 1-8.65-8.948 8.841 8.841 0 0 1 8.8-8.652h.153a8.464 8.464 0 0 1 5.7 2.257l-2.193 2.038A5.27 5.27 0 0 0 9.09 3.4a5.882 5.882 0 0 0-.2 11.76h.124a5.091 5.091 0 0 0 5.248-4.057L14.3 11H9V8h8.34c.066.543.095 1.09.088 1.636-.086 5.053-3.463 8.449-8.4 8.449l-.186-.002Z"
                        clip-rule="evenodd" />
                </svg>
                Register with Google
            </a>
        </div>

        <span class="mx-auto text-black dark:text-white font-extrabold">OR</span>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="{{ route('register') }}" method="POST">
                @csrf
                <div>
                    <label for="name"
                        class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-50">Username</label>
                    <div class="mt-2">
                        <input id="name" name="name" type="text" autocomplete="name" required
                            class="block px-4 w-full rounded-md border-0 py-1.5 text-gray-900 dark:bg-gray-900 dark:text-gray-50 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                            value="{{ old('name') }}">
                    </div>

                </div>
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-50">Email
                        address</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="block px-4 w-full rounded-md border-0 py-1.5 text-gray-900 dark:bg-gray-900 dark:text-gray-50 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                            value="{{ old('email') }}">
                    </div>

                </div>

                <div>
                    <label for="password"
                        class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-50">Password</label>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="block px-4 w-full rounded-md border-0 py-1.5 text-gray-900 dark:bg-gray-900 dark:text-gray-50 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                            value="{{ old('password') }}">
                    </div>

                </div>

                <div>
                    <label for="password_confirmation"
                        class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-50">Confirm
                        Password</label>
                    <div class="mt-2">
                        <input id="password_confirmation" name="password_confirmation"
                            value="{{ old('password_confirmation') }}" type="password" required
                            class="block px-4 w-full rounded-md border-0 py-1.5 text-gray-900 dark:bg-gray-900 dark:text-gray-50 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                    </div>

                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-blue-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 register-btns">Register</button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                Already have an account?
                <a href="{{ route('login') }}" class="font-semibold leading-6 text-blue-600 hover:text-blue-500">Login</a>
            </p>
        </div>
    </div>
@endsection
