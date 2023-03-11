<?php
$psale = $_POST['sale'];
$pqty = $_POST['qty'];
$pdate = date($_POST['date']);
$pname = $_POST['name'];

//echo $pname1."<br>".$lname1;
include("../../config_fifo.php");
// $p_id = "CAST(SELECT distinct * FROM product_sale ps join product p on p.id = ps.p_id where p.p_name like '%$pname%' AS int)";
$p_id = "(SELECT   ps.p_id FROM product_sale ps join product p on p.id = ps.p_id where p.p_name like '%".$pname."%' Limit 1)";
$str = "INSERT INTO product_sale (p_id,sale_per_unit,qty,"."date".") VALUES($p_id,$psale,$pqty,'$pdate')";
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