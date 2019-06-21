<?php require 'view/include/header_admin.php'; ?>

<div id="content">
	<h1>ALL CLIENTS</h1><br>

	<button id="client_btn" onclick="location.href = '/client/create'">add new client</button>

	<br><br>
	
	<?php

		foreach ($clients as $client) {

			echo '<strong id="font">'.$client->name.'</strong>' .

			"<a id='task_names' style=' margin-left: 15px;' href='/client/project/add/?id=".$client->client_id."'>add project</a>" .
			"<a id='task_names' style=' margin-left: 15px;' href='/client/?id=".$client->client_id."'>projects</a><br>" ;
		}

	?>	
</div>	
	<br>
	
</body>
</html>