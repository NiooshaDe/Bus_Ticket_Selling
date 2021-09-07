<form action="?route=register_class" method="post">
    <select name="course">
        <?php
        for ($i = 0; $i < count($courses); $i++) { ?>
            <option value='<?php echo $courses[$i][0]; ?>'><?php echo $courses[$i][1]; ?></option>
            <?php
        }
        ?>
    </select><br>
    <input type="submit" value="send" name="send">
</form>