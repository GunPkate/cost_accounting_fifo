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
      background: -webkit-linear-gradient(to bottom, #ffdd2c, #eed2da);  /* Chrome 10-25, Safari 5.1-6 */
      background: linear-gradient(to bottom, #ffdDac, #efefaa); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */      
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
       <h5><a class="nav-link" href="#">General Ledger</a></h5>
       <h5><a class="nav-link active" aria-current="page" href="#">Report</a></h5>
       <h5><a class="nav-link" href="../logout.php">Log out</a> </h5>
       <!-- <h5><a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a> -->
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
        <th></th>
        <th></th>
        <th class="text-right">Revenues</th>

      </tr>
    </thead>
    <tbody>
      <?php
        include("admin/config_fifo.php");
        $str_sale = " select p.p_name, ps.p_id, sum(ps.qty*sale_per_unit) sale  from product_sale ps "
        ." join product p on p.id = ps.p_id"
        ." group by p_id";
        $r_obj  = mysqli_query($conn,$str_sale);
        //page END
        
        //Revenues
        $r_sum = 0;
            while($row_revenues = mysqli_fetch_array($r_obj)){
              $r_sum += $row_revenues['sale'];
                echo'<tr>'.
                    '<td> -'.$row_revenues['p_name'].'</td>'.
                    '<td></td>'.
                    '<td></td>'.
                    '<td></td>'.
                    '<td class="text-right"> '.$row_revenues['sale'].'</td>'.
                    '<td></td>';
                echo '</tr>';
            }
            echo '<h5>
                  <tr>
                  <td><h5>Total Revenues</h5></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right"><h5>'.($r_sum).'</h5></td>
                    <td></td>
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

    $str_cost = " select p.id, p.p_name,"
    ." COALESCE(sum(pc.qty),0) buy,"
    ." pc.cost_per_unit as cost,"
    ." tc.totalcost as totalcost, "
    ." (tc.totalcost/sum(pc.qty)) wa_cost"
    ." from product p "
    ." join product_cost pc on p.id = pc.p_id "
    ." join (select pc.p_id,sum(pc.qty * pc.cost_per_unit ) as totalcost from product_cost pc group by p_id) tc on tc.p_id = pc.p_id"
    ." group by p.id";
    


        $obj_cogs  = mysqli_query($conn,$str_cost);
        $cogs_sum = 0;

            while($row_cogs = mysqli_fetch_array($obj_cogs)){
              $cogs_sum += $row_cogs['buy']*$row_cogs['cost'];
                echo'<tr>'.
                '<td> -'.$row_cogs['p_name'].'</td>'.
                    '<td></td>'.
                    '<td> -'.$row_cogs['wa_cost'].' x '.$row_cogs['buy'].' = '.'</td>'.
                    '<td class="text-right"> -'.$row_cogs['wa_cost']*$row_cogs['buy'].'</td>'.
                    '<td></td>';
                echo '</tr>';
            }
            echo '<h5>
                  <tr>
                  <td><h5> Cost of Goods sold</h5></td>
                  <td></td>
                  <td></td>
                  <td class="text-right"><h5> -'.($cogs_sum).'</h5></td>
                  <td></td>
                  </tr>
                  </h5>';

            echo '<h5>
                  <tr>
                    <td><h5>Total Gross Profit</h5></td>
                    <td></td>
                    <td></td>
                    <td class="text-right"><h5>'.($r_sum-$cogs_sum).'</h5></td>
                    <td></td>
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
