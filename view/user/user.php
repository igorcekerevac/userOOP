<?php require 'view/include/header_admin.php'; ?>

<div id="content">
	<h1>ALL EMPLOYEES</h1>

    <?php

    if (isset($_SESSION['message']) && $_SESSION['message'] !== '') {

        echo '<p id="status" >'.$_SESSION['message'].'</p>';
        $_SESSION['message'] = '';

    } else {

        echo '<p id="status"> &nbsp </p>';

    }

		foreach ($allUsers as $user) {

			echo '<strong id="font">'.$user->name.'</strong>' .

			"<a id='task_names' style=' margin-left: 15px;' href='delete?id=".$user->user_id."'>delete</a><br>";
			
			//"<a id='task_names' style=' margin-left: 15px;' 
			//href='/user/profile/?id=".$user['user_id']."'>profile</a><br>";
		}

	?>
</div>
	<br>

</body>
</html>