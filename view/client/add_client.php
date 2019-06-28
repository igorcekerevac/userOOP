
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
<!---->
<!--		<input type="text" name="name" value="--><?php //echo Functions\Functions::dataTyped('name'); ?><!--"><br><br>-->
<!---->
<!--		<input id="client_btn" type="submit" name="submit" value="add client">-->

        <table>

            <tr>
                <td>name</td>
                <td><input type="text" name="name" value="<?php echo Functions\Functions::dataTyped('name'); ?>"></td>
            </tr>

            <tr>
                <td>email</td>
                <td><input type="text" name="email" value="<?php echo Functions\Functions::dataTyped('email'); ?>">
                </td>
            </tr>

            <tr>
                <td>password</td>
                <td><input type="password" name="password"
                           value="<?php echo Functions\Functions::dataTyped('password'); ?>"></td>
            </tr>

            <tr>
                <td></td>
                <td><input id="add_btn" type="submit" name="submit" value="add client"></td>
            </tr>

        </table>
	</form>
</div>

</body>
</html>