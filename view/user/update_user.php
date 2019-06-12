<?php require 'view/include/header_user.php';?>


	<div id="update_form">


		<h1 id="update_h1">UPDATE</h1>

        <?php


        if (isset($status)) {

            echo '<p id="status">'.$status.'</p>';

        } elseif ($_SESSION['message'] !== 'message') {

            echo '<p id="status">'.$_SESSION['message'].'</p>';

        } else {

            echo '<p id="status"> &nbsp </p>';

        }

        ?>

		<form action="/user/update/post" method="post">

			<table>

			<tr> 
				<td>name</td>
				<td><input type="text" name="name" value="<?php echo Functions\Functions::data_typed('name'); ?>"></td>
			</tr>
			
			<tr> 
				<td>job</td>
				<td><input type="text" name="job" value="<?php echo Functions\Functions::data_typed('job'); ?>"></td>
			</tr>
			
			<tr> 
				<td>email</td>
				<td><input type="text" name="email" value="<?php echo Functions\Functions::data_typed('email'); ?>"></td>
			</tr>

                <tr>
                    <td>password</td>
                    <td><input type="password" name="password" value="<?php echo Functions\Functions::data_typed('password'); ?>"></td>
                </tr>

			<tr> 
				<td></td>
				<td><input id="add_btn" type="submit" name="submit" value="update"></td>
			</tr>

			</table><br>

		</form>
	</div>

</body>
</html>