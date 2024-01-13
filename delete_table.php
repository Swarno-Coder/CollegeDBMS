    <?php
include "credentials.php";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["YES"])) {
        // Delete the table
        $sql = 'DROP TABLE '.$_GET["tablename"];
        try{
            $res=$conn->query($sql);
            $conn->close();
            header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/main.php?message=success&msg=Table%20".$_GET['tablename']."%20deleted%20successfully&tablename=".$_GET["tablename"]."");
        }
        catch(Exception $e){
            header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/main.php?message=failed&err=".$e->getMessage());
        }
    }
    echo "<br><h2>Delete Table</h2>";
    echo "<form method='post' action='' style='width:100%; max-width:100%; margin-left:0; padding-left:0;'>
        <h2>Are you want to sure to delete? ".$_GET['tablename']."</h2>";
    echo '
            <input type="submit" name="YES" value="YES" id="qrysubmit" style="background-color:red; margin-top:0.5rem;">
            <input type="submit" name="NO" value="NO" id="qrysubmit">
        
    </form>';
?>
