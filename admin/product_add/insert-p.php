<?php
$pname1 = $_POST['p_name'];
$filename = $_FILES['fileUpload']['name'];
$dstfile = "img/test1.jpg"; //don't change

if($filename != ""){

  $filename = $_FILES['fileUpload']['name'];
  $srcfile = $_FILES['fileUpload']['tmp_name'];
  $filename = time().$filename;
  
  $dstfile = "../img/$filename";
  move_uploaded_file($srcfile,$dstfile);
  // if(move_uploaded_file($srcfile,$dstfile)){
  //     echo "Upload success";
  // }else{
  //     echo "Upload failed";
  // }
}else{
  $dstfile = "../img/test1.jpg";
}

//echo $pname1."<br>".$lname1;
include("../config_fifo.php");

$str = "INSERT INTO product (p_name,img) VALUES('$pname1','$dstfile')";
$obj = mysqli_query($conn,$str);
    if($obj) {
        echo "Record add successfully";
        echo "<meta http-equiv='refresh' content='3;URL=../main.php'/>"; //wait 3 sec
      //  header("Location:select_stu.php");
     }
     else{echo "$dstfile = '../img/test1.jpg'";}
?>