<?php
include "credentials.php";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (mysqli_connect_errno()) {die("Connection failed: " . mysqli_connect_error());}
$sql = "SELECT COLUMN_NAME
    FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
    WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = '".$_GET["tablename"]."' AND CONSTRAINT_NAME = 'PRIMARY';";
$result1 = mysqli_query($conn, $sql); // Store the result of the query
$primaryKeyColumn = $result1->fetch_assoc()['COLUMN_NAME'];
$sql = "SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, NUMERIC_PRECISION, NUMERIC_SCALE
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME = '".$_GET['tablename']."';";
$result = mysqli_query($conn, $sql); // Store the result of the query

if ($result) {
    echo "<h1>Update Record</h1>";
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
    <input type="submit" id="qrysubmit" name="updateqry"/>
    </form>';
} else {
    echo 'Error retrieving table content.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["updateqry"])) {
    
    $sql = "UPDATE ".$_GET["tablename"]." SET ";
    mysqli_data_seek($result, 0);
    $columns = array();
    while ($row = mysqli_fetch_assoc($result)){
        if (isset($_POST[$row["COLUMN_NAME"]]) && $_POST[$row["COLUMN_NAME"]] !== "" && $row["COLUMN_NAME"] === $primaryKeyColumn){
            $recordId = $_POST[$row["COLUMN_NAME"]];
        }
        elseif (isset($_POST[$row["COLUMN_NAME"]]) && $_POST[$row["COLUMN_NAME"]] !== ""){
            if (is_string($_POST[$row["COLUMN_NAME"]])) {
                $columns[] = '`'.$row["COLUMN_NAME"].'`="'. $_POST[$row["COLUMN_NAME"]] .'"'; 
            } elseif (is_numeric($_POST[$row["COLUMN_NAME"]])) {
                $columns[] = "`".$row["COLUMN_NAME"]."`=".$_POST[$row["COLUMN_NAME"]]; 
            }else{
                $columns[] = "`".$row["COLUMN_NAME"]."`=".$_POST[$row["COLUMN_NAME"]]; 
            }
        }
    }
    $sql .= implode(", ", $columns);
    $sql .= " WHERE `$primaryKeyColumn`=$recordId;";
    echo $sql;

    try{
        $res=mysqli_query($conn,$sql);
        mysqli_close($conn);
        header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/main.php?message=success&msg=Record%20Updated%20Successfully&tablename=".$_GET["tablename"]."");
    }
    catch(Exception $e){header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/main.php?message=failed&err=".$e->getMessage());}
}
?>