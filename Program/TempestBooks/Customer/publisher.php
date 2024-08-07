<?php
session_start();
include '../dbconnect.php';

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Fetch categories for the dropdown
$publisherQuery = "SELECT * FROM publisher_tb";
$publisherResult = $db->query($publisherQuery);

// Check if a publisher is selected
$publisher = isset($_GET['publisher']) ? $_GET['publisher'] : '';

// Fetch data from the database
$sql = "SELECT * FROM book_tb b
        JOIN author_tb a ON b.Author_ID = a.Author_ID 
        JOIN publisher_tb p ON b.publisher_id = p.publisher_id 
        JOIN isbn_tb i ON b.isbn_id = i.isbn_id 
        JOIN category_tb c ON b.category_id = c.category_id";

if ($publisher) {
    $sql .= " WHERE b.publisher_id = '" . $db->real_escape_string($publisher) . "'";
}

$sql .= " LIMIT 12";
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
        <div class="flex justify-center">
            <form action="" method="GET" class="flex w-full max-w-2xl">
                <select name="publisher" class="w-2/3 py-3 px-4 rounded-l-full focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-black">
                    <option value="" disabled selected>Select a publisher...</option>
                    <?php
                    if ($publisherResult->num_rows > 0) {
                        while ($catRow = $publisherResult->fetch_assoc()) {
                            echo '<option value="' . $catRow['publisher_id'] . '">' . $catRow['publisher_name'] . '</option>';
                        }
                    }
                    ?>
                </select>
                <button type="submit" class="w-1/4 bg-yellow-400 hover:bg-yellow-500 text-white py-3 px-4 rounded-r-full focus:outline-none focus:ring-2 focus:ring-blue-500">Search</button>
            </form>
        </div>
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
                            <a href="bookdetail.php?book_id=<?php echo $row['book_id']; ?>" class="text-xl font-bold mb-2 text-gray-800"><?php echo $row['book_name']; ?></a>
                            <div class="text-sm text-gray-600 space-y-2">
                                <p><strong class="text-gray-800">Book Desc:</strong> <?php echo $row['book_desc']; ?></p>
                                <p><strong class="text-gray-800">Author:</strong> <?php echo $row['Author_Name']; ?></p>
                                <p><strong class="text-gray-800">Publisher:</strong> <?php echo $row['publisher_name']; ?></p>
                                <p><strong class="text-gray-800">ISBN:</strong> <?php echo $row['isbn_num']; ?></p>
                                <p><strong class="text-gray-800">Price:</strong> <?php echo $row['price']; ?></p>
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
