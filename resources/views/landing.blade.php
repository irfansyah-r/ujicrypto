<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>UjiCrypto - Landing Page</title>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="">
		<meta name="description" content="">

        <link rel="icon" href="{{ asset('images/icon-blue.png') }}">
		<!-- animate css -->
		<link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
		<!-- bootstrap css -->
		<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
		<!-- font-awesome -->
		<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
		<!-- google font -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700,800' rel='stylesheet' type='text/css'>

		<!-- custom css -->
		<link rel="stylesheet" href="{{ asset('css/templatemo-style.css') }}">

	</head>
	<body>
		<!-- start preloader -->
		<div class="preloader">
			<div class="sk-spinner sk-spinner-rotating-plane"></div>
    	 </div>
		<!-- end preloader -->
		<!-- start navigation -->
		<nav class="navbar navbar-default navbar-fixed-top templatemo-nav" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon icon-bar"></span>
						<span class="icon icon-bar"></span>
						<span class="icon icon-bar"></span>
					</button>
					<a href="https://ujicrypto.com" class="navbar-brand">UjiCrypto</a>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav navbar-right text-uppercase">
						<li><a href="#home">Home</a></li>
						<li><a href="#feature">Features</a></li>
						{{-- <li><a href="#signal">Signal History</a></li> --}}
						<li><a href="#download">Summary</a></li>
						<li><a href="#contact">Contact</a></li>
						<li><a href="{{ route('login') }}">Log in</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- end navigation -->
		<!-- start home -->
		<section id="home">
			<div class="overlay">
				<div class="container">
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-10 wow fadeIn" data-wow-delay="0.3s">
							<h1 class="text-upper">UjiCrypto Landing Page</h1>
							<p class="tm-white">UjiCrypto merupakan layanan pemantauan harga cryptocurrency mudah dengan bantuan 3 indikator sekaligus dalam satu sistem.</p>
							<img src="{{ asset('images/app-preview.png') }}" class="img-responsive" alt="home img">
						</div>
						<div class="col-md-1"></div>
					</div>
				</div>
			</div>
		</section>
		<!-- end home -->
		<!-- start divider -->
		<section id="divider">
			<div class="container">
				<div class="row">
					<div class="col-md-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						<i class="fa fa-laptop"></i>
						<h3 class="text-uppercase">Stochastic</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation. </p>
					</div>
					<div class="col-md-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						<i class="fa fa-laptop" style="font-size:94px;"></i>
						<h3 class="text-uppercase">Moving Average</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation. </p>
					</div>
					<div class="col-md-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						<i class="fa fa-laptop"></i>
						<h3 class="text-uppercase">Parabolic SAR</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation. </p>
					</div>
				</div>
			</div>
		</section>
		<!-- end divider -->

		<!-- start feature -->
		<section id="feature">
			<div class="container">
				<div class="row">
					<div class="col-md-6 wow fadeInLeft" data-wow-delay="0.6s">
						<h2 class="text-uppercase">Our Software Features</h2>
						<p>Aplikasi pergerakan harga cryptocurrency merupakan aplikasi untuk membantu dalam memantau pergerakan harga cryptocurrency dengan menggunakan 3 indikator.</p>
						<p><span><i class="fa fa-mobile"></i></span>Dapatkan pergerakan setiap harga dan indikasi pergerakan yang akan datang sekaligus dalam satu halaman.</p>
						<p><i class="fa fa-code"></i>Aplikasi diprogram untuk memudahkan anda para trader.</p>
					</div>
					<div class="col-md-6 wow fadeInRight" data-wow-delay="0.6s">
						<img src="{{ asset('images/app-preview.png') }}" class="img-responsive" alt="feature img">
					</div>
				</div>
			</div>
		</section>
		<!-- end feature -->

		<!-- start feature1 -->
		<section id="feature1">
			<div class="container">
				<div class="row">
					<div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
						<img src="{{ asset('images/app-preview.png') }}" class="img-responsive" alt="feature img">
					</div>
					<div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
						<h2 class="text-uppercase">More of Our Software</h2>
						<p>Aplikasi pergerakan harga cryptocurrency merupakan aplikasi untuk membantu dalam memantau pergerakan harga cryptocurrency dengan menggunakan 3 indikator.</p>
						<p><span><i class="fa fa-mobile"></i></span>Dapatkan berbagai fitur yang dikembangkan dalam aplikasi ini sekarang juga.</p>
						<p><i class="fa fa-code"></i>Dapatkan pengalaman pemantauan harga dengan mudah.</p>
					</div>
				</div>
			</div>
		</section>
		<!-- end feature1 -->

		<!-- start signal -->
		{{-- <section id="signal" style="height: 100%;">
			<div class="container">
				<div class="row">
					<div class="col-md-12 wow bounceIn">
						<h2 class="text-uppercase">Signal History</h2>
					</div>
					<div class="col-md-12 wow fadeIn" data-wow-delay="0.6s">
						<div class="table-responsive" style="font-family:sans-serif;">
                        </div>
					</div>
				</div>
			</div>
		</section> --}}
		<!-- end pricing -->

		<!-- start download -->
		<section id="download">
			<div class="container">
				<div class="row">
					<div class="col-md-6 wow fadeInLeft" data-wow-delay="0.6s">
						<h2 class="text-uppercase">Download Our Software</h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation. </p>
						<button class="btn btn-primary text-uppercase"><i class="fa fa-download"></i> Download</button>
					</div>
					<div class="col-md-6 wow fadeInRight" data-wow-delay="0.6s">
						<img src="{{ asset('images/app-preview.png') }}" class="img-responsive" alt="feature img">
					</div>
				</div>
			</div>
		</section>
		<!-- end download -->

		<!-- start contact -->
		<section id="contact">
			<div class="overlay">
				<div class="container">
					<div class="row">
						<div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
							<h2 class="text-uppercase">Contact Us</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation. </p>
							<address>
								<p><i class="fa fa-map-marker"></i>36 Street Name, City Name, United States</p>
								<p><i class="fa fa-phone"></i> 010-010-0110 or 020-020-0220</p>
								<p><i class="fa fa-envelope-o"></i> info@company.com</p>
							</address>
						</div>
						<div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
							<div class="contact-form">
								<form action="#" method="post">
									<div class="col-md-6">
										<input type="text" class="form-control" placeholder="Name">
									</div>
									<div class="col-md-6">
										<input type="email" class="form-control" placeholder="Email">
									</div>
									<div class="col-md-12">
										<input type="text" class="form-control" placeholder="Subject">
									</div>
									<div class="col-md-12">
										<textarea class="form-control" placeholder="Message" rows="4"></textarea>
									</div>
									<div class="col-md-8">
										<input type="submit" class="form-control text-uppercase" value="Send">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- end contact -->

		<!-- start footer -->
		<footer>
			<div class="container">
				<div class="row">
					<p>Copyright © 2084 Your Company Name</p>
				</div>
			</div>
		</footer>
		<!-- end footer -->

		<script src="{{ asset('js/jquery.js') }}"></script>
		<script src="{{ asset('js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('js/wow.min.js') }}"></script>
		<script src="{{ asset('js/jquery.singlePageNav.min.js') }}"></script>
		<script src="{{ asset('js/custom.js') }}"></script>
	</body>
</html>
