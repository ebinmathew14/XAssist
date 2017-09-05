<?php
include('../connection.php');

session_start();
$usr=$_SESSION['facid'];
if($usr=="")
{ 
	header("location:../Guest/login.php");
}
include('header.php');
$selQry="select * from tbl_staff where staff_id=$usr";
$sel=mysql_query($selQry,$con);
$row=mysql_fetch_array($sel);

if(isset($_POST['yes']))
{
	mysql_query("update tbl_staff set staff_confstatus=1 where staff_id=$usr ",$con);
	header("location:DutySelect.php");
}
if(isset($_POST['no']))
{
	mysql_query("update tbl_staff set staff_confstatus=0 where staff_id=$usr ",$con);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Teacher Homepage</title>
</head>

<body>


            <ul class="nav">
            
                <li class="active">
                    <a href="Homepage.php">
                        <i class="pe-7s-science"></i>
                        <p>Home</p>
                    </a>
                </li>
                <?php
                if($row['staff_confstatus']==1)
				{
					?>
                <li>
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
                            <?php
}
?>    
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
            <div class="container-fluid">             
				<?php
				if($row['staff_confstatus']==2)
				{
					?>	
                    <div class="col-md-12">
                    <form id="form1" name="form1" method="post" action="">
                   <li class="list-group-item"><h4 align="left"> Are you available for this exam session?
                           <input type="submit" id="yes" name="yes" value="Yes" class="btn btn-success"/>
                           <input type="submit" id="no" name="no" value="No" class="btn btn-danger" />
                           </h4><i>(Please validate it atleast 1 week before exam date. )</i></li>
                        </form>
                        </div>
                        <?php
				}
				?>
                        <br />
                            <div class="content">
                            <div class="col-md-3">
                           <ul class="list-group">
                              <li class="list-group-item"><h3 align="left"><strong>FACID</strong></h3></li>
                              <li class="list-group-item"><h3 align="left"><strong>NAME</strong></h3></li>
                              <li class="list-group-item"><h3 align="left"><strong>DEPARTMENT</strong></h3></li>
                              <li class="list-group-item"><h3 align="left"><strong>DESIGNATION</strong></h3></li>
                          
                                      </ul>
                                                         </div>
                            <div class="col-md-9">
                           <ul class="list-group">
                              <li class="list-group-item"><h3 align="left"><strong><?php echo $row['staff_facid'];?></strong></h3></li>
                              <li class="list-group-item"><h3 align="left"><strong><?php echo $row['staff_name'];?></strong></h3></li>
                              <li class="list-group-item"><h3 align="left"><strong><?php $deptid=$row['dept_id']; 
							  $row1=mysql_fetch_array(mysql_query("select * from tbl_department where dept_id=$deptid",$con));
							  echo $row1['dept_name'];
							  ?></strong></h3></li>
                              <li class="list-group-item"><h3 align="left"><strong><?php $desgid=$row['desg_id'];
							  $row1=mysql_fetch_array(mysql_query("select * from tbl_designation where desg_id=$desgid",$con));
							  echo $row1['desg_name'];
							  ?></strong></h3></li>
                          
                           
                                                         </ul>
                        </div>
                          

                           
                      
</body>
</html>
<?php
include('footer.php');
?>