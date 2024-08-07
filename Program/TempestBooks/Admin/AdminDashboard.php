<?php
session_start();
include('../dbconnect.php');

if (!isset($_SESSION['AID'])) {
    echo "<script>window.alert('Please login first')</script>";
    echo "<script>window.location='adminlogin.php'</script>";
}

$AdminName = $_SESSION['AN'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Responsive Dashboard">
    <title>Responsive Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div x-data="{ sidebarOpen: false }" class="flex h-screen">
        <!-- Sidebar -->
        <?php include 'navigation.php'; ?>

        <!-- Main Content -->
        <div class="w-full overflow-y-auto overflow-y-auto ml-6">


            <!-- Book List -->

            <fieldset class="overflow-y-auto max-h-[240px] p-4 mt-4 border rounded-lg shadow-md">
                <legend class="text-lg font-bold mb-4">Book List</legend>

                <table class="min-w-full bg-white border-collapse border border-gray-200">

                    <tr class="bg-amber-300">
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">Book ID</th>
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">Book Name</th>
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">Book Quantity</th>
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">Price</th>
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">Book Description</th>
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">Author Name</th>
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">Publisher Name</th>
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">ISBN Code</th>
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">Category</th>
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">Actions</th>
                    </tr>


                    <?php
                    $select = "SELECT * FROM book_tb b, author_tb a, publisher_tb p, isbn_tb i, category_tb c
                                    WHERE b.Author_ID = a.Author_ID 
                                    AND b.publisher_id = p.publisher_id 
                                    AND b.isbn_id = i.isbn_id 
                                    AND b.category_id = c.category_id;";
                    $result = mysqli_query($db, $select);
                    $count = mysqli_num_rows($result);

                    while ($array = mysqli_fetch_assoc($result)) {
                        $book_id = $array['book_id'];
                        $book_name = $array['book_name'];
                        $book_qty = $array['book_qty'];
                        $price = $array['price'];
                        $book_desc = $array['book_desc'];
                        $Author_name = $array['Author_Name'];
                        $publisher_name = $array['publisher_name'];
                        $isbn_num = $array['isbn_num'];
                        $category = $array['category'];

                        echo "<tr>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>$book_id</td>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>$book_name</td>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>$book_qty</td>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>$price</td>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>$book_desc</td>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>$Author_name</td>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>$publisher_name</td>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>$isbn_num</td>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>$category</td>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>
                                <a href='bookupdate.php?BID=$book_id' class='text-blue-500 hover:underline'>Edit</a> |
                                <a href='bookdelete.php?BID=$book_id' onclick='return confirmDelete();' class='text-red-500 hover:underline'>Delete</a>
                            </td>";
                        echo "</tr>";
                    }
                    ?>

                </table>

            </fieldset>


            <!-- Author List -->
            <fieldset class="overflow-y-auto  max-h-[240px] p-4 mt-4 border rounded-lg shadow-md">
                <legend class="text-lg font-bold mb-4">Author List</legend>
                <table class="min-w-full bg-white border-collapse border border-gray-200">
                    <tr class="bg-amber-300">
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">Author ID</th>
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">Author Name</th>
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">Author Biography</th>
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">Actions</th>
                    </tr>
                    <?php
                    $select = "SELECT * FROM author_tb";
                    $result = mysqli_query($db, $select);
                    $count = mysqli_num_rows($result);

                    for ($i = 0; $i < $count; $i++) {
                        $array = mysqli_fetch_assoc($result);
                        $Author_ID = $array['Author_ID'];
                        $Author_Name = $array['Author_Name'];
                        $Authro_Bio = $array['Author_Bio'];

                        echo "<tr class=''>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>$Author_ID</td>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>$Author_Name</td>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>$Authro_Bio</td>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>
                            <a href='authorupdate.php?AuID=$Author_ID'  class='text-blue-500 hover:underline'>Edit</a> |
                            <a href='authordelete.php?AuID=$Author_ID'  onclick='return confirmDelete();' class='text-red-500 hover:underline'>Delete</a>
                        </td>";
                        echo "</tr>";
                    }
                    ?>
                </table>

            </fieldset>



            <!-- ISBN -->
            <fieldset class="overflow-y-auto  max-h-[240px] p-4 mt-4 border rounded-lg shadow-md">
                <legend class="text-lg font-bold mb-4">ISBN List</legend>
                <table class="min-w-full bg-white border-collapse border border-gray-200">
                    <tr class="bg-amber-300">
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">ISBN ID</th>
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">ISBN Num</th>
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">Actions</th>
                    </tr>
                    <?php
                    $select = "SELECT * FROM isbn_tb";
                    $result = mysqli_query($db, $select);
                    $count = mysqli_num_rows($result);

                    for ($i = 0; $i < $count; $i++) {
                        $array = mysqli_fetch_assoc($result);
                        $isbn_id = $array['isbn_id'];
                        $isbn_num = $array['isbn_num'];

                        echo "<tr class=''>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>$isbn_id</td>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>$isbn_num</td>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>
                            <a href='isbnupdate.php?IsID=$isbn_id'  class='text-blue-500 hover:underline'>Edit</a> |
                            <a href='isbndelete.php?IsID=$isbn_id'  onclick='return confirmDelete();' class='text-red-500 hover:underline'>Delete</a>
                        </td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </fieldset>



            <!-- Category List -->
            <fieldset class="overflow-y-auto  max-h-[240px] p-4 mt-4 border rounded-lg shadow-md">
                <legend class="text-lg font-bold mb-4">Category List</legend>
                <table class="min-w-full bg-white border-collapse border border-gray-200">
                    <tr class="bg-amber-300">
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">Category ID</th>
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">Category</th>
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">Actions</th>
                    </tr>
                    <?php
                    $select = "SELECT * FROM category_tb";
                    $result = mysqli_query($db, $select);
                    $count = mysqli_num_rows($result);

                    for ($i = 0; $i < $count; $i++) {
                        $array = mysqli_fetch_assoc($result);
                        $category_id = $array['category_id'];
                        $category = $array['category'];

                        echo "<tr class=''>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>$category_id</td>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>$category</td>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>
                            <a href='categoryupdate.php?CTID=$category_id'  class='text-blue-500 hover:underline'>Edit</a> |
                            <a href='categorydelete.php?CTID=$category_id'  onclick='return confirmDelete();' class='text-red-500 hover:underline'>Delete</a>
                        </td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </fieldset>



            <!-- Publisher -->
            <fieldset class="overflow-y-auto  max-h-[240px] p-4 mt-4 border rounded-lg shadow-md">
                <legend class="text-lg font-bold mb-4">Publlisher List</legend>
                <table class="min-w-full bg-white border-collapse border border-gray-200">
                    <tr class="bg-amber-300">
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">Publisher ID</th>
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">Publisher Name</th>
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">Publisher Description</th>
                        <th class="border border-gray-300 px-4 py-2 text-slate-700">Actions</th>
                    </tr>
                    <?php
                    $select = "SELECT * FROM publisher_tb";
                    $result = mysqli_query($db, $select);
                    $count = mysqli_num_rows($result);

                    for ($i = 0; $i < $count; $i++) {
                        $array = mysqli_fetch_assoc($result);
                        $publisher_id = $array['publisher_id'];
                        $publisher_name = $array['publisher_name'];
                        $publisher_desc = $array['publisher_desc'];

                        echo "<tr class=''>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>$publisher_id</td>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>$publisher_name</td>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>$publisher_desc</td>";
                        echo "<td class='border border-gray-300 px-4 py-2 hover:bg-yellow-100'>
                            <a href='publisherupdate.php?PUID=$publisher_id'  class='text-blue-500 hover:underline'>Edit</a> |
                            <a href='publisherdelete.php?PUID=$publisher_id'  onclick='return confirmDelete();' class='text-red-500 hover:underline'>Delete</a>
                        </td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </fieldset>

        </div>
    </div>
    <script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete?");
    }
</script>
</body>

</html>