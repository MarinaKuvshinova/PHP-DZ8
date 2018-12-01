<?php
include_once "../views/functions.php";
connect();

if($_POST['param']){
    if($_POST['param'] == 'country'){
        $sel = 'select * from countries';
        $res = mysql_query($sel);
        $respons='';
        while($row=mysql_fetch_array($res,MYSQL_ASSOC))
        {
            $respons .= $row['countryName'].'@';
        }
        echo $respons;
    }
    if($_POST['param'] == 'countryandcities'){
        $idcities = $_POST['idcities'];
        $sel = 'select * from countries';
        $res = mysql_query($sel);
        $respons='';
        while($row=mysql_fetch_array($res,MYSQL_ASSOC))
        {
            $respons .= $row['countryName'].'@';
        }
    }

}
