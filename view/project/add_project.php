<?php require 'view/include/header_admin.php'; ?>

<div id="content">	
	<h1>ADD PROJECT</h1><br>

	<form action="" method="post">

		<h4>NAME</h4>
		<input type="text" name="name" value="<?php echo Functions::data_typed('name'); ?>"><br><br>
		<input type="hidden" name="id" value= "<?php echo htmlspecialchars($_GET["id"]); ?>"/>

		<input id="client_btn" type="submit" name="submit" value="add project">

		<?php if (isset($status)) :?>

			<p id="status"><?php echo $status?></p>

		<?php endif; ?>

	</form>
</div>

</body>
</html>