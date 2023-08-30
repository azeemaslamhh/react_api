<!DOCTYPE html>
<html lang="en">
	<head>
		<title></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="/public/assets/images/favicon.ico" />
		<link rel="stylesheet" href="/public/assets/css/fonts.css" />
		<link href="/public/assets/css/auth-corporate.css" rel="stylesheet" type="text/css" />
	</head>
	<body id="kt_body" class="bg-body">
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
					<div class="d-flex flex-center flex-column flex-lg-row-fluid">
						<div class="w-lg-500px p-10">
							<form class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate" id="kt_password_reset_form" data-kt-redirect-url="./new-password.html" action="#">
								<div class="text-center mb-10">
									<a href="/">
										<img alt="Logo" src="/public/assets/images/logo_dark.png" class="h-50px mb-3">
									</a>
									<h1 class="text-dark fw-bold mb-3">Forgot Password ?</h1>
									<div class="text-gray-500 fw-semibold fs-6">Enter your email to reset your password.</div>
								</div>
								<div class="fv-row mb-5 fv-plugins-icon-container">
									<input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control ">
								    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <div class="fv-row mb-5" data-kt-password-meter="true">
									<div class="mb-0">
										<div class="position-relative mb-2">
											<input class="form-control " type="password" placeholder="Password" name="password" autocomplete="off">
											<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
												<i class="bi bi-eye-slash fs-2"></i>
												<i class="bi bi-eye fs-2 d-none"></i>
											</span>
										</div>
										<div class="d-flex align-items-center mb-0" data-kt-password-meter-control="highlight">
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
										</div>
									</div>
									<div class="text-muted">Use 8 or more characters with a mix of letters, numbers &amp; symbols.</div>
								</div>
								<div class="fv-row mb-5">
									<input type="password" placeholder="Repeat Password" name="confirm-password" autocomplete="off" class="form-control ">
								</div>
								<div class="d-flex flex-wrap justify-content-center pb-lg-0">
									<button type="button" id="kt_password_reset_submit" class="btn btn-success mx-1">
										<span class="indicator-label">Submit</span>
										<span class="indicator-progress">Please wait... 
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									</button>
									<a href="/login" class="btn btn-secondary mx-1">Cancel</a>
								</div>
							<div></div></form>
						</div>
					</div>
					<div class="d-flex flex-center flex-wrap px-5">
						<div class="d-flex fw-semibold text-primary fs-base">
							<a href="javaScript:;" class="px-5 link-success" target="_blank">Terms</a>
							<a href="javaScript:;" class="px-5 link-success" target="_blank">Plans</a>
							<a href="javaScript:;" class="px-5 link-success" target="_blank">Contact Us</a>
						</div>
					</div>
				</div>
				<div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
				style="background-image: url(/public/assets/images/auth-bg.png)">
					<div class="d-flex flex-column flex-center py-15 px-5 px-md-15 w-100 py-20"></div>
				</div>
			</div>
		</div>
		<!-- <script src="/public/assets/js/plugins.bundle.js"></script>
		<script src="/public/assets/js/scripts.bundle.js"></script>
		<script src="/public/assets/js/password-reset.js"></script> -->
	</body>
</html>