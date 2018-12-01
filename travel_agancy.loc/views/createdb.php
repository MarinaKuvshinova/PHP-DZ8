<?php
/**
 * Created by PhpStorm.
 * User: MKA
 * Date: 07.11.2018
 * Time: 20:09
 */
include_once 'functions.php';
connect();
$ct1 = "create table countries(
id int not NULL auto_increment PRIMARY KEY,
countryName varchar(64) UNIQUE
) DEFAULT charset='utf8'";

$ct2="create table cities(
id int not NULL auto_increment PRIMARY KEY,
cityName varchar(64),
countryId int,
FOREIGN KEY (countryId) REFERENCES countries(id) on DELETE CASCADE
) DEFAULT charset='utf8'";

$ct3 = "create table hotels(
id int not NULL auto_increment PRIMARY KEY,
hotelName varchar(64),
cityId int,
FOREIGN KEY (cityId) REFERENCES cities(id) on DELETE CASCADE,
countryId int,
FOREIGN KEY (countryId) REFERENCES countries(id) on DELETE CASCADE,
stars int,
cost int,
info VARCHAR(1024)
) DEFAULT charset='utf8'";

$ct4 = "create table images(
id int not NULL auto_increment PRIMARY KEY,
imagePath varchar(255),
hotelId int,
FOREIGN KEY (hotelId) REFERENCES hotels(id) on DELETE CASCADE
) DEFAULT charset='utf8'";

$ct5 = "create table roles(
id int not NULL auto_increment PRIMARY KEY,
roleName varchar(32)
) DEFAULT charset='utf8'";

$ct6 = "create table users(
id int not NULL auto_increment PRIMARY KEY,
login varchar(34) UNIQUE,
pass VARCHAR (128),
email varchar(128),
discont int,
roleId int,
FOREIGN KEY (roleId) REFERENCES roles(id) on DELETE CASCADE,
avatarPath VARCHAR(255)
) DEFAULT charset='utf8'";

$ct7 = "create table sales(
id int not NULL auto_increment PRIMARY KEY,
userId int,
FOREIGN KEY (userId) REFERENCES users(id) on DELETE CASCADE,
hotelId int,
FOREIGN KEY (hotelId) REFERENCES hotels(id) on DELETE CASCADE
) DEFAULT charset='utf8'";


$ct8 = "create table comments(
id int not NULL auto_increment PRIMARY KEY,
userName VARCHAR(128),
dataComment datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
hotelId int,
FOREIGN KEY (hotelId) REFERENCES hotels(id) on DELETE CASCADE,
textComments VARCHAR(255)
) DEFAULT charset='utf8'";


mysql_query($ct1);
$err = mysql_errno();
if ($err)
{
    echo 'Error code 1:'.$err.'<br>';
    return false;
}
mysql_query($ct2);
$err = mysql_errno();
if ($err)
{
    echo 'Error code 2:'.$err.'<br>';
    return false;
}
mysql_query($ct3);
$err = mysql_errno();
if ($err)
{
    echo 'Error code 3:'.$err.'<br>';
    return false;
}
mysql_query($ct4);
$err = mysql_errno();
if ($err)
{
    echo 'Error code 4:'.$err.'<br>';
    return false;
}
mysql_query($ct5);
$err = mysql_errno();
if ($err)
{
    echo 'Error code 5:'.$err.'<br>';
    return false;
}
mysql_query($ct6);
$err = mysql_errno();
if ($err)
{
    echo 'Error code 6:'.$err.'<br>';
    return false;
}
mysql_query($ct7);
$err = mysql_errno();
if ($err)
{
    echo 'Error code 7:'.$err.'<br>';
    return false;
}
mysql_query($ct8);
$err = mysql_errno();
if ($err)
{
    echo 'Error code 8:'.$err.'<br>';
    return false;
}