<?php
// FILEPATH: /C:/xampp/htdocs/clgdbms/show_records.php

// Connect to the database
include "./credential.php";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch records from the table
$sql = "SELECT * FROM ";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Show Records</title>
</head>
<body>
    <h1>Records</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>

        <?php
        // Display records in a table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No records found</td></tr>";
        }
        ?>

    </table>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
