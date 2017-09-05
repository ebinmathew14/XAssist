<?php
include('../connection.php');
include "header.php";


session_start();

$stid=$_SESSION['facid'];

if($stid=="")
{
	header("location:../Guest/Login.php");
}


$desgid=$_SESSION['desgid'];
if(isset($_POST['submit']))
{
	$dtids=$_POST['duty'];
	$dtycntt=$_POST['hdnoduty'];
	if(!empty($dtids) && $dtycntt==count($dtids))
	{	
		
		foreach($dtids as $dtid)
		{
			mysql_query("update tbl_dutyassign set duty_count=duty_count-1 where duty_id=$dtid and desg_id=$desgid",$con);
			mysql_query("insert into tbl_dutyselect(duty_id,staff_id) values($dtid,$stid)",$con);

		}
		mysql_query("update tbl_staff set staff_sel=1 where staff_id=$stid",$con);
	}
	else
		echo '<script>alert("Please select"+'.$dtycntt.'+" duties");</script>';
	
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Duty Selection</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/
libs/jquery/1.3.0/jquery.min.js"></script>
<script type="text/javascript">
var auto_refresh = setInterval(
function ()
{
$('#refresh').load('Refresh.php');
}, 300);

function checkcount(ch)
{
 
	var cnt=0;
	var dtycnt=document.getElementById("hdnoduty").value;
	var chk=document.getElementsByName("duty[]");
	for(var i=0;i<chk.length;i++)
	{
			if(chk.item(i).checked==true)
				cnt++;			
	}
	
	if(cnt>(dtycnt))
	{
		alert("Select Only "+dtycnt+" duties");
		ch.checked=false;
	}
}
</script>
</head>
<body>


            <ul class="nav">
            
                <li>
                    <a href="Homepage.php">
                        <i class="pe-7s-science"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="active">
                    <a href="DutySelect.php">
                        <i class="pe-7s-note2"></i>
                        <p>Duty selection</p>
                    </a>
                </li>
                <li>
                    <a href="DutyList.php">
                        <i class="pe-7s-news-paper"></i>
                        <p>View Duty</p>
                    </a>
                </li>
                                
                <li>
                    <a href="../Guest/logout.php">
                        <i class="pe-7s-bell"></i>
                        <p>Logout</p>
                    </a>
                </li>
				
            </ul>
    	</div>
    </div>

    <div class="main-panel">
        <div class="content">
            
<?php
	$row=mysql_fetch_array(mysql_query("select * from tbl_desigduty where desg_id=$desgid",$con));
	$dtycnt=$row['duty_each'];
	$rowst=mysql_fetch_array(mysql_query("select * from tbl_staff where staff_id=$stid",$con));
$f=$rowst['staff_sel'];
if($f==0)
{
	?>
<h3>Please select <?php echo $dtycnt;?> duties,</h3>
<br />

<form id="form1" name="form1" method="post" action="">
<input type="hidden" id="hdnoduty" name="hdnoduty" value="<?php echo $dtycnt;?>" />
  
  <table border="0" >
    <tr>
      <td width="152"><strong>Date</strong></td>
      <td width="96" rowspan="3">
      <table border="1" align="left" class="table table-striped">
        <tr>
 <?php

$i=0;
$did=array();
$selduty=mysql_query("select distinct(did) from tbl_duty where duty_id in (select duty_id from tbl_dutyassign where desg_id=$desgid and duty_count!=0)",$con);
while($rowduty=mysql_fetch_array($selduty))
{
	$dateid=$rowduty['did'];
	$sel=mysql_query("select * from tbl_examdate where did=$dateid",$con);	
	$row=mysql_fetch_array($sel);
	$did[$i]=$dateid;
	$i=$i+1;
	?>
	<td colspan="2" width="50" align="center"><?php echo $row['date'];
	$dt = strtotime($row['date']);
	echo " (".date("l",$dt).")";?></td>
    <?php
	
}
?>
        </tr>
        <tr>
          <?php

foreach($did as $ddid)
{
	$sel1=mysql_query("select * from tbl_duty where did=$ddid and duty_id in (select duty_id from tbl_dutyassign where desg_id=$desgid and duty_count!=0)",$con);
	while($row=mysql_fetch_array($sel1))
	{
		$c=mysql_num_rows($sel1);
		if($c<2 && $row["sess_id"]==2)
		{
			?>
          <td width="25" ></td>
          <?php
		}
		if($row["sess_id"]==1)
		{
		?>
          <td width="25" ><input type="checkbox" id="duty[]" name="duty[]" value="<?php echo $row['duty_id']; ?>"   onclick="checkcount(this)"/>
            FN</td>
          <?php
		  
		}
		if($row["sess_id"]==2)
		{
			?>
          <td width="25" ><input type="checkbox" id="duty[]" name="duty[]" value="<?php echo $row['duty_id']; ?>" onclick="checkcount(this)"/>
            AN</td>
          <?php
		 
		}
        if($c<2 && $row["sess_id"]==1)
		{
			?>
          <td width="25" ></td>
          <?php
		}
	}
}
?>
        </tr>
        <tr id="refresh">
        
        </tr>
        
        
      </table></td>
    </tr>
    <tr>
      <td><strong>Session</strong></td>
    </tr>
    <tr>
      <td><strong>Remaining Duties</strong></td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td align="left"><input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary" /></td>
    </tr>
  </table>
</form>
<?php
}
else
{

echo '<div class="alert alert-danger" role="alert">
  <strong>Oh sorry!</strong>You have already selected your duties
</div>';

}
?>
</body>

</html>
<?php include "footer.php"; ?>