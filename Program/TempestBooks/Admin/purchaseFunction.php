<?php 
include '../dbconnect.php';
	
function AddProduct($ProductID,$PurchasePrice,$PurchaseQty)
{
	$query="SELECT * FROM book_tb WHERE book_id='$ProductID'";
	$result=mysqli_query(mysqli_connect('localhost','root','','tempest_db'),$query);
	$count=mysqli_num_rows($result);

	if($count < 1) 
	{
		echo "<p>Product ID not found.</p>";
		exit();
	}
	$row=mysqli_fetch_array($result);
	$ProductModel=$row['book_name'];
	$Image=$row['book_img'];

	if($PurchaseQty < 1) 
	{
		echo "<script>window.alert('Purchase Quantity Cannot be Zero (0)')</script>";
		echo "<script>window.location='purchase.php'</script>";
		exit();
	}

	if(isset($_SESSION['PurchaseFunctions'])) 
	{
		$Index=IndexOf($ProductID);
		
		if($Index == -1) 
		{
			$size=count($_SESSION['PurchaseFunctions']);

			$_SESSION['PurchaseFunctions'][$size]['book_id']=$ProductID;
			$_SESSION['PurchaseFunctions'][$size]['book_name']=$ProductModel;
			$_SESSION['PurchaseFunctions'][$size]['unit_price']=$PurchasePrice;
			$_SESSION['PurchaseFunctions'][$size]['qty']=$PurchaseQty;
			$_SESSION['PurchaseFunctions'][$size]['book_img']=$Image;
		}
		else
		{
			$_SESSION['PurchaseFunctions'][$Index]['qty']+=$PurchaseQty;
		}
	}
	else
	{
		$_SESSION['PurchaseFunctions']=array(); //Create Session Array

		$_SESSION['PurchaseFunctions'][0]['book_id']=$ProductID;
		$_SESSION['PurchaseFunctions'][0]['book_name']=$ProductModel;
		$_SESSION['PurchaseFunctions'][0]['unit_price']=$PurchasePrice;
		$_SESSION['PurchaseFunctions'][0]['qty']=$PurchaseQty;
		$_SESSION['PurchaseFunctions'][0]['book_img']=$Image;
	}
	echo "<script>window.location='purchase.php'</script>";
}

function RemoveProduct($ProductID)
{
	$Index=IndexOf($ProductID);
	unset($_SESSION['PurchaseFunctions'][$Index]);
	$_SESSION['PurchaseFunctions']=array_values($_SESSION['PurchaseFunctions']);

	echo "<script>window.location='purchase.php'</script>";
}

function ClearAll()
{	
	unset($_SESSION['PurchaseFunctions']);
	echo "<script>window.location='purchase.php'</script>";
}

function CalculateTotalAmount()
{
	$TotalAmount=0;

	if(isset($_SESSION['PurchaseFunctions']))
	{
		$size=count($_SESSION['PurchaseFunctions']);

		for($i=0;$i<$size;$i++) 
		{ 
			$PurchasePrice=$_SESSION['PurchaseFunctions'][$i]['unit_price'];
			$PurchaseQty=$_SESSION['PurchaseFunctions'][$i]['qty'];
			$TotalAmount+=($PurchasePrice * $PurchaseQty);
		}
		return $TotalAmount;
	}

	else{
		echo"<script>window.alert('Error in Functions')</script>";
	}

	
}

function CalculateTotalQuantity()
{
	$TotalQuantity=0;
	$size=count($_SESSION['PurchaseFunctions']);

	for ($i=0; $i <$size ; $i++) 
	{ 
		$Purchase_Quantity=$_SESSION['PurchaseFunctions'][$i]['qty'];
		$TotalQuantity+=$Purchase_Quantity;
	}
	return $TotalQuantity;
}

function CalculateVAT()
{
	$VAT=0;
	$VAT=CalculateTotalAmount() * 0.05;

	return $VAT;
}

function IndexOf($ProductID)
{
	if (!isset($_SESSION['PurchaseFunctions'])) 
	{
		return -1;
	}

	$size=count($_SESSION['PurchaseFunctions']);

	if ($size < 1) 
	{
		return -1;
	}

	for ($i=0;$i<$size;$i++) 
	{ 
		if($ProductID == $_SESSION['PurchaseFunctions'][$i]['book_id']) 
		{
			return $i;
		}
	}
	return -1;
}

?>