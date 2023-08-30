<!DOCTYPE html>
<html lang="en">
	<head>
		<title></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="/assets/images/favicon.ico" />
		<link href="/assets/css/auth-corporate.css" rel="stylesheet" type="text/css" />
	</head>
	<body data-kt-name="metronic" id="kt_body" class="app-blank">
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
					<div class="d-flex flex-center flex-column flex-lg-row-fluid">
						<div class="w-lg-500px p-10" style="width: 100%;">
							<form method="POST" action="{{ route('login') }}" class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="javaScript:;">
								<div class="text-center mb-11">
									<a href="/">
										<img alt="Logo" src="/assets/images/logo_dark.png" class="h-50px">
									</a>
									<h1 class="text-dark fw-bold mb-3 mt-5">LBMS Email Login</h1>
									<div class="text-gray-500 fw-semibold fs-6">Provide your login details to proceed.</div>
								</div>
								<div class="fv-row mb-0 fv-plugins-icon-container">
									<label class="form-label fs-6 fw-bolder text-dark">Email Address</label>
									<input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent">
									<div class="fv-plugins-message-container invalid-feedback"></div>
								</div>
								<div class="fv-row mb-8 fv-plugins-icon-container">
									<label class="form-label fs-6 fw-bolder text-dark">Password</label>
									<input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent">
									<div class="fv-plugins-message-container invalid-feedback"></div>
									<a href="./reset-password.html" class="link-success forgot fw-semibold">Forgot Password ?</a>
								</div>
								<div class="d-flex mb-10 mt-5 w-100">
									<button type="submit" id="kt_sign_in_submit" class="btn btn-success w-100">
										<span class="indicator-label">Sign In</span>
										<span class="indicator-progress">Please wait... 
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									</button>
								</div>
								<div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet? 
								<a href="./sign-up.html" class="link-success">Sign up</a></div>
								<div></div>
							</form>
						</div>
					</div>
					<div class="d-flex flex-center flex-wrap px-5">
						<div class="d-flex fw-semibold text-primary fs-base">
							<a href="javaScript:;" class="px-5 link-success fw-semibold" target="_blank">Terms</a>
							<a href="javaScript:;" class="px-5 link-success fw-semibold" target="_blank">Plans</a>
							<a href="javaScript:;" class="px-5 link-success fw-semibold" target="_blank">Contact Us</a>
						</div>
					</div>
				</div>
				<div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url(/assets/images/auth-bg.png)">
					<div class="d-flex flex-column flex-center py-15 px-5 px-md-15 w-100 py-20"></div>
				</div>
			</div>
		<script src="/assets/js/plugins.bundle.js"></script>
		<script src="/assets/js/scripts.bundle.js"></script>
		<script src="/assets/js/sign-in.js"></script>
	</body>
</html>