<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        @vite(["resources/sass/app.scss", "resources/js/app.js"])

        <title>Login</title>
    </head>
    <body>
        <div class="container py-5">
            <div class="row jusify-content-center bg-red">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <h2 class="text-center">Login</h2>
                            <form
                                method="POST"
                                action="{{ route("login.admin") }}"
                            >
                                @csrf
                                <div class="mb-3">
                                    <label for="username" class="mb-1">
                                        Username
                                    </label>
                                    <input
                                        type="text"
                                        name="username"
                                        id="username"
                                        class="form-control"
                                        placeholder="Masukan username"
                                    />
                                    @error("username")
                                        <p class="text-danger fst-italic">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label
                                        for="password"
                                        class="mb-1 position-relative"
                                    >
                                        Passwrod
                                    </label>
                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        placeholder="Masukan password"
                                        class="form-control"
                                    />
                                    @error("password")
                                        <p class="text-danger fst-italic">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input
                                        type="checkbox"
                                        name="showPassword"
                                        id="showPassword"
                                    />
                                    <label for="showPassword">
                                        Show Password
                                    </label>
                                </div>
                                <div class="mb-3 text-center">
                                    <button
                                        type="submit"
                                        class="btn btn-primary btn-block"
                                    >
                                        Login
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            const password = document.getElementById('password');
            const checkbox = document.getElementById('showPassword');

            checkbox.addEventListener('change', function () {
                password.type = this.checked ? 'text' : 'password';
            });
        </script>
    </body>
</html>
