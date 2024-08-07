

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search by ISBN</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <?php include 'customernavigation.php'; ?>
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-center mb-4">Search Books by ISBN</h1>
        <div class="max-w-md mx-auto bg-white p-6 rounded shadow-md">
            <form action="search_isbn.php" method="GET">
                <div class="mb-4">
                    <label for="isbn" class="block text-gray-700 font-bold mb-2">Enter ISBN:</label>
                    <input type="text" id="isbn" name="isbn" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-yellow-400" placeholder="Enter ISBN number..." required>
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-white py-2 px-4 rounded focus:outline-none focus:ring focus:ring-yellow-400">Search</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php

include '../dbconnect.php'; // Adjust the path to your database connection file

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Handle form submission
if (isset($_GET['isbn'])) {
    $isbn = $_GET['isbn'];

    // SQL query to retrieve book information based on exact ISBN number
    $isbn_query = "SELECT * FROM book_tb b
        JOIN author_tb a ON b.Author_ID = a.Author_ID 
        JOIN publisher_tb p ON b.publisher_id = p.publisher_id 
        JOIN isbn_tb i ON b.isbn_id = i.isbn_id 
        JOIN category_tb c ON b.category_id = c.category_id
        WHERE i.isbn_num = '$isbn'";

    $isbn_result = $db->query($isbn_query);

    if ($isbn_result->num_rows > 0) {
        // Fetching ISBN information
        $isbn_row = $isbn_result->fetch_assoc();

        // Display search result
        echo "<!DOCTYPE html>
              <html lang='en'>
              <head>
                  <meta charset='UTF-8'>
                  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                  <title>Search Results</title>
                  <link href='https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css' rel='stylesheet'>
                  <style>
                      .result-container {
                          display: flex;
                          justify-content: center;
                          flex-wrap: wrap;
                          gap: 1rem;
                      }
                      .result-card {
                          flex: 1 1 300px; /* Adjust the basis as per your requirement */
                          max-width: 300px; /* Adjust the width as per your requirement */
                      }
                  </style>
              </head>
              <body class='bg-gray-100'>
              <?php include 'customernavigation.php'; ?>
                  <div class='container mx-auto py-8'>
                      <h1 class='text-3xl font-bold text-center mb-4'>Search Results</h1>
                      <div class='max-w-4xl mx-auto'>
                          <div class='result-container'>";
        
        // Display searched ISBN book information horizontally
        echo "<div class='result-card bg-white p-6 rounded shadow-md'>
                  <img src='{$isbn_row['book_img']}' alt='Book Image' class='w-full h-48 object-cover mb-4'>
                  <a href='bookdetail.php?isbn={$isbn_row['isbn_num']}' class='text-xl font-bold text-gray-800'>{$isbn_row['book_name']}</a>
                  <p class='text-gray-600'>{$isbn_row['book_desc']}</p>
                  <div class='mt-4'>
                      <p><strong class='text-gray-800'>Author:</strong> {$isbn_row['Author_Name']}</p>
                      <p><strong class='text-gray-800'>Publisher:</strong> {$isbn_row['publisher_name']}</p>
                      <p><strong class='text-gray-800'>ISBN:</strong> {$isbn_row['isbn_num']}</p>
                      <p><strong class='text-gray-800'>Price:</strong> {$isbn_row['price']}</p>
                      <p><strong class='text-gray-800'>Category:</strong> {$isbn_row['category']}</p>
                      <p><strong class='text-gray-800'>Quantity:</strong> {$isbn_row['book_qty']}</p>
                      <form action='bookdetail.php' method='get'>
        <input type='hidden' name='book_id' value='{$isbn_row['book_id']}'>
        <button type='submit' class='bg-yellow-400 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded'>
            See More
        </button>
    </form>
                  </div>
              </div>";

        echo "</div>
              </div>
              </div>
              </body>
              </html>";
    } else {
        // No results found for the entered ISBN
        echo "<!DOCTYPE html>
              <html lang='en'>
              <head>
                  <meta charset='UTF-8'>
                  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                  <title>No Results</title>
                  <link href='https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css' rel='stylesheet'>
              </head>
              <body class='bg-gray-100'>
              <?php include 'customernavigation.php'; ?>
                  <div class='container mx-auto py-8'>
                      <h1 class='text-3xl font-bold text-center mb-4'>No Results Found</h1>
                      <div class='max-w-md mx-auto bg-white p-6 rounded shadow-md'>
                          <p>No books found with ISBN number: <strong>{$isbn}</strong></p>
                      </div>
                  </div>
              </body>
              </html>";
    }

    $db->close();
}
?>
