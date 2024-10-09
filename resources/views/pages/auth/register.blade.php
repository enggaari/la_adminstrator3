<!doctype html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Phoenix</title>
    <link rel="apple-touch-icon" sizes="180x180" href="../../../assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../../assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../../assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../assets/img/favicons/favicon.ico">
    <link rel="manifest" href="../../../assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="../../../assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&amp;display=swap"
        rel="stylesheet">
    <link href="../../../assets/css/phoenix.min.css" rel="stylesheet" id="style-default">
    <link href="../../../assets/css/user.min.css" rel="stylesheet" id="user-style-default">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            opacity: 0;
        }
    </style>
</head>

<body>
    <main class="main" id="top">
        <div class="container-fluid px-0">
            <div class="container">
                <div class="row flex-center min-vh-100 py-5">
                    <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3"><a
                            class="d-flex flex-center text-decoration-none mb-4" href="../../../index.html">
                            <div class="d-flex align-items-center"><img src="../../../assets/img/icons/logo.png"
                                    alt="phoenix" width="58"></div>
                        </a>
                        <div class="text-center mb-7">
                            <h3>Sign Up</h3>
                            <p class="text-700">Create your account today</p>
                        </div>
                        {{-- <button class="btn btn-phoenix-secondary w-100 mb-3"><span
                                class="fab fa-google text-google me-2 fs--1"></span>Sign up with google</button><button
                            class="btn btn-phoenix-secondary w-100"><span
                                class="fab fa-facebook text-facebook me-2 fs--1"></span>Sign up with facebook</button>
                        --}}
                        <div class="position-relative mt-4">
                            <hr class="bg-200">
                            <div class="divider-content-center">use email</div>
                        </div>
                        {{-- <form> --}}
                        <div class="mb-3 text-start">
                            <label class="form-label" for="name">Name</label>
                            <input class="form-control" id="name" placeholder="Name">
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label" for="email">Email
                                address</label>
                            <input class="form-control" id="email" type="email" placeholder="name@example.com">
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label" for="password">Password</label>
                                <input class="form-control form-icon-input" type="password" id="password"
                                    placeholder="Password">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="confirm_password">Confirm
                                    Password</label>
                                <input class="form-control form-icon-input" type="confirm_password"
                                    placeholder="Confirm Password">
                            </div>
                        </div>
                        {{-- <div class="form-check mb-3"><input class="form-check-input" id="termsService"
                                    type="checkbox"><label class="form-label" for="termsService">I accept the <a
                                        href="#!">terms </a>and <a href="#!">privacy policy</a></label></div> --}}
                        <button class="btn-register btn btn-primary w-100 mb-3"> Sign up</button>
                        <div class="text-center"><a class="fs--1 fw-bold"
                                href="../../../pages/authentication/simple/sign-in.html">Log into an existing
                                account</a></div>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="../../../assets/js/phoenix.js"></script>
    <script src="../../../assets/jquery/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {

            $(".btn-register").click(function() {

                var nama_lengkap = $("#name").val();
                var email = $("#email").val();
                var password = $("#password").val();
                var token = $("meta[name='csrf-token']").attr("content");

                if (nama_lengkap.length == "") {

                    Swal.fire({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'Nama Lengkap Wajib Diisi !'
                    });

                } else if (email.length == "") {

                    Swal.fire({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'Alamat Email Wajib Diisi !'
                    });

                } else if (password.length == "") {

                    Swal.fire({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'Password Wajib Diisi !'
                    });

                } else {

                    //ajax
                    $.ajax({

                        url: "{{ route('store') }}",
                        type: "POST",
                        cache: false,
                        data: {
                            "nama_lengkap": nama_lengkap,
                            "email": email,
                            "password": password,
                            "_token": token
                        },

                        success: function(response) {

                            if (response.success) {

                                Swal.fire({
                                    type: 'success',
                                    title: 'Register Berhasil!',
                                    text: 'silahkan login!'
                                });

                                $("#nama_lengkap").val('');
                                $("#email").val('');
                                $("#password").val('');

                            } else {

                                Swal.fire({
                                    type: 'error',
                                    title: 'Register Gagal!',
                                    text: 'silahkan coba lagi!'
                                });

                            }

                            console.log(response);

                        },

                        error: function(response) {
                            Swal.fire({
                                type: 'error',
                                title: 'Opps!',
                                text: 'server error!'
                            });
                        }

                    })

                }

            });

        });
    </script>
</body>


</html>
