<?php
session_start();
include '../dbconnect.php';
include '../AutoIDFunction.php';

if (!isset($_SESSION['AID'])) {
    echo "<script>window.alert('Please login first')</script>";
    echo "<script>window.location='adminlogin.php'</script>";
    exit();
}

if (isset($_POST['btn'])) {
    $BID = $_POST['txtBookID'];
    $BName = mysqli_real_escape_string($db, $_POST['txtBookName']);
    $Bqty = $_POST['txtBookQty'];
    $Bprice = $_POST['txtBookPrice'];
    $Bdesc = mysqli_real_escape_string($db, $_POST['txtBookDesc']);
    $txtAuthor = $_POST['cboAuthor'];
    $txtPublisher = $_POST['cboPublisher'];
    $txtISBN = $_POST['cboISBN'];
    $txtCategory = $_POST['cboCategory'];

    // File upload handling
    $img = $_FILES['fileimg']['name'];
    $folder = "../Addimg/";
    $bookimage = $folder . uniqid() . "_" . $img;
    $copy = move_uploaded_file($_FILES['fileimg']['tmp_name'], $bookimage);
    if (!$copy) {
        echo "<script>window.alert('Cannot Upload Image')</script>";
        exit();
    }

    // Check if book already exists
    $checkmedia = "SELECT * FROM book_tb WHERE book_name='$BName'";
    $query = mysqli_query($db, $checkmedia);
    if (!$query) {
        echo "<script>window.alert('Database Error')</script>";
        exit();
    }
    $count = mysqli_num_rows($query);
    if ($count > 0) {
        echo "<script>window.alert('Book is Already Existed')</script>";
        echo "<script>window.location='books.php'</script>";
        exit();
    }

    // Insert new book record
    $insert = "INSERT INTO book_tb (book_id, book_name, book_qty, price, book_desc, book_img, Author_ID, publisher_id, isbn_id, category_id)
               VALUES ('$BID', '$BName', '$Bqty', '$Bprice', '$Bdesc', '$bookimage', '$txtAuthor', '$txtPublisher', '$txtISBN', '$txtCategory')";
    $query2 = mysqli_query($db, $insert);
    if ($query2) {
        echo "<script>window.alert('Upload Successful')</script>";
        echo "<script>window.location='books.php'</script>";
        exit();
    } else {
        echo "<script>window.alert('Upload Failed')</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book Information</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>

    <!-- Navigation -->
    <div class=" fixed inset-y-0 left-0 w-32 h-screen transform fixed transition-transform duration-300">
    <!-- <div class="w-32 h-screen fixed"> -->
    <?php include 'navigation.php'; ?>
    </div>

    <!-- Form -->
    <div class="md:ml-64 ml-18 p-10 w-50 flex flex-col">
    <div class="bg-white border border-4 rounded-lg shadow relative m-10">
        <div class="flex items-start justify-between p-5 border-b rounded-t">
            <h3 class="text-xl font-semibold">
                Add Book Information
            </h3>
        </div>

            <div class="p-6 space-y-6">
                <form action="books.php" method="post" enctype="multipart/form-data">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="txtBookID" class="text-sm font-medium text-gray-900 block mb-2">Book ID</label>
                            <input type="text" name="txtBookID" id="txtBookID" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" placeholder="Book ID" value="<?php echo AutoID('book_tb', 'book_id', 'BID-', 5) ?>" required readonly>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="txtBookName" class="text-sm font-medium text-gray-900 block mb-2">Book Name</label>
                            <input type="text" name="txtBookName" id="txtBookName" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" placeholder="Book Name" required>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="txtBookQty" class="text-sm font-medium text-gray-900 block mb-2">Book Quantity</label>
                            <input type="number" name="txtBookQty" id="txtBookQty" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" placeholder="Enter Book Quantity (1 to 50)" min="1" max="50" required>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="txtBookPrice" class="text-sm font-medium text-gray-900 block mb-2">Book Price</label>
                            <input type="number" name="txtBookPrice" id="txtBookPrice" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" placeholder="Enter Book Price (5000 to 10,000,000)" min="5000" max="1000000" required>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="txtBookDesc" class="text-sm font-medium text-gray-900 block mb-2">Book Description</label>
                            <input type="text" name="txtBookDesc" id="txtBookDesc" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" placeholder="Book Description" required>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="fileimg" class="text-sm font-medium text-gray-900 block mb-2">Book Image</label>
                            <input type="file" name="fileimg" id="fileimg" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" required>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="cboAuthor" class="text-sm font-medium text-gray-900 block mb-2">Choose Author Name</label>
                            <select name="cboAuthor" id="cboAuthor" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5">
                                <?php
                                $select = "SELECT * FROM author_tb";
                                $query = mysqli_query($db, $select);
                                $count = mysqli_num_rows($query);

                                for ($i = 0; $i < $count; $i++) {
                                    $fetch = mysqli_fetch_array($query);
                                    $AUID = $fetch['Author_ID'];
                                    $AUname = $fetch['Author_Name'];

                                    echo "<option value='$AUID'>$AUname</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="cboPublisher" class="text-sm font-medium text-gray-900 block mb-2">Choose Publisher Name</label>
                            <select name="cboPublisher" id="cboPublisher" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5">
                                <?php
                                $select = "SELECT * FROM publisher_tb";
                                $query = mysqli_query($db, $select);
                                $count = mysqli_num_rows($query);

                                for ($i = 0; $i < $count; $i++) {
                                    $fetch = mysqli_fetch_array($query);
                                    $PUid = $fetch['publisher_id'];
                                    $PUname = $fetch['publisher_name'];

                                    echo "<option value='$PUid'>$PUname</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="cboISBN" class="text-sm font-medium text-gray-900 block mb-2">Choose ISBN Code</label>
                            <select name="cboISBN" id="cboISBN" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5">
                                <?php
                                $select = "SELECT * FROM isbn_tb";
                                $query = mysqli_query($db, $select);
                                $count = mysqli_num_rows($query);

                                for ($i = 0; $i < $count; $i++) {
                                    $fetch = mysqli_fetch_array($query);
                                    $ISid = $fetch['isbn_id'];
                                    $ISnum = $fetch['isbn_num'];

                                    echo "<option value='$ISid'>$ISnum</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="cboCategory" class="text-sm font-medium text-gray-900 block mb-2">Choose Category</label>
                            <select name="cboCategory" id="cboCategory" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5">
                                <?php
                                $select = "SELECT * FROM category_tb";
                                $query = mysqli_query($db, $select);
                                $count = mysqli_num_rows($query);

                                for ($i = 0; $i < $count; $i++) {
                                    $fetch = mysqli_fetch_array($query);
                                    $CTid = $fetch['category_id'];
                                    $CTname = $fetch['category'];

                                    echo "<option value='$CTid'>$CTname</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-span-full">
                        <button type="submit" name="btn" class="mt-4 bg-yellow-500 text-white p-2 rounded-lg hover:bg-yellow-600">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


   
</body>

</html>