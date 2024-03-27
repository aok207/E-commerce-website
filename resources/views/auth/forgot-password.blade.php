@extends('layout.master')

@section('js')
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
    </script>

    <script>
        document.querySelector('#forgot-password-btn').addEventListener('click', function(e) {
            if (document.getElementById('email').value === "") {
                return;
            }
            document.getElementById('loading').classList.remove('hidden', 'opacity-0');
            document.getElementById('loading').classList.add('flex', 'opacity-100');
        });
    </script>
@endsection

@section('content')
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm space-y-4">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900 dark:text-gray-50">Reset
                Your Password
            </h2>
            <p class="text-md font-semibold dark:text-gray-50">Enter your email address below to receive a password reset
                link.
            </p>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="{{ route('forgot-password') }}" method="POST">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-50">Email
                        address</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="block px-4 w-full rounded-md border-0 py-1.5 text-gray-900 dark:bg-gray-900 dark:text-gray-50 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                            value="{{ old('email') }}">
                    </div>
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
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-blue-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                        id="forgot-password-btn">Get
                        Password Reset Link</button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                Don't Have an account?
                <a href="{{ url('/register') }}"
                    class="font-semibold leading-6 text-blue-600 hover:text-blue-500">Register</a>
            </p>
        </div>
    </div>
@endsection
