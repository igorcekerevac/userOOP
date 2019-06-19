
<?php require 'view/include/header_admin.php'; ?>

<div id="content">
	<h1>ADD CLIENT</h1>

    <?php

    if (isset($status)) {
        echo '<p id="status">' . $status . '</p>';
    } else {
        echo '<p id="status">&nbsp</p>';
    }

    ?>

	<form action="/client/create/post" method="post">

		<h4>NAME</h4>

		<input type="text" name="name" value="<?php echo Functions\Functions::dataTyped('name'); ?>"><br><br>

		<input id="client_btn" type="submit" name="submit" value="add client">

	</form>
</div>

</body>
</html>