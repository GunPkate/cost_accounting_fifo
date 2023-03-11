<?php
    session_start();
    include("admin/config_fifo.php");       

    $username = mysqli_real_escape_string($conn,$_POST['username']); //get params
    $password = mysqli_real_escape_string($conn,$_POST['password']); //get params
    // $username = $_POST['username']; //get params
    // $password = $_POST['password']; //get params


    $str = "select * from admin where username = '$username' and password = '$password' ";

    $obj = mysqli_query($conn,$str);

    if($obj && mysqli_num_rows($obj)==1){
        $_SESSION['username'] = $username; 
        echo "Successfully login";
        echo "<meta http-equiv='refresh' content='3;URL=admin/main.php'/>"; //wait 3 sec
    }else{
        echo " login failed";
        echo "<meta http-equiv='refresh' content='3;URL=login.php'/>"; //wait 3 sec
    }
?>