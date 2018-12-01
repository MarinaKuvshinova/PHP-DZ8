<h2>Select Tours</h2>
<hr>
<?php connect()?>
<?php
    $res = mysql_query('select * from countries order by countryName');
?>
<form action="index.php?page=1" method="post" class="form-inline">
    <div class="form-inline" style="width: auto; display: inline-block">
        <select name="countryid" class="form-control">
            <option value="0" disabled selected>Select country...</option>
            <?php while($row=mysql_fetch_array($res, MYSQL_ASSOC)):?>
                <option value="<?=$row['id']?>"><?=$row['countryName']?></option>
            <?php endwhile;?>
        </select>
        <input type="submit" name="selcountry" value="Select Country" class="btn btn-primary">
    </div>
    <?php
        if (isset($_POST['selcountry'])){
            $countryId = $_POST['countryid'];
            $result = mysql_query("select * from cities where countryId = $countryId ORDER by cityName");

    ?>
    <div class="form-inline" style="width: auto; display: inline-block">
        <select name="cityId" class="form-control">
            <option value="0" disabled selected>Select city...</option>
            <?php while($row = mysql_fetch_array($result, MYSQL_ASSOC)):?>
                <option value="<?=$row['id']?>"><?=$row['cityName']?></option>
            <?php endwhile; ?>
        </select>
        <input type="submit" name="selcity" value="Select City" class="btn btn-primary">
    </div>
    <?php }?>

    <?php
        if(isset($_POST['selcity'])){
            $cityId = $_POST['cityId'];
            $sel = "select co.countryName, ci.cityName, ho.hotelName, ho.cost, ho.stars, ho.id from hotels ho, cities ci, countries co where ho.cityId=$cityId and ho.countryId = co.id and ho.cityId = ci.id";
            $resu = mysql_query($sel);
    ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>Hotel</td>
                        <td>Country</td>
                        <td>City</td>
                        <td>Price</td>
                        <td>Stars</td>
                        <td>Link</td>
                    </tr>
                </thead>
                <?php while($row=mysql_fetch_array($resu, MYSQL_ASSOC)):?>
                    <tr>
                        <td><?=$row['hotelName']?></td>
                        <td><?=$row['countryName']?></td>
                        <td><?=$row['cityName']?></td>
                        <td><?=$row['cost']?></td>
                        <td><?=$row['stars']?></td>
                        <td><a href="index.php?hotel=<?=$row['id']?>" target="_blank">More info</a></td>
                    </tr>
                <?php endwhile;?>
            </table>
    <?php }?>

</form>
