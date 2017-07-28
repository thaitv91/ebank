<?php
function total_user_survey($survey_id)
{
	$query = mysql_query("select * from survey where survey_id = '$survey_id' ");
	$num = mysql_num_rows($query);
	return $num;
}