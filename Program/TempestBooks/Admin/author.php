<?php
session_start();
include '../dbconnect.php';
include '../AutoIDFunction.php';

if (!isset($_SESSION['AID'])) { // Changed this line to check if the session is not set
    echo "<script>window.alert('Please login first')</script>";
    echo "<script>window.location='adminlogin.php'</script>";
    exit(); // Added exit to stop further execution if the user is not logged in
}

if (isset($_POST['btn'])) {
    $AUID = $_POST['txtAuthorID'];
    $AUNAME = $_POST['txtAuthorName'];
    $AUBIO = $_POST['txtAuthorBio'];

    $checkmedia = "SELECT * FROM author_tb WHERE Author_ID='$AUID'";
    $query = mysqli_query($db, $checkmedia);
    $count = mysqli_num_rows($query);

    if ($count > 0) {
        echo "<script>window.alert('Social Media App Is Already Existed')</script>";
        echo "<script>window.location='author.php'</script>";
    } else {
        $insert = "INSERT INTO author_tb (Author_ID, Author_Name, Author_Bio)
                   VALUES ('$AUID', '$AUNAME', '$AUBIO')";
        $query = mysqli_query($db, $insert);

        if ($query) {
            echo "<script>window.alert('Upload Successful')</script>";
            echo "<script>window.location='author.php'</script>";
        } else {
            echo "<script>window.alert('Upload Failed')</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Author Information</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<!-- Navigation -->
<div class=" fixed inset-y-0 left-0 w-32 h-screen transform fixed transition-transform duration-300">
    <?php include 'navigation.php';?>
</div>
    

<!-- Form -->
<div class="md:ml-64 ml-18 p-10 w-50 flex flex-col">
    <div class="bg-white border border-4 rounded-lg shadow relative m-10">
        <div class="flex items-start justify-between p-5 border-b rounded-t">
            <h3 class="text-xl font-semibold">
                Add Author Information
            </h3>
        </div>

        <div class="p-6 space-y-6">
            <form action="author.php" method="post"> <!-- Added method="post" and action="" -->
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Author ID</label>
                        <input type="text" name="txtAuthorID" id="product-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" placeholder="Author ID" value="<?php echo AutoID('author_tb', 'author_id', 'AUID-', 5) ?>" required="" readonly>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Author Name</label>
                        <input type="text" name="txtAuthorName" id="product-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" placeholder="Author Name" required="">
                    </div>

                    <div class="col-span-full">
                        <label for="product-details" class="text-sm font-medium text-gray-900 block mb-2">Author Biography</label>
                        <textarea id="product-details" rows="6" name="txtAuthorBio" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-4" placeholder="Add Author Biography Here"></textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-span-full">
                    <button type="submit" name="btn" class="mt-4 bg-yellow-500 text-white p-2 rounded-lg hover:bg-yellow-600">Submit</button>
                </div>



            </form>
        </div>


    </div>
</div>
    <!-- </div> -->
</body>
</html>
