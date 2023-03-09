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
    .revenues { 
      background: #7F7FD5;  /* fallback for old browsers */
      background: -webkit-linear-gradient(to bottom, #91EAE4, #86BEE4);  /* Chrome 10-25, Safari 5.1-6 */
      background: linear-gradient(to bottom, #91EAE4, #86BEE7); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    }
    
    .cogs{
      background: #f9c823;  /* fallback for old browsers */
      background: -webkit-linear-gradient(to bottom, #f9bc2c, #ee821a);  /* Chrome 10-25, Safari 5.1-6 */
      background: linear-gradient(to bottom, #f9bc2c, #ee821a); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */      
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
       <h5><a class="nav-link active" aria-current="page" href="./admin/main.php">Home</a></h5>
       <h5><a class="nav-link" href="#">Features</a></h5>
       <h5><a class="nav-link" href="../report.php">Report</a></h5>
       <h5><a class="nav-link" href="../logout.php">Log out</a> </h5>
       <h5><a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
      </div>
    </div>
  </div>
</nav>

<div class="container">
  <h4>
    Profit or Loss
  </h4><br>
  <table class="table table-hover revenues">
    
    <thead>
      <th><h5>Revenues</h5></th>
      <th></th>
      <th></th>
    </thead>
    <thead>
      <tr>
        <th>Name</th>
        <th></th>
        <th>Revenues</th>

      </tr>
    </thead>
    <tbody>
      <?php
        include("admin/config_fifo.php");
        $str = "select p.id, p.p_name, ps.sale_per_unit as sale, ps.qty as ps_qty,"
        ." pc.cost_per_unit as cost, pc.qty as pc_qty"
        ."  from product p"
        ."  join product_cost pc on p.id = pc.p_id "
        ."  join product_sale ps on p.id = ps.p_id "
        ." group by p.id ";
        $r_obj  = mysqli_query($conn,$str);
        //page END
        
        //Revenues
        $r_sum = 0;
            while($row_revenues = mysqli_fetch_array($r_obj)){
              $r_sum += $row_revenues['ps_qty']*$row_revenues['sale'];
                echo'<tr>'.
                    '<td> -'.$row_revenues['p_name'].'</td>'.
                    '<td> '.$row_revenues['sale'].' x '.$row_revenues['ps_qty'].' = '.'</td>'.
                    '<td> '.$row_revenues['ps_qty']*$row_revenues['sale'].'</td>';
                echo '</tr>';
            }
            echo '<h5>
                  <tr>
                  <td><h5>Total Revenues</h5></td>
                    <td></td>
                    <td><h5>'.($r_sum).'</h5></td>
                  </tr>
                  </h5>    
      </tbody>
      </table>';
    
    echo '
    <table class="table table-hover cogs">
    <thead>
      <th><h5>Cost of Goods Sold</h5></th>
      <th></th>
      <th></th>
    </thead>
    <thead>
      <tr>
        <th>Name</th>
        <th></th>
        <th>Cost of Goods Sold</th>

      </tr>
    </thead>
    <tbody>
    ';

        $obj_cogs  = mysqli_query($conn,$str);
        $cogs_sum = 0;

            while($row_cogs = mysqli_fetch_array($obj_cogs)){
              $cogs_sum += $row_cogs['pc_qty']*$row_cogs['cost'];
                echo'<tr>'.
                    '<td> -'.$row_cogs['p_name'].'</td>'.
                    '<td> -'.$row_cogs['cost'].' x '.$row_cogs['pc_qty'].' = '.'</td>'.
                    '<td> -'.$row_cogs['pc_qty']*$row_cogs['cost'].'</td>';
                echo '</tr>';
            }
            echo '<h5>
                  <tr>
                  <td><h5>Total Cost of Goods sold</h5></td>
                    <td></td>
                    <td><h5> -'.($cogs_sum).'</h5></td>
                  </tr>
                  </h5>';

            echo '<h5>
                  <tr>
                    <td><h5>Total Gross Profit</h5></td>
                    <td></td>
                    <td><h5>'.($r_sum-$cogs_sum).'</h5></td>
                  </tr>
                  </h5>'; 
        ?>

    </tbody>
  </table>
  
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
