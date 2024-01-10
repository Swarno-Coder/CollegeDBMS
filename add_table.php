<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the table name from the form
    $tableName = $_POST["table_name"];

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

    // Create the SQL query to create a new table
    $sql = "CREATE TABLE $tableName (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        column1 VARCHAR(30) NOT NULL";

    // Get the additional columns and their types
    $columns = $_POST["column"];
    $types = $_POST["column_type"];

    // Add the additional columns to the SQL query
    for ($i = 0; $i < count($columns); $i++) {
        $column = $columns[$i];
        $type = $types[$i];
        $sql .= ", $column $type";
    }

    $sql .= ")";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Table created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Table</title>
</head>
<body>
    <h2>Add a New Table</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="table_name">Table Name:</label>
        <input type="text" name="table_name" id="table_name" required>
        <br><br>
        <label for="column">Column:</label>
        <input type="text" name="column[]" id="column" required>
        <label for="column_type">Type:</label>
        <input type="text" name="column_type[]" id="column_type" required>
        <br><br>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $columns = $_POST["column"];
            $types = $_POST["column_type"];
            for ($i = 0; $i < count($columns); $i++) {
                echo "<label for='column'>Column:</label>";
                echo "<input type='text' name='column[]' id='column' value='" . $columns[$i] . "' required>";
                echo "<label for='column_type'>Type:</label>";
                echo "<input type='text' name='column_type[]' id='column_type' value='" . $types[$i] . "' required>";
                echo "<br><br>";
            }
        }
        ?>
        <input type="submit" value="Create Table">
    </form>
</body>
</html>
