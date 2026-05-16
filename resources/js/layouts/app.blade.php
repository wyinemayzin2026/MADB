<!DOCTYPE html>
<html lang="en">

<head>
    <title>အခွန်</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/templatemo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>


    <!-- Header -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-blue-900 rounded-lg flex items-center justify-center">
                        <i class="fas fa-university text-white text-xl"></i>
                    </div>
                    <span class="font-bold text-xl text-gray-800 tracking-tight">အခွန်</span>
                </div>
                <div class="hidden md:flex space-x-8 font-medium text-gray-600">
                    <a class="hover:text-blue-900 transition" href="{{ url('/') }}">ပင်မစာမျက်နှာ</a /a>
                    <a class="hover:text-blue-900 transition" href="{{ url('/about') }}">ရည်မှန်းချက်</a>
                    <a class="hover:text-blue-900 transition" href="{{ url('/shop') }}">အခွန်အမျိုးအစားများ</a>
                    <a class="hover:text-blue-900 transition" href="{{ url('/contact') }}">ဆက်သွယ်ရန်</a>

                </div>
                <div class="flex items-center gap-4">
                    <button
                        class="bg-green-700 text-white px-5 py-2 rounded-full text-sm font-semibold hover:bg-blue-800 transition shadow-lg">
                        အကောင့်၀င်ရန်
                    </button>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')
    <!-- Start Footer -->
    <footer class="bg-dark" id="tempaltemo_footer">
        <div class="container">
            <div class="row  footer-link">

                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-success border-bottom pb-3 border-light logo">Hinthada AKON</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li>
                            <i class="fas fa-map-marker-alt fa-fw"></i>
                            ရုံးအမှတ်(၄၆)၊ ပြည်တွင်းအခွန်များဦးစီးဌာန၊ နေပြည်တော်
                        </li>
                        <li>
                            <i class="fa fa-phone fa-fw"></i>
                            <a class="text-decoration-none" href="tel:010-020-0340">၀၆၇-၃၄၃၀၅၂၂ ၊ ၀၆၇-၃၄၃၀၅၄၄</a>
                        </li>
                        <li>
                            <i class="fa fa-envelope fa-fw"></i>
                            <a class="text-decoration-none" href="mailto:info@company.com">info@ird.gov.mm</a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-light border-bottom pb-3 border-light">ဆက်စပ်ဝက်ဘ်ဆိုဒ်များ</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li><a class="text-decoration-none" href="#">Ministry of Planning and Finance</a></li>
                        <li><a class="text-decoration-none" href="#">Myanmar National Portal</a></li>
                        <li><a class="text-decoration-none" href="#">IRD Digital Library</a></li>

                    </ul>
                </div>

                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-light border-bottom pb-3 border-light">Further Info</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li><a class="text-decoration-none" href="{{ url('/') }}">ပင်မစာမျက်နှာ</a></li>
                        <li><a class="text-decoration-none" href="{{ url('/about') }}">ရည်မှန်းချက် </a></li>
                        <li><a class="text-decoration-none" href="{{ url('/shop') }}">အခွန်အမျိုးအစားများ</a></li>
                        <li><a class="text-decoration-none" href="{{ url('/contact') }}">ဆက်သွယ်ရန်</a></li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="w-100 bg-black py-3">
            <div class="container">
                <div class="row pt-2">
                    <div class="col-12">
                        <p class="text-left text-light">
                            © 2026 IRD. All Rights Reserved
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </footer>

    <script src="{{ asset('assets/js/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/templatemo.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <style>
        .footer-link {
            padding: 20px 100px;
        }
    </style>
</body>

</html>
