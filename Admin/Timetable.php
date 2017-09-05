<?php
 include("../connection.php");
 include("header.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Timetable Entry</title>
</head>
<script>
function GetSubject(str)
{
	var str1 = document.getElementById("dept").value;
  	var xmlhttp;
	if (window.XMLHttpRequest)
  	{
 		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
  	xmlhttp.open("GET","AjaxSubject.php?sid="+str+"&did="+str1,true);
	xmlhttp.send();
   	xmlhttp.onreadystatechange=function() //readystate--1  send request  2---server recieved  3--processs 4 ---return
	{
  		if(xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
    		document.getElementById("sub").innerHTML=xmlhttp.responseText;
		}
  	}
}
</script>
<?php
/*$f=0;
$sessid="";
$deptid="";
$semid="";
$subid="";
if(isset($_GET['edit']))
{
$f=1;

        $id=$_GET['edit'];
		$selQry="select * from tbl_timetable where tid=$id";
		$sel=mysql_query($selQry,$con);
		$row=mysql_fetch_array($sel);
		$date=$row['date'];
		$sessid=$row['sess_id'];
		$deptid=$row['dept_id'];
		$semid=$row['sem_id'];
		$subid=$row['sub_id'];
		
}*/

	if(isset($_POST['save']))
	{
		/*if($f==0)
		{*/
			$sess=$_POST['session'];
			$dept_id=$_POST['dept'];
			$sem_id=$_POST['sem'];
			$sub_id=$_POST['sub'];
			$date=$_POST['txtdate'];
			
			$selqry1="select * from tbl_examdate where date='$date'";
			$sel1=mysql_query($selqry1,$con);
			if(mysql_fetch_array($sel1)=="")
			{
				$insqry1="insert into tbl_examdate(date) values('$date')";
				mysql_query($insqry1,$con);
			}
				
				$selqry2="select * from tbl_examdate where date='$date'";
				$sel2=mysql_query($selqry2,$con);
				$row2=mysql_fetch_array($sel2);
				$did=$row2['did'];
				
			$insqry="insert into tbl_timetable(sess_id,dept_id,sem_id,sub_id,did) values('$sess','$dept_id','$sem_id','$sub_id',$did)";
			mysql_query($insqry,$con);
		/*}
		else
		{
			$id=$_GET['edit'];
		    $sess=$_POST['session'];
			$dept_id=$_POST['dept'];
			$sem_id=$_POST['sem'];
			$sub_id=$_POST['sub'];
			$date=$_POST['txtdate'];
			$updtqry="update tbl_timetable set date='$date', sess_id=$sess, dept_id=$dept_id, sem_id=$sem_id, sub_id=$sub_id where tid=$id";
			mysql_query($updtqry,$con);
		}*/
	}



	if(isset($_GET['del']))
	{
		$id=$_GET['del'];
		$delQry="delete from tbl_timetable where tid=$id";
		mysql_query($delQry,$con);
		echo "<meta http-equiv='refresh' content='0;URL=Timetable.php'>";
	}
	if(isset($_POST['restime']))
	{
		$delQry="delete from tbl_timetable";
		mysql_query($delQry,$con);
		echo "<meta http-equiv='refresh' content='0;URL=Timetable.php'>";
	}
?>
<body>
<form id="form1" name="form1" method="post" action="">
  <table width="406" border="0">
    <tr height="55">
    <div class="form-group">
      <td width="131">Exam Date</td>
      <td width="259"><input type="date" name="txtdate" id="txtdate" value="<?php echo $date;?>" class="form-control" /></td>
    </div>
    </tr>
   <tr height="55">
   <div class="form-group">
      <td>Session</td>
      <div class="radio">
      <td><input type="radio" name="session" id="session" value="1" />
      Forenoon 
      <input type="radio" name="session" id="session" value="2" />
      Afternoon</td>
    </div>
    </tr>
    <tr height="55">
    <div class="form-group">
      <td>Department</td>
      <td>
        <select name="dept" id="dept" class="form-control" >
        <option>--Select Department--</option>
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
      <td>Semester</td>
      <td>
        <select name="sem" id="sem" onchange="GetSubject(this.value);" class="form-control" >
        <option>--Select Semester--</option>
        <?php
		   $selQry="select * from tbl_semester";
		   $sel=mysql_query($selQry,$con);
		   while($row=mysql_fetch_array($sel))
		   {
			   ?>
               <option value="<?php echo $row['sem_id'];?>" ><?php echo $row['sem_name'];?></option>
		<?php	   
		   }
		?>
      </select></td>
    </tr>
    <tr height="55">
    <div class="form-group">
      <td>Subject</td>
      <td>
        <select name="sub" id="sub" class="form-control">
        <option>--Select Subject--</option>
      
      </select></td>
      </div>
    </tr>
    <tr height="55">
    <td></td>
      <td align="left"><input type="submit" name="save" id="save" value="Save" class="btn btn-primary" />
      <input type="reset" name="cancel" id="cancel" value="Cancel" class="btn btn-danger" /></td>
    </tr>
    <tr height="55">
    <td></td>
    <td align="left"><input type="submit" name="restime" id="restime" value="Reset Timetable" class="btn btn-success" />
    </td>
    </tr>
   </table>
  <p>&nbsp;</p>
  <table width="450" height="91" border="1" class="table">
    <tr>
      <td width="100" align="center">Exam Date</td>
      <td width="50" align="center">Session</td>
      <td width="100" align="center">Department</td>
      <td width="50" align="center">Semester</td>
      <td width="100" align="center">Subject</td>
     </tr>
    <?php
		$selQry="select * from tbl_examdate e,tbl_timetable t where e.did=t.did";
		$sel=mysql_query($selQry,$con);
		while($row=mysql_fetch_array($sel))
		{
	?>		
    <tr>
      <td align="left"><?php echo $row['date'];?></td>
      <td align="left"><?php
		if($row['sess_id']==1)
			echo "FN";
		else echo "AN";
	?></td>
      <td align="left"><?php
		$selQry1="select * from tbl_department where dept_id='".$row['dept_id']."'";
		$sel1=mysql_query($selQry1,$con);
		while($row1=mysql_fetch_array($sel1))
		{
			echo $row1['dept_name'];
		}			
	?>	</td>
      <td align="left"><?php
		$selQry1="select * from tbl_semester where sem_id='".$row['sem_id']."'";
		$sel1=mysql_query($selQry1,$con);
		while($row1=mysql_fetch_array($sel1))
		{
			echo $row1['sem_name'];
		}			
	?>	</td>
      <td align="left"><?php
		$selQry1="select * from tbl_subject where sub_id='".$row['sub_id']."'";
		$sel1=mysql_query($selQry1,$con);
		while($row1=mysql_fetch_array($sel1))
		{
			echo $row1['sub_name'];
		}			
	?>	</td>
    
      <!--<td align="center"><a href="Timetable.php?edit=<?php echo $row['tid'];?>">EDIT</a></td>-->
      <td width="50" align="left"><a href="Timetable.php?del=<?php echo $row['tid'];?>">DELETE</a></td>
    
	</tr>
	<?php
		}
    ?>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>
<?php
include("footer.php");
?>