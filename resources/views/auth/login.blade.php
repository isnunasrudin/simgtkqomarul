<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login - {{ config('app.name') }}</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{ asset('img/icon.ico') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ['{{ asset('css/fonts.min.css') }}']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/atlantis.css') }}">
</head>

<body class="login">
    <div class="wrapper wrapper-login wrapper-login-full p-0">
        <div style="overflow: hidden"
            class="position-relative login-aside w-50 d-flex flex-column align-items-center justify-content-center text-center bg-primary-gradient">
            <img src="{{ asset('img/login-bg.jpg') }}" alt="" class="w-100 h-100 position-absolute"
                style="object-fit: cover; opacity: 0.15">
            <h1 class="position-relative title fw-bold text-white mb-3">Selamat Datang</h1>
            <p class="position-relative subtitle text-white op-7">
                Sistem Manajemen Guru dan Tenaga Kependidikan <br />
                Yayasan PP Qomarul Hidayah Trenggalek
            </p>
        </div>
        <div class="login-aside w-50 d-flex align-items-center justify-content-center bg-white">
            <div class="container container-login container-transparent animated fadeIn">
                <img src="{{ asset('img/qomarul.webp') }}" height="100px" class="d-block mx-auto mb-4">
                <a href="{{ route('login.google') }}" class="btn btn-outline-primary btn-block">
                    <img width="20px" style="margin-bottom:3px; margin-right:5px" alt="Google sign-in"
                        src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/1024px-Google_%22G%22_logo.svg.png" />
                    Login dengan Google
                </a>
                <div class="d-flex align-items-center my-4">
                    <hr class="flex-grow-1">
                    <span class="mx-3 text-muted">atau</span>
                    <hr class="flex-grow-1">
                </div>
                <form class="login-form" method="POST">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @csrf
                    <div class="form-group">
                        <label for="email" class="placeholder"><b>Email</b></label>
                        <input id="email" name="email" type="text" class="form-control" value="{{ old('email') }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="placeholder"><b>Kata Sandi</b></label>
                        <div class="position-relative">
                            <input id="password" name="password" type="password" class="form-control" required>
                            <div class="show-password">
                                <i class="icon-eye"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-action-d-flex mb-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="rememberme">
                            <label class="custom-control-label m-0" for="rememberme">Ingat Saya</label>
                        </div>
                        <button type="submit"
                            class="btn btn-secondary col-md-5 float-right mt-3 mt-sm-0 fw-bold">Masuk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/core/popper.min.js') }}"></script>
    <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/atlantis.min.js') }}"></script>

</body>

</html>