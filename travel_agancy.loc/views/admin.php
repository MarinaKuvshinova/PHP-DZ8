<?php
connect();
if (isset($_POST['addCountry']))
{
    $countryName = trim(htmlspecialchars($_POST['countryName']));
    if (empty($countryName)) return false;
    $insert = "insert into countries(countryName) VALUES ('$countryName')";
    mysql_query($insert);
}
if (isset($_POST['delCountry']))
{
    foreach ($_POST as $k=>$v){
        if (substr($k,0,2)=="cb")
        {
            $idc = substr($k,2);
            $delete = "delete from countries WHERE id = $idc";
            mysql_query($delete);

        }

    }
}
if (isset($_POST['addCity']))
{
    $city = trim(htmlspecialchars($_POST['cityName']));
    if (empty($city)) return false;
    $countryId = $_POST['countryNameSelect'];
    $insert = "insert into cities (cityName, countryId) VALUES ('$city', $countryId)";
    mysql_query($insert);
    $error = mysql_errno();
    if ($error)
    {
        echo "$error Не работает!!!!";
        return false;
    }
}
if(isset($_POST['delCity']))
{
    foreach ($_POST as $k=>$v)
    {
        if (substr($k,0,2)=='ci')
        {
            $idc = substr($k,2);
            $delete = "delete from cities WHERE id = $idc";
            mysql_query($delete);
        }
    }
}
//обработчик для добавления и удаления городов
if(isset($_POST['addHotel']))
{
    $hotelName=trim(htmlspecialchars($_POST['hotelName']));
    $cost=trim(htmlspecialchars($_POST['cost']));
    $stars=trim(htmlspecialchars($_POST['stars']));
    $info=trim(htmlspecialchars($_POST['info']));
    if (empty($hotelName)||empty($cost)||empty($stars)||empty($info))
    {
        echo "FUCK ASS!!!!";
        return false;
    }
    $cityId = $_POST['hcity'];
    $s = 'select countries.id from countries, cities where countries.id = cities.countryId and cities.id ='.$cityId;
    $r = mysql_query($s);
    $row = mysql_fetch_array($r, MYSQL_NUM);
    $countryId = $row[0];
    $insertHotel = "insert into hotels(hotelName, cityId, countryId, stars, cost, info) VALUES ('$hotelName', $cityId, $countryId, $stars, $cost, '$info')";
    mysql_query($insertHotel);
    $error = mysql_errno();
//    if ($error)
//    {
//        echo "$error Не работает!!!!";
//        return false;
//    }
}
if(isset($_POST['delHotel']))
{
    foreach ($_POST as $k=>$v){
        if (substr($k,0,2) == 'hb'){
            $idc = substr($k,2);
            $del = "delete FROM hotels where id=$idc";
            mysql_query($del);
            $error = mysql_errno();
            if ($error)
            {
                echo "$error Не работает!!!!";
                return false;
            }
        }
    }
}

if (isset($_REQUEST['addImage'])){
    foreach ($_FILES['file']['name'] as $k=>$v){
        if($_FILES['file']['error'][$k]!=0){
            continue;
        }
        if(move_uploaded_file($_FILES['file']['tmp_name'][$k],'images/'.$v)){
            $id = $_REQUEST['hotelid'];
            $insert="insert into images(hotelId, imagePath) VALUES ($id, '$v')";
            mysql_query($insert);
        }
    }
}


$selectCountries= 'select * FROM countries';
$resourseCounties = mysql_query($selectCountries);
$selectCities= 'select ci.id, ci.cityName, co.countryName from countries co, cities ci where ci.countryId = co.id';
$resourseCities = mysql_query($selectCities);
$selectHotels = 'select ci.cityName, ho.id, ho.hotelName, ho.cityId, ho.countryId, ho.stars, ho.info, co.countryName from cities ci, hotels ho, countries co where ho.cityId = ci.id and ho.countryId = co.id';
$resourseHotels = mysql_query($selectHotels);

//запросы для селекта стран
$selectCountriesCity = 'select ci.id, ci.cityName, co.countryName from cities ci, countries co where ci.countryId = co.id';
$resourseCountiesCityC = mysql_query($selectCountriesCity);

$resourseHotelsImage = mysql_query($selectHotels);



?>
<div class="row">
    <div class="col-sm-6">
        <!--todo section A:for Country-->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3>Добавление стран</h3>
            </div>
            <form action="index.php?page=4" method="post" id="formCountry">
                <div class="panel-body">
                        <table class="table table-striped">
                            <?php while ($row = mysql_fetch_array($resourseCounties, MYSQL_NUM)):?>
                                <tr>
                                    <td><?=$row[0]?></td>
                                    <td><?=$row[1]?></td>
                                    <td><input type="checkbox" name="cb<?=$row[0]?>"></td>
                                </tr>
                            <?php endwhile;?>
                        </table>
                        <div class="form-inline">
                            <input type="text" class="form-control" name="countryName" placeholder="Country">
                        </div>
                </div>
                <div class="panel-footer">
                    <input type="submit" class="btn btn-success btn-sm" name="addCountry" value="Add">
                    <input type="submit" class="btn btn-warning btn-sm" name="delCountry" value="Delete">
                </div>
            </form>
        </div>
    </div>
    <div class="col-sm-6">
        <!--todo section B:for City-->
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3>Добавление города</h3>
            </div>
            <form action="index.php?page=4" method="post" id="formCities">
            <div class="panel-body">
                    <table class="table table-striped">
                        <?php while ($row = mysql_fetch_array($resourseCities, MYSQL_ASSOC)):?>
                            <tr>
                                <td><?=$row["id"]?></td>
                                <td><?=$row["cityName"]?></td>
                                <td><?=$row["countryName"]?></td>
                                <td><input type="checkbox" name="ci<?=$row['id']?>"></td>
                            </tr>
                        <?php endwhile;?>
                    </table>
                    <div class="form-inline">
                        <input type="text" name="cityName" placeholder="City" class="form-control">
                        <select name="countryNameSelect" class="form-control">
                            <? $resourseCountiesCity = mysql_query($selectCountries);?>
                            <?php while ($row = mysql_fetch_array($resourseCountiesCity, MYSQL_ASSOC)):?>
                                <option value="<?=$row['id']?>"><?=$row['countryName']?></option>
                            <?php endwhile;?>
                        </select>
                    </div>

            </div>
            <div class="panel-footer">
                <input type="submit" name="addCity" value="Add" class="btn btn-sm btn-success btn-sm">
                <input type="submit" name="delCity" value="Delete" class="btn btn-sm btn-warning btn-sm">
            </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <!--todo section C:for Hotels-->
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3>Добавление отеля</h3>
            </div>
            <form action="index.php?page=4" method="post">
                <div class="panel-body">
                    <table class="table table-striped">
                        <?php while($row = mysql_fetch_array($resourseHotels, MYSQL_ASSOC)):?>
                            <tr>
                                <td><?=$row["id"]?></td>
                                <td><?=$row["cityName"]." : ".$row["countryName"]?></td>
                                <td><?=$row["hotelName"]?></td>
                                <td><input type="checkbox" name="hb<?=$row['id']?>"></td>
                            </tr>
                        <?php endwhile;?>
                    </table>
                    <div class="form-group">
                        <select name="hcity" class="form-control">
                            <?php while ($row = mysql_fetch_array($resourseCountiesCityC, MYSQL_ASSOC)):?>
                                <option value='<?=$row['id']?>'><?= $row['cityName']." ".$row['countryName']?></option>
                            <?php endwhile;?>
                        </select>
                    </div>
                    <div class="form-inline form-group">
                        <input type="text" name="hotelName" placeholder="Hotel" class="form-control">
                        <input type="text" name="cost" placeholder="Cost" class="form-control">
                        <label for="stars">Stars:</label>
                        <input type="number" id="stars" name="stars" min="1" max="5" style="width: 130px;" class="form-control">
                    </div>
                    <div class="form-group">
                        <textarea name="info" placeholder="Description"  class="form-control"></textarea>
                    </div>
                </div>
                <div class="panel-footer">
                    <input type="submit" name="addHotel" value="Add" class="btn btn-success btn-sm">
                    <input type="submit" name="delHotel" value="Delete" class="btn btn-warning btn-sm">

                </div>
            </form>
        </div>
    </div>
    <div class="col-sm-6">
        <!--todo section D:for Images-->
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3>Добавление изображенния</h3>
            </div>
           <form action="index.php?page=4" method="post" enctype="multipart/form-data"> <!-- форма будет грузить файлы-->
                <div class="panel-body">
                    <div class="form-group">
                        <select name="hotelid" class="form-control">
                            <?php while ($row=mysql_fetch_array($resourseHotelsImage, MYSQL_NUM)):?>
                                <option value="<?=$row[1]?>">
                                    <?=$row[2].' ('.$row[6].': '.$row[0].')'?>
                                </option>
                            <?php endwhile?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="file" name="file[]" multiple="multiple" style="min-height: 48px;">
                    </div>
                </div>
                <div class="panel-footer">
                    <input type="submit" name="addImage" value="Add" class="btn btn-sm btn-success">
                </div>
           </form>
        </div>
    </div>
</div>