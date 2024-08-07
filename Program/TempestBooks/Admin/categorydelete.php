<?php
include('../dbconnect.php');
session_start(); // Start the session to use $_SESSION

if (!isset($_SESSION['AID'])) {
    echo "<script>window.open('customerlogin.php', '_self')</script>";
    exit(); // Exit to prevent further execution
} else {
    if (isset($_GET['CTID'])) {
        $delete_id = $_GET['CTID'];

        $delete_book = "DELETE FROM category_tb WHERE category_id='$delete_id'";
        $run_book = mysqli_query($db, $delete_book);

        if ($run_book) {
            echo "<script>alert('One ISBN Information Has Been Deleted');</script>";
            echo "<script>window.open('AdminDashboard.php?view_terms', '_self')</script>";
        } else {
            // Optional: Add error handling
            echo "<script>alert('Failed to delete the book.');</script>";
        }
    }
}
?>
