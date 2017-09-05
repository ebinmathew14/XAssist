<?php
include('../connection.php');
include('header.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Classroom Details</title>
</head>


<?php
if(isset($_GET['did']))
{
	$did=$_GET['did'];
	mysql_query("delete from tbl_class where cid=$did",$con);
		echo "<meta http-equiv='refresh' content='0;URL=ClassDetails.php'>";
}
$eid="";
if(isset($_GET['eid']))
{
	$eid=$_GET['eid'];
	$rowup=mysql_fetch_array(mysql_query("select * from tbl_class where cid=$eid",$con));
	$cnoup=$rowup['classno'];
	$capup=$rowup['capacity'];
		
}




if(isset($_POST['save']))
{
	$classno=$_POST['classno'];
	$capacity=$_POST['capacity'];
			
	if(!is_numeric($capacity))
		echo '<script> alert("Please enter a valid Capacity")</script>';
	else	
	{
		if($classno==""||$capacity=="")
		{
			echo '<script> alert("Please enter all details")</script>';
		}
		else
		{
			if($eid!="")
			{
					$upqry="update tbl_class set classno='$classno',capacity='$capacity' where cid='$eid'";
					mysql_query($upqry,$con);
							
			}
			else
			{	if(mysql_num_rows(mysql_query("select * from tbl_class where classno='$classno'",$con))!=0)
						{
							echo '<script>alert("Entry Already Exists");</script>';
						}
						else
						{
				$insqry="insert into tbl_class(classno,capacity) values('$classno','$capacity')";
				mysql_query($insqry,$con);
						}
			}
		}
	}
	echo "<meta http-equiv='refresh' content='0;URL=ClassDetails.php'>";
					
}
?>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="362" border="0">
    
    <tr height="55">
    <div class="form-group">
      <td width="123">Class No</td>
      <td width="223">
      <input type="text" name="classno" id="classno" required="required" class="form-control" value="<?php if($eid!="") echo $cnoup;?>" /></td>
      <td width="250" align="justify"><i>(*Please enter Classno. Eg: L201)</i></td>
    </div>
    </tr>
    
    
    
    <tr height="55">
    <div class="form-group">
      <td>Capacity</td>
      <td>
      <input type="text" name="capacity" id="capacity" required="required" class="form-control" value="<?php if($eid!="") echo $capup;?>"/></td>
     <!--<td width="250" align="justify"><i>(*Please enter Capacity . Eg: 60)</i></td>-->
    </div>
    
    </tr>
    
    
    <tr height="55">
      <td></td>
      <td align="left"><input type="submit" name="save" id="save" value="Save" class="btn btn-primary" />
      <input type="reset" name="cancel" id="cancel" value="Cancel" class="btn btn-danger" onclick="window.location='http://localhost/eaa/Admin/ClassDetails.php';return false;"/></td>
    </tr>
  </table>
</form>


<table border="1" class="table">
<tr>
<th align="center" width="100">Class No </th>
<th align="center" width="100">Capacity</th>
</tr>
<tr>
<?php 
$sel="select * from tbl_class";
$selq=mysql_query($sel,$con);
while($row=mysql_fetch_array($selq)){
	
?>
<td align="center" width="100"><?php echo $row['classno'];?></td>
<td align="center" width="100"><?php echo $row['capacity'];?></td>
<div class="form-group">
<td width="30"><a href="ClassDetails.php?eid=<?php echo $row['cid'];?>">Edit</a></td>
<td width="30"><a href="ClassDetails.php?did=<?php echo $row['cid'];?>">Delete</a></td>
</div>
</tr>
<?php }?>
</table>



</body>
</html>
<?php
include('footer.php');
?>