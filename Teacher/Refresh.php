<?php
include('../connection.php');
session_start();
$desgid=$_SESSION['desgid'];
$i=0;
$did=array();
$selduty=mysql_query("select distinct(did) from tbl_duty where duty_id in (select duty_id from tbl_dutyassign where desg_id=$desgid and duty_count!=0)",$con);
while($rowduty=mysql_fetch_array($selduty))
{
	$dateid=$rowduty['did'];
	$did[$i]=$dateid;
	$i=$i+1;
}
foreach($did as $ddid)
{
	$sel1=mysql_query("select * from tbl_duty where did=$ddid and duty_id in (select duty_id from tbl_dutyassign where desg_id=$desgid and duty_count!=0)",$con);
	while($row=mysql_fetch_array($sel1))
	{
		$duid=$row['duty_id'];
		$sel3=mysql_query("select * from tbl_dutyassign where duty_id=$duid and desg_id=$desgid",$con);
		$row3=mysql_fetch_array($sel3);
		$c=mysql_num_rows($sel1);
		if($c<2 && $row["sess_id"]==2)
		{
			echo '
          <td width="20"></td>
          ';
		}
		if($row["sess_id"]==1)
		{
			echo '
          <td width="20" ><input type="text" id="count" name="count" value="'.$row3["duty_count"].'" readonly="readonly" style="width:20px;" />
            </td>';
         }
		if($row["sess_id"]==2)
		{
			echo '
          <td width="20"><input type="text" id="count" name="count" value="'.$row3["duty_count"].'" readonly="readonly" style="width:20px;"/>
            </td>';
          
		}
        if($c<2 && $row["sess_id"]==1)
		{
			echo '
          <td width="20"></td>
          ';
		}
	}
}
?>