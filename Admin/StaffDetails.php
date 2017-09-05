<?php
 include("../connection.php");
include('header.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Staff Details</title>
</head>
<?php
if(isset($_GET['did']))
{
	$did=$_GET['did'];
	mysql_query("delete from tbl_staff where staff_id=$did",$con);
	echo "<meta http-equiv='refresh' content='0;URL=StaffDetails.php'>";
}
$eid="";
if(isset($_GET['eid']))
{
	$eid=$_GET['eid'];
	$rowup=mysql_fetch_array(mysql_query("select * from tbl_staff where staff_id=$eid",$con));
	$fcid=$rowup['staff_facid'];
	$stname=$rowup['staff_name'];
	$stemail=$rowup['staff_email'];
	$stpass=$rowup['staff_pwd'];
		
}
	if(isset($_POST['save']))
	{
			$staff_name=$_POST['staff_name'];
			$staff_facid=$_POST['staff_facid'];
			$staff_email=$_POST['staff_email'];
			$staff_dept=$_POST['staff_dept'];
			$staff_desg=$_POST['staff_desg'];
			$staff_pwd=$_POST['staff_pwd'];
			
			
			if(is_numeric($staff_name))
			echo '<script> alert("Please enter a valid  StaffName")</script>';
			else	
			{
				if($staff_name==""||$staff_facid==""||$staff_dept==""||$staff_desg=="")
				{
				echo '<script> alert("Please enter all details")</script>';
				}
			else
				{
					if($eid!="")
					{
					$upqry="update tbl_staff set staff_name='$staff_name', staff_email='$staff_email', dept_id='$staff_dept', desg_id='$staff_desg', staff_pwd='$staff_pwd' where staff_id='$eid'";
					mysql_query($upqry,$con);
							
					}
					else
					{
					if(mysql_num_rows(mysql_query("select * from tbl_staff where staff_facid='$staff_facid'",$con))!=0)
						{
							echo '<script>alert("Entry Already Exists");</script>';
						}
						else
						{
				$insqry="insert into tbl_staff(staff_name,staff_email,dept_id,desg_id,staff_facid,staff_pwd,staff_confstatus) values('$staff_name','$staff_email','$staff_dept','$staff_desg','$staff_facid','$staff_pwd',2)";
			mysql_query($insqry,$con);
						}
					}
				}
			}
					
			echo "<meta http-equiv='refresh' content='0;URL=StaffDetails.php'>";
	}
?>
<body>
<form id="form1" name="form1" method="post" action="">
  <table width="450" border="0">
    <tr height="55">
    <div class="form-group">
      <td width="170">Faculty Name</td>
      <td width="270">
      <input type="text" name="staff_name" id="staff_name" required="required" class="form-control" value="<?php if($eid!="") echo $stname;?>"/></td>
    </div>
    </tr>
    <tr height="55">
    <div class="form-group">
      <td>Faculty ID</td>
      <td>
      <input type="text" name="staff_facid" id="staff_facid" required="required" class="form-control" value="<?php if($eid!="") echo $fcid;?>" <?php if($eid!="") echo 'disabled="disabled"';?> /></td>
    </div>
    </tr>
    <tr height="55">
    <div class="form-group">
      <td>Faculty Email</td>
      <td>
      <input type="email" name="staff_email" id="staff_email" required="required" class="form-control" value="<?php if($eid!="") echo $stemail;?>" /></td>
    </div>
    </tr>
    <tr height="55">
    <div class="form-group">
      <td>Faculty Department</td>
      <td>
        <select name="staff_dept" id="staff_dept" class="form-control">
        <option value="">--Select Department--</option>
        <?php
		   $selQry="select * from tbl_department";
		   $sel=mysql_query($selQry,$con);
		   while($row=mysql_fetch_array($sel))
		   {
			   ?>
               <option value="<?php echo $row['dept_id'];?>"><?php echo $row['dept_name'];?></option>
		<?php	   
		   }
		?>
      </select></td>
    </div>
    </tr>
    <tr height="55">
    <div class="form-group">
      <td>Faculty Designation</td>
      <td>
        <select name="staff_desg" id="staff_desg" class="form-control">
        <option value="">--Select Designation--</option>
        <?php
		   $selQry="select * from tbl_designation";
		   $sel=mysql_query($selQry,$con);
		   while($row=mysql_fetch_array($sel))
		   {
			   ?>
               <option value="<?php echo $row['desg_id'];?>"><?php echo $row['desg_name'];?></option>
		<?php	   
		   }
		?>
      </select></td>
    </div>
    </tr>
    <tr height="55">
	<div class="form-group">
      <td>Password</td>
      <td>
      <input type="password" name="staff_pwd" id="staff_pwd" required="required" class="form-control" value="<?php if($eid!="") echo $stpass;?>"/></td>
    </div>
    </tr>
    <tr height="55">
    <div class="form-group">
    <td></td>
      <td align="left"><input type="submit" name="save" id="save" value="Save" class="btn btn-primary" />
      <input type="reset" name="cancel" id="cancel" value="Cancel" class="btn btn-danger"onclick="window.location='http://localhost/eaa/Admin/StaffDetails.php';return false;" /></td>
    </div>
    </tr>
  </table>
</form>

<div class="table">
<table border="1">
<tr height="50">
<td align="center" width="100"><strong>Faculty Id </strong></td>
<td align="center" width="250"><strong>Faculty Name</strong></td>
<td align="center" width="150"><strong>Designation</strong></td>
<td align="center" width="150"><strong>Department</strong></td>
<td align="center" width="150"><strong>Email ID</strong></td>

</tr>

<?php 
$sel="select * from tbl_staff";
$selq=mysql_query($sel,$con);
while($row=mysql_fetch_array($selq)){
	
?>
<tr>
<td align="justify" width="100"><?php echo $row['staff_facid'];?></td>
<td align="justify" width="250"><?php echo $row['staff_name'];?></td>
<td align="justify" width="150"><?php $deid=$row['desg_id']; $row1=mysql_fetch_array(mysql_query("select * from tbl_designation where desg_id=$deid",$con)); echo $row1['desg_name'];?></td>
<td align="center" width="70"><?php $depid=$row['dept_id']; $row1=mysql_fetch_array(mysql_query("select * from tbl_department where dept_id=$depid",$con)); echo $row1['dept_code'];?></td>
<td align="justify" width="250"><?php echo $row['staff_email'];?></td>
<td align="center" width="75"><?php echo $row['staff_pwd'];?></td>

<td align="center" width="40"><a href="StaffDetails.php?eid=<?php echo $row['staff_id'];?>">Edit</a></td>
<td align="center" width="50"><a href="StaffDetails.php?did=<?php echo $row['staff_id'];?>">Delete</a></td>
</tr>
<?php }?>
</table>
</div>



</body>
</html>
<?php
include('footer.php');
?>