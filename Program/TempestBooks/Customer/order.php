<?php

session_start();

include '../dbconnect.php';

include('Shopping_Cart_Functions.php');

include('../AutoIDFunction.php');


if (!isset($_SESSION['CID'])) {

    echo "<script>window.alert('Please Log in')</script>";

    echo "<script>window.location='customerlogin.php'</script>";
} else {

    $CusID = $_SESSION['CID'];

    $check = "SELECT * FROM customer_tb where customer_id='$CusID'";

    $query = mysqli_query($db, $check);

    $result = mysqli_fetch_array($query);
}

if (isset($_POST['btnConfirm'])) {
    $rdoDeliveryType = $_POST['rdoDeliveryType'];
    if ($rdoDeliveryType == 1) {
        $Address = $_POST['txtAddress'];
        $Phone = $_POST['txtPhone'];
    } else {
        $CID = $_SESSION['CustomerID'];
        $select = "SELECT * FROM Customer WHERE Customer_ID='$CID'";
        $query = mysqli_query($db, $select);
        $data = mysqli_fetch_array($query);

        $Address = $data['Address'];
        $Phone = $data['Phone'];
    }

    $Customer_ID = $_SESSION['Customer_ID'];
    $Status = "Pending";
    $txtOrderID = $_POST['txtOrderID'];
    $txtOrderDate = $_POST['txtOrderDate'];
    $txtTotalamount = $_POST['txtTotalamount'];
    $txtVAT = $_POST['txtVAT'];
    $txtGrandTotal = $_POST['txtGrandTotal'];
    $txtTotalQuantity = $_POST['txtTotalQuantity'];
    $txtRemark = $_POST['txtRemark'];
    $rdoPaymentType = $_POST['rdoPaymentType'];

    $Orderquery = "INSERT INTO order_tb
                    (order_id,order_date,orderTotalAmount,orderTax,orderAllTotal,orderTotalQuantity,remark,payment_type,order_location,order_phone,order_status,customer_id)
                    VALUES
                    ('$txtOrderID', '$txtOrderDate', '$txtTotalamount', '$txtVAT', '$txtGrandTotal', '$txtTotalQuantity', ' $txtRemark', '$rdoPaymentType', '$Address', '$Phone', '$Status','$Customer_ID')";
    $result = mysqli_query($db, $Orderquery);


    $size = count($_SESSION['ShoppingCartFunctions']);

    for ($i = 0; $i < $size; $i++) {
        $ProductID = $_SESSION['ShoppingCartFunctions'][$i]['Product_ID'];
        $BuyQty = $_SESSION['ShoppingCartFunctions'][$i]['BuyQty'];
        $Product_Amount = $_SESSION['ShoppingCartFunctions'][$i]['Product_Amount'];
    }

    $ODquery = "INSERT INTO order_detail
                (Order_ID, Product_ID, Product_Price, BuyQty)
                VALUES
                ('$txtOrderID',' $ProductID', '$Product_Amount', '$BuyQty')";
    $result = mysqli_query($db, $ODquery);


    $update = "UPDATE Product
                set Product_Quantity-'$txtTotalQuantity'
                WHERE Product_ID='$ProductID'";
    $updateret = mysqli_query($db, $update);


    if ($result) {
        unset($_SESSION['ShoppingCartFunctions']);
        echo "<script>window.alert('Checkojut Process Complete')</script>";
        echo "<script>window.location='customerlogin.php'</script>";
    } else {
        echo "<p>Something Went Wrong in CheckOut" . mysqli_error($db) . "</p>";
    }
}

?>

<!DOCTYPE html>

<html>

<head>

    <title></title>
    <script type="text/javascript">
        function showPaymentTable() {
            document.getElementById('PaymentTable').style.visibility = "visible";
        }

        function hidePaymentTable() {
            document.getElementById('PaymentTable').style.visibility = "hidden";
        }

        function showAddress() {
            document.getElementById('AddressTable').style.visibility = "visible";
        }

        function hideAddress() {
            document.getElementById('AddressTable').style.visibility = "hidden";
        }
    </script>
</head>

<body>

    <form action="order.php" method="POST">

        <fieldset>

            <legend>Customer Info</legend>

            <label>Customer ID</label>
            <p><?php echo $result['customer_id'] ?></p>

            <label>Customer Name</label>
            <p><?php echo $result['customer_name'] ?></p>

            <label>Customer Email</label>
            <p><?php echo $result['customer_email'] ?></p>

            <label>Customer Name</label>
            <p><?php echo $result['customer_name'] ?></p>

            <label>Customer Email</label>
            <p><?php echo $result['customer_email'] ?></p>


        </fieldset>

        <fieldset>

            <legend>Order Info</legend>

            <label>Order Code</label>
            <input type="text" name="txtordercode" value="<?php echo AutoID('order_tb', 'order_id', 'Ord-', 5) ?>" readonly />
            <label>Order Date</label>
            <input type="text" name="txtOrderDate" value="<?php echo date('Y-m-d') ?>" OnClick="showCalender(calender,this)" readonly />
            <input type="number" name="txtOrderTotalAmount" value="<?php echo CalculateTotalAmount(); ?>" readonly /> MMK
            <input type="number" name="txtOrderTax" value="<?php echo CalculateVAT() ?>" readonly /> MMK
            <input type="number" name="txtOrderAllTotal" value="<?php echo CalculateTotalAmount() + CalculateVAT() ?>" readonly /> MMK
            <input type="number" name="txtOrderTotalQuantity" value="<?php echo CalculateTotalQuantity() ?>" readonly />
            <input type="text" name="txtremark" placeholder="Enter your remark">

        </fieldset>

        <fieldset>

            <legend>(3) Payment Section</legend>

            <table>
                <tr>
                    <td>Payment Type<br />
                        <input type="radio" name="rdoPaymentType" value="MPU" onClick="showPaymentTable()" checked />MPU
                        <input type="radio" name="rdoPaymentType" value="VISA" onclick="showPaymentTable()" />VISA
                        <input type="radio" name="rdoPaymentType" value="COD" onclick="hidePaymentTable()" />Cash on Delivery
                    </td>
                </tr>
                <tr>
                    <td>
                        <table id="PaymentTable" name="PaymentTable">
                            <tr>
                                <td>
                                    Name <small>(as it appearson your card)</small><br />
                                    <input type="text" name="txtNameOnCard" placeholder="ex. Mg Mg" /><br />
                                    CardNumber <small>(no dashes or spaces)</small><br />
                                    <input type="text" name="txtNameOnCard" placeholder="1234567" /><br />
                                    Expiration Date <small>(no dashes or spaces)</small><br />

                                    <select name="cboMonth">
                                        <option>Month</option>
                                        <option>June</option>
                                        <option>November</option>
                                        <option>December</option>
                                    </select>

                                    <select name="cboYear">
                                        <option>Year</option>
                                        <option>2023</option>
                                        <option>2024</option>
                                        <option>2025</option>
                                    </select><br />

                                    Security Code <small>(3 on Back, Amex 4 on front)</small><br />

                                    <input type="number" name="txtsecuritycode" placeholder="ex. 123"><br />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </fieldset>


        <fieldset>
            <legend>(4) Order Delivery Details:</legend>
            <table>
                <tr>
                    <td>
                        Delivery Type<br />
                        <input type="radio" name="rdoDeliveryType" value="1" onclick="showAddress()" checked />Othders Address
                        <input type="radio" name="rdoDeliveryType" value="2" onclick="hideAddress()" />Same Address
                    </td>
                </tr>

                <tr>
                    <td>
                        <table id="AddressTable" name="AddressTable">
                            <tr>
                                <td>DeliveryPhone:<br />
                                    <input type="text" name="txtPhone" placeholder=""><br />DeliverAddress:<br />
                                    <textarea name="txtAddress"></textarea>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <hr />
                        <input type="submit" name="btnConfirm" value="Confirm Order" />
                        <a href="Product_Display.php">Continue Shopping</a>
                    </td>
                </tr>
            </table>
        </fieldset>

        <fieldset>
            <legend>(5)Orders Summary </legend>
            <?php

            if (!isset($_SESSION['ShoppingCartFunctions'])) {

                echo "<p>Shopping Cart is Empty</p>";

                echo "<a href='Product_Display.php'>Continue Shopping</a>";
            } else {

            ?>
                <table border="1">
                    <tr>
                        <th>Image</th>
                        <th>ProductID</th>
                        <th>ProductName</th>
                        <th>Price</th>
                        <th>BuyQty</th>
                        <th>SubTotal</th>
                        <th>Action</th>
                    </tr>

                    <?php

                    $size = count($_SESSION['ShoppingCartFunctions']);

                    for ($i = 0; $i < $size; $i++) {
                        $Product_Image_1 = $_SESSION['ShoppingCartFunctions'][$i]['AppImage1'];
                        $Product_ID = $_SESSION['ShoppingCartFunctions'][$i]['ApplianceCode'];
                        $Product_Name = $_SESSION['ShoppingCartFunctions'][$i]['ApplianceName'];
                        $Product_Amount = $_SESSION['ShoppingCartFunctions'][$i]['Price'];
                        $BuyQty = $_SESSION['ShoppingCartFunctions'][$i]['BuyQuantity'];
                        $subTotal = $Product_Amount * $BuyQty;

                        echo "<tr>";
                        echo "<td><img src='$Product_Image_1' width='100px' height='100px'/></td>";
                        echo "<td>$Product_ID</td>";
                        echo "<td>$Product_Name</td>";
                        echo "<td>$Product_Amount</td>";
                        echo "<td>$BuyQty</td>";
                        echo "<td>$subTotal</td>";
                        echo "<td><a href='Shopping_Cart.php?Product_ID=$Product_ID&Action=Remove'>Remove</a></td>";
                        echo "</tr>";
                    }
                    ?>

                    <tr>
                        <td colspan="7" align="right">
                            Sub-Total: <b><?php echo CalculateTotalAmount() ?></b></br>
                            VAT (5%): <b><?php echo CalculateVAT() ?></b></br>
                            Grand Total: <b><?php echo CalculateTotalAmount() + CalculateVAT() ?></b></br>
                            <hr />
                        </td>
                    </tr>
                </table>
            <?php
            }
            ?>
        </fieldset>

    </form>

</body>

</html>