<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reserve</title>
</head>
<body>
<form method="post" action="ReserveView.php" dir="rtl">
    <label for="student">نام دانشجو: </label>
    <input type="txt" id="student" name="student">

    <label for="studentId">شماره دانشجو: </label>
    <input type="number" id="studentId" name="studentId">

    <label for="teacher">کد استاد: </label>
    <input type="number" id="teacher" name="teacher">

    <select name="subject">
        <option>Math</option>
        <option>Programming</option>
        <option>English</option>
    </select>

    <button type="submit" name="submit">ثبت</button>
</form>
</body>
</html>

<?php
include_once 'C:\Users\IHC\phpfiles\xampp\htdocs\MVC\Controller\ReserveController.php';

if(isset($_POST['submit']) and isset($_POST['student']) and isset($_POST['studentId']) and isset($_POST['teacher'])){
$finalObject = new ReserveController();
print_r($finalObject->getter());
}
?>