<?php require 'view/include/header.php'; ?>

<div id="log_header">
	
	<a id="login" href="/">sign up</a>

</div>

<div id="sign_form">

	<h1 id="sign_h1">LOGIN</h1>

	<?php 

		if (isset($status)) {

			echo '<p id="status">'.$status.'</p>';
			
		} else {

			echo '<p id="status"> &nbsp </p>';

		} ?>

	<form action="/employee/login/post" method="post">

		<table>
			<tr>
				<td>email</td>
				<td><input type="text" name="email" value=""></td>
			</tr>

            <tr>
                <td>password</td>
                <td><input type="password" name="password" value=""></td>
            </tr>

			<tr>
				<td></td>
				<td><input id="add_btn" type="submit" name="submit" value="login"></td>
			</tr>
		</table>

	</form>
</div>

</body>
</html>