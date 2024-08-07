<?php  
include '../dbconnect.php';

function AddShoppingCart($Product_ID,$BuyQty)
{
	include('../dbconnect.php');
	$query="SELECT * FROM book_tb WHERE book_id='$Product_ID'";
	$result=mysqli_query($db,$query);
	$count=mysqli_num_rows($result);

	if($count < 1) 
	{
		echo "<p>Product ID not found.</p>";
		exit();
	}
	$row=mysqli_fetch_array($result);
	$Product_Name=$row['book_name'];
	$Product_Amount=$row['price'];
	$Product_Image_1=$row['book_img'];

	if($BuyQty < 1) 
	{
		echo "<script>window.alert('Purchase Quantity Cannot be Zero (0)')</script>";
		echo "<script>window.location='Shopping_Cart.php'</script>";
		exit();
	}

	if(isset($_SESSION['ShoppingCartFunctions'])) 
	{
		$Index=IndexOf($Product_ID);
		
		if($Index == -1) 
		{
			$size=count($_SESSION['ShoppingCartFunctions']);

			$_SESSION['ShoppingCartFunctions'][$size]['book_id']=$Product_ID;
			$_SESSION['ShoppingCartFunctions'][$size]['book_name']=$Product_Name;
			$_SESSION['ShoppingCartFunctions'][$size]['price']=$Product_Amount;
			$_SESSION['ShoppingCartFunctions'][$size]['BuyQty']=$BuyQty;
			$_SESSION['ShoppingCartFunctions'][$size]['book_img']=$Product_Image_1;
		}
		else
		{
			$_SESSION['ShoppingCartFunctions'][$Index]['BuyQty']+=$BuyQty;
		}
	}
	else
	{
		$_SESSION['ShoppingCartFunctions']=array(); //Create Session Array

		$_SESSION['ShoppingCartFunctions'][0]['book_id']=$Product_ID;
		$_SESSION['ShoppingCartFunctions'][0]['book_name']=$Product_Name;
		$_SESSION['ShoppingCartFunctions'][0]['price']=$Product_Amount;
		$_SESSION['ShoppingCartFunctions'][0]['BuyQty']=$BuyQty;
		$_SESSION['ShoppingCartFunctions'][0]['book_img']=$Product_Image_1;
	}
	echo "<script>window.location='Shopping_Cart.php'</script>";
}

function RemoveShoppingCart($Product_ID)
{
	$Index=IndexOf($Product_ID);
	unset($_SESSION['ShoppingCartFunctions'][$Index]);
	$_SESSION['ShoppingCartFunctions']=array_values($_SESSION['ShoppingCartFunctions']);

	echo "<script>window.location='Shopping_Cart.php'</script>";
}

function ClearShoppingCart()
{	
	unset($_SESSION['ShoppingCartFunctions']);
	echo "<script>window.location='Shopping_Cart.php'</script>";
}

function CalculateTotalAmount()
{
	$TotalAmount=0;

	$size=count($_SESSION['ShoppingCartFunctions']);

	for($i=0;$i<$size;$i++) 
	{ 
		$Product_Amount=$_SESSION['ShoppingCartFunctions'][$i]['price'];
		$BuyQty=$_SESSION['ShoppingCartFunctions'][$i]['BuyQty'];
		$TotalAmount+=($Product_Amount * $BuyQty);
	}
	return $TotalAmount;
}

function CalculateVAT()
{
	$VAT=0;
	$VAT=CalculateTotalAmount() * 0.05;

	return $VAT;
}
function CalculateTotalQuantity()
{
	$TotalQuantity=0;
	$size=count($_SESSION['ShoppingCartFunctions']);

	for ($i=0; $i <$size ; $i++) 
	{ 
		$BuyQty=$_SESSION['ShoppingCartFunctions'][$i]['BuyQty'];
		$TotalQuantity+=$BuyQty;
	}
	return $TotalQuantity;
}

function IndexOf($Product_ID)
{
	if (!isset($_SESSION['ShoppingCartFunctions'])) 
	{
		return -1;
	}

	$size=count($_SESSION['ShoppingCartFunctions']);

	if ($size < 1) 
	{
		return -1;
	}

	for ($i=0;$i<$size;$i++) 
	{ 
		if($Product_ID == $_SESSION['ShoppingCartFunctions'][$i]['book_id']) 
		{
			return $i;
		}
	}
	return -1;
}

?>