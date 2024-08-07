<?php
session_start();
include '../dbconnect.php';

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
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


    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-4">Books</h1>
        <?php if ($result->num_rows > 0) : ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                        <img src="<?php echo $row['book_img']; ?>" alt="Book Image" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <a href="bookdetail.php" class="text-xl font-bold mb-2 text-gray-800"><?php echo $row['book_name']; ?></a>
                            <!-- <p class="text-gray-600 mb-4"><?php echo $row['book_desc']; ?></p> -->
                            <div class="text-sm text-gray-600 space-y-2">
                                <p><strong class="text-gray-800">Author:</strong> <?php echo $row['Author_Name']; ?></p>
                                <p><strong class="text-gray-800">Price:</strong> <?php echo $row['price']; ?></p>
                                <p><strong class="text-gray-800">Category:</strong> <?php echo $row['category']; ?></p>
                                <p><strong class="text-gray-800">Quantity:</strong> <?php echo $row['book_qty']; ?></p>

                                <form action="bookdetail.php" method="get">
                                    <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
                                    <button type="submit" class="bg-yellow-400 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                                        See More
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p>No data found</p>
        <?php endif; ?>
        <?php $db->close(); ?>
    </div>



    <?php include 'footer.php'; ?>

</body>

</html>