<form action="?route=do_add_course" method="post">
    <input type="text" name="name"><br>
    <select name="professor">
        <?php
        for ($i = 0; $i < count($professors); $i++) { ?>
            <option value='<?php echo $professors[$i][0]; ?>'><?php echo $professors[$i][1]; ?></option>
            <?php
        }
        ?>
    </select><br>
    <input type="submit" value="send" name="send">
</form>