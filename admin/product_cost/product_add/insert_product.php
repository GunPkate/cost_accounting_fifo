<?php
  session_start();
  if( $_SESSION['username'] =="" ){
    echo "<meta http-equiv='refresh' content='0;URL=../../login.php'/>"; //wait 3 sec
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Product</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <h4 class="navbar-brand">Product System </h4>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
       <h5><a class="nav-link active" aria-current="page" href="../main.php">Home</a></h5>
       <h5><a class="nav-link" href="#">General Ledger</a></h5>
       <h5><a class="nav-link" href="../report.php">Report</a></h5>
       <h5><a class="nav-link" href="../logout.php">Log out</a> </h5>
       <h5><a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
      </div>
    </div>
  </div>
</nav>

<?php
  $stock_name = $_GET['stock_name'];        
  include("../../config_fifo.php");
?>

<div class="container mt-4">
  <form action="insert-p.php" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="address">Product: <?php echo $stock_name ?> </label>
      <input type="hidden" class="form-control" name="name" value="<?php echo $stock_name ?>" >
    </div>
    <div class="form-group">
      <label for="address">Cost Price:</label>
      <input type="number" class="form-control" name="cost" placeholder="Enter Cost" required="">
    </div>
    <div class="form-group">
      <label for="name">Stock:</label>
      <input type="text" class="form-control" name="qty" placeholder="Enter Stock" required="">
    </div>
    <div class="form-group">
      <label for="address">Date:</label>
      <input type="Date" class="form-control" name="date" placeholder="Enter Date" >
    </div>
    <input type="submit" name="submit" class="btn btn-primary" style="float:right;" value="Submit">
  </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
