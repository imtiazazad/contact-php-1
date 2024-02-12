<?php
include('db_connection.php');

// Check if the 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the message with the specified ID
    $stmt = $conn->prepare("SELECT * FROM messages WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a message is found
    if ($result->num_rows > 0) {
        $message = $result->fetch_assoc();
    } else {
        // Redirect to the index.php if the message is not found
        header("Location: index.php");
        exit();
    }
} else {
    // Redirect to the index.php if 'id' parameter is not provided
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Message</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>View Message</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $message['id'] ?></td>
                    <td><?= $message['name'] ?></td>
                    <td><?= $message['email'] ?></td>
                    <td><?= $message['message'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap JS scripts here -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
