<?php 
session_start();
include('../dbconnect.php');

if (isset($_POST['btnlogin'])) 
{
	$email=$_POST['txtadminemail'];
	$pass=$_POST['txtadminpassword'];

	$logincode="SELECT * FROM admin_tb WHERE admin_email='$email' AND admin_password='$pass'";

	$query=mysqli_query($db,$logincode);

	$count=mysqli_num_rows($query);

	if ($count>0) 
	{
		$array=mysqli_fetch_array($query);
		$AID=$array['admin_id'];
		$AN=$array['admin_name'];

		$_SESSION['AID']=$AID;
		$_SESSION['AN']=$AN;

		echo "<script>window.alert('Success Login')</script>";
		echo "<script>window.location='AdminDashboard.php'</script>";
	}
	// counter error message attempt 
	else{	
		if (isset($_SESSION['LoginError'])) {
			$counterror=$_SESSION['LoginError'];
			if ($counterror==1) {
				echo "<script>window.alert('Admin Login Failed! Attempt Two')</script>";
				$_SESSION['LoginError']=2;
			}
			else if ($counterror==2){
				echo "<script>window.alert('Admin Login Failed! Attempt Three')</script>";
				echo "<script>window.location='Timer.php'</script>";
			}
		}
		else{
			echo "<script>window.alert('Admin Login Failed! Attempt One')</script>";
			$_SESSION['LoginError']=1;
		}
	}
}

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Login</title>
	<script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
	
<section class="flex flex-col items-center pt-6">
  <div class="w-full bg-white rounded-lg shadow border md:mt-0 sm:max-w-md xl:p-0">
    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
      <!-- Logo Section -->
      <div class="flex justify-center">
        <img src="../Images/LOGO.jpg" alt="Logo" class="h-24 w-35">
      </div>
      <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">Admin Login</h1>
      <form class="space-y-4 md:space-y-6" action="adminlogin.php" method="POST">
        <div>
          <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Admin Email</label>
          <input type="text" name="txtadminemail" id="name" class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" placeholder="abc12@gmail.com" required>
        </div>

		<div>
        <label for="password" class="block mb-2 text-xs font-medium text-gray-900">Admin Password</label>
          <div class="relative">
            <input type="password" name="txtadminpassword" id="password" placeholder="••••••••" class="bg-white border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2" required>
            <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
              <svg id="eye-icon" class="h-5 w-5 text-gray-500" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
          </div>
        </div>
        <!-- Submit Button -->
        <div class="col-span-full">
          <input type="submit" name="btnlogin" value="Login" class="mt-4 bg-yellow-500 text-white p-2 rounded-lg hover:bg-yellow-600">
        </div>
        <p class="text-sm font-light text-gray-500">Don't have an account? <a class="font-medium text-yellow-600 hover:underline" href="adminregister.php">Sign up here</a></p>
      </form>
    </div>
  </div>
</section>

<script>
  function togglePasswordVisibility() {
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');

    if (passwordField.type === 'password') {
      passwordField.type = 'text';
      eyeIcon.innerHTML = '<path d="M13.875 18.825C13.024 19.267 12.031 19.5 11 19.5c-4.477 0-8.268-2.943-9.542-7 1.274-4.057 5.065-7 9.542-7 .998 0 1.946.143 2.825.407" /><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
    } else {
      passwordField.type = 'password';
      eyeIcon.innerHTML = '<path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
    }
  }
</script>

</body>
</html>