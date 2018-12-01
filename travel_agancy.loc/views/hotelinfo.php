<?php
session_start();
include_once "functions.php";
connect();
$id = $_GET['hotel'];
$selHotel = mysql_query("select ho.id, ho.hotelName, ci.cityName, co.countryName, ho.stars, ho.cost, ho.info from hotels ho, countries co, cities ci  WHERE ho.id=$id and ho.cityId=ci.id and ho.countryId=co.id");
$resHotel = mysql_fetch_array($selHotel, MYSQL_ASSOC);

$selImg = mysql_query("select * from images  WHERE hotelId=$id");
//$resImg = mysql_fetch_array($selImg, MYSQL_ASSOC);

$selCom = mysql_query("select * from comments  WHERE hotelId=$id");
?>


<h2>Information about hotel</h2>
<hr/>
<div class="container">
    <div class="info-box">
<!--        <div class="image-container">-->
<!--            --><?php //echo '<img src="../images/'.$resImg['imagePath'].'" alt="'.$resImg['imagePath'].'"/>' ?>
<!--        </div>-->
        <div id="myCarousel" class="carousel slide image-container" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <?php
                    $i=0;
                    $cl='';
                    while(mysql_num_rows($selImg)-1>=$i){
                        $cl=$i==0?'active':'';
                        echo '<li data-target="#myCarousel" data-slide-to="'.$i++.'" class="'.$cl.'"></li>';
                    }
                ?>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <?php $i=0?>
                <?php while($row=mysql_fetch_array($selImg, MYSQL_ASSOC)):?>
                    <?php
                        $cl=$i==0?'active':'';
                        $i++;
                    ?>
                    <div class="item <?=$cl?>">
                        <img src='images/<?=$row['imagePath']?>' alt='<?=$row['imagePath']?>'/>
                    </div>
                <?php endwhile;?>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class="info">
            <h1><?php echo $resHotel['hotelName'] ?></h1>
            <small class="data" style="color: #9d9d9d">Рейтинг: <?php echo $resHotel['stars'] ?></small>
            <dl>
                <dt>Country:</dt>
                <dd><?php echo $resHotel['countryName'] ?></dd>
                <dt>City:</dt>
                <dd><?php echo $resHotel['cityName'] ?></dd>
                <dt>Info:</dt>
                <dd><?php echo $resHotel['info'] ?></dd>
            </dl>
            <span class="price"><?php echo $resHotel['cost'] ?> <small style="font-size: 20px">грн./сут.</small></span>
        </div>
    </div>
    <div class="comment-box">
        <h2>Отзывы:</h2>
        <?php while($row=mysql_fetch_array($selCom, MYSQL_ASSOC)):?>
            <hr/>
            <div class="col-lg-12">
                <h4><?php echo $row['userName'] ?></h4>
                <small class="date">Дата: <?php echo $row['dataComment'] ?></small>
                <p><?php echo $row['textComments'] ?></p>
            </div>
        <?php endwhile;?>
    </div>

</div>
