<?php
session_start();
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];

    // Validate and sanitize the data (you can add your own validation rules here)

    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "college";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO your_table_name (name, email, phone) VALUES ('$name', '$email', '$phone')";

    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error inserting record: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
session_abort();
?>

<!DOCTYPE html>
<html>
<body>
    <h1>Choose a table</h1>

    <h1>Insert Record</h1>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" required><br><br>
        <input type="submit" value="Insert">
    </form>
</body>
</html>
