<?php
include("../../config_fifo.php");

    $delete_id = $_GET['del']; //get params


    $str = "delete from product_cost where id = '$delete_id'";
    $obj = mysqli_query($conn,$str);

    if($obj){
        echo "Successfully deleted";
        echo "<meta http-equiv='refresh' content='3;URL=../../main.php'/>"; //wait 3 sec
    }else{
        echo " delete failed";
        echo "<meta http-equiv='refresh' content='3;URL=../../main.php'/>"; //wait 3 sec
    }
?>