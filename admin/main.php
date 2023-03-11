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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>
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
       <h5><a class="nav-link active" aria-current="page" href="./main.php">Home</a></h5>
       <h5><a class="nav-link" href="../ledger.php">General Ledger</a></h5>
       <h5><a class="nav-link" href="../report.php">Report</a></h5>
       <h5><a class="nav-link" href="../logout.php">Log out</a> </h5>
       <!-- <h5><a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a> -->
      </div>
    </div>
  </div>
</nav>

<?php         
  $strKeyword = null;
  if(isset($_POST['txt'])){
    $strKeyword = $_POST['txt'];
  }
?>

<div class="container mt-4">
  <h4>
    <form name="frmSearch" method="POST">
      <input name="txt" type="text" value="<?=$strKeyword?>"/>
      <input type="submit"/>
    </form>
    <a href="./product_add/insert_product.php" class="btn btn-primary" style="float:right;">Add Product</a>
    </h4><br>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Id</th>
        <th>Image</th>
        <th>Name</th>
        <th>Buy</th>
        <th>Sale</th>
        <th>Stock</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
    <?php

include("./config_fifo.php");

//No left No value for new product
// $str = "select p.id, p.p_name, img,"
// ." COALESCE(sum(pc.qty),0) buy," 
// ." COALESCE(sum(ps.qty),0) sale,"
// ." COALESCE(sum(pc.qty)-sum(ps.qty),'Sold out') stock "
// ."  from product p"
// ." left join product_cost pc on p.id = pc.p_id "
// ." left join product_sale ps on p.id = ps.p_id "
// ."where p_name like '%$strKeyword%' group by p.id ";
$str = "select c_id,c_name,c_img,buy, sale, (buy - sale) stock from "
." (select p.id c_id, p.p_name c_name, img c_img, "
." COALESCE(sum(pc.qty),0) buy "
." from product p "
." left join product_cost pc on p.id = pc.p_id "
." group by p.id ) as t_cost "
." join "
." (select p.id s_id, p.p_name, img,"
." COALESCE(sum(ps.qty),0) sale "
." from product p "
." left join product_sale ps on p.id = ps.p_id "
." group by p.id ) as t_sale"
." on t_cost.c_id = t_sale.s_id "
." where c_name like '%$strKeyword%' ";


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


$str .=" order by c_id ASC LIMIT $Page_Start , $Per_Page";
$obj  = mysqli_query($conn,$str);
//page END

// function getCost($p_id){
//   global $conn;
//   // $p_id = 1  ;
//   $str2 = " select * from product_cost pc where p_id like '%$p_id%' order by date desc"; 
//   $obj2 = mysqli_query($conn,$str2);
  
//   $str3 = " select sum(qty) as qty from product_sale ps where p_id like '%$p_id%'"; 
//   $obj3 = mysqli_query($conn,$str3);
  
//   // while($sale_qty = mysqli_fetch_array($obj3)){ 
//     //   echo  $sale_qty['qty']." "."<br>";
//     // }
    
//     //WA weighted average
//     calCost($obj2,$obj3);
// }

// function calCost($cost,$sale){
//   // $sale_count = 0;
//   // while($sale_qty = mysqli_fetch_array($sale)){
//     //   $sale_count = $sale_qty['qty'];
//     //   echo  $sale_count." "."<br>";
//     // }
    
//     $avg_cost = 0;
//     $cost_qty = 0;
//     while($cost_row = mysqli_fetch_array($cost)){ 
//       $avg_cost += $cost_row['qty']*$cost_row['cost_per_unit'];
//       $cost_qty += $cost_row['qty'];
//       // echo  $cost_row['qty']." ".$cost_row['date']."<br>";
//   }
//   // echo $avg_cost."<br>";
//   // echo $cost_qty."<br>";
//   // echo ($avg_cost/$cost_qty)."<br>";
//   $result = null;
//   $avg_cost > 0 && $cost_qty > 0? $result = ($avg_cost/$cost_qty) : $result;
//   echo $result."<br>";
//   return $result;
// }

    $ya = 0;
    while($row = mysqli_fetch_array($obj)){
        $ya++;
        // $cost_wa;
        // echo $row['id']." aa ";
        // getCost($row['id']) > 0?$cost_wa = getCost($row['id']):$cost_wa = "0";
        echo'<tr>'.
            // '<td>'.$ya.'</td>'.
            // '<td>'.'<img src="img/test1.jpg">'.'</td>'.
            // '<td>'.$row['id'].'</td>'.
            '<td>'.$ya.'</td>'.
            '<td>'.'<img style="width:300px" src="'.$row['c_img'].'"></td>'.
            '<td>'.$row['c_name'].'</td>'.
            '<td>'.$row['buy'].'</td>'.
            '<td>'.$row['sale'].'</td>'.
            '<td>'.$row['stock'].'</td>';
            // '<td>'.$cost_wa.'</td>';  //query from product_cost where p_id = $row['id']  if() avg or 

?>
                    <td class="text-center">
                        <!--Product stock buy-->
                        <a href="./product_cost/cost.php?stock_name=<?php echo $row['p_name']?>" style="color:blue"> <!--param edit-->
                        <i class="fa fa-cart-shopping" aria-hidden="true"></i>Buy</a>&nbsp &nbsp
                        <!--Product stock buy-->
                        <!--Product stock sale-->
                        <a href="./product_sale/sale.php?stock_name=<?php echo $row['p_name']?>" style="color:green"> <!--param edit-->
                        <i class="fa fa-boxes-stacked" aria-hidden="true"></i>Sale</a>&nbsp &nbsp
                        <!--Product stock sale-->
                        <a href="./product_add/edit_product.php?edit=<?php echo $row['id']?>" style="color:salmon"> <!--param edit-->
                        <i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>&nbsp &nbsp
                        <a href="./product_add/delete_product.php?del=<?php echo $row['id']?>" style="color:red" onclick="return confirm('Are you sure want to delete this record <?= $row['id']?>')">
                        <i class="fa fa-trash" aria-hidden="true">Delete</i>
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
