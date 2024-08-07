<?php
session_start();
include('../dbconnect.php');
include('Shopping_Cart_Functions.php');
include('../AutoIDFunction.php');

if (!isset($_SESSION['CID'])) {
    echo "<script>window.alert(Please Login First)</script>";
    echo "<script>window.location='Customer_Login.php'</script>";
    exit();
} else {
    $customer_ID = $_SESSION['CID'];
    $query = "SELECT * From customer_tb WHERE customer_id='$customer_ID'";
    $ret = mysqli_query($db, $query);
    $row = mysqli_fetch_array($ret);
}

if (isset($_POST['btnConfirm'])) {
    $rdoDeliveryType = $_POST['rdoDeliveryType'];
    if ($rdoDeliveryType == 1) {
        $Address = $_POST['txtAddress'];
        $Phone = $_POST['txtPhone'];
    } else {
        // $CID = $_SESSION['CID'];
        // $select = "SELECT * FROM customer_tb WHERE customer_id='$CID'";
        // $query = mysqli_query($db, $select);
        // $data = mysqli_fetch_array($query);

        $Address = $_POST['Address'];
        $Phone = $_POST['Phone'];
    }

    $Customer_ID = $_SESSION['CID'];
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
        $ProductID = $_SESSION['ShoppingCartFunctions'][$i]['book_id'];
        $BuyQty = $_SESSION['ShoppingCartFunctions'][$i]['BuyQty'];
        $Product_Amount = $_SESSION['ShoppingCartFunctions'][$i]['price'];


        $ODquery = "INSERT INTO orderdetail
                (order_id, book_id, Product_Price, BuyQty)
                VALUES
                ('$txtOrderID',' $ProductID', '$Product_Amount', '$BuyQty')";
        $result = mysqli_query($db, $ODquery);


        $update = "UPDATE book_tb
                set book_qty=book_qty-'$BuyQty'
                WHERE book_id='$ProductID'";
        $updateret = mysqli_query($db, $update);
    }
    if ($result) {
        unset($_SESSION['ShoppingCartFunctions']);
        echo "<script>window.alert('Checkout Process Complete')</script>";
        echo "<script>window.location='customerlogin.php'</script>";
    } else {
        echo "<p>Something Went Wrong in CheckOut" . mysqli_error($db) . "</p>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Form</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function showPaymentTable() {
            document.getElementById('PaymentTable').style.display = "block";
        }

        function hidePaymentTable() {
            document.getElementById('PaymentTable').style.display = "none";
        }

        function showAddress() {
            document.getElementById('AddressTable').style.visibility = "visible";
        }

        function hideAddress() {
            document.getElementById('AddressTable').style.visibility = "hidden";
        }
    </script>
</head>

<body class="bg-gray-100">

    <?php include 'customernavigation.php'; ?>

    <div class="max-w-4xl mx-auto bg-white p-8 mt-10 rounded-lg shadow-lg">
        <form action="Checkout.php" method="POST">

            <!-- Customer Personal Data -->
            <fieldset>
                <legend class="text-xl font-semibold mb-4 text-yellow-400">Customer Personal Data</legend>
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-900">Customer Phone Number</label>
                    <input type="text" name="Phone" id="phone" placeholder="Enter your phone number" class="appearance-none bg-gray-50 border border-gray-300 rounded-lg py-2 px-4 block w-full leading-tight 
                    focus:outline-none focus:bg-white focus:border-blue-500 text-gray-900 text-sm mt-2" required>
                </div>

                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-900">Customer Address</label>
                    <input type="text" name="Address" id="address" class="appearance-none bg-gray-50 border border-gray-300 rounded-lg py-2 px-4 block w-full leading-tight 
    focus:outline-none focus:bg-white focus:border-blue-500 text-gray-900 text-sm mt-2" placeholder="Enter your address" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-900">Customer Email</label>
                    <input type="email" name="Email" id="email" class="appearance-none bg-gray-50 border border-gray-300 rounded-lg py-2 px-4 block w-full leading-tight 
    focus:outline-none focus:bg-white focus:border-blue-500 text-gray-900 text-sm mt-2" value="<?php echo $row['customer_email']; ?>" readonly>
                </div>
            </fieldset>

            <!-- Order Information -->
            <fieldset class="mt-6">
                <legend class="text-xl font-semibold mb-4 text-yellow-400">Order Information</legend>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-900">Order Number</label>
                    <input type="text" name="txtOrderID" value="<?php echo AutoID('order_tb', 'order_id', 'ORD-', 5); ?>" class="bg-gray-100 border border-gray-300 rounded-lg py-2 px-4 block w-full text-gray-900 
    placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" readonly>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-900">Order Date</label>
                    <input type="text" name="txtOrderDate" value="<?php echo date('Y-m-d'); ?>" class="bg-gray-100 border border-gray-300 rounded-lg py-2 px-4 block w-full text-gray-900 
    placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" readonly>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-900 mb-2">Order Total Amount</label>
                    <div class="relative">
                        <input type="number" name="txtTotalamount" value="<?php echo CalculateTotalAmount(); ?>" class="bg-gray-100 border border-gray-300 rounded-lg py-2 px-4 w-full text-gray-900 placeholder-gray-400 
            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 pr-16" readonly>
                        <span class="absolute inset-y-0 right-4 flex items-center text-gray-700">MMK</span>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-900 mb-2">VAT (5%)</label>
                    <div class="relative">
                        <input type="number" name="txtVAT" value="<?php echo CalculateVAT(); ?>" class="bg-gray-100 border border-gray-300 rounded-lg py-2 px-4 w-full text-gray-900 placeholder-gray-400 
            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 pr-16" readonly>
                        <span class="absolute inset-y-0 right-4 flex items-center text-gray-700">MMK</span>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-900 mb-2">Grand Total</label>
                    <div class="relative">
                        <input type="number" name="txtGrandTotal" value="<?php echo CalculateTotalAmount() + CalculateVAT(); ?>" class="bg-gray-100 border border-gray-300 rounded-lg py-2 px-4 w-full text-gray-900 placeholder-gray-400 
            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 pr-16" readonly>
                        <span class="absolute inset-y-0 right-4 flex items-center text-gray-700">MMK</span>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-900 mb-2">Total Quantity</label>
                    <div class="relative">
                        <input type="number" name="txtTotalQuantity" value="<?php echo CalculateTotalQuantity(); ?>" class="bg-gray-100 border border-gray-300 rounded-lg py-2 px-4 w-full text-gray-900 placeholder-gray-400 
            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 pr-16" readonly>
                        <span class="absolute inset-y-0 right-4 flex items-center text-gray-700">Pcs</span>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-900 mb-2">Remark</label>
                    <div class="relative">
                        <input type="text" name="txtRemark" placeholder="Enter your remark" class="bg-gray-100 border border-gray-300 rounded-lg py-2 px-4 w-full text-gray-900 placeholder-gray-400 
            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>


                <!-- Payment Section -->
                <fieldset class="mt-6">
                    <legend class="text-xl font-semibold mb-4 text-yellow-400">Payment Section</legend>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-900">Payment Type</label><br />
                        <input type="radio" name="rdoPaymentType" value="MPU" onclick="showPaymentTable()" class="mr-2 text-yellow-600 focus:ring-yellow-500" checked /> MPU
                        <input type="radio" name="rdoPaymentType" value="VISA" onclick="showPaymentTable()" class="mr-2 text-yellow-600 focus:ring-yellow-500" /> VISA
                        <input type="radio" name="rdoPaymentType" value="COD" onclick="hidePaymentTable()" class="mr-2 text-yellow-600 focus:ring-yellow-500" /> Cash on Delivery
                    </div>

                    <div id="PaymentTable" class="hidden">
                        <div class="mb-4">
                            <label for="nameOnCard" class="block text-sm font-medium text-gray-900">Name (as it appears on your card)</label>
                            <input type="text" name="txtNameOnCard" id="nameOnCard" class="bg-gray-100 border border-gray-300 rounded-lg py-2 px-4 w-full text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500" placeholder="Ex. Mg Mg">
                        </div>

                        <div class="mb-4">
                            <label for="cardNumber" class="block text-sm font-medium text-gray-900">Card Number (no dashes or spaces)</label>
                            <input type="text" name="txtCardNumber" id="cardNumber" class="bg-gray-100 border border-gray-300 rounded-lg py-2 px-4 w-full text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500" placeholder="1234567">
                        </div>

                        <div class="mb-4 flex">
                            <div class="mr-2">
                                <label for="expirationMonth" class="block text-sm font-medium text-gray-900">Expiration Date</label>
                                <select name="cboMonth" id="expirationMonth" class="bg-gray-100 border border-gray-300 rounded-lg py-2 px-4 w-full text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500">
                                    <option>Month</option>
                                    <option>June</option>
                                    <option>November</option>
                                    <option>December</option>
                                </select>
                            </div>

                            <div class="mr-2">
                                <label for="expirationYear" class="block text-sm font-medium text-gray-900">&nbsp;</label>
                                <select name="cboYear" id="expirationYear" class="bg-gray-100 border border-gray-300 rounded-lg py-2 px-4 w-full text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500">
                                    <option>Year</option>
                                    <option>2023</option>
                                    <option>2024</option>
                                    <option>2025</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="securityCode" class="block text-sm font-medium text-gray-900">Security Code (3 on Back, Amex 4 on front)</label>
                            <input type="number" name="txtSecurityCode" id="securityCode" class="bg-gray-100 border border-gray-300 rounded-lg py-2 px-4 w-full text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500" placeholder="Ex. 123">
                        </div>
                    </div>
                </fieldset>

                <!-- Order Delivery Details -->
                <fieldset class="mt-6">
                    <legend class="text-xl font-semibold mb-4 text-yellow-400">Order Delivery Details</legend>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-900">Delivery Type</label><br />
                        <input type="radio" name="rdoDeliveryType" value="1" onclick="showAddress()" class="mr-2 text-gray-600 focus:ring-gray-500" checked /> Other's Address
                        <input type="radio" name="rdoDeliveryType" value="2" onclick="hideAddress()" class="mr-2 text-gray-600 focus:ring-gray-500" /> Same Address
                    </div>

                    <div id="AddressTable" class="mb-4">
                        <div>
                            <label for="deliveryPhone" class="block text-sm font-medium text-gray-900">Delivery Phone</label>
                            <input type="text" name="txtPhone" id="deliveryPhone" class="bg-gray-50 border border-gray-300 rounded-lg py-2 px-4 w-full text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500" placeholder="Enter delivery phone number">
                        </div>

                        <div class="mt-4">
                            <label for="deliveryAddress" class="block text-sm font-medium text-gray-900">Delivery Address</label>
                            <textarea name="txtAddress" id="deliveryAddress" class="bg-gray-100 border border-gray-300 rounded-lg py-2 px-4 w-full text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 h-20 resize-none" placeholder="Enter delivery address"></textarea>
                        </div>
                    </div>
                </fieldset>

                <!-- Orders Summary -->
                <fieldset class="mt-6">
                    <legend class="text-2xl font-bold mb-4 text-yellow-400">Orders Summary</legend>
                    <?php if (!isset($_SESSION['ShoppingCartFunctions'])) : ?>
                        <p class="mb-4">Shopping Cart is Empty</p>
                        <a href="Product_Display.php" class="text-gray-600">Continue Shopping</a>
                    <?php else : ?>
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 text-slate-600">Image</th>
                                    <th class="px-4 py-2 text-slate-600">Product ID</th>
                                    <th class="px-4 py-2 text-slate-600">Product Name</th>
                                    <th class="px-4 py-2 text-slate-600">Price</th>
                                    <th class="px-4 py-2 text-slate-600">Buy Qty</th>
                                    <th class="px-4 py-2 text-slate-600">SubTotal</th>
                                    <th class="px-4 py-2 text-slate-600">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION['ShoppingCartFunctions'] as $item) : ?>
                                    <tr>
                                        <td class="px-4 py-2"><img src="<?php echo $item['book_img']; ?>" class="w-16 h-16 object-cover"></td>
                                        <td class="px-4 py-2"><?php echo $item['book_id']; ?></td>
                                        <td class="px-4 py-2"><?php echo $item['book_name']; ?></td>
                                        <td class="px-4 py-2"><?php echo $item['price']; ?></td>
                                        <td class="px-4 py-2"><?php echo $item['BuyQty']; ?></td>
                                        <td class="px-4 py-2"><?php echo $item['price'] * $item['BuyQty']; ?></td>
                                        <td class="px-4 py-2"><a href="Shopping_Cart.php?Product_ID=<?php echo $item['book_id']; ?>&Action=Remove" class="text-red-500">Remove</a></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="bg-gray-100">
                                    <td colspan="7" class="px-4 py-2 text-right">
                                        Sub-Total: <b><?php echo CalculateTotalAmount(); ?></b><br>
                                        VAT (5%): <b><?php echo CalculateVAT(); ?></b><br>
                                        Grand Total: <b><?php echo CalculateTotalAmount() + CalculateVAT(); ?></b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </fieldset>

                <!-- Submit Button -->
                <div class="mt-6 flex justify-end">
                    <input type="submit" name="btnConfirm" value="Confirm Order" onclick="return showConfirmation();" class="bg-yellow-400 border border-yellow-300 hover:bg-slate-50 hover:border-yellow-200 hover:text-slate-500 text-white font-bold py-2 px-6 rounded cursor-pointer transition-all duration-300">
                    <a href="book.php" class="bg-slate-50 hover:bg-yellow-400 hover:text-white border border-yellow-200 text-gray-800 font-bold py-2 px-6 rounded ml-4 transition-all duration-300">Continue Shopping</a>
                </div>

        </form>


    </div>
    <?php include 'footer.php'; ?>


    <script>
        function showConfirmation() {
            return confirm("Confirm to make order?");
        }
    </script>

</body>


</html>