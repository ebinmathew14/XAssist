<?php
include('../connection.php');
include('header.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Subject Details</title>
</head>
<?php

	if(isset($_GET['did']))
	{
	$did=$_GET['did'];
	mysql_query("delete from tbl_subject where sub_id=$did",$con);
		echo "<meta http-equiv='refresh' content='0;URL=StaffDetails.php'>";
	}
$eid="";
if(isset($_GET['eid']))
{
	$eid=$_GET['eid'];
	$rowup=mysql_fetch_array(mysql_query("select * from tbl_subject where sub_id=$eid",$con));
	$subnameup=$rowup['sub_name'];
	$subcodeup=$rowup['sub_code'];
	
}






	if(isset($_POST['save']))
	{
			$subname=$_POST['subname'];
			$subcode=$_POST['subcode'];
			
			if(is_numeric($subname)||is_numeric($subcode))
			echo '<script> alert("Please enter a valid Subject Details")</script>';
			else	
			{
				if($subname==""||$subcode=="")
				{
				echo '<script> alert("Please enter Subject Details")</script>';
				}
				else
				{
					if($eid!="")
					{
					$upqry="update tbl_subject set sub_name='$subname',sub_code='$subcode' where sub_id='$eid'";
					mysql_query($upqry,$con);
							
					}
					else
					{
						if(mysql_num_rows(mysql_query("select * from tbl_subject where sub_name='$subname'",$con))==0)
						{
							echo '<script>alert("Entry Already Exists");</script>';
						}
						else
						{
						$insqry="insert into tbl_subject(sub_name,sub_code) values('$subname','$subcode')";
						mysql_query($insqry,$con);
						}
					}
				}
			}
					echo "<meta http-equiv='refresh' content='0;URL=SubjectDetails.php'>";
	}
?>
<body>
<form id="form1" name="form1" method="post" action="">
  <table width="550" border="0">
    <tr height="55">
    <div class="form-group">
      <td width="100">Subject Name</td>
      <td width="200">
      <input type="text" name="subname" id="subname" required="required" class="form-control"  value="<?php if($eid!="") echo $subnameup;?>"/></td>
       <td width="250" align="justify"><i>(*Please Enter Subject Name. Eg:Calculus)</i></td>

    </div>
    </tr>
    <tr height="55">
    <div class="form-group">
      <td width="100">Subject Code</td>
      <td width="200">
      <input type="text" name="subcode" id="subcode" required="required" class="form-control" value="<?php if($eid!="") echo $subcodeup;?>"/></td>
       <td width="250" align="justify"><i>(*Please Enter Subcode. Eg: MA101 if Calculus)</i></td>

    </div>
    </tr>
    <tr height="55">
    <td width="100"></td>
      <td width="200" align="left">          
       <input type="submit" name="save" id="save" value="Save" class="btn btn-primary" />
      <input type="reset" name="cancel" id="cancel" value="Cancel" class="btn btn-danger" onclick="window.location='http://localhost/eaa/Admin/SubjectDetails.php';return false;" /></td>
    </tr>
    <td width="250"></td>
  </table>
  
</form>

<table border="1" class="table">
<tr>
<th align="center" width="100">Subject Code</th>
<th align="center" width="100">Subject Name</th>
</tr>
<tr>

<?php 
$sel="select * from tbl_subject";
$selq=mysql_query($sel,$con);
while($row=mysql_fetch_array($selq)){
	
?>
<td align="center" width="100"><?php echo $row['sub_code'];?></td>
<td align="center" width="100"><?php echo $row['sub_name'];?></td>
<div class="form-group">
<td width="30"><a href="SubjectDetails.php?eid=<?php echo $row['sub_id'];?>">Edit</a></td>
<td width="30"><a href="SubjectDetails.php?did=<?php echo $row['sub_id'];?>">Delete</a></td>
</div>
</tr>
<?php }?>
</table>



</body>
</html>
<?php
include('footer.php');
?>