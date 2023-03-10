<!DOCTYPE html>
<html lang="en">
<head>
  <title>Employees System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
</head>
<body>

<div class="card text-center" style="padding:15px;">
<h4>PHP : Edit Data</h4>
</div><br> 
<?php
include("../config_fifo.php");
        $edit_id = $_GET['edit'];

        $str = "select * from product where id ='$edit_id'";
        $obj = mysqli_query($conn,$str);
        $row = mysqli_fetch_array($obj);
        
?>

<div class="container mt-4">
  <form action="edit-p.php=< ?=$edit_id?>" method="POST" enctype="multipart/form-data"> <!--Send ID-->
    <div class="form-group">
      <label for="name">Product:</label>
      <input type="text" class="form-control" name="p_name" placeholder="Enter name" required="">
    </div>
    <input type="submit" name="submit" class="btn btn-primary" style="float:right;" value="Submit">
  </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
