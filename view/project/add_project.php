<?php require 'view/include/header_admin.php'; ?>

<div id="content">	
	<h1>ADD PROJECT/<?= $client->name; ?></h1>

    <?php

    if (isset($status)) {
        echo '<p id="status">' . $status . '</p>';
    } else {
        echo '<p id="status">&nbsp</p>';
    }

    ?>

	<form action="/client/project/add/post" method="post">

		<h4>NAME</h4>
		<input type="text" name="name" value="<?php echo Functions\Functions::data_typed('name'); ?>"><br><br>
		<input type="hidden" name="id" value= "<?php echo htmlspecialchars($_GET['id']); ?>"/>

		<input id="client_btn" type="submit" name="submit" value="add project">

	</form>
</div>

</body>
</html>