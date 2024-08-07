<?php
session_start();
include '../dbconnect.php';
include '../AutoIDFunction.php';
include 'purchaseFunction.php';

if (!isset($_SESSION['AID'])) { // Changed this line to check if the session is not set
    echo "<script>window.alert('Please login first')</script>";
    echo "<script>window.location='adminlogin.php'</script>";
    exit(); // Added exit to stop further execution if the user is not logged in
}

if (isset($_POST['btnSave'])) {
    $txtPurchaseID = $_POST['txtPurchaseID'];
    $txtPurchaseDate = $_POST['txtPurchaseDate'];
    $txtTotalAmount = $_POST['txtTotalAmount'];
    $cboSupplierID = $_POST['cboSupplierID'];
    $Status = "Pending";
    $txtTax = $_POST['txtTax'];
    $txtAllTotal = $_POST['txtAllTotal'];
    $StaffID = $_SESSION['AID'];
    $TotalQuantity = 0;

    $Query1 = "INSERT INTO `purchase_tb`
			(`purchase_id`, `purchase_date`, `purchase_amount`, `purchase_tax`, `purchase_total_amount`, `supplier_id`, `purchase_status`,`admin_id`)
			VALUES
			('$txtPurchaseID','$txtPurchaseDate','$txtTotalAmount','$txtTax','$txtAllTotal','$cboSupplierID','$Status','$StaffID')
			";
    $result = mysqli_query($db, $Query1);

    $size = count($_SESSION['PurchaseFunctions']);
    for ($i = 0; $i < $size; $i++) {
        $ProductID = $_SESSION['PurchaseFunctions'][$i]['book_id'];
        $PurchasePrice = $_SESSION['PurchaseFunctions'][$i]['unit_price'];
        $PurchaseQty = $_SESSION['PurchaseFunctions'][$i]['qty'];

        $Query2 = "INSERT INTO `purchasedetail_tb`
				(`purchase_id`, `book_id`, `qty`, `unit_price`)
				VALUES
				('$txtPurchaseID','$ProductID','$PurchaseQty','$PurchasePrice')
				";
        $result = mysqli_query($db, $Query2);

        // $update = "UPDATE book_tb
        //          set book_qty=book_qty+'$PurchaseQty'
        //          Where book_id='$ProductID'";
        // $updateret = mysqli_query($db, $update);


        if ($result) {
            echo "<script>window.alert('Purchase_Order Data are successfully saved')</script>";
            unset($_SESSION['PurchaseFunctions']);
            echo "<script>window.location='purchase.php'</script>";
        } else {
            echo "<p>Something wrong in Purchase Order :" . mysqli_error($db) . "</p>";
        }
    }
}

if (isset($_POST['btnAdd'])) {
    $ProductID = $_POST['cboProductID'];
    $PurchasePrice = $_POST['txtPurchasePrice'];
    $PurchaseQty = $_POST['txtPurchaseQty'];

    AddProduct($ProductID, $PurchasePrice, $PurchaseQty);
}

if (isset($_GET['Action'])) {
    $Action = $_GET['Action'];

    if ($Action === "Remove") {
        $ProductID = $_GET['book_id'];
        RemoveProduct($ProductID);
    } elseif ($Action === "ClearAll") {
        ClearAll();
    }
} else {
    $Action = "";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order</title>
    <script type="text/javascript" src="DatePicker/datepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="DatePicker/datepicker.css" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-5">

    <!-- Navigation -->
    <div class="w-32 h-screen fixed">
        <?php include 'navigation.php'; ?>
    </div>

    <!-- Form -->
    <div class="md:ml-64 ml-18 p-10 w-50 flex flex-col">
        <div class="bg-white border border-4 rounded-lg shadow relative m-10">
            <div class="flex items-start justify-between p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold">
                    Make Purchase Order Here!
                </h3>
            </div>
            <div class="p-6 space-y-6">
                <form action="purchase.php" method="post" class="grid grid-cols-1 gap-6">
                    <fieldset class="border border-yellow-300 p-4 rounded">
                        <legend class="text-xl text-slate-700 font-semibold">Purchase Info :</legend>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="text-yellow-800 block mb-2">Purchase_ID</label>
                                <input type="text" name="txtPurchaseID" value="<?php echo AutoID('purchase_tb', 'purchase_id', 'P-', 5) ?>" readonly class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" />
                            </div>
                            <div>
                                <label class="text-yellow-800 block mb-2">Purchase_Date</label>
                                <input type="text" name="txtPurchaseDate" value="<?php echo date('Y-m-d') ?>" onclick="showCalender(calender,this)" readonly class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" />
                            </div>
                            <div>
                                <label class="text-yellow-800 block mb-2">Admin Name</label>
                                <input type="text" name="txtStaffName" value="<?php echo $_SESSION['AN'] ?>" readonly class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" />
                            </div>
                            <div>
                                <label class="text-yellow-800 block mb-2">TotalAmount</label>
                                <input type="number" name="txtTotalAmount" value="<?php echo CalculateTotalAmount(); ?>" readonly class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" />
                            </div>
                            <div>
                                <label class="text-yellow-800 block mb-2">Tax</label>
                                <input type="number" name="txtTax" value="<?php echo  CalculateVAT(); ?>" readonly class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" />
                            </div>
                            <div>
                                <label class="text-yellow-800 block mb-2">All_Total</label>
                                <input type="number" name="txtAllTotal" value="<?php echo CalculateTotalAmount() + CalculateVAT();  ?>" readonly class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" />
                            </div>
                            <div>
                                <label class="text-yellow-800 block mb-2">BookID</label>
                                <select name="cboProductID" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5">
                                    <option>-Choose BookID-</option>
                                    <?php
                                    $query_pro = "SELECT * FROM book_tb";
                                    $ret_pro = mysqli_query($db, $query_pro);
                                    $count_pro = mysqli_num_rows($ret_pro);

                                    for ($i = 0; $i < $count_pro; $i++) {
                                        $row_pro = mysqli_fetch_array($ret_pro);
                                        $Product_ID = $row_pro['book_id'];
                                        $Product_Name = $row_pro['book_name'];

                                        echo "<option value='$Product_ID'>$Product_ID - $Product_Name</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div>
                                <label class="text-yellow-800 block mb-2">Purchase Price (MMK)</label>
                                <input type="number" name="txtPurchasePrice" value="0"  max="1000000" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" /> 
                            </div>
                            <div>
                                <label class="text-yellow-800 block mb-2">Purchase Quantity (Books)</label>
                                <input type="number" name="txtPurchaseQty" value="0" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 mb-3" />
                            </div>
                        </div>
                        <div class="flex space-x-4 mt-2">
                            <input type="submit" name="btnAdd" value="Add" class="bg-yellow-500 text-white rounded-lg py-3 px-5 text-md hover:bg-yellow-600 active:bg-yellow-700 transition duration-150" />
                            <a href="purchase.php?Action=ClearAll" class="bg-gray-300 text-gray-700 rounded-lg py-3 px-5 te
                            xt-md hover:bg-gray-400 active:bg-gray-500 transition duration-150">Clear All</a>
                        </div>


                    </fieldset>

                    <fieldset class="border border-yellow-300 p-4 rounded">
                        <legend class="text-xl text-slate-700 font-semibold">Purchase Records :</legend>
                        <?php
                        if (!isset($_SESSION['PurchaseFunctions'])) {
                            echo "<p class='text-red-500'>No Purchase Record Found.</p>";
                        } else {
                        ?>
                            <table class="min-w-full bg-white border border-yellow-500 rounded">
                                <thead class="bg-yellow-500 text-white">
                                    <tr>
                                        <th class="py-2 px-4 border">Image</th>
                                        <th class="py-2 px-4 border">ID</th>
                                        <th class="py-2 px-4 border">ProductModel</th>
                                        <th class="py-2 px-4 border">PurchasePrice <small>(MMK)</small></th>
                                        <th class="py-2 px-4 border">PurchaseQty <small>(pcs)</small></th>
                                        <th class="py-2 px-4 border">Sub-Total <small>(MMK)</small></th>
                                        <th class="py-2 px-4 border">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $size = count($_SESSION['PurchaseFunctions']);

                                    for ($i = 0; $i < $size; $i++) {
                                        $Image = $_SESSION['PurchaseFunctions'][$i]['book_img'];
                                        $ProductID = $_SESSION['PurchaseFunctions'][$i]['book_id'];
                                        $ProductModel = $_SESSION['PurchaseFunctions'][$i]['book_name'];
                                        $PurchasePrice = $_SESSION['PurchaseFunctions'][$i]['unit_price'];
                                        $PurchaseQty = $_SESSION['PurchaseFunctions'][$i]['qty'];
                                        $SubTotal = $_SESSION['PurchaseFunctions'][$i]['unit_price'] * $_SESSION['PurchaseFunctions'][$i]['qty'];

                                        echo "<tr class='hover:bg-yellow-100 transition duration-150'>";
                                        echo "<td class='py-2 px-4 border'><img src='$Image' width='100px' height='100px' class='rounded shadow'></td>";
                                        echo "<td class='py-2 px-4 border text-center'>$ProductID</td>";
                                        echo "<td class='py-2 px-4 border text-center'>$ProductModel</td>";
                                        echo "<td class='py-2 px-4 border text-center'>$PurchasePrice</td>";
                                        echo "<td class='py-2 px-4 border text-center'>$PurchaseQty</td>";
                                        echo "<td class='py-2 px-4 border text-center'>$SubTotal</td>";
                                        echo "<td class='py-2 px-4 border text-center'><a href='purchase.php?Action=Remove&book_id=$ProductID' class='text-red-500 hover:underline'>Remove</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                                <tr>
                                    <td colspan="6" class="text-right py-2 px-4 border">Supplier ID :</td>
                                    <td class="py-2 px-4 border">
                                        <select name="cboSupplierID" class="border border-yellow-500 rounded p-2 focus:outline-none focus:ring-2 focus:ring-yellow-600">
                                            <option>-Choose Supplier ID-</option>
                                            <?php
                                            $query_pro = "SELECT * FROM supplier_tb";
                                            $ret_pro = mysqli_query($db, $query_pro);
                                            $count_pro = mysqli_num_rows($ret_pro);

                                            for ($i = 0; $i < $count_pro; $i++) {
                                                $row_pro = mysqli_fetch_array($ret_pro);
                                                $Supplier_ID = $row_pro['supplier_id'];
                                                $Supplier_Name = $row_pro['supplier_name'];

                                                echo "<option value='$Supplier_ID'>$Supplier_ID - $Supplier_Name</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tfoot>
                                    <tr>
                                        <td class="py-2 px-4 border">
                                            <input type="submit" name="btnSave" value="Save" class="bg-yellow-500 text-white rounded p-2 hover:bg-yellow-600 active:bg-yellow-700 transition duration-150" />
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        <?php
                        }
                        ?>
                    </fieldset>

                </form>
            </div>

        </div>

</body>

</html>