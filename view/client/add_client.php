
<?php require 'view/include/header_admin.php'; ?>

<div id="content">
	<h1>ADD CLIENT</h1><br>

	<form action="/client/create/post" method="post">

		<h4>NAME</h4>

		<input type="text" name="name" value="<?php echo Functions\Functions::data_typed('name'); ?>"><br><br>

		<input id="client_btn" type="submit" name="submit" value="add client">

		<?php if (isset($status)) :?>

			<p id="status"><?php echo $status?></p>

		<?php endif; ?>

	</form>
</div>

</body>
</html>