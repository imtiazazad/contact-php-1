<?php
include('db_connection.php');

// Check if 'id' parameter is provided in the URL
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
        // Redirect to index.php if the message is not found
        header("Location: index.php");
        exit();
    }
} else {
    // Redirect to index.php if 'id' parameter is not provided
    header("Location: index.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newName = $_POST['name'];
    $newEmail = $_POST['email'];
    $newMessage = $_POST['message'];

    // Update the message in the database
    $updateStmt = $conn->prepare("UPDATE messages SET name = ?, email = ?, message = ? WHERE id = ?");
    $updateStmt->bind_param("sssi", $newName, $newEmail, $newMessage, $id);

    if ($updateStmt->execute()) {
        // Redirect to view.php after successful update
        header("Location: view.php?id=" . $id);
        exit();
    } else {
        $errorMessage = "Error updating message.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Message</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Message</h2>

        <?php if (isset($errorMessage)) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $errorMessage ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $message['name'] ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $message['email'] ?>" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="message" rows="4" required><?= $message['message'] ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="view.php?id=<?= $id ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <!-- Include Bootstrap JS scripts here -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
