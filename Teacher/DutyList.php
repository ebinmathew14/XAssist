<?php
include('../connection.php');
include('header.php');
session_start();
$stid=$_SESSION['facid'];
if($stid=="")
{ 
	header("location:../Guest/login.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Duty List</title>
</head>

<body>


            <ul class="nav">
            
                <li>
                    <a href="Homepage.php">
                        <i class="pe-7s-science"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li>
                    <a href="DutySelect.php">
                        <i class="pe-7s-note2"></i>
                        <p>Duty selection</p>
                    </a>
                </li>
                <li class="active">
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
            <div class="row">
                   
                        <div class="card">
            
             
            
<table width="50%" border="2" align="center">
  <thead align="center">
  <tr align="center">
    <th align="center"><h3 align="center"><strong>Date</strong></h3></th>
    <th align="center"><h3 align="center"><strong>Session</strong></h3></th>
   </tr>
    </thead>
  <?php
  $sel=mysql_query("select * from tbl_dutyselect where staff_id=$stid",$con);
  while($row=mysql_fetch_array($sel))
  {
  	$duid=$row['duty_id'];
 	$row1=mysql_fetch_array(mysql_query("select * from tbl_duty where duty_id=$duid",$con));
	$sid=$row1['sess_id'];
	$did=$row1['did'];
	$row2=mysql_fetch_array(mysql_query("select * from tbl_examdate where did=$did",$con));
	$date=$row2['date'];
	?>
  <tr align="center">
    <td align="center" height="50"><?php echo $date;?></td>
    <td align="center" height="50"><?php if($sid==1) echo "FN"; else echo "AN";?></td>
  </tr>
  <?php
  }
  ?>
</table>
</ul>
</body>
</html>
<?php
include('footer.php');
?>