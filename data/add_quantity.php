<?php
session_start();
//ini_set("display_errors","on");
include("condition.php");
include("function/functions.php");
include("function/income.php");
if($_SESSION['success'] == 1)
{
	print "<br>Product Successfully Purchase !!";
	unset($_SESSION['success']);
}
	$q = mysql_query("select * from shopping_product ");
	$num = mysql_num_rows($q);
	?>

<h1>Shopping Cart</h1>
<?php
 $id = $_SESSION['ebank_user_id'];
 $cart_arr = $_REQUEST;
if(isset($cart_arr))
{
	$new_prd_quan = $cart_arr["qunt_item"];
	$prd_id = $cart_arr["id"];
	/* For Stock Management
	"select * from shopping_product where stock >= $new_prd_quan and id='$prd_id'"
	*/
	$sql = "select * from shopping_product where id='$prd_id'";
	$qu = mysql_query($sql);
	$num = mysql_num_rows($qu);
	if($num > 0)
	{
		$item_arr = $_SESSION['item'];
		if(in_array($prd_id,$item_arr))
		{
			$count_item_arr = array_count_values($item_arr);
			$old_prd_quan = $count_item_arr[$prd_id];
			if($old_prd_quan > $new_prd_quan)
			{
				$loss_prd = ($old_prd_quan - $new_prd_quan);
				$_SESSION["cart"] = $_SESSION["cart"] - $loss_prd;
				for($i = 0; $i < $loss_prd; $i++)
				{
					if(in_array($prd_id,$item_arr))
					{
						$key = array_search($prd_id,$_SESSION['item']);
						unset($_SESSION['item'][$key]);
						
					}
				}
				sort($_SESSION['item']);
				//print "loss";
			}
			else
			{
				$inc_prd = ($new_prd_quan - $old_prd_quan);
				$_SESSION["cart"] = $_SESSION["cart"] + $inc_prd;
				for($i = 0; $i < $inc_prd; $i++)
				{
					$_SESSION['item'][] = $prd_id;
				}
				//print "inc";
			}
		}
		else
		{
			
			$_SESSION["cart"] = $_SESSION["cart"] + $new_prd_quan;
			for($i = 0; $i < $new_prd_quan; $i++)
			{
				$_SESSION['item'][] = $prd_id;
			}
			echo "<script type=\"text/javascript\">";
			echo "window.location = \"index.php?page=product_shop\"";
			echo "</script>";
		}
		
	}
	else
	{
		$_SESSION['product_stock'] = 1;
	}

}
	echo "<script type=\"text/javascript\">";
	echo "window.location = \"index.php?page=view_cart\"";
	echo "</script>";
?>
