
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
	
		#font{
			font-size: 20px;
		}
		#left{
			margin-right: 10px;
			margin-left: 20px;
		}
	</style>
</head>
<body>

	<h1><?php echo $name ?> profile!</h1>
	<h2>Active projects:</h2>

	<?php 

	if(!empty($found_projects)){
		foreach($found_projects as $project){

			echo "<li>".$project['name'] ."<a id='left' href='/client/project/task?id=".$project['project_id']."'>tasks</a></li>";
		}
	}else{
		echo "No added projects!";
	}	
	?>
	<br><br>
	<button onclick="location.href = '/clients'">back to clients</button><br><br>

</body>
</html>