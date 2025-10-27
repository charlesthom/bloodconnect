<!DOCTYPE html>
<html>
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Netic</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
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
            font-size: 16px;
            padding: 7px 20px 7px 20px;
            text-transform: uppercase;
            background-color: transparent;
            margin: 0px 7px;
            border-radius: 5px;
            background-color: #ed1c24;
        }
        .login_button a {
            color: #ffffff;
        }
      </style>
   </head>
   <body>
      <div class="header_section">
         <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <!-- <a class="navbar-brand"href="index.html"><img src="images/logo.png"></a> -->
               <a class="navbar-brand"href="index.html" style="color: #fff; font-weight: 700; font-size: 32px; letter-spacing: 3px;">BloodConnect</a>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ml-auto">
                     <li class="nav-item active">
                        <a class="nav-link" href="index.html">Home</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="about.html">About</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="hosting.html">Hosting</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="testimonial.html">Testimonial</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="domain.html">Domain</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="services.html">Services</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact Us</a>
                     </li>
                  </ul>
                  <form class="form-inline my-2 my-lg-0">
                  </form>
               </div>
            </nav>
            {{-- <div class="custom_bg">
               <div class="custom_menu">
                  <ul>
                     <li class="active"><a href="index.html">Home</a></li>
                     <li><a href="#">About</a></li>
                     <li><a href="hosting.html">Hosting</a></li>
                     <li><a href="testimonial.html">Testimonial</a></li>
                     <li><a href="domain.html">Domain</a></li>
                     <li><a href="services.html">Services</a></li>
                     <li><a href="contact.html">Contact Us</a></li>
                  </ul>
               </div>
               <form class="form-inline my-2 my-lg-0">
                  <div class="search_btn">
                     <li><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                     <li><a href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></li>
                  </div>
               </form>
            </div> --}}
            <div class="login_button">
                <a href="/login">Login</a>
            </div>
         </div>
         <!-- banner section start --> 
         <div class="banner_section layout_padding">
            <div id="my_slider" class="carousel slide" data-ride="carousel">
               <div class="carousel-inner">
                  <div class="carousel-item active">
                     <div class="container">
                        <div class="row">
                           <div class="col-md-6">
                              <h1 class="banner_taital">Connecting <br>Life Together</h1>
                              <div class="read_bt"><a href="/hospital-list">See Hospital List</a></div>
                           </div>
                           <div class="col-md-6">
                              <div class="banner_img"><img src="{{asset('landing/images/banner-img.png')}}"></div>
                           </div>
                        </div>
                     </div>
                  </div>
                  {{-- <div class="carousel-item">
                     <div class="container">
                        <div class="row">
                           <div class="col-md-6">
                              <h1 class="banner_taital">Hosting <br>And Domain</h1>
                              <div class="read_bt"><a href="#">Read More</a></div>
                           </div>
                           <div class="col-md-6">
                              <div class="banner_img"><img src="{{asset('landing/images/banner-img.png')}}"></div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="carousel-item">
                     <div class="container">
                        <div class="row">
                           <div class="col-md-6">
                              <h1 class="banner_taital">Hosting <br>And Domain</h1>
                              <div class="read_bt"><a href="#">Read More</a></div>
                           </div>
                           <div class="col-md-6">
                              <div class="banner_img"><img src="{{asset('landing/images/banner-img.png')}}"></div>
                           </div>
                        </div>
                     </div>
                  </div> --}}
               </div>
               <a class="carousel-control-prev" href="#my_slider" role="button" data-slide="prev">
               <i class="fa fa-angle-left"></i>
               </a>
               <a class="carousel-control-next" href="#my_slider" role="button" data-slide="next">
               <i class="fa fa-angle-right"></i>
               </a>
            </div>
         </div>
         <!-- banner section end -->
      </div>
      <!-- header section end -->
      <!-- domain section start -->
      {{-- <div class="domain_section">
         <div class="container">
            <div class="domain_box">
               <div class="domain_rate">
                  <ul>
                     <li><a href="#"><span style="color: #8b2791;">.com</span> $11.25</a></li>
                     <li><a href="#"><span style="color: #8b2791;">.org</span> $12.50</a></li>
                     <li><a href="#"><span style="color: #8b2791;">.net</span> $14.50 </a></li>
                     <li><a href="#"><span style="color: #8b2791;">.com</span> $11.50</a></li>
                     <li><a href="#"><span style="color: #8b2791;">info</span> $9.00</a></li>
                     <li><a href="#"><span style="color: #8b2791;">xyz</span> $0.99</a></li>
                  </ul>
               </div>
               <div class="domain_main">
                  <form class="example" action="#">
                     <input type="text" placeholder="Search Domain.." name="Search Domain..">
                     <button type="submit">Search Now</button>
                  </form>
               </div>
            </div>
         </div>
      </div> --}}
      <!-- domain section end -->
      <!-- about section start -->
      <div class="about_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-md-4">
                  <div class="about_box">
                     <div class="icon_1"><img src="{{asset('landing/images/icon-1.png')}}"></div>
                     <h3 class="faster_text">Faster, Efficient Support</h3>
                     <p class="lorem_text">Bridging the gap between blood donors and those in need. Our platform streamlines blood requests for hospitals and connects them with verified donors, ensuring faster and efficient support</p>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="about_box">
                     <div class="icon_1"><img src="{{asset('landing/images/icon-2.png')}}"></div>
                     <h3 class="faster_text">Trusted Connections</h3>
                     <p class="lorem_text">We simplify the blood donation process, providing hospitals with critical resources and life-saving support, and donors with a direct way to make a significant impact</p>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="about_box">
                     <div class="icon_1"><img src="{{asset('landing/images/icon-3.png')}}"></div>
                     <h3 class="faster_text">Empowering Communities</h3>
                     <p class="lorem_text">Your central hub for blood donation and management. Facilitating seamless communication between healthcare providers and generous donors to save lives, one donation at a time</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- about section end -->
      <!-- hosting section start -->
      {{-- <div class="hosting_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-md-6">
                  <h1 class="hosting_taital">GRID WEB HOSTING OVERVIEW</h1>
                  <p class="hosting_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud </p>
                  <div class="click_bt"><a href="#">Click Here</a></div>
               </div>
               <div class="col-md-6">
                  <div class="hosting_img"><img src="{{asset('landing/images/hosting-img.png')}}"></div>
               </div>
            </div>
         </div>
      </div>
      <!-- hosting section end -->
      <!-- pricing section start -->
      <div class="pricing_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <h1 class="pricing_taital">Our Pricing Plan</h1>
                  <p class="pricing_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore </p>
               </div>
            </div>
            <div class="pricing_section_2">
               <div class="row">
                  <div class="col-md-4">
                     <div class="pricing_box">
                        <h3 class="number_text">1</h3>
                        <h5 class="cloud_text">Cloud Hosting</h5>
                        <h1 class="dolor_text">$19</h1>
                        <h3 class="monthly_text">MONTHLY</h3>
                        <p class="band_text">5GB bandwidth Free Email Addresses 24/7 security monitoring</p>
                        <div class="signup_bt"><a href="#">Sign Up</a></div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="pricing_box">
                        <h3 class="number_text">2</h3>
                        <h5 class="cloud_text">VPS Hosting</h5>
                        <h1 class="dolor_text">$19</h1>
                        <h3 class="monthly_text">MONTHLY</h3>
                        <p class="band_text">5GB bandwidth Free Email Addresses 24/7 security monitoring</p>
                        <div class="signup_bt"><a href="#">Sign Up</a></div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="pricing_box">
                        <h3 class="number_text">3</h3>
                        <h5 class="cloud_text">Shared Hosting</h5>
                        <h1 class="dolor_text">$19</h1>
                        <h3 class="monthly_text">MONTHLY</h3>
                        <p class="band_text">5GB bandwidth Free Email Addresses 24/7 security monitoring</p>
                        <div class="signup_bt"><a href="#">Sign Up</a></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div> --}}
      <!-- pricing section end -->
      <!-- services section start -->
      {{-- <div class="services_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <h1 class="services_taital">Our Services</h1>
                  <p class="services_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore </p>
               </div>
            </div>
            <div class="services_section_2">
               <div id="main_slider"class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                     <div class="carousel-item active">
                        <div class="row">
                           <div class="col-md-4">
                              <div class="service_box">
                                 <div class="services_icon">
                                    <img src="{{asset('landing/images/icon-4.png')}}" class="image_1">
                                    <img src="{{asset('landing/images/icon-7.png')}}" class="image_2">
                                 </div>
                                 <h3 class="wordpress_text">WordPress Hosting</h3>
                                 <p class="opposed_text">opposed to using 'Content here, content here', making it look like readable</p>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="service_box">
                                 <div class="services_icon">
                                    <img src="{{asset('landing/images/icon-5.png')}}" class="image_1">
                                    <img src="{{asset('landing/images/icon-5.png')}}" class="image_2">
                                 </div>
                                 <h3 class="wordpress_text">Cloud Hosting</h3>
                                 <p class="opposed_text">opposed to using 'Content here, content here', making it look like readable</p>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="service_box">
                                 <div class="services_icon">
                                    <img src="{{asset('landing/images/icon-6.png')}}" class="image_1">
                                    <img src="{{asset('landing/images/icon-9.png')}}" class="image_2">
                                 </div>
                                 <h3 class="wordpress_text">Dedicated Hosting</h3>
                                 <p class="opposed_text">opposed to using 'Content here, content here', making it look like readable</p>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="carousel-item">
                        <div class="row">
                           <div class="col-md-4">
                              <div class="service_box">
                                 <div class="services_icon">
                                    <img src="{{asset('landing/images/icon-4.png')}}" class="image_1">
                                    <img src="{{asset('landing/images/icon-7.png')}}" class="image_2">
                                 </div>
                                 <h3 class="wordpress_text">WordPress Hosting</h3>
                                 <p class="opposed_text">opposed to using 'Content here, content here', making it look like readable</p>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="service_box">
                                 <div class="services_icon">
                                    <img src="{{asset('landing/images/icon-5.png')}}" class="image_1">
                                    <img src="{{asset('landing/images/icon-5.png')}}" class="image_2">
                                 </div>
                                 <h3 class="wordpress_text">Cloud Hosting</h3>
                                 <p class="opposed_text">opposed to using 'Content here, content here', making it look like readable</p>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="service_box">
                                 <div class="services_icon">
                                    <img src="{{asset('landing/images/icon-6.png')}}" class="image_1">
                                    <img src="{{asset('landing/images/icon-9.png')}}" class="image_2">
                                 </div>
                                 <h3 class="wordpress_text">Dedicated Hosting</h3>
                                 <p class="opposed_text">opposed to using 'Content here, content here', making it look like readable</p>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="carousel-item">
                        <div class="row">
                           <div class="col-md-4">
                              <div class="service_box">
                                 <div class="services_icon">
                                    <img src="{{asset('landing/images/icon-4.png')}}" class="image_1">
                                    <img src="{{asset('landing/images/icon-7.png')}}" class="image_2">
                                 </div>
                                 <h3 class="wordpress_text">WordPress Hosting</h3>
                                 <p class="opposed_text">opposed to using 'Content here, content here', making it look like readable</p>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="service_box">
                                 <div class="services_icon">
                                    <img src="{{asset('landing/images/icon-5.png')}}" class="image_1">
                                    <img src="{{asset('landing/images/icon-5.png')}}" class="image_2">
                                 </div>
                                 <h3 class="wordpress_text">Cloud Hosting</h3>
                                 <p class="opposed_text">opposed to using 'Content here, content here', making it look like readable</p>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="service_box">
                                 <div class="services_icon">
                                    <img src="{{asset('landing/images/icon-6.png')}}" class="image_1">
                                    <img src="{{asset('landing/images/icon-9.png')}}" class="image_2">
                                 </div>
                                 <h3 class="wordpress_text">Dedicated Hosting</h3>
                                 <p class="opposed_text">opposed to using 'Content here, content here', making it look like readable</p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <a class="carousel-control-prev" href="#main_slider" role="button" data-slide="prev">
                  <i class="fa fa-angle-left"></i>
                  </a>
                  <a class="carousel-control-next" href="#main_slider" role="button" data-slide="next">
                  <i class="fa fa-angle-right"></i>
                  </a>
               </div>
            </div>
         </div>
      </div> --}}
      <!-- services section end -->
      <!-- testimonial section start -->
      {{-- <div class="testimonial_section layout_padding">
         <div class="container">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
               <ol class="carousel-indicators">
                  <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
               </ol>
               <div class="carousel-inner">
                  <div class="carousel-item active">
                     <div class="row">
                        <div class="col-md-12">
                           <h1 class="testimonial_taital">Testimonials</h1>
                           <p class="testimonial_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore </p>
                           <div class="testimonial_section_2">
                              <p class="ipsum_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit essLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit ess</p>
                              <div class="quick_img"><img src="{{asset('landing/images/quick-icon.png')}}"></div>
                           </div>
                           <div class="client_img"><img src="{{asset('landing/images/client-img.png')}}"></div>
                           <h4 class="client_name">Joy Mori</h4>
                        </div>
                     </div>
                  </div>
                  <div class="carousel-item">
                     <div class="row">
                        <div class="col-md-12">
                           <h1 class="testimonial_taital">Testimonials</h1>
                           <p class="testimonial_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore </p>
                           <div class="testimonial_section_2">
                              <p class="ipsum_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit essLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit ess</p>
                              <div class="quick_img"><img src="{{asset('landing/images/quick-icon.png')}}"></div>
                           </div>
                           <div class="client_img"><img src="{{asset('landing/images/client-img.png')}}"></div>
                           <h4 class="client_name">Joy Mori</h4>
                        </div>
                     </div>
                  </div>
                  <div class="carousel-item">
                     <div class="row">
                        <div class="col-md-12">
                           <h1 class="testimonial_taital">Testimonials</h1>
                           <p class="testimonial_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore </p>
                           <div class="testimonial_section_2">
                              <p class="ipsum_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit essLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit ess</p>
                              <div class="quick_img"><img src="{{asset('landing/images/quick-icon.png')}}"></div>
                           </div>
                           <div class="client_img"><img src="{{asset('landing/images/client-img.png')}}"></div>
                           <h4 class="client_name">Joy Mori</h4>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div> --}}
      <!-- testimonial section end -->
      <!-- newslatter section start -->
      {{-- <div class="newslatter_section">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <h1 class="newslatter_taital">Subscribe Newsletter</h1>
                  <form class="example" action="#">
                     <input type="text" class="mail" placeholder="Enter Your email" name="Enter Your email">
                     <button type="submit">Sbscribe</button>
                  </form>
               </div>
            </div>
         </div>
      </div> --}}
      <!-- newslatter section end -->
      <!-- footer section start -->
      <div class="footer_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-sm-4">
                  <h3 class="footer_text">Useful links</h3>
                  <div class="footer_menu">
                     <ul>
                        <li class="{{ request()->is('') ? 'active' : ''}}"><a href="/"><span class="angle_icon {{ request()->is('/') ? 'active' : ''}}"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> Home</a></li>
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
      <!-- copyright section end -->
      <!-- Javascript files-->
      <script src="{{asset('landing/js/jquery.min.js')}}"></script>
      <script src="{{asset('landing/js/popper.min.js')}}"></script>
      <script src="{{asset('landing/js/bootstrap.bundle.min.js')}}"></script>
      <script src="{{asset('landing/js/jquery-3.0.0.min.js')}}"></script>
      <script src="{{asset('landing/js/plugin.js')}}"></script>
      <!-- sidebar -->
      <script src="{{asset('landing/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
      <script src="{{asset('landing/js/custom.js')}}"></script>
   </body>
</html>