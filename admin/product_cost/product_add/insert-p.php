<?php
$pcost = $_POST['cost'];
$pqty = $_POST['qty'];
$pdate = date($_POST['date']);
$pname = $_POST['name'];

//echo $pname1."<br>".$lname1;
include("../../config_fifo.php");
// $p_id = "CAST(SELECT distinct * FROM product_cost pc join product p on p.id = pc.p_id where p.p_name like '%$pname%' AS int)";
$p_id = "(SELECT   pc.p_id FROM product_cost pc join product p on p.id = pc.p_id where p.p_name like '%".$pname."%' Limit 1)";
$str = "INSERT INTO product_cost (p_id,cost_per_unit,qty,"."date".") VALUES($p_id,$pcost,$pqty,'$pdate')";
echo $str."<br>";
$obj = mysqli_query($conn,$str);
    if($obj) {
        echo "Record add successfully";
        echo $pname;
        echo $pdate;
        echo "<meta http-equiv='refresh' content='3;URL=../../main.php'/>"; //wait 3 sec
      //  header("Location:select_stu.php");
     }
     else{
      echo "fail";
      echo $pname;
      echo $pdate;
    }
?>