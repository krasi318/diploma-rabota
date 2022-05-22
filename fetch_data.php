<?php

//fetch_data.php

include('database_connection.php');

if(isset($_POST["action"]))
{
	$query = "SELECT * FROM dishes WHERE 1 ";
	
	if(isset($_POST["brand"]))
	 {
	 	$brand_filter = implode("','", $_POST["brand"]);


		 $count = count(  $_POST["brand"] );
		 $query .= " 
		 AND dishes.id IN (
		 SELECT dishes_id FROM (
			SELECT dp.dishes_id, p.name, COUNT(*) c
			FROM `products` p
			LEFT JOIN dishes_has_products dp ON dp.products_id = p.id
			WHERE p.name IN( '$brand_filter' )
			GROUP BY dp.dishes_id
			) a
			WHERE a.c >= $count
		)
		
		";

		
	 }




	// if(isset($_POST["ram"]))
	// {
	// 	$ram_filter = implode("','", $_POST["ram"]);
	// 	$query .= "
	// 	 AND product_ram IN('".$ram_filter."')
	// 	";
	// }
	// if(isset($_POST["storage"]))
	// {
	// 	$storage_filter = implode("','", $_POST["storage"]);
	// 	$query .= "
	// 	 AND product_storage IN('".$storage_filter."')
	// 	";
	// }

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$output = '';
	if($total_row > 0)
	{
		foreach($result as $row)
		{
			$output .= '
			<div class="col-sm-4 col-lg-3 col-md-3">
				<div style="border:3px solid #ccc; border-radius:5px; padding:16px; margin-bottom:16px; height:320px;">
										
					<img src="image/'. $row['image'] .'"class="img-responsive" >
					<p align="center"><strong><a href='.$row['url'].' target="_blank"> '.  $row['name'] .  '</a></strong></p>
					
					<p>'. $row['recipe'].'</p>
					
			
				</div>
			</div>
			';
		}
	}
	else
	{
		$output = '<h3>No Data Found</h3>';
	}
	echo $output;
}

?>