<?php
session_start();
include '../dbconnect.php';
include '../AutoIDFunction.php';

if (isset($_POST['btnregister'])) {
    $CustomerID = $_POST['txtcustomerID'];
    $Customername = $_POST['txtcustomername'];
    $CustomerEmail = $_POST['txtcustomerEmail'];
    $Customerpassword = $_POST['txtcustomerpassword'];
    $CustomerDoB = $_POST['txtcustomerDoB'];

    $number = preg_match('@[0-9]@', $Customerpassword);
    $uppercharacter = preg_match('@[A-Z]@', $Customerpassword);
    $lowercharacter = preg_match('@[a-z]@', $Customerpassword);
    $special = preg_match('@[^\w]@', $Customerpassword);

    $checkemail = "SELECT * From customer_tb WHERE customer_email='$CustomerEmail'";
    $result = mysqli_query($db, $checkemail);
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        echo "<script>window.alert('Admin Email Already Exist!')</script>";
        echo "<script>window.location='customerregister.php'</script>";
    } else if (strlen($Customerpassword) < 8 || !$number || !$uppercharacter || !$lowercharacter || !$special) {
        echo "<script>window.alert('Password must be 8 character in length and must contain one number and uppercharacter and lowercharacter and special character')</script>";
        echo "<script>window.location='customerregister.php'</script>";
    } else {
        $insert = "INSERT INTO customer_tb (customer_id, customer_name, customer_email, customer_password, customer_dob)
                   VALUES ('$CustomerID', '$Customername', '$CustomerEmail', '$Customerpassword', '$CustomerDoB')";

        $inserted = mysqli_query($db, $insert);

        if ($inserted) {
            echo "<script>window.alert('Register Success!')</script>";
            echo "<script>window.location='customerlogin.php'</script>";
        } else {
            echo "<script>window.alert('Registration Failed. Please try again.')</script>";
            echo "<script>window.location='customerregister.php'</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* You can add custom styles here if needed */
        /* For simplicity, I'm not including Tailwind CSS classes here */
        /* This assumes you have a separate CSS file or are using Tailwind via CDN */
    </style>
</head>

<body class="bg-white">
    <?php include 'customernavigation.php'; ?>
    <section class="flex flex-col items-center pt-6">
        <div class="w-full bg-white rounded-lg shadow border md:mt-0 sm:max-w-md xl:p-0">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">Create an account</h1>
                <form class="space-y-4 md:space-y-6" method="POST" action="customerregister.php">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Customer ID</label>
                        <input type="text" name="txtcustomerID" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" value="<?php echo AutoID('customer_tb', 'customer_id', 'CID-', 5) ?>" placeholder="Emelia Erickson" readonly>
                    </div>
                    <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Customer Name</label>
                        <input type="text" name="txtcustomername" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" placeholder="Emelia Erickson" required>
                    </div>
                    <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Customer Email</label>
                        <input type="text" name="txtcustomerEmail" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" placeholder="customer12@gmail.com" required>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Customer Password</label>
                        <input type="password" name="txtcustomerpassword" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" required>
                    </div>
                    <div>
                        <label for="dob" class="block mb-2 text-sm font-medium text-gray-900">Customer Date of Birth</label>
                        <input type="date" name="txtcustomerDoB" id="dob" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" required>
                    </div>
                    <!-- Submit Button -->
                    <div class="col-span-full">
                        <input type="submit" name="btnregister" value="Save" class="mt-4 bg-yellow-500 text-white p-2 rounded-lg hover:bg-yellow-600">
                    </div>
                    <p class="text-sm font-light text-gray-500">Already have an account? <a class="font-medium text-blue-600 hover:underline" href="customerlogin.php">Login here</a></p>
                </form>
            </div>
        </div>
    </section>

</body>

</html>