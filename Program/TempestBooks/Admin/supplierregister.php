<?php
session_start();
include '../dbconnect.php';
include '../AutoIDFunction.php';

if (isset($_POST['btnregister'])) {
    $AID = $_POST['txtsupplierID'];
    $AName = $_POST['txtsuppliername'];
    $AEmail = $_POST['txtsupplieremail'];    
    $APass = $_POST['txtpassword'];

    $number = preg_match('@[0-9]@', $APass);
    $uppercharacter = preg_match('@[A-Z]@', $APass);
    $lowercharacter = preg_match('@[a-z]@', $APass);
    $special = preg_match('@[^\w]@', $APass);

    $checkemail = "SELECT * From supplier_tb WHERE supplier_email='$AEmail'";
    $result = mysqli_query($db, $checkemail);
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        echo "<script>window.alert('Supplier Email Already Exist!')</script>";
        echo "<script>window.location='supplierregister.php'</script>";
    } else if (strlen($APass) < 8 || !$number || !$uppercharacter || !$lowercharacter || !$special) {
        echo "<script>window.alert('Password must be 8 character in length and must contain one number and uppercharacter and lowercharacter and special character')</script>";
        echo "<script>window.location='supplierregister.php'</script>";
    } else {
        $insert = "INSERT into supplier_tb(supplier_id,supplier_name,supplier_email,supplier_password)
					VALUES('$AID','$AName','$AEmail','$APass')";
        echo "<script>window.location='supplierlogin.php'</script>";

        $inserted = mysqli_query($db, $insert);

        if ($inserted) {
            echo "<script>window.alert('Register Success!')</script>";
            echo "<script>window.location='supplierlogin.php'</script>";
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
  <div
    class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
      <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">Create an
        account
      </h1>
      <form class="space-y-4 md:space-y-6" method="POST" action="supplierregister.php">
        <div>
          <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Supplier ID</label>
          <input type="text" name="txtsupplierID" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?php echo AutoID('supplier_tb', 'supplier_id', 'SID-', 5) ?>" placeholder="Emelia Erickson" readonly>
        </div>
        <div>
          <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Supplier Name</label>
          <input type="text" name="txtsuppliername" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="emelia_erickson24" required="">
        </div>
        <div>
          <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Supplier Email</label>
          <input type="text" name="txtsupplieremail" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="emelia_erickson24" required="">
        </div>
        <div>
          <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Supplier Password</label>
          <input type="password" name="txtpassword" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
        </div>
        <!-- Submit Button -->
        <div class="col-span-full">
                <input type="submit" name="btnregister" value="Save" class="mt-4 bg-yellow-500 text-white p-2 rounded-lg hover:bg-yellow-600">
            </div>
        <p class="text-sm font-light text-gray-500 dark:text-gray-400">Already have an account? <a
            class="font-medium text-blue-600 hover:underline dark:text-blue-500" href="supplierlogin.php">Sign in here</a>
        </p>
      </form>
    </div>
  </div>
</section>

 </body>
 </html>