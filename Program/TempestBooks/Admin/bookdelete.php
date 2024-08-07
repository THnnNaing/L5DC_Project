<?php
include('../dbconnect.php');
session_start(); // Start the session to use $_SESSION

if (!isset($_SESSION['AID'])) {
    echo "<script>window.open('customerlogin.php', '_self')</script>";
    exit(); // Exit to prevent further execution
} else {
    if (isset($_GET['BID'])) {
        $delete_id = $_GET['BID'];

        // Delete the dependent rows first
        $delete_purchase_details = "DELETE FROM purchasedetail_tb WHERE book_id='$delete_id'";
        $run_delete_purchase_details = mysqli_query($db, $delete_purchase_details);

        if ($run_delete_purchase_details) {
            // Now delete the book
            $delete_book = "DELETE FROM book_tb WHERE book_id='$delete_id'";
            $run_delete_book = mysqli_query($db, $delete_book);

            if ($run_delete_book) {
                echo "<script>alert('One Book Information Has Been Deleted');</script>";
                echo "<script>window.open('AdminDashboard.php?view_terms', '_self')</script>";
            } else {
                // Optional: Add error handling
                echo "<script>alert('Failed to delete the book.');</script>";
            }
        } else {
            // Optional: Add error handling
            echo "<script>alert('Failed to delete purchase details.');</script>";
        }
    }
}
?>
