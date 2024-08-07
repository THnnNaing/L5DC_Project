<?php
session_start();
include '../dbconnect.php';

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Initialize variables
$search = "";
$sql = "SELECT * FROM book_tb b
        JOIN author_tb a ON b.Author_ID = a.Author_ID 
        JOIN publisher_tb p ON b.publisher_id = p.publisher_id 
        JOIN isbn_tb i ON b.isbn_id = i.isbn_id 
        JOIN category_tb c ON b.category_id = c.category_id";

// Process search query if provided
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql .= " WHERE b.book_name LIKE '%$search%'"; // Modify query to include search condition
}

$sql .= " LIMIT 30"; // Limit results to 30 records

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
    <style>
        /* Additional custom styles */
        .search-input {
            background-color: #fff; /* Set background color for search input */
            color: #333; /* Set text color for search input */
        }
    </style>
</head>

<body class="bg-gray-100">
    <?php include 'customernavigation.php'; ?>

    <!-- Search Form -->
    <div class="bg-gray-800 text-white py-20">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">Welcome to our Book Store</h1>
            <p class="text-lg mb-8">Discover a wide range of books and enhance your reading experience.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET" class="mb-4 sm:flex items-center justify-center max-w-lg mx-auto">
                <input type="text" name="search" class="border p-3 rounded-l-lg sm:rounded-l-none sm:rounded-r-none sm:mr-2 w-full sm:w-2/3 search-input" placeholder="Search by book name" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="bg-yellow-400 text-white p-3 rounded-r-lg sm:rounded-l-none sm:rounded-r-lg sm:flex-shrink-0">Search</button>
            </form>
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
            <p class="text-center">No data found</p>
        <?php endif; ?>
        <?php $db->close(); ?>
    </div>

    <?php include 'footer.php'; ?>

</body>

</html>
