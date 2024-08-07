<?php
include('../dbconnect.php');
session_start(); // Start the session to use $_SESSION

if (!isset($_SESSION['AID'])) {
    echo "<script>window.open('customerlogin.php', '_self')</script>";
    exit(); // Exit to prevent further execution
} else {
    if (isset($_GET['IsID'])) {
        $delete_id = $_GET['IsID'];

        $delete_book = "DELETE FROM isbn_tb WHERE isbn_id='$delete_id'";
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
