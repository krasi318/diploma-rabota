<?php 
include('database_connection.php');
include('auth_session.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" id="roundedges" type="image/x-icon" href="image/favicon.ico">

    <title>Готварски уебсайт</title>

    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href = "css/jquery-ui.css" rel = "stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
        	<br />
        	<h2 align="center">Готварски уебсайт </h2>
            <form action="cookingsite.php" method="get">
            <p><?php 
            //izvejdane na pozdrav
            if(isset($_SESSION["username"])){
            $username = $_SESSION["username"];
            echo "<h4>Здравей, " . $_SESSION["username"] . "</h4 >";} ?></p>
            </form>
            
        	<br>
            <div class="col-md-3">                				
                <div class="list-group">
					<h3>Изберете вече наличните продукти :</h3>
                    <div style="height: 600px; overflow-y: auto; overflow-x: hidden;">
					<?php

                    $query = "SELECT DISTINCT(name) FROM products";
                    $statement = $connect->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll();
                    foreach($result as $row)
                    {
                    ?>
                    <!-- izvejdane na butonite ot lqvo -->
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector brand" value="<?php echo $row['name']; ?>" > <?php echo $row['name']; ?></label>
                    </div>
                    <?php
                    }

                    ?>
                    </div>
                </div>

				<div class="list-group">
					
                </div>
				
				<div class="list-group">
					
                </div>
            </div>

            <div class="col-md-9">
            	<br />
                <div class="row filter_data">

                </div>
            </div>
        </div>

    </div>
<style>
#loading
{
	text-align:center; 
	background: url('loader123.gif') no-repeat center; 
	height: 150px;
}
#roundedges{
    border-radius: 90px;
}
h4{
   text-align: center;
}
#logout{
    background-color: yellow;
    text-align:right;
}
</style>

<script>
$(document).ready(function(){

    filter_data();

    function filter_data()
    {
        $('.filter_data').html('<div id="loading" style="" ></div>');
        var action = 'fetch_data';
        var minimum_price = $('#hidden_minimum_price').val();
        var maximum_price = $('#hidden_maximum_price').val();
        var brand = get_filter('brand');
        var ram = get_filter('ram');
        var storage = get_filter('storage');
        $.ajax({
            url:"fetch_data.php",
            method:"POST",
            data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price, brand:brand, ram:ram, storage:storage},
            success:function(data){
                $('.filter_data').html(data);
            }
        }); 
    }

    function get_filter(class_name)
    {
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }

    $('.common_selector').click(function(){
        filter_data();
    });

    

});
</script>
<a href="index.php" id="logout">Изход</a>
</body>

</html>
