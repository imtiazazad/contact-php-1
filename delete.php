<?php
include('db_connection.php');

// Check if 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the message with the specified ID
    $deleteStmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
    $deleteStmt->bind_param("i", $id);

    if ($deleteStmt->execute()) {
        // Redirect to index.php after successful delete
        header("Location: index.php");
        exit();
    } else {
        $errorMessage = "Error deleting message.";
    }
} else {
    // Redirect to index.php if 'id' parameter is not provided
    header("Location: index.php");
    exit();
}
?>
