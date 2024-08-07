<?php 
session_start();
include('init.php'); 
include('../dbconnect.php');
include('Shopping_Cart_Functions.php');

if (!isset($_SESSION['CID'])) {
    echo "<script>window.alert('Please login first')</script>";
    echo "<script>window.location='customerlogin.php'</script>";
    exit();
}

if(isset($_REQUEST['Action'])) 
{
    $Action=$_REQUEST['Action'];
    if($Action === "Remove")
    {
        $Product_ID=$_REQUEST['book_id'];
        RemoveShoppingCart($Product_ID);
    }
    elseif ($Action === "Buy")
    {
        $txtProductID=$_REQUEST['txtProductID'];
        $txtBuyQty=$_REQUEST['txtBuyQty'];
        AddShoppingCart($txtProductID,$txtBuyQty);
    }
    else
    {
        ClearShoppingCart();
    }
}
else
{
    $Action="";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<?php include 'customernavigation.php'; ?>

    <div class="container mx-auto p-4">
        <form action="Shopping_Cart.php" method="GET">
            <fieldset class="bg-white shadow-md rounded p-4">
                <legend class="text-2xl font-bold mb-4">Here is Your Shopping Bag:</legend>
                <?php
                if (!isset($_SESSION['ShoppingCartFunctions'])) 
                {
                    echo "<p class='text-gray-600'>Shopping Cart is Empty</p>";
                    echo "<a href='book.php' class='text-blue-500 hover:underline'>Continue Shopping</a>";
                }
                else
                {
                ?>
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">Image</th>
                            <th class="border px-4 py-2">BookID</th>
                            <th class="border px-4 py-2">BookName</th>
                            <th class="border px-4 py-2">Price</th>
                            <th class="border px-4 py-2">BuyQty</th>
                            <th class="border px-4 py-2">SubTotal</th>
                            <th class="border px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $size = count($_SESSION['ShoppingCartFunctions']);
                        for ($i = 0; $i < $size; $i++) 
                        { 
                            $Product_Image_1 = $_SESSION['ShoppingCartFunctions'][$i]['book_img'];
                            $Product_ID = $_SESSION['ShoppingCartFunctions'][$i]['book_id'];
                            $Product_Name = $_SESSION['ShoppingCartFunctions'][$i]['book_name'];
                            $Product_Amount = $_SESSION['ShoppingCartFunctions'][$i]['price'];
                            $BuyQty = $_SESSION['ShoppingCartFunctions'][$i]['BuyQty'];
                            $subTotal = $_SESSION['ShoppingCartFunctions'][$i]['price'] * $_SESSION['ShoppingCartFunctions'][$i]['BuyQty'];

                            echo "<tr>";
                            echo "<td class='border px-4 py-2'><img src='$Product_Image_1' width='100' height='100' class='object-cover'/></td>";
                            echo "<td class='border px-4 py-2'>$Product_ID</td>";
                            echo "<td class='border px-4 py-2'>$Product_Name</td>";
                            echo "<td class='border px-4 py-2'>$$Product_Amount</td>";
                            echo "<td class='border px-4 py-2'>$BuyQty</td>";
                            echo "<td class='border px-4 py-2'>$$subTotal</td>";
                            echo "<td class='border px-4 py-2'><a href='Shopping_Cart.php?Product_ID=$Product_ID&Action=Remove' class='text-red-500 hover:underline'>Remove</a></td>";
                            echo "</tr>";
                        }
                        ?>
                        <tr>
                            <td colspan="7" class="border px-4 py-2 text-right">
                                <div class="font-bold">Sub-Total: $<?php echo CalculateTotalAmount() ?></div>
                                <div class="font-bold">TAX (5%): $<?php echo CalculateVAT() ?></div>
                                <div class="font-bold">Grand Total: $<?php echo CalculateTotalAmount() + CalculateVAT() ?></div>
                                <hr class="my-2"/>
                                <div>
                                    <a href="Shopping_Cart.php?Action=ClearAll" class="text-red-500 hover:underline" onclick="return showConfirmation();">Clear Cart</a> |
                                    <a href="home.php" class="text-blue-500 hover:underline">Continue Shopping</a> |
                                    <a href="Checkout.php" class="text-green-500 hover:underline">Make Payment</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php 
                }
                ?>
            </fieldset>
        </form>
    </div>
    
    <?php include 'footer.php'; ?>

    <script>
        function showConfirmation() {
            return confirm("Confirm to delete?");
        }
    </script>
</body>
</html>
