
<!DOCTYPE html>
<html>
<head>
	<title>OOP</title>
	<style type="text/css">
	
		#font{
			font-size: 20px;
		}
		#page{
			margin-right: 13px;
			text-decoration: none;
		}
		#page:hover{
			color: red;
		}
		#left{
			margin-right: 10px;
			margin-left: 20px;
		}
	</style>

</head>
<body>

	<h1>ALL CLIENTS</h1><br>

	<button onclick="location.href = '/client/create'">add new client</button>
	<button onclick="location.href = '/admin'">home</button><br><br>

	<br>

	
	<?php

		foreach ($all_clients as $client) {

			echo '<strong id="font">'.$client['name'].'</strong>' .

			"<a id='left' href='/client/project/add/?id=".$client['client_id']."'>add project</a>" .
			"<a href='/client/?id=".$client['client_id']."'>client page</a><br>" ;
		}

	?>	

	<br>


</body>
</html>