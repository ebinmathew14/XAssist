<?php
include('../connection.php');
include('header.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Department Details</title>
</head>
<?php


if(isset($_GET['did']))
{
	$did=$_GET['did'];
	mysql_query("delete from tbl_department where dept_id=$did",$con);
		echo "<meta http-equiv='refresh' content='0;URL=DepartmentDetails.php'>";
}
$eid="";
if(isset($_GET['eid']))
{
	$eid=$_GET['eid'];
	$rowup=mysql_fetch_array(mysql_query("select * from tbl_department where dept_id=$eid",$con));
	$dnameup=$rowup['dept_name'];
	$dcodeup=$rowup['dept_code'];
		
}



if(isset($_POST['save']))
	{
			$deptname=$_POST['deptname'];
			$deptcode=$_POST['deptcode'];
					
	if(is_numeric($deptname)||is_numeric($deptcode))
	echo '<script> alert("Please enter a valid Department Name")</script>';
		else	
		{
		if($deptname==""||$deptcode=="")
		{
			echo '<script> alert("Please enter all details")</script>';
		}
		else
		{
			if($eid!="")
			{
					$upqry="update tbl_department set dept_name='$deptname',dept_code='$deptcode' where dept_id='$eid'";
					mysql_query($upqry,$con);
							
			}
			else
			{
				if(mysql_num_rows(mysql_query("select * from tbl_department where dept_name='$deptname'",$con))!=0)
						{
							echo '<script>alert("Entry Already Exists");</script>';
						}
						else
						{
				$insqry="insert into tbl_department(dept_name,dept_code) values('$deptname','$deptcode')";
				mysql_query($insqry,$con);
						}
			
			}
		}
	}
	
		echo "<meta http-equiv='refresh' content='0;URL=DepartmentDetails.php'>";	
			
	}
?>
<body>
<form id="form1" name="form1" method="post" action="">
  <table width="421" border="0">
    <tr height="55">
    <div class="form-group">
      <td width="141">Department Name</td>
      <td width="229">
      <input type="text" name="deptname" id="deptname" required="required" class="form-control" value="<?php if($eid!="") echo $dnameup;?>"/></td>
      <td width="250" align="justify"><i>(*Please Enter Department Name. Eg:Civil Engineering)</i></td>
      
    </div>
    </tr>
    <tr height="55">
    <div class="form-group">
      <td>Department Code</td>
      <td>
      <input type="text" name="deptcode" id="deptcode" required="required" class="form-control" value="<?php if($eid!="") echo $dcodeup;?>"/></td>
      <td width="250" align="justify"><i>(*Please Enter Department code. Eg: CS)</i></td>
    </div>
    </tr>
    <tr height="55">
    <td></td>
      <td align="left"><input type="submit" name="save" id="save" value="Save" class="btn btn-primary" />
           <input type="reset" name="cancel" id="cancel" value="Cancel" class="btn btn-danger" onclick="window.location='http://localhost/eaa/Admin/DepartmentDetails.php';return false;" /></td>
    </tr>
  </table>
</form>


<table border="1" class="table">
<tr>
<th align="center" width="100">Department Name</th>
<th align="center" width="100">Department Code</th>
</tr>
<tr>

<?php 
$sel="select * from tbl_department";
$selq=mysql_query($sel,$con);
while($row=mysql_fetch_array($selq)){
	
?>
<td align="center" width="100"><?php echo $row['dept_name'];?></td>
<td align="center" width="100"><?php echo $row['dept_code'];?></td>
<div class="form-group">
<td width="30"><a href="DepartmentDetails.php?eid=<?php echo $row['dept_id'];?>">Edit</a></td>
<td width="30"><a href="DepartmentDetails.php?did=<?php echo $row['dept_id'];?>">Delete</a></td>
</div>
</tr>
<?php }?>
</table>


</body>
</html>
<?php
include('footer.php');
?>