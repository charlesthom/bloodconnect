<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>BloodConnect - Hospitals</title>

    <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="{{asset('landing/css/bootstrap.min.css')}}">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="{{asset('landing/css/style.css')}}">
      <!-- Responsive-->
      <link rel="stylesheet" href="{{asset('landing/css/responsive.css')}}">
      <!-- fevicon -->
      <link rel="icon" href="{{asset('landing/images/fevicon.png')}}" type="image/gif" />
      <!-- fonts -->
      <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Sen:400,700,800&display=swap" rel="stylesheet">
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="{{asset('landing/css/jquery.mCustomScrollbar.min.css')}}">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">

    <style>
        .login_button {
            float: right;
            padding: 7px 20px;
            background-color: #ed1c24;
            border-radius: 5px;
        }
        .login_button a { color: #fff; }

        .hospital-card {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 25px;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.05);
        }

        .hospital-card h4 {
            font-weight: 700;
            margin-bottom: 10px;
        }

        .hospital-card p {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

<div class="header_section">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/" style="color:#fff; font-weight:700; font-size:32px; letter-spacing:3px;">
                BloodConnect
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item active"><a class="nav-link" href="#">Hospitals</a></li>
                    <li class="nav-item"><a class="nav-link" href="/about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
                </ul>
            </div>

            <div class="login_button">
                <a href="/login">Login</a>
            </div>
        </nav>
    </div>
</div>

<!-- Hospital List Section -->
<div class="about_section layout_padding" style="background-color: #fafafa;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="faster_text" style="text-align:center; margin-bottom:30px;">
                    Registered Hospitals
                </h1>
            </div>
        </div>

        <div class="row">
            <!-- Example Static Items (Replace with Blade Loop) -->
            {{-- <div class="col-md-4">
                <div class="hospital-card">
                    <h4>City Hospital</h4>
                    <p>Cebu City</p>
                    <p>Contact: 09123456789</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="hospital-card">
                    <h4>St. Anne Medical Center</h4>
                    <p>Mandaue City</p>
                    <p>Contact: 09876543210</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="hospital-card">
                    <h4>Red Cross Cebu</h4>
                    <p>Lapu-Lapu City</p>
                    <p>Contact: 09223334444</p>
                </div>
            </div> --}}

            {{-- Laravel sample dynamic code: --}}
            @foreach($hospitals as $hospital)
            <div class="col-md-4">
                <div class="hospital-card">
                    <h4>{{ $hospital->name }}</h4>
                    <p>{{ explode('|', $hospital->location)[0] }}</p>
                    <p>Contact: {{ $hospital->user->phone }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Footer -->
<div class="footer_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-sm-4">
                  <h3 class="footer_text">Useful links</h3>
                  <div class="footer_menu">
                     <ul>
                        <li class="{{ request()->is('') ? 'active' : ''}}"><a href="/"><span class="angle_icon {{ request()->is('') ? 'active' : ''}}"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> Home</a></li>
                        <li class="{{ request()->is('/login') ? 'active' : ''}}"><a href="/login"><span class="angle_icon {{ request()->is('login') ? 'active' : ''}}"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>  Login</a></li>
                        <li class="{{ request()->is('/hospital-list') ? 'active' : ''}}"><a href="/hospital-list"><span class="angle_icon {{ request()->is('hospital-list') ? 'active' : ''}}"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> Hospital List</a></li>
                        {{-- <li><a href="domain.html"><span class="angle_icon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> Domain</a></li>
                        <li><a href="testimonial.html"><span class="angle_icon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>  Testimonial</a></li>
                        <li><a href="contact.html"><span class="angle_icon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>  Contact Us</a></li> --}}
                     </ul>
                  </div>
               </div>
               <div class="col-sm-4">
                  <h3 class="footer_text">Address</h3>
                  <div class="location_text">
                     <ul>
                        <li>
                           <a href="#">
                           <span class="padding_left_10"><i class="fa fa-map-marker" aria-hidden="true"></i></span>Mandaue City</a>
                        </li>
                        {{-- <li>
                           <a href="#">
                           <span class="padding_left_10"><i class="fa fa-phone" aria-hidden="true"></i></span>(+71) 1234567890<br>(+71) 1234567890
                           </a>
                        </li>
                        <li>
                           <a href="#">
                           <span class="padding_left_10"><i class="fa fa-envelope" aria-hidden="true"></i></span>demo@gmail.com
                           </a>
                        </li> --}}
                     </ul>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="footer_main">
                     {{-- <h3 class="footer_text">Find Us</h3>
                     <p class="dummy_text">more-or-less normal distribution </p> --}}
                     <div class="social_icon">
                        <ul>
                           <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                           <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                           <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- footer section end -->
      <!-- copyright section start -->
      <div class="copyright_section">
         <div class="container">
            <p class="copyright_text">© 2025 BloodConnect. All Rights Reserved.</p>
         </div>
      </div>

<script src="{{asset('landing/js/jquery.min.js')}}"></script>
<script src="{{asset('landing/js/bootstrap.bu
