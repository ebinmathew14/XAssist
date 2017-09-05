<?php
 include("../connection.php");
 include("header.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Syllabus Details</title>
</head>
<?php
if(isset($_GET['did']))
{
	$did=$_GET['did'];
	mysql_query("delete from tbl_syllabus where sy_id=$did",$con);
	echo "<meta http-equiv='refresh' content='0;URL=SyllabusDetails.php'>";
}
$eid="";
if(isset($_GET['eid']))
{
	$eid=$_GET['eid'];
	$rowup=mysql_fetch_array(mysql_query("select * from tbl_syllabus where sy_id=$eid",$con));
	$updep=$rowup['dept_id'];
	$upsem=$rowup['sem_id'];
	$upsub=$rowup['sub_id'];	
}

	if(isset($_POST['save']))
	{
			$dept_id=$_POST['dept_name'];
			$sem_id=$_POST['sem_name'];
			$sub_id=$_POST['sub_name'];
			if($dept_id==""||$sem_id==""||$sub_id=="")
			{
			echo '<script> alert("Please enter all details")</script>';
			}
			else
			{
				
				if($eid!="")
					{
					$upqry="update tbl_syllabus set dept_id='$dept_id', sem_id='$sem_id', sub_id='$sub_id' where sy_id='$eid'";
					mysql_query($upqry,$con);
							
					}
					else
					{
						if(mysql_num_rows(mysql_query("select * from tbl_syllabus where dept_id='$dept_id' and sem_id='$sem_id' and sub_id='$sub_id'",$con))!=0)
						{
							echo '<script>alert("Entry Already Exists");</script>';
						}
						else
						{
			$insqry="insert into tbl_syllabus(dept_id,sem_id,sub_id) values('$dept_id','$sem_id','$sub_id')";
			mysql_query($insqry,$con);
						}
					}
			}
			echo "<meta http-equiv='refresh' content='0;URL=SyllabusDetails.php'>";
	}
?>
<body>
<form id="form1" name="form1" method="post" action="">
  <table width="389" border="0">
    <tr height="55">
    <div class="form-group">
      <td width="138">Department Name</td>
      <td width="235">
        <select name="dept_name" id="dept_name" class="form-control">
        <option value="">--Select Department--</option>
        <?php
		   $selQry="select * from tbl_department";
		   $sel=mysql_query($selQry,$con);
		   while($row=mysql_fetch_array($sel))
		   {
			   ?>
               <option value="<?php echo $row['dept_id'];?>" <?php if($eid!="" && $row['dept_id']==$updep) echo 'selected="selected"';?> ><?php echo $row['dept_name'];?></option>
		<?php	   
		   }
		?>
      </select></td>
      </div>
    </tr>
    <tr height="55">
    <div class="form-group">
      <td>Semester</td>
      <td>
        <select name="sem_name" id="sem_name" class="form-control">
      <option value="">--Select Semester--</option>
        <?php
		   $selQry="select * from tbl_semester";
		   $sel=mysql_query($selQry,$con);
		   while($row=mysql_fetch_array($sel))
		   {
			   ?>
               <option value="<?php echo $row['sem_id'];?>" <?php if($eid!="" && $row['sem_id']==$upsem) echo 'selected="selected"';?>><?php echo $row['sem_name'];?></option>
		<?php	   
		   }
		?>
      </select></td>
    </div>
    </tr>
    <tr height="55">
    <div class="form-group">
      <td>Subject</td>
      <td>
        <select name="sub_name" id="sub_name" class="form-control">
        <option value="">--Select Subject--</option>
        <?php
		   $selQry="select * from tbl_subject";
		   $sel=mysql_query($selQry,$con);
		   while($row=mysql_fetch_array($sel))
		   {
			   ?>
               <option value="<?php echo $row['sub_id'];?>" <?php if($eid!="" && $row['sub_id']==$upsub) echo 'selected="selected"';?>><?php echo $row['sub_code'].' - '.$row['sub_name'];?></option>
		<?php	   
		   }
		?>
      </select></td>
    </div>
    </tr>
    <tr height="55">
    <td></td>
      <td align="left"><input type="submit" name="save" id="save" value="Save" class="btn btn-primary" />
      <input type="reset" name="cancel" id="cancel" value="Cancel" class="btn btn-danger" onclick="window.location='http://localhost/eaa/Admin/SyllabusDetails.php';return false;"/></td>
    </tr>
  </table>
</form>
<div class="table">
<table border="1">
<tr>
<td align="center"><strong>Semester</strong></td>
<td align="center"><strong>Department</strong></td>
<td align="center"><strong>Subject Name</strong></td>
<td align="center"><strong>Subject Code</strong></td>
</tr>

<?php
	$sel=mysql_query("select * from tbl_syllabus",$con);
	while($row=mysql_fetch_array($sel))
	{
		?>
        <tr>
        <td align="center"><?php $semid=$row['sem_id'];
		$row1=mysql_fetch_array(mysql_query("select * from tbl_semester where sem_id=$semid",$con));
		echo $row1['sem_name'];
		?></td>
        <td align="center"><?php $depid=$row['dept_id'];
		$row1=mysql_fetch_array(mysql_query("select * from tbl_department where dept_id=$depid",$con));
		echo $row1['dept_code'];
		?></td>
        
        <td align="justify"><?php $subid=$row['sub_id'];
		$row1=mysql_fetch_array(mysql_query("select * from tbl_subject where sub_id=$subid",$con));
		echo $row1['sub_name'];
		?></td>
        <td align="center"><?php echo $row1['sub_code'];?></td>
        <td align="center" width="40"><a href="SyllabusDetails.php?eid=<?php echo $row['sy_id'];?>">Edit</a></td>
<td align="center" width="50"><a href="SyllabusDetails.php?did=<?php echo $row['sy_id'];?>">Delete</a></td>
        </tr>
        <?php
	}
?>
</table>
</div>
</body>
</html>
<?php
include("footer.php");
?>