<?php
session_start();
include('../dbconnect.php');
include('../AutoIDFunction.php');
include('purchaseFunction.php');

if (!isset($_SESSION['AID'])) { // Changed this line to check if the session is not set
	echo "<script>window.alert('Please login first')</script>";
	echo "<script>window.location='adminlogin.php'</script>";
	exit(); // Added exit to stop further execution if the user is not logged in
}

if (isset($_POST['btnConfirm'])) {
	$txtPurchaseID = $_POST['txtPurchaseID'];

	$query = mysqli_query($db, "SELECT * FROM purchasedetail_tb WHERE purchase_id='$txtPurchaseID'");

	while ($row = mysqli_fetch_array($query)) {
		$Product_ID = $row['book_id'];
		$Quantity = $row['qty'];

		$UpdateQty = "UPDATE book_tb
					SET book_qty= book_qty + '$Quantity'
					WHERE book_id='$Product_ID'
					";
		$ret = mysqli_query($db, $UpdateQty);
	}

	$UpdateStatus = "UPDATE purchase_tb
				   SET purchase_status='Confirmed'
				   WHERE purchase_id='$txtPurchaseID'";
	$ret = mysqli_query($db, $UpdateStatus);

	if ($ret) //True
	{
		echo "<script>window.alert('SUCCESS : Purchase Order Successfully Confirmed.')</script>";
		echo "<script>window.location='purchaselist.php'</script>";
	} else {
		echo "<p>Something went wrong in Purchase Details" . mysqli_error($db) . "</p>";
	}
}

if (isset($_GET['purchase_id'])) {
	$Purchase_ID = $_GET['purchase_id'];

	$query1 = "SELECT p.*, sup.supplier_id, sup.supplier_name, a.admin_id,a.admin_name
			FROM purchase_tb p, supplier_tb sup, admin_tb a
			WHERE p.supplier_id=sup.supplier_id
			AND p.admin_id=a.admin_id
			AND p.purchase_id='$Purchase_ID'
			";
	$result1 = mysqli_query($db, $query1);
	$row1 = mysqli_fetch_array($result1);

	$query2 = "SELECT p.*, pd.*, b.book_id, b.book_name
			FROM purchase_tb p, purchasedetail_tb pd, book_tb b
			WHERE p.purchase_id=pd.purchase_id
			AND pd.book_id=b.book_id
			";
	//echo $query2;
	$result2 = mysqli_query($db, $query2);
	$count = mysqli_num_rows($result2);
} else {
	$PurchaseOrderID = "";

	echo "<script>window.alert('ERROR : Purchase Order Details not Found.')</script>";
	echo "<script>window.location='purchaselist.php'</script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Purchase Details</title>
	<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-6">
	<form action="purchasedetail.php" method="POST">
		<fieldset class="border border-yellow-300 p-3 rounded-md">
			<legend class="text-lg font-semibold text-slate-700">Purchase Order Detail Report for POID: <?php echo $Purchase_ID ?></legend>
			<table class="min-w-full bg-white border-collapse mt-4">
				<tr>
					<td class="border px-4 py-2">Purchase_ID</td>
					<td class="border px-4 py-2 font-bold"><?php echo $Purchase_ID ?></td>
					<td class="border px-4 py-2">Status</td>
					<td class="border px-4 py-2 font-bold"><?php echo $row1['purchase_status'] ?></td>
				</tr>
				<tr>
					<td class="border px-4 py-2">Purchase Date</td>
					<td class="border px-4 py-2 font-bold"><?php echo $row1['purchase_date'] ?></td>
					<td class="border px-4 py-2">Report Date</td>
					<td class="border px-4 py-2 font-bold"><?php echo date('Y-m-d') ?></td>
				</tr>
				<tr>
					<td class="border px-4 py-2">Supplier Name</td>
					<td class="border px-4 py-2 font-bold"><?php echo $row1['supplier_name'] ?></td>
					<td class="border px-4 py-2">Admin Name</td>
					<td class="border px-4 py-2 font-bold"><?php echo $row1['admin_name'] ?></td>
				</tr>
				<tr>
					<td colspan="4">
						<table class="min-w-full bg-white border-collapse mt-4">
							<tr class="bg-yellow-300">
								<th class="border px-4 py-2">Book Name</th>
								<th class="border px-4 py-2">Purchase_Price</th>
								<th class="border px-4 py-2">Purchase_Quantity</th>
								<th class="border px-4 py-2">Sub-Total</th>
							</tr>
							<?php
							for ($i = 0; $i < $count; $i++) {
								$row2 = mysqli_fetch_array($result2);
								echo "<tr>";
								echo "<td class='border px-4 py-2'>" . $row2['book_name'] . "</td>";
								echo "<td class='border px-4 py-2'>" . $row2['unit_price'] . "</td>";
								echo "<td class='border px-4 py-2'>" . $row2['qty'] . "</td>";
								echo "<td class='border px-4 py-2'>" . ($row2['unit_price'] * $row2['qty']) . "</td>";
								echo "</tr>";
							}
							?>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="4" class="text-right p-4">
						Total Amount: <b><?php echo $row1['purchase_amount'] ?> MMK</b><br>
						Tax Amount (VAT): <b><?php echo $row1['purchase_tax'] ?> MMK</b><br>
						Grand Total: <b><?php echo $row1['purchase_total_amount'] ?> MMK</b><br>
					</td>
				</tr>
				<tr>
					<td colspan="4" class="text-right p-4">
						<input type="hidden" name="txtPurchaseID" value="<?php echo $Purchase_ID ?>">
						<?php
						if ($row1['purchase_status'] === "Pending") {
							echo "<input type='submit' name='btnConfirm' value='Confirm' class='bg-yellow-300 hover:bg-yellow-400 text-white font-bold py-2 px-4 rounded'/>";
						} else {
							echo "<input type='submit' name='btnConfirm' value='Confirm' disabled class='bg-gray-300 text-white font-bold py-2 px-4 rounded'/>";
						}
						?>
					</td>
				</tr>
			</table>
		</fieldset>
	</form>
	<!--- Print Button --->
	<div class="mt-4 text-center">
		<a href="http://www.printfriendly.com" class="text-yellow-700 hover:text-yellow-500" onClick="window.print();return false;" title="Printer Friendly and PDF">
			<img src="https://cdn.printfriendly.com/button-print-grnw20.png" alt="Print Friendly and PDF" class="inline">
		</a>
	</div>
</body>

</html>