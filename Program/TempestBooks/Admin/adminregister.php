<?php
session_start();
include '../dbconnect.php';
include '../AutoIDFunction.php';

if (isset($_POST['btnregister'])) {
    $AID = $_POST['txtadminID'];
    $AName = $_POST['txtadminname'];
    $APass = $_POST['txtadminpassword'];
    $AEmail = $_POST['txtadminemail'];
    $Aphone = $_POST['txtadminPhoneNumber'];

    $number = preg_match('@[0-9]@', $APass);
    $uppercharacter = preg_match('@[A-Z]@', $APass);
    $lowercharacter = preg_match('@[a-z]@', $APass);
    $special = preg_match('@[^\w]@', $APass);

    $checkemail = "SELECT * From admin_tb WHERE admin_email='$AEmail'";
    $result = mysqli_query($db, $checkemail);
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        echo "<script>window.alert('Admin Email Already Exist!')</script>";
        echo "<script>window.location='adminregister.php'</script>";
    } else if (strlen($APass) < 8 || !$number || !$uppercharacter || !$lowercharacter || !$special) {
        echo "<script>window.alert('Password must be 8 character in length and must contain one number and uppercharacter and lowercharacter and special character')</script>";
        echo "<script>window.location='adminregister.php'</script>";
    } else {
        $insert = "INSERT into admin_tb(admin_id,admin_name,admin_password,admin_email,admin_phnum)
					VALUES('$AID','$AName','$APass','$AEmail','$Aphone')";
          echo "<script>window.alert('Register Success!')</script>";
        echo "<script>window.location='adminlogin.php'</script>";

        $inserted = mysqli_query($db, $insert);

        if ($inserted) {
            echo "<script>window.alert('Register Success!')</script>";
            echo "<script>window.location='adminlogin.php'</script>";
        }
    }

}

?>

 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<title>AdminRegisteration</title>
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
      <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">Create an account</h1>
      <form class="space-y-4 md:space-y-6" method="POST" action="adminregister.php">
        <div>
          <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Admin ID</label>
          <input type="text" name="txtadminID" id="name" class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" value="<?php echo AutoID('admin_tb', 'admin_id', 'AID-', 5) ?>" placeholder="Emelia Erickson" readonly>
        </div>
        <div>
          <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Admin Name</label>
          <input type="text" name="txtadminname" id="username" class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" placeholder="emelia_erickson24" required>
        </div>
        <div>
          <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Admin Email</label>
          <input type="email" name="txtadminemail" id="email" class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" placeholder="emelia_erickson24@example.com" required>
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
        <div>
          <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Admin Phone Number</label>
          <input type="tel" name="txtadminPhoneNumber" id="phone" class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" placeholder="123-456-7890" required>
        </div>
        <!-- Submit Button -->
        <div class="col-span-full">
          <input type="submit" name="btnregister" value="Sign Up" class="mt-4 bg-yellow-500 text-white p-2 rounded-lg hover:bg-yellow-600">
        </div>
        <p class="text-sm font-light text-gray-500">Already have an account? <a class="font-medium text-yellow-600 hover:underline" href="adminlogin.php">Login here</a></p>
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