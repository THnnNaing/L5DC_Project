<?php
session_start();
include('../dbconnect.php');
include('../AutoIDFunction.php');

if (!isset($_SESSION['AID'])) { // Changed this line to check if the session is not set
    echo "<script>window.alert('Please login first')</script>";
    echo "<script>window.location='adminlogin.php'</script>";
    exit(); // Added exit to stop further execution if the user is not logged in
}

if (isset($_POST['btnConfirm'])) {
    $txtPurchaseID = $_POST['txtPurchaseID'];

    $query = mysqli_query($db, "SELECT * FROM orderdetail WHERE order_id='$txtPurchaseID'");

    while ($row = mysqli_fetch_array($query)) {
        $Product_ID = $row['book_id'];
        $Quantity = $row['BuyQty'];

        $UpdateQty = "UPDATE book_tb
                    SET book_qty= book_qty - '$Quantity'
                    WHERE book_id='$Product_ID'
                    ";
        $ret = mysqli_query($db, $UpdateQty);
    }

    $UpdateStatus = "UPDATE order_tb
                   SET order_status='Confirmed'
                   WHERE order_id='$txtPurchaseID'";
    $ret = mysqli_query($db, $UpdateStatus);

    if ($ret) { // True
        echo "<script>window.alert('SUCCESS : Order Successfully Confirmed.')</script>";
        echo "<script>window.location='orderlist.php'</script>";
    } else {
        echo "<p>Something went wrong in Purchase Details" . mysqli_error($db) . "</p>";
    }
}

if (isset($_GET['order_id'])) {
    $Order_id = $_GET['order_id'];

    $query1 = "SELECT o.*, c.customer_id, c.customer_name
            FROM order_tb o, customer_tb c
            WHERE o.customer_id=c.customer_id
            AND o.order_id='$Order_id'
            ";
    $result1 = mysqli_query($db, $query1);
    $row1 = mysqli_fetch_array($result1);

    $query = "SELECT admin_name FROM admin_tb";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_array($result);

    $query2 = "SELECT o.*, b.*, od.*
                FROM order_tb o, book_tb b, orderdetail od
                WHERE o.order_id=od.order_id
                AND b.book_id=od.book_id
                ";
    $result2 = mysqli_query($db, $query2);
    $count = mysqli_num_rows($result2);


} else {
    $PurchaseOrderID = "";

    echo "<script>window.alert('ERROR : Order Details not Found.')</script>";
    echo "<script>window.location='orderlist.php'</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-6">
    <form action="orderdetails.php" method="POST">
        <fieldset class="border border-yellow-300 p-4 rounded-md">
            <legend class="text-lg font-semibold text-slate-700">Order Detail Report for OID: <?php echo $Order_id ?></legend>
            <table class="min-w-full bg-white border-collapse mt-4">
                <tr>
                    <td class="border px-4 py-2">Order ID</td>
                    <td class="border px-4 py-2 font-bold"><?php echo $Order_id ?></td>
                    <td class="border px-4 py-2">Status</td>
                    <td class="border px-4 py-2 font-bold"><?php echo $row1['order_status'] ?></td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Order Date</td>
                    <td class="border px-4 py-2 font-bold"><?php echo $row1['order_date'] ?></td>
                    <td class="border px-4 py-2">Report Date</td>
                    <td class="border px-4 py-2 font-bold"><?php echo date('Y-m-d') ?></td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Customer Name</td>
                    <td class="border px-4 py-2 font-bold"><?php echo $row1['customer_name'] ?></td>
                    <td class="border px-4 py-2">Staff Name</td>
                    <td class="border px-4 py-2 font-bold"><?php echo $row['admin_name'] ?></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <table class="min-w-full bg-white border-collapse mt-4">
                            <tr class="bg-yellow-300">
                                <th class="border px-4 py-2">Book Name</th>
                                <th class="border px-4 py-2">Order_Price</th>
                                <th class="border px-4 py-2">Order_Quantity</th>
                                <th class="border px-4 py-2">Sub-Total</th>
                            </tr>
                            <?php
                            for ($i = 0; $i < $count; $i++) {
                                $row2 = mysqli_fetch_array($result2);
                                echo "<tr>";
                                echo "<td class='border px-4 py-2'>" . $row2['book_name'] . "</td>";
                                echo "<td class='border px-4 py-2'>" . $row2['Product_Price'] . "</td>";
                                echo "<td class='border px-4 py-2'>" . $row2['BuyQty'] . "</td>";
                                echo "<td class='border px-4 py-2'>" . ($row2['Product_Price'] * $row2['BuyQty']) . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right p-4">
                        Total Amount: <b><?php echo $row1['orderTotalAmount'] ?> MMK</b><br>
                        Tax Amount (VAT): <b><?php echo $row1['orderTax'] ?> MMK</b><br>
                        Grand Total: <b><?php echo $row1['orderAllTotal'] ?> MMK</b><br>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right p-4">
                        <input type="hidden" name="txtPurchaseID" value="<?php echo $row1['order_id'] ?>">
                        <?php
                        if ($row1['order_status'] === "Pending") {
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