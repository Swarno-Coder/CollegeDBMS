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
        if ($conn->query($sql) === TRUE) {
            echo "Table ".$_GET['tablename']." deleted successfully.";
        } else {
            echo "Error deleting table: " . $conn->error;
        }
    }
    // Close the database connection
    $conn->close();
    

    echo "<br><h2>Delete Table</h2>";
    echo "<form method='post' action='' style='width:100%; max-width:100%; margin-left:0; padding-left:0;'>
        <h2>Are you want to sure to delete? ".$_GET['tablename']."</h2>";
    echo '
            <input type="submit" name="YES" value="YES" id="qrysubmit" style="background-color:red; margin-top:0.5rem;">
            <input type="submit" name="NO" value="NO" id="qrysubmit">
        
    </form>';
?>
