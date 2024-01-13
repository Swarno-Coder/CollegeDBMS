<?php
include "credentials.php";
$conn=mysqli_connect($servername,$username,$password,$dbname);
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "<form action='' method='post' style='width:100%; max-width:100%; margin-left:0; padding-left:0;'>
<label for='colno'>No. of columns you want in this table?</label>
<input type='number' name='colno'>
<input type='submit' id='qrysubmit' name='tnsubmit'>
        </form>";
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tnsubmit"])){
    $tno = $_POST["colno"];
    //echo "<form><table><tr><th>Name</th></tr><tr><td>Tua</td></tr></table></form>";
    echo "<form action='' method='post' style='width:100%; max-width:100%; margin-left:0; padding-left:0;'>
    <label for='newtable_name'>TableName</label>
    <input type='text' name='newtable_name'>";
    echo '<table style="border-collapse: collapse; width: 100%;">
    <tr>
        <th style="border: 1px solid black; padding: 8px;">Name</th>
        <th style="border: 1px solid black; padding: 8px;">Type</th>
        <th style="border: 1px solid black; padding: 8px;">Length</th>
        <th style="border: 1px solid black; padding: 8px;">Not Null</th>
        <th style="border: 1px solid black; padding: 8px;">Primary Key</th>
    </tr>';
    for ($i=1; $i<=$tno; $i++){
        echo "<tr>
        <td style='border: 1px solid black; padding: 8px;'><input type='text' name='col_name".$i."'/></td>
        <td style='border: 1px solid black; padding: 8px;'><input type='text' name='typeof".$i."'/></td>
        <td style='border: 1px solid black; padding: 8px;'><input type='number' name='length".$i."'/></td>
        <td style='border: 1px solid black; padding: 8px;'><input type='checkbox' name='is".$i."notnull'/></td>
        <td style='border: 1px solid black; padding: 8px;'><input type='checkbox' name='is".$i."pkey'/></td>
        </tr>";
    }
    echo '</table>
    <input type="submit" id="qrysubmit" name="tabsubmit">
    </form>';
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tabsubmit"])){
    $tName = $_POST['newtable_name'];
    $sql = "CREATE TABLE $tName (";
    for ($i = 1; isset($_POST["col_name$i"]); $i++) {
        $columnName = $_POST["col_name$i"];
        $columnType = $_POST["typeof$i"];
        $typeLength = $_POST["length$i"];
        $isNotNull = isset($_POST["is${i}notnull"]);
        $isPrimaryKey = isset($_POST["is${i}pkey"]);
        
        if ($columnType === 'varchar' || $columnType === 'char') {
            $sql .= "$columnName VARCHAR ($typeLength)";
        } else {
            $sql .= "$columnName $columnType";
        }

        if ($isPrimaryKey) {
            $sql .= " PRIMARY KEY NOT NULL";
        }
        if ($isNotNull && !$isPrimaryKey){
            $sql .= " NOT NULL";
        }

        if (isset($_POST["col_name" . ($i + 1)])) {
            $sql .= ", ";
        }
    }
    $sql .= ");";
    echo $sql;

    try{
        $res=mysqli_query($conn,$sql);
        mysqli_close($conn);
        header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/main.php?message=success&msg=Table%20Created%20Successfully&tablename=".$_GET["tablename"]."");
    }
    catch(Exception $e){
        header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/main.php?message=failed&err=".$e->getMessage());
    }
}
?>