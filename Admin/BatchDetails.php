<?php
 include("../connection.php");
 include('header.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Batch Details</title>
<style>
.table
{
	width:250px;
}
</style>
</head>
<?php
if(isset($_GET['did']))
{
	$did=$_GET['did'];
	mysql_query("delete from tbl_batch where batch_id=$did",$con);
	//mysql_query("delete from tbl_students where batch_id=$did",$con);	
	echo "<meta http-equiv='refresh' content='0;URL=BatchDetails.php'>";
}
$eid="";
if(isset($_GET['eid']))
{
	$eid=$_GET['eid'];
	$rowup=mysql_fetch_array(mysql_query("select * from tbl_batch where batch_id=$eid",$con));
	$batup=$rowup['batch'];
	$semup=$rowup['sem_id'];
		
}


	if(isset($_POST['save']))
	{
			$batch=$_POST['batch'];
			$sem_id=$_POST['sem'];
			if(!is_numeric($batch))
				echo '<script> alert("Please enter a valid batch")</script>';
			else	
			{
				if($batch==""||$sem_id=="")
				{
					echo '<script> alert("Please enter all details")</script>';
				}
				else
				{
					if($eid!="")
					{
						$upqry="update tbl_batch set batch='$batch',sem_id='$sem_id' where batch_id='$eid'";
						mysql_query($upqry,$con);
							
					}
					else
					{
						if(mysql_num_rows(mysql_query("select * from tbl_batch where batch=$batch",$con))!=0)
						{
							echo '<script>alert("Entry Already Exists");</script>';
						}
						else
						{
							$insqry="insert into tbl_batch(batch,sem_id) values('$batch','$sem_id')";
							mysql_query($insqry,$con);
						}
					}
				}
			}
			echo "<meta http-equiv='refresh' content='0;URL=BatchDetails.php'>";
	}



?>
<body>

<form id="form1" name="form1" method="post" action="">
  <table width="500" border="0">
    <tr height="55">
    <div class="form-group">
      <td width="80">Batch</td>
      <td width="180">
      <input type="text" name="batch" id="batch" required="required" class="form-control" value="<?php if($eid!="") echo $batup;?>" /></td>
      <td width="250" align="justify"><i>(*Please enter passout year. Eg: 2017)</i></td>
    </div>
    </tr>
    <tr height="55">
    <div class="form-group">
      <td>Semester</td>
      <td>
        <select name="sem" id="sem" class="form-control">
        <option value="">--Select Semester--</option>
        <?php
		   $selQry="select * from tbl_semester";
		   $sel=mysql_query($selQry,$con);
		   while($row=mysql_fetch_array($sel))
		   {
			   ?>
               <option value="<?php echo $row['sem_id'];?>"><?php echo $row['sem_name'];?></option>
		<?php	   
		   }
		?>
      </select></td>
      <td width="250" align="justify"><i>(*Please enter current semester)</i></td>
    </div>
    </tr>
    <tr height="55">
    <td></td>
      <td align="left"><input type="submit" name="save" id="save" value="Save" class="btn btn-primary" />
      <input type="reset" name="cancel" id="cancel" value="Cancel" class="btn btn-danger" onclick="window.location='http://localhost/eaa/Admin/BatchDetails.php';return false;" /></td>
    </tr>
  </table>
  
  </form>


<table border="1" class="table">
<tr>
<th align="center" width="100">Batch </th>
<th align="center" width="100">Semester</th>
</tr>
<tr>
<?php 
$sel="select * from tbl_batch";
$selq=mysql_query($sel,$con);
while($row=mysql_fetch_array($selq)){
	
?>
<td align="center" width="100"><?php echo $row['batch'];?></td>
<td align="center" width="100">S<?php echo $row['sem_id'];?></td>
<div class="form-group">
<td width="30"><a href="BatchDetails.php?eid=<?php echo $row['batch_id'];?>">Edit</a></td>
<td width="30"><a href="BatchDetails.php?did=<?php echo $row['batch_id'];?>">Delete</a></td>
</div>
</tr>
<?php }?>
</table>

</body>
</html>
<?php
include('footer.php');
?>