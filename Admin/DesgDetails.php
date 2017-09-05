<?php
include('../connection.php');
include('header.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Designation Details</title>
</head>
<?php


if(isset($_GET['did']))
{
	$did=$_GET['did'];
	mysql_query("delete from tbl_designation where desg_id=$did",$con);
		echo "<meta http-equiv='refresh' content='0;URL=DesgDetails.php'>";
}
$eid="";
if(isset($_GET['eid']))
{
	$eid=$_GET['eid'];
	$rowup=mysql_fetch_array(mysql_query("select * from tbl_designation where desg_id=$eid",$con));
	$desnameup=$rowup['desg_name'];
	//$desdutyup=$rowup['desg_duty'];
		
}





	if(isset($_POST['save']))
	{
			$desgname=$_POST['desg_name'];
						
			if(is_numeric($desgname))
				echo '<script> alert("Please enter valid Designation Details")</script>';
			else	
			{
				if($desgname=="")
				{
					echo '<script> alert("Please enter all details")</script>';
				}
				else
				{
					if($eid!="")
					{
						$upqry="update tbl_designation set desg_name='$desgname' where desg_id='$eid'";
						mysql_query($upqry,$con);
							
					}
					else
					{
						if(mysql_num_rows(mysql_query("select * from tbl_designation where desg_name='$desgname'",$con))!=0)
						{
							echo '<script>alert("Entry Already Exists");</script>';
						}
						else
						{
						$insqry="insert into tbl_designation(desg_name) values('$desgname')";
						mysql_query($insqry,$con);
						}
					}
				}
			}
echo "<meta http-equiv='refresh' content='0;URL=DesgDetails.php'>";
			
			
	}
?>
<body>
<form id="form1" name="form1" method="post" action="">
  <table width="381" border="0">
    <tr height="55">
    <div class="form-group">
      <td width="131">Designation Name</td>
      <td width="226">
      <input type="text" name="desg_name" id="desg_name" class="form-control" value="<?php if($eid!="") echo $desnameup;?>" />
      </td></td>
      <td width="250" align="justify"><i>(*Eg: Professor)</i></td>
      </div>
    </tr>
    <!--<tr height="55">
    <div class="form-group">
      <td>Duty Count(in %)</td>
      <td>
      <input type="text" name="duty_count" id="duty_count" class="form-control" value="<?php if($eid!="") echo $desdutyup;?>"/>
      </td>
      <td width="250" align="justify"><i>(*Calculated automatically based on available staffs)</i></td>
    </div>
    </tr>-->
    <tr height="55">
    <td></td>
      <td align="left"><input type="submit" name="save" id="save" value="Save" class="btn btn-primary" /> 
      <input type="reset" name="cancel" id="cancel" value="Cancel" class="btn btn-danger" onclick="window.location='http://localhost/eaa/Admin/DesgDetails.php';return false;" /></td>
    </tr>
  </table>
</form>


<table border="1" class="table">
<tr>
<td align="center" width="100"><strong>Designation Name</strong> </td>
<!--<th align="center" width="100">Duty Count(%)</th>-->
</tr>

<?php 
$sel="select * from tbl_designation";
$selq=mysql_query($sel,$con);
while($row=mysql_fetch_array($selq)){
	
?>
<tr>
<td align="center" width="100"><?php echo $row['desg_name'];?></td>
<!--
<td align="center" width="100"><?php //echo $row['desg_duty'];?>%</td>-->
<div class="form-group">
<td width="30"><a href="DesgDetails.php?eid=<?php echo $row['desg_id'];?>">Edit</a></td>
<td width="30"><a href="DesgDetails.php?did=<?php echo $row['desg_id'];?>">Delete</a></td>
</div>
</tr>
<?php }?>
</table>


</body>
</html>
<?php include('footer.php');?>