<?php
include('../dbconnect.php');

function fetch_book_details($db, $book_id)
{
    $query = $db->prepare("SELECT b.*, a.Author_Name, p.publisher_name, i.isbn_num, c.category 
                           FROM book_tb b 
                           JOIN author_tb a ON b.Author_ID = a.Author_ID 
                           JOIN publisher_tb p ON b.publisher_id = p.publisher_id 
                           JOIN isbn_tb i ON b.isbn_id = i.isbn_id 
                           JOIN category_tb c ON b.category_id = c.category_id 
                           WHERE b.book_id = ?");
    $query->bind_param('i', $book_id);
    $query->execute();
    return $query->get_result();
}

if (isset($_GET['BID'])) {
    $book_id = $_GET['BID'];
    $result = fetch_book_details($db, $book_id);

    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $book_id = $data['book_id'];
        $book_name = $data['book_name'];
        $book_qty = $data['book_qty'];
        $price = $data['price'];
        $book_desc = $data['book_desc'];
        $book_img = $data['book_img'];
        $author_name = $data['Author_Name'];
        $publisher_name = $data['publisher_name'];
        $isbn_num = $data['isbn_num'];
        $category = $data['category'];
    } else {
        echo "<script>window.alert('Book not found')</script>";
        echo "<script>window.location='AdminDashboard.php'</script>";
        exit();
    }
}

if (isset($_POST['btnupdate'])) {
    $book_id = $_POST['book_id'];
    $book_name = $_POST['book_name'];
    $book_qty = $_POST['book_qty'];
    $price = $_POST['price'];
    $book_desc = $_POST['book_desc'];

    $result = fetch_book_details($db, $book_id);
    $data = $result->fetch_assoc();
    $book_img = $data['book_img']; // default to existing image

    if (isset($_FILES['book_img']) && $_FILES['book_img']['error'] == UPLOAD_ERR_OK) {
        $book_img = $_FILES['book_img']['name'];
        $temp_name = $_FILES['book_img']['tmp_name'];
        move_uploaded_file($temp_name, "../Addimg/$book_img");
    }

    $author_name = $_POST['Author_Name'];
    $publisher_name = $_POST['cboPublisher'];
    $isbn_num = $_POST['cboISBN'];
    $category = $_POST['cboCategory'];

    // Fetch IDs based on names
    $author_query = $db->prepare("SELECT Author_ID FROM author_tb WHERE Author_Name = ?");
    $author_query->bind_param('s', $author_name);
    $author_query->execute();
    $author_result = $author_query->get_result();
    $author_id = $author_result->fetch_assoc()['Author_ID'];

    $publisher_query = $db->prepare("SELECT publisher_id FROM publisher_tb WHERE publisher_name = ?");
    $publisher_query->bind_param('s', $publisher_name);
    $publisher_query->execute();
    $publisher_result = $publisher_query->get_result();
    $publisher_id = $publisher_result->fetch_assoc()['publisher_id'];

    $isbn_query = $db->prepare("SELECT isbn_id FROM isbn_tb WHERE isbn_num = ?");
    $isbn_query->bind_param('s', $isbn_num);
    $isbn_query->execute();
    $isbn_result = $isbn_query->get_result();
    $isbn_id = $isbn_result->fetch_assoc()['isbn_id'];

    $category_query = $db->prepare("SELECT category_id FROM category_tb WHERE category = ?");
    $category_query->bind_param('s', $category);
    $category_query->execute();
    $category_result = $category_query->get_result();
    $category_id = $category_result->fetch_assoc()['category_id'];

    $update = $db->prepare("UPDATE book_tb 
                        SET book_name = ?, book_qty = ?, price = ?, book_desc = ?, book_img = ?, 
                            Author_ID = ?, publisher_id = ?, isbn_id = ?, category_id = ? 
                        WHERE book_id = ?");

    $update->bind_param(
        "sidsdsssss",
        $book_name,
        $book_qty,
        $price,
        $book_desc,
        $book_img,
        $author_id,
        $publisher_id,
        $isbn_id,
        $category_id,
        $book_id
    );

    if ($update->execute()) {
        echo "<script>window.alert('Update Success')</script>";
        echo "<script>window.location='AdminDashboard.php'</script>";
    } else {
        echo "<script>window.alert('Update Failed: " . $update->error . "')</script>";
        echo "<script>window.location='bookupdate.php?BID=$book_id'</script>";
    }

    $update->close(); // Close the prepared statement

}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Book Information</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="w-32 h-screen fixed">
        <?php include 'navigation.php'; ?>
    </div>

    <div class="ml-64 p-10 w-50 flex flex-col">
        <div class="bg-white border border-4 rounded-lg shadow relative m-10">
            <div class="flex items-start justify-between p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold">
                    Update Book Information
                </h3>
            </div>

            <div class="p-6 space-y-6">
                <form action="bookupdate.php" method="post" enctype="multipart/form-data">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="txtBookID" class="text-sm font-medium text-gray-900 block mb-2">Book ID</label>
                            <input type="text" name="book_id" id="txtBookID" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" value="<?php echo $book_id; ?>" readonly>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="txtBookName" class="text-sm font-medium text-gray-900 block mb-2">Book Name</label>
                            <input type="text" name="book_name" id="txtBookName" value="<?php echo $book_name; ?>" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" required>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="txtBookQty" class="text-sm font-medium text-gray-900 block mb-2">Book Quantity</label>
                            <input type="number" name="book_qty" id="txtBookQty" value="<?php echo $book_qty; ?>" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" min="1" max="50" required>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="txtBookPrice" class="text-sm font-medium text-gray-900 block mb-2">Book Price</label>
                            <input type="number" name="price" id="txtBookPrice" value="<?php echo $price; ?>" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" min="5000" max="1000000" required>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="txtBookDesc" class="text-sm font-medium text-gray-900 block mb-2">Book Description</label>
                            <textarea name="book_desc" id="txtBookDesc" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" required><?php echo $book_desc; ?></textarea>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="txtBookImg" class="text-sm font-medium text-gray-900 block mb-2">Book Image</label>
                            <input type="file" name="book_img" id="txtBookImg" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5">
                            <img src="../Addimg/<?php echo $book_img; ?>" width="100" height="150" class="mt-2">
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="selAuthor" class="text-sm font-medium text-gray-900 block mb-2">Choose Author</label>
                            <select name="Author_Name" id="selAuthor" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5">
                                <option value="<?php echo $author_name; ?>"><?php echo $author_name; ?></option>
                                <?php
                                $select_authors = "SELECT * FROM author_tb";
                                $result_authors = mysqli_query($db, $select_authors);
                                while ($row = mysqli_fetch_assoc($result_authors)) {
                                    echo "<option value='" . $row['Author_Name'] . "'>" . $row['Author_Name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="selPublisher" class="text-sm font-medium text-gray-900 block mb-2">Choose Publisher</label>
                            <select name="cboPublisher" id="selPublisher" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5">
                                <option value="<?php echo $publisher_name; ?>"><?php echo $publisher_name; ?></option>
                                <?php
                                $select_publishers = "SELECT * FROM publisher_tb";
                                $result_publishers = mysqli_query($db, $select_publishers);
                                while ($row = mysqli_fetch_assoc($result_publishers)) {
                                    echo "<option value='" . $row['publisher_name'] . "'>" . $row['publisher_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="selISBN" class="text-sm font-medium text-gray-900 block mb-2">Choose ISBN</label>
                            <select name="cboISBN" id="selISBN" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5">
                                <option value="<?php echo $isbn_num; ?>"><?php echo $isbn_num; ?></option>
                                <?php
                                $select_isbns = "SELECT * FROM isbn_tb";
                                $result_isbns = mysqli_query($db, $select_isbns);
                                while ($row = mysqli_fetch_assoc($result_isbns)) {
                                    echo "<option value='" . $row['isbn_num'] . "'>" . $row['isbn_num'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="selCategory" class="text-sm font-medium text-gray-900 block mb-2">Choose Category</label>
                            <select name="cboCategory" id="selCategory" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5">
                                <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                                <?php
                                $select_categories = "SELECT * FROM category_tb";
                                $result_categories = mysqli_query($db, $select_categories);
                                while ($row = mysqli_fetch_assoc($result_categories)) {
                                    echo "<option value='" . $row['category'] . "'>" . $row['category'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <input type="submit" name="btnupdate" value="Update" class="mt-4 bg-yellow-500 text-white p-2 rounded-lg hover:bg-yellow-600">
                </form>
            </div>
        </div>
    </div>
</body>

</html>