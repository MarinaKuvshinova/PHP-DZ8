<h3>Comments</h3>
<?php connect()?>
<?php
$res = mysql_query('select * from hotels order by hotelName');
if(isset($_POST['commentHotel'])){
    $userName=trim(htmlspecialchars($_POST['userName']));
    $commentText=trim(htmlspecialchars($_POST['textComment']));
    $hotelId = $_POST['hotelId'];
    if (empty($userName)||empty($commentText))
    {
        echo "FUCK ASS!!!!";
        return false;
    }
    $insert = "insert into comments (userName, hotelId,textComments) VALUES ('$userName', $hotelId, '$commentText')";
    mysql_query($insert);
    $error = mysql_errno();
    if ($error)
    {
        echo "$error Не работает!!!!";
        return false;
    }
}
?>
<form action="index.php?page=2" method="post">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" name="userName">
    </div>
    <div class="form-group">
        <label for="name">Select Hotel:</label>
        <select name="hotelId" class="form-control">
            <option value="0" disabled selected>Select hotel...</option>
            <?php while($row=mysql_fetch_array($res, MYSQL_ASSOC)):?>
                <option value="<?=$row['id']?>"><?=$row['hotelName']?></option>
            <?php endwhile;?>
        </select>
    </div>
    <div class="form-group">
        <label for="textComment">Text comments:</label>
        <textarea class="form-control" name="textComment" style="height: 100px" cols="30" rows="10"></textarea>
    </div>
    <input type="submit" name="commentHotel" value="Send" class="btn btn-primary">
</form>