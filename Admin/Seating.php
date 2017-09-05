<?php
include('../connection.php');
/*include('header.php');
include('footer.php');*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>X-assist-Admin</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />

<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
<title>Seating Arrangement</title>
</head>
<?php
	
	if(isset($_POST['submit']))
	{
		    
			mysql_query("update tbl_class set class_flag=0",$con);		
			$sess=$_POST['radsess'];
			$did=$_POST['seldate'];
			mysql_query("truncate table tbl_seating",$con);
			$selqry="select * from tbl_timetable where did=$did and sess_id=$sess GROUP BY sub_id";
			$sel=mysql_query($selqry,$con);
			while($row=mysql_fetch_array($sel))//begin first while....to fill based on subjects
			{
					/*First Loop selected subjects for a particular date and session*/
					$sidtm=$row['sub_id'];
								
						$selqry1="select * from tbl_syllabus where sub_id=$sidtm";
						$sel1=mysql_query($selqry1,$con);
						$selclass=mysql_query("select * from tbl_class where class_flag<2 order by cid",$con);
						$count=0;
						$seatrow=0;
					while($row1=mysql_fetch_array($sel1))//begin second while
					{		
						$semidsy=$row1['sem_id'];
						$deptidsy=$row1['dept_id'];
						$selqry2="select * from tbl_batch where sem_id=$semidsy";
						$sel2=mysql_query($selqry2,$con);
						$row2=mysql_fetch_array($sel2);
						$batchid=$row2['batch_id'];
						
						$selqry3="select * from tbl_studentdetails where batch_id=$batchid and dept_id=$deptidsy";
						$sel3=mysql_query($selqry3,$con);
					if($count==$seatrow)
					{
						$classdata=mysql_fetch_array($selclass);//begin if
					
						$classno=$classdata['cid'];
						$classcapacity=$classdata['capacity'];
						$count=$classcapacity/2;
						$seatrow=0;
					}
						$fillcount=mysql_num_rows(mysql_query("select * from tbl_seating where cid=$classno",$con));
						if($count<=$fillcount)/*to check the case for 24 or 34*/
						{
							$count=$count-($fillcount-$count);
						}
						else
						{
							$count=$count-$fillcount;
						}
					    $seatrow=0;	
						while($row3=mysql_fetch_array($sel3))//to fill students,begin 3 while
						{	
							if($seatrow>=$count)//
							{
								mysql_query("update tbl_class set class_flag=class_flag+1 where cid=$classno",$con);
								
								if($classdata=mysql_fetch_array($selclass))/*to select appropriate class*/
								{
									$classno=$classdata['cid'];
									$classcapacity=$classdata['capacity'];
									$count=$classcapacity/2;
									
									$fillcount=mysql_num_rows(mysql_query("select * from tbl_seating where cid=$classno",$con));
									if($count<=$fillcount)/*to check the case for 24 or 34*/
									{
										$count=$count-($fillcount-$count);
									}
									else
									{
										$count=$count-$fillcount;
									}
									
									$seatrow=0;
								}
								else echo "NO CLASSES AVAILABLE...STUDENTS NEEDED TO BE SEATED";
							}
							$regno=$row3['st_regno'];
							$sid=$row3['st_id'];
							$insqryst="insert into tbl_seating(st_regno,cid,st_id) values($regno,$classno,$sid)";
							mysql_query($insqryst,$con);	
							$seatrow=$seatrow+1;
														
						}//end 3 while
						$fillcount=mysql_num_rows(mysql_query("select * from tbl_seating where cid=$classno",$con));
						if($fillcount==$classcapacity || $fillcount==($classcapacity/2) )
							{
								mysql_query("update tbl_class set class_flag=class_flag+1 where cid=$classno",$con);
								$seatrow=0;
							}
			}//end 2 while
			
	}//end 1 while
	$fillcount=mysql_num_rows(mysql_query("select * from tbl_seating where cid=$classno",$con));
	if($fillcount<($classcapacity/2))
	 mysql_query("update tbl_class set class_flag=3 where cid=$classno",$con);
	if($fillcount<($classcapacity) && $fillcount>($classcapacity/2) )
	 mysql_query("update tbl_class set class_flag=4 where cid=$classno",$con);
	header("location:SeatPdf.php");
}
	
?>
<body background="../bkimg.jpg">

<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">

    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="http://localhost/eaa/Guest/home.php" class="simple-text">
                    <h3><strong>X-Assist</strong></h3>
                </a>
            </div>

            <ul class="nav">
            
                <li>
                    <a href="HomePage.php">
                        <i class="pe-7s-science"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li>
                    <a href="BatchDetails.php">
                        <i class="pe-7s-note2"></i>
                        <p>Batch Details</p>
                    </a>
                </li>
                <li>
                    <a href="ClassDetails.php">
                        <i class="pe-7s-note2"></i>
                        <p>Class Details</p>
                    </a>
                </li>
                <li>
                    <a href="DepartmentDetails.php">
                        <i class="pe-7s-note2"></i>
                        <p>Department Details</p>
                    </a>
                </li>
                <li>
                    <a href="DesgDetails.php">
                        <i class="pe-7s-note2"></i>
                        <p>Designation Details</p>
                    </a>
                </li>
                <li>
                    <a href="SemDetails.php">
                        <i class="pe-7s-note2"></i>
                        <p>Semester Details</p>
                    </a>
                </li>
                <li>
                    <a href="StaffDetails.php">
                        <i class="pe-7s-note2"></i>
                        <p>Staff Details</p>
                    </a>
                </li>
                <li>
                    <a href="SubjectDetails.php">
                        <i class="pe-7s-note2"></i>
                        <p>Subject Details</p>
                    </a>
                </li>
                <li>
                    <a href="SyllabusDetails.php">
                        <i class="pe-7s-note2"></i>
                        <p>Syllabus Details</p>
                    </a>
                </li>
                <li>
                    <a href="Timetable.php">
                        <i class="pe-7s-note2"></i>
                        <p>Timetable Entry</p>
                    </a>
                </li>
                <li>
                    <a href="Dutyallot.php">
                        <i class="pe-7s-note2"></i>
                        <p>Duty Allot</p>
                    </a>
                </li>
                <li>
                    <a href="Seating.php">
                        <i class="pe-7s-note2"></i>
                        <p>Seating</p>
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
        
            <div class="container-fluid">             
<div class="row">
                   
                        <div class="card ">
                            <div class="content">
<form id="form1" name="form1" method="post" action="">
  <table width="324" border="0">
    <tr height="55">
    <div class="form-group">
      <td width="113">Date</td>
      <td width="168"><select name="seldate" id="seldate" class="form-control">
      <option>--Select Date--</option>
        <?php
		   $selQry="select * from tbl_examdate";
		   $sel=mysql_query($selQry,$con);
		   while($row=mysql_fetch_array($sel))
		   {
			   ?>
               <option value="<?php echo $row['did'];?>"  ><?php echo $row['date'];?></option>
		<?php	   
		   }
		?>
      
      </select></td>
    </div>
    </tr>
    <tr height="55">
    <div class="radio">
      <td>Session</td>
      <td><input type="radio" name="radsess" id="radsess" value="1" />
        Forenoon  <input type="radio" name="radsess" id="radsess" value="2" />
        Afternoon</td>
        </div>
    </tr>
    <tr height="55">
    <td></td>
      <td align="left"><input type="submit" name="submit" id="submit" value="Submit" class="btn btn-success" /></td>
    </tr>
  </table>
</form>
</div>
                    </div>
                   

                </div>
            </div>
        </div></div>


        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="HomePage.php">
                                Home
                            </a>
                        </li>
                                                
                    </ul>
                </nav>
                <p class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script> <a href="http://localhost/eaa/Guest/about.php">X-Assist</a>, a complete exam automator
                </p>
            </div>
        </footer>

    </div>
</div>


</body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>

</html>
