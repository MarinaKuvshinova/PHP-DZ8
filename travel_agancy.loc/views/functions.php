<?php
/**
 * Created by PhpStorm.
 * User: MKA
 * Date: 07.11.2018
 * Time: 19:01
 */
function connect(
    $host = 'localhost',
    $user = 'root',
    $pass = '',
    $dbname = 'traveldb'
){
    $link = mysql_connect($host, $user, $pass) or die('connection error');
    mysql_select_db($dbname) or die('db open error');
    mysql_query("set names 'utf8'");
}

function register($name, $pass, $email){
    $name = trim(htmlspecialchars($name));
    $pass = trim(htmlspecialchars($pass));
    $email = trim(htmlspecialchars($email));
    if (empty($name) || empty($pass) || empty($email))
    {
        echo "<h3 class='alert alert-danger'> Fill All Required</h3>";
        return false;
    }
    $pass=md5($pass);
    $inser = "insert into users(login, pass, email, roleId)
                values('$name', '$pass', '$email', 2)";
    connect();
    mysql_query($inser);
    $error = mysql_errno();
    if ($error)
    {
        if ($error == 1062)
            echo "<h3 class='alert alert-danger'> This Login Is Already Taken!</h3>";
        else
            echo "<h3 class='alert alert-danger'>Error code: $error</h3>";
    }
    return true;
}