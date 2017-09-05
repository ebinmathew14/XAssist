<?php
include('../connection.php');
include('header.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Semester Details</title>
</head>
<?php


	if(isset($_GET['did']))
	{
	$did=$_GET['did'];
	mysql_query("delete from tbl_semester where sem_id=$did",$con);
		echo "<meta http-equiv='refresh' content='0;URL=StaffDetails.php'>";
	}
$eid="";
if(isset($_GET['eid']))
{
	$eid=$_GET['eid'];
	$rowup=mysql_fetch_array(mysql_query("select * from tbl_semester where sem_id=$eid",$con));
	$semup=$rowup['sem_name'];
	
}





	if(isset($_POST['save']))
	{
			$semname=$_POST['semname'];
			
			if(is_numeric($semname))
			echo '<script> alert("Please enter a valid Semester Name")</script>';
			else	
			{
				if($semname=="")
				{
				echo '<script> alert("Please enter  Semester")</script>';
				}
				else
				{
					if($eid!="")
					{
					$upqry="update tbl_semester set sem_name='$semname' where sem_id='$eid'";
					mysql_query($upqry,$con);
							
					}
					else
					{
						if(mysql_num_rows(mysql_query("select * from tbl_semester where sem_name='$semname'",$con))!=0)
						{
							echo '<script>alert("Entry Already Exists");</script>';
						}
						else
						{
						$insqry="insert into tbl_semester(sem_name) values('$semname')";
						mysql_query($insqry,$con);
						}
					}
				}
			}
			echo "<meta http-equiv='refresh' content='0;URL=SemDetails.php'>";
}
?>
<body>
<form id="form1" name="form1" method="post" action="">
  <table width="346" border="0">
    <tr height="55">
    <div class="form-group">
      <td width="117">Semester Name</td>
      <td width="219">
      <input type="text" name="semname" id="semname" required="required" class="form-control" value="<?php if($eid!="") echo $semup;?>"/></td>
      <td width="250" align="justify"><i>(*Please enter Semester Name. Eg: S4)</i></td>
    </div>
    </tr>
    <tr>
      <td></td>
      <td align="left">    <input type="submit" name="save" id="save" value="Save" class="btn btn-primary" />
      <input type="reset" name="cancel" id="cancel" value="Cancel" class="btn btn-danger" onclick="window.location='http://localhost/eaa/Admin/SemDetails.php';return false;"/></td>
    </tr>
  </table>
  
  <table border="1" class="table">
<tr>
<th align="center" width="100">Semester Name</th>

</tr>
<tr>

<?php 
$sel="select * from tbl_semester";
$selq=mysql_query($sel,$con);
while($row=mysql_fetch_array($selq)){
	
?>
<td align="center" width="100"><?php echo $row['sem_name'];?></td>

<div class="form-group">
<td width="30"><a href="SemDetails.php?eid=<?php echo $row['sem_id'];?>">Edit</a></td>
<td width="30"><a href="SemDetails.php?did=<?php echo $row['sem_id'];?>">Delete</a></td>
</div>
</tr>
<?php }?>
</table>

  
</form>
</body>
</html>
<?php
include('footer.php');
?>