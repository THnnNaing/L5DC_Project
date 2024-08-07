<?php
session_start();
include '../dbconnect.php';

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if (isset($_GET['book_id'])) {
    $Product_ID = $_GET['book_id'];

    $query = "SELECT * FROM book_tb b, author_tb a, publisher_tb p, isbn_tb i, category_tb c
                                    WHERE b.book_id='$Product_ID'
                                    AND b.Author_ID = a.Author_ID 
                                    AND b.publisher_id = p.publisher_id 
                                    AND b.isbn_id = i.isbn_id 
                                    AND b.category_id = c.category_id
                                    ";
    $result = mysqli_query($db, $query);

    $row = mysqli_fetch_array($result);
    $Product_Name = $row['book_name'];
    $Product_Amount = $row['price'];
    $Product_Quantity = $row['book_qty'];
    $AN = $row['Author_Name'];
    $PN = $row['publisher_name'];
    $IN = $row['isbn_num'];
    $CN = $row['category'];
    $Product_Image_1 = $row['book_img'];
} else {
    echo "<script>Product Not Found</script>";
}

// Fetch data from the database
$sql = "SELECT * FROM book_tb b, author_tb a, publisher_tb p, isbn_tb i, category_tb c
                                    WHERE b.Author_ID = a.Author_ID 
                                    AND b.publisher_id = p.publisher_id 
                                    AND b.isbn_id = i.isbn_id 
                                    AND b.category_id = c.category_id Limit 12";
$result = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <?php include 'customernavigation.php'; ?>

    
    <div class="bg-gray-800 text-white py-20">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">Welcome to our Book Store</h1>
            <p class="text-lg mb-8">Discover a wide range of books and enhance your reading experience.</p>
        </div>
    </div>

    <div class="container mx-auto mt-8">
        <form action="Shopping_Cart.php" method="GET" enctype="multipart/form-data" class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
            <input type="hidden" name="Action" value="Buy">
            <fieldset>
                <legend class="text-2xl font-bold mb-4">Book Details: <?php echo $Product_Name ?></legend>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left side (photo) -->
                    <div class="flex items-center justify-center mb-4 md:mb-0">
                        <img src="<?php echo $Product_Image_1 ?>" class="w-full md:w-80 h-auto object-cover rounded-lg" alt="Book Cover">
                    </div>

                    <!-- Right side (information) -->
                    <div class="md:pl-6 space-y-4">
                        <div class="flex items-center">
                            <span class="block font-semibold">Book Name:</span>
                            <span class="ml-2 text-lg"><?php echo $Product_Name ?></span>
                        </div>
                        <div class="flex items-center">
                            <span class="block font-semibold">Author Name:</span>
                            <span class="ml-2"><?php echo $AN ?></span>
                        </div>
                        <div class="flex items-center">
                            <span class="block font-semibold">Publisher Name:</span>
                            <span class="ml-2"><?php echo $PN ?></span>
                        </div>
                        <div class="flex items-center">
                            <span class="block font-semibold">ISBN:</span>
                            <span class="ml-2"><?php echo $IN ?></span>
                        </div>
                        <div class="flex items-center">
                            <span class="block font-semibold">Category:</span>
                            <span class="ml-2"><?php echo $CN ?></span>
                        </div>
                        <div class="flex items-center">
                            <span class="block font-semibold">Each Price:</span>
                            <span class="ml-2"><?php echo $Product_Amount ?></span>
                        </div>
                        <div class="flex items-center">
                            <span class="block font-semibold">Stock Quantity:</span>
                            <span class="ml-2"><?php echo $Product_Quantity ?></span>
                        </div>
                        <div class="flex items-center">
                            <span class="block font-semibold">Buy Quantity:</span>
                            <input type="number" name="txtBuyQty" min="1" max="<?php echo $Product_Quantity ?>" class="ml-2 px-3 py-2 border rounded-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                        </div>
                        <div class="flex justify-end">
                            <input type="hidden" name="txtProductID" value="<?php echo $Product_ID ?>">
                            <input type="submit" name="Buy" value="Add to Cart" class="bg-yellow-400 hover:bg-yellow-500 text-white py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        </div>
                    </div>
                </div>

            </fieldset>
        </form>
    </div>

    <br>
    <?php include 'footer.php'; ?>

</body>

</html>
