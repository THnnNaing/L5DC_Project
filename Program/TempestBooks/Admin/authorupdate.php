<?php
include('../dbconnect.php');

if (isset($_GET['AuID'])) {
    $Author_ID = $_GET['AuID'];

    // Fetch author data
    $query = "SELECT * FROM author_tb WHERE author_id = '$Author_ID'";
    $result = mysqli_query($db, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $Author_ID = $data['Author_ID'];
        $Author_Name = $data['Author_Name'];
        $Author_Bio = $data['Author_Bio'];
    } else {
        // Handle error or redirect if no author found
        echo "<script>window.alert('Author not found')</script>";
        echo "<script>window.location='AdminDashboard.php'</script>";
        exit();
    }
}

if (isset($_POST['btnupdate'])) {
    $Author_ID = $_POST['txtAuthorID']; // Corrected to txtAuthorID
    $Author_Name = $_POST['txtAuthorName']; // Corrected to txtAuthorName
    $Author_Bio = $_POST['txtAuthorBio']; // Corrected to txtAuthorBio

    // Update query syntax corrected
    $update = "UPDATE author_tb		
               SET Author_Name = '$Author_Name',
                   Author_Bio = '$Author_Bio'
               WHERE Author_ID = '$Author_ID'";
    
    $result = mysqli_query($db, $update);

    if ($result) {
        echo "<script>window.alert('Update Success')</script>";
        echo "<script>window.location='AdminDashboard.php'</script>";
    } else {
        echo "<script>window.alert('Update Failed')</script>";
        echo "<script>window.location='authorupdate.php?AuID=$Author_ID'</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Author Information</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<!-- Navigation -->
<div class="w-32 h-screen fixed">
    <?php include 'navigation.php'; ?>
</div>

<!-- Form -->
<div class="ml-64 p-10 w-50 flex flex-col">
    <div class="bg-white border border-4 rounded-lg shadow relative m-10">
        <div class="flex items-start justify-between p-5 border-b rounded-t">
            <h3 class="text-xl font-semibold">
                Update Author Information
            </h3>
        </div>

        <div class="p-6 space-y-6">
            <form action="authorupdate.php" method="post"> <!-- Corrected method and action -->
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Author ID</label>
                        <input type="text" name="txtAuthorID" id="product-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" placeholder="Author ID" value="<?php echo $Author_ID; ?>" readonly>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Author Name</label>
                        <input type="text" name="txtAuthorName" id="product-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" placeholder="Author Name" value="<?php echo $Author_Name; ?>" required>
                    </div>
                    <div class="col-span-full">
                        <label for="product-details" class="text-sm font-medium text-gray-900 block mb-2">Author Biography</label>
                        <textarea id="product-details" rows="6" name="txtAuthorBio" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-4" placeholder="Add Author Biography Here"><?php echo $Author_Bio; ?></textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-span-full">
                    <input type="submit" name="btnupdate" value="Update" class="mt-4 bg-yellow-500 text-white p-2 rounded-lg hover:bg-yellow-600">
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
