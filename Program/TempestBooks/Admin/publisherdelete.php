<?php
include('../dbconnect.php');


if (!isset($_SESSION['AID'])) {

    echo "<script>window.open('login.php','_self')</script>";
} else {

?>

<?php

    if (isset($_GET['PUID'])) {

        $delete_id = $_GET['PUID'];

        $delete_book = "delete from publisher_tb where publisher_id='$delete_id'";

        $run_book = mysqli_query($con, $delete_book);

        if ($run_book) {

            echo "<script>alert(' One Book Information Has Been Deleted ')</script>";

            echo "<script>window.open('AdminDashboard.php?view_terms','_self')</script>";
        }
    }


?>


<?php } ?>