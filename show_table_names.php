<?php
include "credentials.php";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
    $sql = "SELECT table_name FROM information_schema.tables WHERE table_schema = '$dbname';";
    $res = $conn->query($sql);

    echo "<form action='' method='get'>";
    echo "<select name='tablename' onchange='this.form.submit()'>"; // Add onchange event to submit the form automatically

    $selectedTable = isset($_GET['tablename']) ? $_GET['tablename'] : ''; // Get the selected tablename

    while ($row = $res->fetch_assoc()) {
        if ($row["table_name"] == $selectedTable) {
            echo "<option value='" . $row["table_name"] . "' selected>" . $row["table_name"] . "</option>"; // Show the selected tablename on top
        } else {
            echo "<option value='" . $row["table_name"] . "'>" . $row["table_name"] . "</option>"; // Show other options
        }
    }

    echo "</select>";
    echo "</form>";
    $tableName = isset($_GET['tablename']) ? $_GET['tablename'] : ''; // Get the selected tablename
} catch (Exception $e) {
    header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.html?message=failed&err=" . $e->getMessage());
}

$conn->close();
?>