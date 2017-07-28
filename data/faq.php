<?php
$sqli = "select * from faqs";

$query = mysql_query($sqli);

$num = mysql_num_rows($query);

if ($num > 0)
{
    ?>
    <div class="box box-primary" style="padding: 15px"> 
        <div class="row">

            <?php
            $x = 0;

            while ($row = mysql_fetch_array($query))
            {
                $x++;

                $id = $row['id'];

                $question = $row['question'];

                $answer = $row['answer'];
                ?>
                <div class="col-sm-6">
                    <div class="well" style=" background-color: #FFF; padding: 6px 12px">
                        <h4 style="color: #3c8dbc"><?= $x ?>. <?= $question ?> <a href="javascript:void(0)" onClick="show_hide('img<?= $id; ?>');"><img src="images/plus.png" id="img<?= $id; ?>" class="pull-right"></a></h4>
                        <p id="<?= $id ?>" style="display: none"><?= $answer ?></p>
                    </div>
                </div>
                <?php
            }
        }
        else
        {
            print "<B style=\"color:#FF0000; font-size:12pt;\">There are no information to show !!</b>";
        }
        ?>

    </div>
</div>



<script type="text/javascript">

    function show_hide(id)

    {



        var CurrentRowClick = id.replace("img", "");



        if (document.getElementById(CurrentRowClick).style.display == "none")

        {

            document.getElementById(CurrentRowClick).style.display = "";

            document.getElementById("img" + CurrentRowClick).src = "images/minus.png";

        } else

        {

            document.getElementById(CurrentRowClick).style.display = "none";

            document.getElementById("img" + CurrentRowClick).src = "images/plus.png";

        }



        if (document.getElementById("prv_open").value != CurrentRowClick)

        {

            hide_prv_row(document.getElementById("prv_open").value);

        }

        document.getElementById("prv_open").value = CurrentRowClick;



    }

</script>