<?php
 include("../connection.php");
 include('header.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Student Details</title>
</head>
<?php
if(isset($_GET['did']))
{
	$did=$_GET['did'];
	mysql_query("delete from tbl_studentdetails where st_id=$did",$con);
	echo "<meta http-equiv='refresh' content='0;URL=StudentDetails.php'>";
}
$eid="";
if(isset($_GET['eid']))
{
	$eid=$_GET['eid'];
	$rowup=mysql_fetch_array(mysql_query("select * from tbl_studentdetails where st_id=$eid",$con));
	$upregno=$rowup['st_regno'];
	$upname=$rowup['st_name'];
		
}



	if(isset($_POST['save']))
	{
			$regno=$_POST['regno'];
			$sname=$_POST['sname'];
			$batch=$_POST['batch'];
			$dept=$_POST['dept'];
			if($regno==""||$dept==""||$batch==""||$sname="")
			{
			echo '<script> alert("Please enter all details")</script>';
			}
			else
			{
				if($eid!="")
					{
					$upqry="update tbl_studentdetails set st_name='$sname', batch_id='$batch', dept_id='$dept' where st_id='$eid'";
					mysql_query($upqry,$con);
							
					}
					else
					{
				if(mysql_num_rows(mysql_query("select * from tbl_studentdetails where st_regno='$regno'",$con))!=0)
						{
							echo '<script>alert("Entry Already Exists");</script>';
						}
						else
						{
			$insqry="insert into tbl_studentdetails(st_regno,st_name,batch_id,dept_id) values('$regno','$sname','$batch','$dept')";
			mysql_query($insqry,$con);
						}
					}
			}
			
			echo "<meta http-equiv='refresh' content='0;URL=StudentDetails.php'>";
	}
?>
<body>
<form id="form1" name="form1" method="post" action="">

  <table width="479" border="0">
    <tr height="55">
    <div class="form-group">
      <td width="185">Student Reg No.</td>
      <td width="284">
      
      <input type="text" name="regno" id="regno" required="required" class="form-control" value="<?php if($eid!="") echo $upregno;?>" <?php if($eid!="") echo 'disabled="disabled"';?> /></td>
      </div>
    </tr>
    <tr height="55">
    <div class="form-group">
    
      <td>Student Name</td>
      <td>
      <input type="text" name="sname" id="sname" required="required" class="form-control" value="<?php if($eid!="") echo $upname;?>" /></td>
      </div>
    </tr>
    <tr height="55">
    <div class="form-group">
      <td>Student Batch</td>
      <td>
        <select name="batch" id="batch" class="form-control">
      <option value="">--Select Batch--</option>
        <?php
		   $selQry="select * from tbl_batch";
		   $sel=mysql_query($selQry,$con);
		   while($row=mysql_fetch_array($sel))
		   {
			   ?>
               <option value="<?php echo $row['batch_id'];?>"><?php echo $row['batch'];?></option>
		<?php	   
		   }
		?>
      </select></td></div>
    </tr>
    <tr height="55"><div class="form-group">
      <td>Student Department</td>
      <td>
        <select name="dept" id="dept" class="form-control">
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
      </select></td></div>
    </tr>
    <tr><div class="form-group">
    <td>&nbsp;</td>
      <td align="left"><input type="submit" name="save" id="save" value="Save" class="btn btn-primary" />
      <input type="reset" name="cancel" id="cancel" value="Cancel" class="btn btn-danger" /></td>
    </tr></div>
  </table>
  </div>
</form>
<div class="table">
<table border="1">
<tr>
<th>Regno</th>
<th>Name</th>
<th>Department</th>
<th>Batch</th>
</tr>
<?php
	$sel=mysql_query("select * from tbl_studentdetails");
	while($row=mysql_fetch_array($sel))
	{
		?>
<tr>		
<td width="100"><?php echo $row['st_regno'];?></td>
<td width="250"><?php echo $row['st_name'];?></td>
<td width="100" align="center"><?php $dept1=$row['dept_id'];
		$row1=mysql_fetch_array(mysql_query("select * from tbl_department where dept_id=$dept1",$con));
		echo $row1['dept_code'];?></td>
<td width="100"><?php $bat=$row['batch_id'];
		$row2=mysql_fetch_array(mysql_query("select * from tbl_batch where batch_id=$bat",$con));
		echo $row2['batch'];?></td>
<td align="center" width="40"><a href="StudentDetails.php?eid=<?php echo $row['st_id'];?>">Edit</a></td>
<td align="center" width="50"><a href="StudentDetails.php?did=<?php echo $row['st_id'];?>">Delete</a></td>
</tr>
<?php
	}
	?>
    </table>
    </div>
</body>
</html>
<?php
include('footer.php');
?>