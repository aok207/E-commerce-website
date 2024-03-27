@extends('layout.master')

@section('content')
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm space-y-4">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900 dark:text-gray-50">Reset
                Your Password
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="{{ route('post-reset-password') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
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
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-50">Enter
                        New
                        Password</label>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="password" required
                            class="block px-4 w-full rounded-md border-0 py-1.5 text-gray-900 dark:bg-gray-900 dark:text-gray-50 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                    </div>

                </div>
                <div>
                    <label for="password_confirmation"
                        class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-50">Confirm
                        Password</label>
                    <div class="mt-2">
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            autocomplete="password_confirmation" required
                            class="block px-4 w-full rounded-md border-0 py-1.5 text-gray-900 dark:bg-gray-900 dark:text-gray-50 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                    </div>

                </div>

                <div>
                    <button type="submit" id="reset-password-btn"
                        class="flex w-full justify-center rounded-md bg-blue-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Reset
                        Password</button>
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

@section('js')
    <script>
        document.querySelector('#reset-password-btn').addEventListener('click', function(e) {
            if (document.getElementById('email').value === "" || document
                .getElementById('password').value === "" || document.getElementById('password_confirmation')
                .value === "") {
                return;
            }
            document.getElementById('loading').classList.remove('hidden', 'opacity-0');
            document.getElementById('loading').classList.add('flex', 'opacity-100');
        });
    </script>
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
