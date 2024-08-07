<?php
session_start();
include('../dbconnect.php');

if (isset($_POST['btnlogin'])) {
	$email = $_POST['txtcustomeremail'];
	$pass = $_POST['txtcustomerpassword'];

	$logincode = "SELECT * FROM customer_tb WHERE customer_email='$email' AND customer_password='$pass'";

	$query = mysqli_query($db, $logincode);

	$count = mysqli_num_rows($query);

	if ($count > 0) {
		$array = mysqli_fetch_array($query);
		$CID = $array['customer_id'];
		$CN = $array['customer_name'];

		$_SESSION['customer_logged_in'] = true;
		$_SESSION['CID'] = $CID;
		$_SESSION['CN'] = $CN;

		echo "<script>window.alert('Success Login')</script>";
		echo "<script>window.location='home.php'</script>";
	} else {
		if (isset($_SESSION['LoginError'])) {
			$counterror = $_SESSION['LoginError'];
			if ($counterror == 1) {
				echo "<script>window.alert('Customer Login Failed! Attempt Two')</script>";
				$_SESSION['LoginError'] = 2;
			} else if ($counterror == 2) {
				echo "<script>window.alert('Customer Login Failed! Attempt Three')</script>";
				echo "<script>window.location='Timer.php'</script>";
			}
		} else {
			echo "<script>window.alert('Customer Login Failed! Attempt One')</script>";
			$_SESSION['LoginError'] = 1;
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login Page</title>
	<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
	<?php include 'customernavigation.php'; ?>
	<section class="flex flex-col items-center pt-6 min-h-screen">
		<div class="w-full bg-white rounded-lg shadow border md:mt-0 sm:max-w-4xl xl:p-0">
			<div class="flex flex-col md:flex-row">
				<!-- Side Photo -->
				<div class="hidden md:block md:w-1/2 bg-cover bg-center rounded-l-lg" style="background-image: url('../Images/login.jpg');">
					<!-- Replace 'url('../Images/login.jpg')' with your actual image path -->
				</div>
				<!-- Login Form -->
				<div class="w-full md:w-1/2 p-6 space-y-4 md:space-y-6 sm:p-8 flex flex-col justify-center">
					<h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl text-center">Customer Login</h1>
					<form class="space-y-4" action="customerlogin.php" method="POST">
						<div>
							<label for="email" class="block mb-2 text-sm font-medium text-gray-900">Customer Email</label>
							<input type="email" name="txtcustomeremail" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" placeholder="abc12@gmail.com" required>
						</div>
						<div>
							<label for="password" class="block mb-2 text-sm font-medium text-gray-900">Customer Password</label>
							<input type="password" name="txtcustomerpassword" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" placeholder="" required>
						</div>
						<!-- Submit Button -->
						<div class="col-span-full">
							<input type="submit" name="btnlogin" value="Login" class="mt-4 bg-yellow-500 text-white p-2 rounded-lg hover:bg-yellow-600 w-full">
						</div>


						<p class="text-sm font-light text-gray-500 text-center">Don't have an account?
							<a class="font-medium text-blue-600 hover:underline" href="customerregister.php">Sign up here</a>
						</p>

						<button onclick="window.location.href='home.php'" class="flex items-center space-x-2 text-blue-500 hover:text-yellow-500 hover:underline focus:outline-none">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-6 h-6"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
								<path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
							</svg>
							<span>GO BACK?</span>
						</button>
					</form>
				</div>
			</div>
		</div>
	</section>
</body>

</html>