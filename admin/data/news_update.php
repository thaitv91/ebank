<?php
$id = $_GET['id'];
$array = mysql_fetch_array(mysql_query("select * from news where id='$id'"));
if (isset($_POST['submit']))
{
    $title = $_POST['title'];
    $news = $_POST['news'];
    if ($title != "" and $news != "")
    { 
        mysql_query("UPDATE news SET title='$title',news='$news' WHERE id='$id'");
        echo "<script type=\"text/javascript\">";
        echo "window.location = \"index.php?page=news_list\"";
        echo "</script>";
    }
    else
    {
        echo $error = "Some Field Is blank";
    }
}

?>
<table class="table table-bordered">
    <form name="message" action="index.php?page=news_update&id=<?=$id?>" method="post">
        <tr>
            <th>Title</th>
            <td><input type="text" style="width:370px;" name="title" value="<?= $array['title'] ?>" /></td>
        </tr>
        <tr>
            <th>News</th>
            <td><textarea name="news" cols="50" rows="5" class="text-editor"><?= $array['news'] ?></textarea></td>
        </tr>
        <tr>
            <td colspan="2" class="text-center">
                <input type="submit" name="submit" value="Submit" class="btn btn-info"/>
            </td>
        </tr>
    </form>
</table>


