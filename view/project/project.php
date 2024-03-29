<?php require 'view/include/header_admin.php'; ?>

<div id="content">	
	<h1>PROJECT/ <?php echo $project->name?> </h1>
    <h4 style="font-style: italic; margin-top: -10px;">CLIENT <?php echo $client->name?> </h4>
    <h4 style="font-style: italic; margin-top: -20px;">created: <?php echo $project->date_created?> by admin</h4>
    <h4 style="margin-top: -15px;"><a href="/client/project/finished?id=<?php echo $project->project_id ?>">finish project</a></h4><br>
    <div id="addUser">
        <h2>Add employee</h2><br>
        <form action="/project/addUser/" method="post">

            <table>
                <tr>
                    <td style="padding: 0px;"><h5>employee</h5></td>
                    <td>
                        <?php
                        echo "<select name='id'>";
                        echo "<option>choose user</option>";

                        foreach ($availableEmployees as $user) {
                            echo "<option value='" . $user->user_id . "'>" . $user->name . "</option>";
                        }
                        echo "</select>";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="project_id" value="<?php echo $project->project_id; ?>">
                    </td>
                    <td>
                        <input id="add_btn" style="width: 140px; float:left;" type="submit" name="submit"
                               value="add user">
                    </td>
                </tr>

            </table>

        </form>

        <h4>Employees working on project:</h4>
        <ul>
            <?php
                if (empty($employeesOnProject)) {
                    echo '<h5>'.'No added employees to project.'.'</h5>';
                }
            ?>

            <?php foreach ($employeesOnProject as $user) : ?>
                <li style="font-family: Verdana;"><?php echo $user->name?></li>
            <?php endforeach; ?>

        </ul>
    </div>
    <div id="addTask">
        <h2>Add task</h2><br>

        <form action='/client/project/post/?id='". <?php echo $project->project_id; ?>."' method="post">

        <table>
            <tr>
                <td style="padding: 0px;"><h5>task name</h5></td>
                <td><input type="text" name="name"></td>
            </tr>
            <tr>
                <td style="padding: 0px;"><h5>employee</h5></td>
                <td>
                    <?php
                    echo "<select name='user_id'>";
                    echo "<option>choose employee</option>";

                    foreach ($employeesOnProject as $user) {
                        echo "<option value='" . $user->user_id . "'>". $user->name ."/".$user->job."</option>";
                    }

                    echo "</select>";

                    ?></td>
            </tr>

        </table>

        <input type="hidden" name="project_id" value= "<?php echo $project->project_id; ?>"/>
        <input id="add_btn" style="float: left; " type="submit" name="submit" value="add task">

        </form><br><br>

        <h4>All tasks:</h4>
        <ul>
            <?php
            if (empty($allTasks)) {
                echo '<h5>'.'No added tasks to project.'.'</h5>';
            }
            ?>

            <?php foreach ($allTasks as $task) : ?>
                <li style="font-family: Verdana;"><a id="task_names" href="/client/project/task/?id=<?php echo $task->task_id; ?>">
                        <?php echo $task->name?></a> /employee: <?php $user = $task->getUser();
                    echo $user->name; ?>/</li>
            <?php endforeach; ?>

        </ul>
    </div>
</div>

</body>
</html>