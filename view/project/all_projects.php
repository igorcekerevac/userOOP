<?php require 'view/include/header_admin.php'; ?>

<div id="content">

	<h1>ALL PROJECTS</h1>

    <?php

    if (isset($status)) {
        echo '<p id="status">' . $status . '</p>';
    } else {
        echo '<p id="status">&nbsp</p>';
    }

    ?>

    <form action="/project/add/" method="post">

        <table>
            <tr>
                <td style="padding: 0px;"><h5>project name</h5></td>
                <td><input type="text" name="name"></td>
            </tr>
            <tr>
                <td style="padding: 0px;"><h5>client</h5></td>
                <td>
                    <?php
                    echo "<select name='id'>";
                    echo "<option>choose client</option>";

                    foreach ($allClients as $client) {
                        echo "<option value='" . $client->client_id . "'>" . $client->name . "</option>";
                    }

                    echo "</select>";

                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input id="add_btn" style="width: 140px; float:left;" type="submit" name="submit"
                           value="add project"><br><br><br>
                </td>
            </tr>

        </table>

    </form>

    <h3>Active projects!</h3>
	<?php

    $id = array();

	if (!empty($allProjects)) {

        foreach ($allProjects as $project) {

            if (!in_array($project['project_id'], $id) && $project['status'] !== 'finished') {
                array_push($id, $project['project_id']);
                echo '<h3>#id' . $project['project_id'] . '/ ' . $project['client_name'] . ' / ' . '
                <a  href="/project/?id=' . $project['project_id'] . '">' .$project['project_name'] .'</a>' . ' / ' . '
                <a href="/client/project/finished?id=' . $project['project_id'] . '">finish project</a></h3>';
            }
            if ($project['task_id'] !== null && $project['status'] === 'active') {
                echo '<h5><li id="task">' . 'Task: ' .
                    '<a id="task_names" href="/client/project/task/?id=' . $project['task_id'] . '">' . $project['task_name'] . '</a>' .
                    ' &nbsp&nbsp/&nbsp Employee: ' . $project['user_name'] . ' 
                <a id=\'task_delete\' style=\' margin-left: 15px;\' href="/delete/task?id=' . $project['task_id'] . '">delete task</a>
                </li></h5><br>';
            }
        }
        if (empty($id)) {
            echo '<h3>'.'No active projects in database!'.'</h3>';
        }
    } else {
	    echo '<h3>'.'No projects in database!'.'</h3>';
    }

	?>

</div>

</body>
</html>