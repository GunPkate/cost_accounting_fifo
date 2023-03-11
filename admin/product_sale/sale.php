<?php
  // session_start();
  // if( $_SESSION['username'] =="" ){
  //   echo "<meta http-equiv='refresh' content='0;URL=../login.php'/>"; //wait 3 sec
  // }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Product System</title> 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
       <h5><a class="nav-link" href="../main.php">Home</a></h5>
       <h5><a class="nav-link" href="../../ledger.php">General Ledger</a></h5>
       <h5><a class="nav-link" href="../../report.php">Report</a></h5>
       <h5><a class="nav-link" href="../../logout.php">Log out</a> </h5>
       <!-- <h5><a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a> -->
      </div>
    </div>
  </div>
</nav>

<?php
  $stock_name = $_GET['stock_name'];         
  $strKeyword = null;
  if(isset($_POST['txt'])){
    $strKeyword = $_POST['txt'];
  }
?>

<div class="container mt-4">
  <h4>
    <!-- <form name="frmSearch" method="POST">
      <input name="txt" type="text" value="< ?=$strKeyword?>"/>
      <input type="submit"/>
    </form> -->
    <a href="./product_add/insert_product.php?stock_name=<?php echo $stock_name ?>" class="btn btn-primary" style="float:right;">Sell</a>
    </h4><br>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Sale Per Unit</th>
        <th>Stock</th>
        <th>Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php

include("../config_fifo.php");

//No left No value for new product
$str = "select p.id, p.p_name, ps.id as ps_id,ps.sale_per_unit as price, ps.qty as stock , ps.date as date from product p"
." join product_sale ps on p.id = ps.p_id "
." where p_name like '%$stock_name%'  ";
// ."  where date like '%$strKeyword%'  ";
// ."  order by pc.date desc" ;


$obj = mysqli_query($conn,$str);

$Num_Rows = mysqli_num_rows($obj);

$Per_Page = 5;   // Per Page

$Page = isset($_GET["Page"]) ? $_GET['Page'] : '';
if($Page == ''){ $Page=1; }

$Prev_Page = $Page-1;
$Next_Page = $Page+1;

$Page_Start = (($Per_Page*$Page)-$Per_Page);
if($Num_Rows<=$Per_Page)
{ 
  $Num_Pages =1;
}
else if(($Num_Rows % $Per_Page)==0)
{
  $Num_Pages =($Num_Rows/$Per_Page) ;
}
else
{
  $Num_Pages =($Num_Rows/$Per_Page)+1;
  $Num_Pages = (int)$Num_Pages;
}


$str .=" order by id ASC LIMIT $Page_Start , $Per_Page";
$obj  = mysqli_query($conn,$str);
//page END

    $ya = 0;
    while($row = mysqli_fetch_array($obj)){
        $ya++;
        $cost_wa = 0;

          echo
          '<tr>'.
          '<td>'.$row['ps_id'].'</td>'.
          '<td>'.$row['p_name'].'</td>'.
          '<td>'.$row['price'].'</td>'.
          '<td>'.$row['stock'].'</td>'.
          '<td>'.$row['date'].'</td>';
?>
                    <td>
                        <!-- <a href="./product_add/edit_product.php?edit=<?php echo $row['id']?>" style="color:green"> 
                        <i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp -->
                        <a href="./product_add/delete_product.php?del=<?php echo $row['ps_id']?>" style="color:red" onclick="return confirm('Are you sure want to delete this record <?= $row['ps_id']?>')">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                    </td>

<?php
        echo '</tr>';
        // echo "<br>";
    }
?>

  <!-- ส่วนของโค้ตในการแสดงเลขหน้า -->
	<br>
	Total <?php echo $Num_Rows;?> Record : <?php echo $Num_Pages;?> Page :
	<?php

     $pp = isset($_GET['txtKeyword'])? $_GET['txtKeyword']:'';

	if($Prev_Page)
	{
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&txtKeyword=$pp'><< Back</a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&txtKeyword=$pp'>$i</a> ]";
		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&txtKeyword=$pp'>Next>></a> ";
	}

	?>

     
    </tbody>
  </table>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
