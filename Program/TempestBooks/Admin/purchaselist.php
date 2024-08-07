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

if(isset($_POST['btnSearch'])) 
{
	$rdoSearchType=$_POST['rdoSearchType'];

	if($rdoSearchType == 1) 
	{
		$lstProductID=$_POST['lstProductID'];

		$query="SELECT po.*, s.supplier_id,s.supplier_name 
				FROM purchase_tb po, supplier_tb s
				WHERE po.purchase_id='$lstProductID'
				AND po.supplier_id=s.supplier_id
				";
		$result=mysqli_query($db,$query);
		$count=mysqli_num_rows($result);
	}
	elseif($rdoSearchType == 2) 
	{
		$txtFrom=date('Y-m-d',strtotime($_POST['txtFrom']));
		$txtTo=date('Y-m-d',strtotime($_POST['txtTo']));

		$query="SELECT po.*, s.supplier_id,s.supplier_name 
				FROM purchase_tb po, supplier_tb s
				WHERE po.purchase_date BETWEEN '$txtFrom' AND '$txtTo'
				AND po.supplier_id=s.supplier_id
				";
		$result=mysqli_query($db,$query);
		$count=mysqli_num_rows($result);
	}
	else
	{
		$cboStatus=$_POST['cboStatus'];

		$query="SELECT po.*, s.supplier_id,s.supplier_name 
				FROM purchase_tb po, supplier_tb s
				WHERE po.purchase_status='$cboStatus'
				AND po.supplier_id=s.supplier_id
				";
		$result=mysqli_query($db,$query);
		$count=mysqli_num_rows($result);
	}

}		
else if(isset($_POST['btnShowAll'])) 
{
	$query="SELECT po.*, s.supplier_id,s.supplier_name 
			FROM purchase_tb po, supplier_tb s
			WHERE po.supplier_id=s.supplier_id
			";
	$result=mysqli_query($db,$query);
	$count=mysqli_num_rows($result);

}
else
{
	$TodayDate=date('Y-m-d');

	$query="SELECT po.*, s.supplier_id,s.supplier_name 
			FROM purchase_tb po, supplier_tb s
			WHERE po.purchase_date='$TodayDate'
			AND po.supplier_id=s.supplier_id
			";
	$result=mysqli_query($db,$query);
	$count=mysqli_num_rows($result);
	
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order List</title>
    <script type="text/javascript" src="DatePicker/datepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="DatePicker/datepicker.css"/>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-5">

<div class="w-32 h-screen fixed">
        <?php include 'navigation.php'; ?>
    </div>

    <div class="md:ml-64 ml-18 p-10 w-50 flex flex-col">
    <form action="purchaselist.php" method="post" class="space-y-5">
    <fieldset class="border border-yellow-500 p-4 rounded">
        <legend class="text-xl text-yellow-600 font-semibold">Search Option :</legend>
        <div class="space-y-4">
            <div class="flex items-center space-x-4">
                <input type="radio" name="rdoSearchType" value="1" id="searchById" checked class="text-yellow-600"/>
                <label for="searchById" class="text-yellow-800">Search By Book_ID</label>
                <input list="lstProductID" name="lstProductID" class="border border-yellow-500 rounded p-2 focus:outline-none focus:ring-2 focus:ring-yellow-600"/>
                <datalist id="lstProductID">
                    <?php  
                    $POquery="SELECT * FROM purchase_tb";
                    $ret=mysqli_query($db,$POquery);
                    $POcount=mysqli_num_rows($ret);

                    for($z=0;$z<$POcount;$z++) 
                    { 
                        $POrow=mysqli_fetch_array($ret);
                        $Purchase_ID=$POrow['purchase_id'];
                        echo "<option value='$Purchase_ID'>";
                    }
                    ?>
                </datalist>
            </div>
            <div class="flex items-center space-x-4">
                <input type="radio" name="rdoSearchType" value="2" id="searchByDate" class="text-yellow-600"/>
                <label for="searchByDate" class="text-yellow-800">Search By Date</label>
                <div class="flex items-center space-x-2">
                    <label for="fromDate" class="text-yellow-800"><b>From :</b></label>
                    <input type="text" name="txtFrom" value="<?php echo date('Y-m-d') ?>" onclick="showCalendar(this);" class="border border-yellow-500 rounded p-2 focus:outline-none focus:ring-2 focus:ring-yellow-600"/>
                    <label for="toDate" class="text-yellow-800"><b>To :</b></label>
                    <input type="text" name="txtTo" value="<?php echo date('Y-m-d') ?>" onclick="showCalendar(this);" class="border border-yellow-500 rounded p-2 focus:outline-none focus:ring-2 focus:ring-yellow-600"/>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <input type="radio" name="rdoSearchType" value="3" id="searchByStatus" class="text-yellow-600"/>
                <label for="searchByStatus" class="text-yellow-800">Search By Status</label>
                <select name="cboStatus" class="border border-yellow-500 rounded p-2 focus:outline-none focus:ring-2 focus:ring-yellow-600">
                    <option>Pending</option>
                    <option>Confirmed</option>
                </select>
            </div>
            <div class="flex space-x-4">
                <input type="submit" name="btnSearch" value="Search" class="bg-yellow-500 text-white rounded p-2 hover:bg-yellow-600 active:bg-yellow-700 transition duration-150"/>
                <input type="submit" name="btnShowAll" value="Show All" class="bg-yellow-500 text-white rounded p-2 hover:bg-yellow-600 active:bg-yellow-700 transition duration-150"/>
                <input type="reset" value="Clear" class="bg-gray-300 text-gray-700 rounded p-2 hover:bg-gray-400 active:bg-gray-500 transition duration-150"/>
            </div>
        </div>
    </fieldset>

    <fieldset class="border border-yellow-500 p-4 rounded">
        <legend class="text-xl text-yellow-600 font-semibold">Search Result :</legend>
        <?php  
        if($count<1) 
        {
            echo "<p class='text-red-500'>No Purchase Order Found.</p>";
        }
        else
        {
        ?>
            <table class="min-w-full bg-white border border-yellow-500 rounded">
                <thead class="bg-yellow-500 text-white">
                    <tr>
                        <th class="py-2 px-4 border">PurchaseOrder_ID</th>
                        <th class="py-2 px-4 border">Date</th>
                        <th class="py-2 px-4 border">Supplier Name</th>
                        <th class="py-2 px-4 border">Total Amount</th>
                        <th class="py-2 px-4 border">GrandTotal</th>
                        <th class="py-2 px-4 border">Status</th>
                        <th class="py-2 px-4 border">~</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    for ($i=0;$i<$count;$i++) 
                    { 
                        $row=mysqli_fetch_array($result);
                        $Purchase_ID=$row['purchase_id'];

                        echo "<tr class='hover:bg-yellow-100 transition duration-150'>";
                        echo "<td class='py-2 px-4 border'>$Purchase_ID</td>";
                        echo "<td class='py-2 px-4 border'>" . $row['purchase_date'] . "</td>";
                        echo "<td class='py-2 px-4 border'>" . $row['supplier_name'] . "</td>";
                        echo "<td class='py-2 px-4 border'>" . $row['purchase_amount'] . "</td>";
                        echo "<td class='py-2 px-4 border'>" . $row['purchase_total_amount'] . "</td>";
                        echo "<td class='py-2 px-4 border'>" . $row['purchase_status'] . "</td>";
                        echo "<td class='py-2 px-4 border'><a href='purchasedetail.php?purchase_id=$Purchase_ID' class='text-yellow-600 hover:underline'>Details</a></td>";
                        echo "</tr>";
                    }			
                    ?>
                </tbody>
            </table>
        <?php
        }
        ?>
    </fieldset>
</form>
    </div>

</body>
</html>
