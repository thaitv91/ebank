<?php
function get_total_paid_unpaid_members($users)
{
	$paid = 0;
	$unpaid = 0;
	$t_invst = 0;
	$cnt = count($users);
	for($i = 0; $i < $cnt; $i++)
	{
		if($users[$i][0] != 0)
		{
			$u_id = $users[$i][0];
			$q = mysql_query("select * from reg_fees_structure where user_id = '$u_id' ");	
			$num = mysql_num_rows($q);
			if($num > 0)
			{
				while($row = mysql_fetch_array($q))
				{
					if($row['update_fees'] > 0)
					{
						$t_invst = $t_invst+$row['reg_fees']+$row['update_fees']; 
						$paid++;
					}
					else
						$unpaid++;		
				}
			}
			else
			{	
				$unpaid++;
			}
		}	
	}
	$result[0] = $paid;
	$result[1] = $unpaid;
	$result[2] = $t_invst;
	return $result;
}				
	
	
