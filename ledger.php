<?php
  // session_start();
  // if( $_SESSION['username'] =="" ){
  //   echo "<meta http-equiv='refresh' content='0;URL=../login.php'/>"; //wait 3 sec
  // }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Employees System</title> 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<style>
    .ledger { 
      background: #7F7FD5;  /* fallback for old browsers */
      background: -webkit-linear-gradient(to bottom, #BFEFEF, #FFcfF4);  /* Chrome 10-25, Safari 5.1-6 */
      background: linear-gradient(to bottom, #F1EAE4, #FFF); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    }
    
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <h4 class="navbar-brand">Product System </h4>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
       <h5><a class="nav-link" href="./admin/main.php">Home</a></h5>
       <h5><a class="nav-link active" aria-current="page" href="#">General Ledger</a></h5>
       <h5><a class="nav-link" href="./report.php">Report</a></h5>
       <h5><a class="nav-link" href="../logout.php">Log out</a> </h5>
       <!-- <h5><a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a> -->
      </div>
    </div>
  </div>
</nav>

<div class="container">
  <h4>
    General Ledger
  </h4><br>
  <table class="table table-hover ledger">
    
    <thead>
      <th><h5>Revenues</h5></th>
      <th></th>
      <th></th>
    </thead>
    <thead>
      <tr>
        <th>Revenues</th>
        <th></th>
        <th>Name</th>
        <th></th>
        <th>Dr</th>
        <th>Cr</th>

      </tr>
    </thead>
    <tbody>
      <?php
        include("admin/config_fifo.php");
        $str_cost = " select p.p_name, pc.p_id,"
        ." pc.qty, pc.cost_per_unit,  "
        ." pc.qty*cost_per_unit cost"
        ." from product_cost pc "
        ." join product p on p.id = pc.p_id";
        
        //Cr
        $str_sale = " select p.p_name, ps.p_id,"
        ." ps.qty, ps.sale_per_unit,"
        ." ps.qty*sale_per_unit sale"
        ." from product_sale ps "
        ." join product p on p.id = ps.p_id";
        
        $cost_obj = mysqli_query($conn,$str_cost);
        $r_obj = mysqli_query($conn,$str_sale);
        //Revenues
        $e_sum = 0;
            while($row_expense = mysqli_fetch_array($cost_obj)){
              $e_sum += $row_expense['cost'];
                echo'<tr>'.
                  '<td> -Purchase of '.$row_expense['p_name'].'</td>'.
                  '<td> </td>'.
                  '<td> '.$row_expense['qty'].' x '.$row_expense['cost_per_unit'].'</td>'.
                  '<td> </td>'.
                  '<td> '.$row_expense['cost'].'</td>'.
                  '<td> </td>';
                echo '</tr>';
            }

            $r_sum =0;
            while($row_revenues = mysqli_fetch_array($r_obj)){
              $r_sum += $row_revenues['sale'];
                echo'<tr>'.
                  '<td> </td>'.
                  '<td> -Sales of '.$row_revenues['p_name'].'</td>'.
                  '<td> </td>'.
                  '<td> '.$row_revenues['qty'].' x '.$row_revenues['sale_per_unit'].'</td>'.
                  '<td> </td>'.
                  '<td> '.$row_revenues['sale'].'</td>';
                echo '</tr>';
            }
            echo '<h5>
                  <tr>
                  <td><h5>Total Expense</h5></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><h5>'.($e_sum).'</h5></td>
                  </tr>
                  </h5>    
                  ';
            if($r_sum-$e_sum>0){
              echo '<h5>
              <tr>
              <td><h5>Cash Received</h5></td>
                <td></td>
                <td></td>
                <td></td>
                <td><h5>'.($r_sum-$e_sum).'</h5></td>
              </tr>
              </h5>    
              ';
            }else{
              echo '<h5>
              <tr>
              <td><h5>Cash Payment</h5></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><h5>'.($e_sum-$r_sum).'</h5></td>
              </tr>
              </h5>    
              echo ';
            }

            echo '<h5>
                  <tr>
                  <td><h5>Total Revenues</h5></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><h5>'.($r_sum).'</h5></td>
                  </tr>
                  </h5>    
                  
      </tbody>
      </table>';
      ?>  
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
