<?php
session_start();
include "credentials.php";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, NUMERIC_PRECISION, NUMERIC_SCALE
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME = '".$_GET['tablename']."';";
$result = mysqli_query($conn, $sql); // Store the result of the query

if ($result) {
    echo "<h1>Insert Record</h1>";
    echo "<form method='post' action='' style='width:100%; max-width:100%; margin-left:0; padding-left:0;'>";
    // Start the table
    echo '<table style="border-collapse: collapse; width: 100%;">';
    echo '<tr>
    <th style="border: 1px solid black; padding: 8px;">Name</th>
    <th style="border: 1px solid black; padding: 8px;">Type</th>
    <th style="border: 1px solid black; padding: 8px;">Length</th>
    <th style="border: 1px solid black; padding: 8px;">Value</th>
        </tr>';
    // Table content
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        foreach ($row as $value) {
            if ($value){
                echo '<td style="border: 1px solid black; padding: 8px;">' . $value . '</td>';
            }
        }
        echo "<td style='border: 1px solid black; padding: 8px;'><input type='text' name='".$row["COLUMN_NAME"]."'/></td>";
        echo '</tr>';
    }
    // End the table
    echo '</table>
    <input type="submit" id="qrysubmit" name="insertqry"/>
    </form>';
} else {
    echo 'Error retrieving table content.';
}

// Close the database connection
//mysqli_close($connection);
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["insertqry"])) {

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO ".$_GET["tablename"]." (";
    mysqli_data_seek($result, 0); // Reset the result pointer to the beginning
    $columns = array();
    while ($row = mysqli_fetch_assoc($result)){
        $columns[] = "`".$row["COLUMN_NAME"]."`";
    }
    $sql .= implode(", ", $columns);
    $sql .= ") VALUES (";
    mysqli_data_seek($result, 0); // Reset the result pointer to the beginning
    $values = array();
    while ($row = mysqli_fetch_assoc($result)){
        $value = $_POST[$row["COLUMN_NAME"]];
        $value = preg_replace_callback('/[a-zA-Z]/', function($matches) {
            return strtoupper($matches[0]);
        }, $value);
        $values[] = "'" . $value . "'";
    }
    $sql .= implode(", ", $values);
    $sql .= ");";
    try{
        $res=mysqli_query($conn,$sql);
        mysqli_close($conn);
        header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/main.php?message=success&msg=Record%20Inserted%20Successfully&tablename=".$_GET["tablename"]."");
    }
    catch(Exception $e){
        header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/main.php?message=failed&err=".$e->getMessage());
    }
}
?>