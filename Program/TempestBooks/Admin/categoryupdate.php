<?php 
include('../dbconnect.php');

if (isset($_GET['CTID'])) {
    $category_id = mysqli_real_escape_string($db, $_GET['CTID']);

    $query = "SELECT * FROM category_tb WHERE category_id = '$category_id'";
    $result = mysqli_query($db, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_array($result);
        $category_id = $data['category_id'];
        $category = $data['category'];
    } else {
        echo "<script>window.alert('Category ID not found')</script>";
        echo "<script>window.location='AdminDashboard.php'</script>";
        exit(); // Exit to prevent further execution
    }
}

if (isset($_POST['btnupdate'])) {
    $category_id = mysqli_real_escape_string($db, $_POST['txtCategoryID']);
    $category = mysqli_real_escape_string($db, $_POST['txtCategoryName']);

    $update = "UPDATE category_tb		
              SET category = '$category'
              WHERE category_id = '$category_id'";
    $result = mysqli_query($db, $update);

    if ($result) {
        echo "<script>window.alert('Update Success')</script>";
        echo "<script>window.location='AdminDashboard.php'</script>";
    } else {
        echo "<script>window.alert('Update Failed')</script>";
        echo "<script>window.location='categoryupdate.php?CTID=$category_id'</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Category Information</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<!-- Navigation -->
<div class="w-32 h-screen fixed">
    <?php include 'navigation.php';?>
</div>

<!-- Form -->
<div class="ml-64 p-10 w-50 flex flex-col">
    <div class="bg-white border border-4 rounded-lg shadow relative m-10">
        <div class="flex items-start justify-between p-5 border-b rounded-t">
            <h3 class="text-xl font-semibold">
                Update Category Information
            </h3>
        </div>

        <div class="p-6 space-y-6">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="txtCategoryID" class="text-sm font-medium text-gray-900 block mb-2">Category ID</label>
                        <input type="text" name="txtCategoryID" id="txtCategoryID" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" placeholder="Category ID" value="<?php echo $category_id; ?>" readonly>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="txtCategoryName" class="text-sm font-medium text-gray-900 block mb-2">Category Name</label>
                        <input type="text" name="txtCategoryName" id="txtCategoryName" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" placeholder="Category Name" value="<?php echo $category; ?>" required>
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
