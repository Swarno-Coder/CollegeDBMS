<?php
// FILEPATH: /c:/xampp/htdocs/clgdbms/delete_record.php

// Connect to the MySQL database
include "credentials.php";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch records from the database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["colname"]) && isset($_POST["colval"]) && isset($_GET["tablename"])) {
    $sql = "DELETE FROM ".$_GET["tablename"]." WHERE `".$_POST["colname"]."` = ".$_POST["colval"].";";
    $conn->query($sql);
}

// Close the database connection
$conn->close();
?>
<form method='post' action='' style='width:100%; max-width:100%; margin-left:0; padding-left:0;'>
<label for="colname">Column Name (e.g ID):</label>
<input type="text" name="colname" id="colname">
<label for="colval">Value of that column:</label>
<input type="text" name="colval" id="colval">
<input type="submit" value="Submit" id="qrysubmit">
</form>
