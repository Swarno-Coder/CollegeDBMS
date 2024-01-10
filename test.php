<?php 
include "credentials.php";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
}
$sql = "SELECT table_name FROM information_schema.tables WHERE table_schema = '$dbname';";
    $res = $conn->query($sql);
    
    while($row = $res->fetch_assoc()){
        #echo $row["table_name"];
        echo "<option value='".$row["table_name"]."'>".$row["table_name"]."</option>";
    }
?>