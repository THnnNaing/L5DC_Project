<?php 
include('../dbconnect.php');

if (isset($_GET['IsID'])) {
	
	$isbn_id = mysqli_real_escape_string($db, $_GET['IsID']);

	$query = "SELECT * FROM isbn_tb WHERE isbn_id = '$isbn_id'";
	$result = mysqli_query($db, $query);

	if ($result && mysqli_num_rows($result) > 0) {
		$data = mysqli_fetch_array($result);
		$isbn_id = $data['isbn_id'];
		$isbn_num = $data['isbn_num'];
	} else {
		echo "<script>window.alert('ISBN ID not found')</script>";
		echo "<script>window.location='AdminDashboard.php'</script>";
		exit(); // Exit to prevent further execution
	}
}

if (isset($_POST['btnupdate'])) {
	$isbn_id = mysqli_real_escape_string($db, $_POST['txtIsbnID']);
	$isbn_num = mysqli_real_escape_string($db, $_POST['txtIsbnNum']);

	$update = "UPDATE isbn_tb		
			   SET isbn_num = '$isbn_num'
               WHERE isbn_id = '$isbn_id'";
	$result = mysqli_query($db, $update);

	if ($result) {
		echo "<script>window.alert('Update Success')</script>";
		echo "<script>window.location='AdminDashboard.php'</script>";
	} else {
		echo "<script>window.alert('Update Failed')</script>";
		echo "<script>window.location='isbnupdate.php?IsID=$isbn_id'</script>";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Update ISBN Information</title>
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
				Update ISBN Information
			</h3>
		</div>

		<div class="p-6 space-y-6">
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<div class="grid grid-cols-6 gap-6">
					<div class="col-span-6 sm:col-span-3">
						<label for="txtIsbnID" class="text-sm font-medium text-gray-900 block mb-2">ISBN ID</label>
						<input type="text" name="txtIsbnID" id="txtIsbnID" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" placeholder="ISBN ID" value="<?php echo $isbn_id; ?>" readonly>
					</div>
					<div class="col-span-6 sm:col-span-3">
						<label for="txtIsbnNum" class="text-sm font-medium text-gray-900 block mb-2">ISBN Code</label>
						<input type="text" name="txtIsbnNum" id="txtIsbnNum" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" placeholder="ISBN Code" value="<?php echo $isbn_num; ?>" required>
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
