<?php
$pname1 = $_POST['p_name'];
// $filename = $_FILES['fileUpload']['name'];
// $dstfile = "img/test1.jpg"; //don't change
// $id1 = $_POST['id'];

$edit_id = $_GET['edit'];
?>
<script>
  console.log(<?=$edit_id?>)
  console.log(<?=$pname1?>)
</script>

<?php
include("../config_fifo.php");
$str = "UPDATE product SET p_name='$pname1' where id = '$edit_id' " ;
// $str = "UPDATE product SET first_name='$pname1',last_name='$lname1',email='$email1' where id = '$id1' " ;
$obj = mysqli_query($conn,$str);
    if($obj) {
        echo "Record update successfully";
      //  header("Location:../main.php");
      echo "<meta http-equiv='refresh' content='3;URL=../main.php'/>"; //wait 3 sec
    } else
?>