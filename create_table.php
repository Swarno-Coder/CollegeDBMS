<?php
include "credentials.php";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $conncetion=mysqli_connect($server,$db_username,$db_password,$databasename,$port);
        if(!$conncetion){
            header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/error.html");
        }
        echo "<form action='' method='post'>
                No. of columns you want in this table?
                <input type='number' name='colno'>
                <input type='submit'>
            </form>";
        $tableName = $_POST['table_name'];
        $sql = "CREATE TABLE $tableName (";

        for ($i = 1; isset($_POST["col_name$i"]); $i++) {
            $columnName = $_POST["col_name$i"];
            $columnType = $_POST["typeof$i"];
            $isPrimaryKey = isset($_POST["is${i}pkey"]) && $_POST["is${i}pkey"] == 'on';
            $sql .= "$columnName $columnType";
            if ($isPrimaryKey) {
                $sql .= " PRIMARY KEY NOT NULL";
            }
            if (isset($_POST["col_name" . ($i + 1)])) {
                $sql .= ", ";
            }
        }
        $sql .= ");";
        echo $sql;
        try{
            $res=mysqli_query($conncetion,$sql);
            mysqli_close($conncetion);
            header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/index.html?message=success&msg=Table%20Created%20Successfully");
        }
        catch(Exception $e){
            header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/index.html?message=failed&err=".$e->getMessage());
        }
    }
?>