<?php
// FILEPATH: /C:/xampp/htdocs/clgdbms/update_record.php

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the record ID from the form
    $recordId = $_POST['record_id'];

    // Get the updated values from the form
    $updatedValue1 = $_POST['updated_value1'];
    $updatedValue2 = $_POST['updated_value2'];
    // Add more variables for other fields if needed

    // Connect to the database
    $servername = "localhost";
    $username = "your_username";
    $password = "your_password";
    $dbname = "your_database_name";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the record in the database
    $sql = "UPDATE your_table_name SET field1='$updatedValue1', field2='$updatedValue2' WHERE id='$recordId'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Record</title>
</head>
<body>
    <h1>Update Record</h1>
    <form method="POST" action="">
        <label for="record_id">Record ID:</label>
        <input type="text" name="record_id" id="record_id" required><br><br>

        <label for="updated_value1">Updated Value 1:</label>
        <input type="text" name="updated_value1" id="updated_value1" required><br><br>

        <label for="updated_value2">Updated Value 2:</label>
        <input type="text" name="updated_value2" id="updated_value2" required><br><br>

        <!-- Add more input fields for other fields if needed -->

        <input type="submit" value="Update Record">
    </form>
</body>
</html>
