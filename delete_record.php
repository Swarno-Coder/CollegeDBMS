<?php
include "credentials.php";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["colname"]) && isset($_POST["colval"]) && isset($_GET["tablename"])) {
    $sql = "DELETE FROM ".$_GET["tablename"]." WHERE `".$_POST["colname"]."` = ".$_POST["colval"].";";
    try{$conn->query($sql);
        $conn->close();
        header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/main.php?message=success&msg=Record%20Deleted%20Successfully&tablename=".$_GET["tablename"]."");
    }
    catch(Exception $e){header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/main.php?message=failed&err=".$e->getMessage());}
}
?>
<form method='post' action='' style='width:100%; max-width:100%; margin-left:0; padding-left:0;'>
<label for="colname">Column Name (e.g ID):</label>
<input type="text" name="colname" id="colname">
<label for="colval">Value of that column:</label>
<input type="text" name="colval" id="colval">
<input type="submit" value="Submit" id="qrysubmit">
</form>
