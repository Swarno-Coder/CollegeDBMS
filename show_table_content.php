<?php
include "credentials.php";
$connection = mysqli_connect($servername, $username, $password, $dbname);
$query = "SELECT * FROM ".$_GET['tablename'].";";
$result = mysqli_query($connection, $query);

// Check if the query was successful
if ($result) {
    
    // Start the table
    echo '<table style="border-collapse: collapse; width: 100%;">';
    
    // Table header
    echo '<tr>';
    $fieldInfo = mysqli_fetch_fields($result);
    foreach ($fieldInfo as $field) {
        echo '<th style="border: 1px solid black; padding: 8px;">' . $field->name . '</th>';
    }
    echo '</tr>';
    
    // Table content
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        foreach ($row as $value) {
            echo '<td style="border: 1px solid black; padding: 8px;">' . $value . '</td>';
        }
        echo '</tr>';
    }
    
    // End the table
    echo '</table>';
} else {
    echo 'Error retrieving table content.';
}

// Close the database connection
mysqli_close($connection);
?>
