<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COLLEGE DATABASE ACCESS PORTAL</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="main_wrapper">
    <a href="./logout.php" id="logout">Logout</a>
    <h3 class="title">COLLEGE DATABASE ACCESS PORTAL</h3>
    <div class="wrapper" >
        <form action="" method="get">
            <ol>
                <li class="items"><input name='create' type='submit' value="Create Table"/></li>
                <li class="items">
                    <?php include "show_table_names.php";?>
                </li>
                <li class="items"><input name='delete' type='submit' value="Delete Table"/></li>
                <li class="items"><input name='insert' type='submit' value="Insert Row"></li>
                <li class="items"><input name='delete_row' type='submit' value="Delete Row"></li>
                <li class="items"><input name='update' type='submit' value="Update Row"/></li>
                <li class="items"><input name='show' type='submit' value="Show Table"/></li>
            </ol>
        </form>
        <div class="content" >
            <?php
            if (isset($_GET['tablename']) && !isset($_GET['create'])){
                echo "<h1 class='tabselection'>Table Selected: ".$_GET["tablename"]."</h1>";
            }
            elseif(isset($_GET['create'])){}
            else{echo "<h1>No Table Selected Please select one from dropdown menu on the left.</h1>";}

            if(isset($_GET['message']) && $_GET['message'] == 'success'){
                echo "<p style='color:var(--success)'>".$_GET['msg']."</p>";
            }
            elseif(isset($_GET['message']) && $_GET['message'] == 'failed'){
                echo "<p style='color:var(--danger)'> error while executing the query ".$_GET['err']."</p>";
            }
            elseif(isset($_GET['create'])){
                echo "<h1 class='tabselection'>Create Table:";
                include "create_table.php";
            }
            elseif(isset($_GET['tablename']) && $_GET['tablename'] != '' && isset($_GET['delete'])){
              include "delete_table.php";
            }
            elseif(isset($_GET['tablename']) && $_GET['tablename'] != '' && isset($_GET['insert'])){
                include "insert_record.php";
            }
            elseif(isset($_GET['tablename']) && $_GET['tablename'] != '' && isset($_GET['update'])){
                include "update_record.php";
            }
            elseif(isset($_GET['tablename']) && $_GET['tablename'] != '' && isset($_GET['delete_row'])){
              include "delete_record.php";
            }
            elseif(isset($_GET['tablename']) && $_GET['tablename'] != '' && isset($_GET['show'])){
              include "show_table_content.php";
            }
            
            ?>
            
        </div>
    </div>
</div>
</body>
</html>