<!DOCTYPE html>
<html lang="en">
<head>
  <title>Product System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
</head>
<body>

<div class="card text-center" style="padding:15px;">
<h4>PHP : Login</h4>
</div><br> 
<?php
        include("admin/config_fifo.php");       
?>

<div class="container">
  <form action="check.php" method="POST" >
    <div class="form-group">
      <label for="name">Username:</label>
      <input type="text" class="form-control" name="username" placeholder="Username" required="">
    </div>
    <div class="form-group">
      <label for="phone">Password :</label>
      <input type="text" class="form-control" name="password" placeholder="Password" required="">
    </div>

    <input type="submit" name="submit" class="btn btn-primary" style="float:right;" value="Submit">
  </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
