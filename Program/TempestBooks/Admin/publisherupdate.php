<?php 
include('../dbconnect.php');

if (isset($_GET['PUID'])) {
    $publisher_id = mysqli_real_escape_string($db, $_GET['PUID']);

    $query = "SELECT * FROM publisher_tb WHERE publisher_id = '$publisher_id'";
    $result = mysqli_query($db, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_array($result);
        $publisher_id = $data['publisher_id'];
        $publisher_name = $data['publisher_name'];
        $publisher_desc = $data['publisher_desc'];
    } else {
        echo "<script>window.alert('Publisher ID not found')</script>";
        echo "<script>window.location='AdminDashboard.php'</script>";
        exit(); // Exit to prevent further execution
    }
}

if (isset($_POST['btnupdate'])) {
    $publisher_id = mysqli_real_escape_string($db, $_POST['txtPublisherID']);
    $publisher_name = mysqli_real_escape_string($db, $_POST['txtPublisherName']);
    $publisher_desc = mysqli_real_escape_string($db, $_POST['txtPublisherDesc']);

    $update = "UPDATE publisher_tb		
               SET publisher_name = '$publisher_name',
                   publisher_desc = '$publisher_desc'
               WHERE publisher_id = '$publisher_id'";
    $result = mysqli_query($db, $update);

    if ($result) {
        echo "<script>window.alert('Update Success')</script>";
        echo "<script>window.location='AdminDashboard.php'</script>";
    } else {
        echo "<script>window.alert('Update Failed')</script>";
        echo "<script>window.location='publisherupdate.php?PUID=$publisher_id'</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Publisher Information</title>
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
                Update Publisher Information
            </h3>
        </div>

        <div class="p-6 space-y-6">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="txtPublisherID" class="text-sm font-medium text-gray-900 block mb-2">Publisher ID</label>
                        <input type="text" name="txtPublisherID" id="txtPublisherID" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" placeholder="Publisher ID" value="<?php echo $publisher_id; ?>" readonly>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="txtPublisherName" class="text-sm font-medium text-gray-900 block mb-2">Publisher Name</label>
                        <input type="text" name="txtPublisherName" id="txtPublisherName" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" placeholder="Publisher Name" value="<?php echo $publisher_name; ?>" required>
                    </div>
                    <div class="col-span-full">
                        <label for="txtPublisherDesc" class="text-sm font-medium text-gray-900 block mb-2">Publisher Description</label>
                        <textarea id="txtPublisherDesc" rows="6" name="txtPublisherDesc" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-4" placeholder="Add Publisher Description Here"><?php echo $publisher_desc; ?></textarea>
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
