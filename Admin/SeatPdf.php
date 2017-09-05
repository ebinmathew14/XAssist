<?php

$con = @mysql_connect('localhost','root','');
mysql_select_db('eaa');
if(isset($_POST['btnprint']))
{
	$page_html = file_get_contents("seatingpdf.php");
	include('dompdf/dompdf_config.inc.php');
	$dompdf = new DOMPDF();
	$dompdf->load_html($page_html);
	$dompdf->render();
	$dompdf->stream('Seat.pdf');
}
if(isset($_POST['btnback']))
{
	header("location:Seating.php");
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
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

</head>


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
                        <p>Batch Entry</p>
                    </a>
                </li>
                <li>
                    <a href="ClassDetails.php">
                        <i class="pe-7s-note2"></i>
                        <p>Class Entry</p>
                    </a>
                </li>
                <li>
                    <a href="DepartmentDetails.php">
                        <i class="pe-7s-note2"></i>
                        <p>Department Entry</p>
                    </a>
                </li>
                <li>
                    <a href="DesgDetails.php">
                        <i class="pe-7s-note2"></i>
                        <p>Designation Entry</p>
                    </a>
                </li>
                <li>
                    <a href="SemDetails.php">
                        <i class="pe-7s-note2"></i>
                        <p>Semester Entry</p>
                    </a>
                </li>
                <li>
                    <a href="StudentDetails.php">
                        <i class="pe-7s-note2"></i>
                        <p>Student Entry</p>
                    </a>
                </li>
                <li>
                    <a href="StaffDetails.php">
                        <i class="pe-7s-note2"></i>
                        <p>Staff Entry</p>
                    </a>
                </li>
                <li>
                    <a href="SubjectDetails.php">
                        <i class="pe-7s-note2"></i>
                        <p>Subject Entry</p>
                    </a>
                </li>
                <li>
                    <a href="SyllabusDetails.php">
                        <i class="pe-7s-note2"></i>
                        <p>Syllabus Entry</p>
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
                        <p>Duty Allotment</p>
                    </a>
                </li>
                <li>
                    <a href="Seating.php">
                        <i class="pe-7s-note2"></i>
                        <p>Seating Print</p>
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
                   
                        <div class="card ">
                            <div class="content">
                               

<div class="alert alert-success" role="alert" align="center">
  <strong>(Seating Preview)</strong>
</div>
<form method="post" action="" >
<hr size="5px"/>

<div align="center">
<table width="440">
<tr>
<td align="left">
<input type="submit" id="btnback" name="btnback" value="Back" class="btn btn-primary" align="middle" style="width:100px; height:50px;" />
</td>
<td align="right">
<input type="submit" id="btnprint" name="btnprint" value="Download as PDF" class="btn btn-success" align="middle" style="width:200px; height:50px;" />
</td>
</tr>
</table>

</div>
<?php
	$selclass=mysql_query("select * from tbl_class where class_flag!=0",$con);
	while($rowclass=mysql_fetch_array($selclass))
	{
		$cno=$rowclass['cid'];
		
		$cname=$rowclass['classno'];
		$selseat=mysql_query("select * from tbl_seating where cid=$cno");
		$i=0;
		while($i<60)
		{	
			$a[$i]=0;
			$i=$i+1;
		}
		$i=0;
		while($rowseat=mysql_fetch_array($selseat))
		{
			$a[$i]=$rowseat['st_regno'];
			$i=$i+1;
		}
		$j=0;
		?>
        <hr size="5px" />
		<h1 align="center"><?php echo $cname; ?> </h1>
        <br />
        
        <table width="440" border="1" align="center" style="page-break-after:always">
        
		<?php
		while($j<10)
		{
?>		
  <tr>
    <td width="50"><?php if($a[$j]!=0) echo $a[$j]; else?>&nbsp;<?php ;?></td>
    <td width="50"><?php if($a[$j+30]!=0) echo $a[$j+30]; else?>&nbsp;<?php ;?></td>
    <td width="70">&nbsp;</td>
    <td width="50"><?php if($a[$j+10]!=0) echo $a[$j+10]; else?>&nbsp;<?php ;?></td>
    <td width="50"><?php if($a[$j+40]!=0) echo $a[$j+40]; else?>&nbsp;<?php ;?></td>
    <td width="70">&nbsp;</td>
    <td width="50"><?php if($a[$j+20]!=0) echo $a[$j+20]; else?>&nbsp;<?php ;?></td>
    <td width="50"><?php if($a[$j+50]!=0) echo $a[$j+50]; else?>&nbsp;<?php ;?></td>
  </tr>
  
  <?php
  			$j=$j+1;
		}
	?>
        </table>
        <h1 align="center"><?php echo $cname; ?> </h1>
        <table width="410" border="1" align="center" style="page-break-after:always">
        <tr>   
            <td width="60" align="center"><?php echo "Regno";?></td>
    		<td width="200" align="center"><?php echo "Name";?></td>
    		<td width="150" align="center"><?php echo "Signature";?></td>
            </tr>
        
    <?php
  		$olddept=0;
		$oldbatch=0;
		$selregno=mysql_query("select * from tbl_seating where cid=$cno",$con);
		while($rowregno=mysql_fetch_array($selregno))
		{
			$stid=$rowregno['st_id'];
			$stu=mysql_query("select * from tbl_studentdetails where st_id=$stid",$con);
			$student=mysql_fetch_array($stu);
			$regno=$student['st_regno'];
			$name=$student['st_name'];
			$dept=$student['dept_id'];
			$batch=$student['batch_id'];
			if($oldbatch!=0 || $olddept!=0)
			if($dept!=$olddept || $batch!=$oldbatch)
			{
				?>
                </table>
                <!--<p class="break"></p>
                <br />-->
                <h1 align="center"><?php echo $cname; ?> </h1>
                <table width="410" border="1" align="center" style="page-break-after:always">
            <tr>   
            <td width="60" align="center"><?php echo "Regno";?></td>
    		<td width="200" align="center"><?php echo "Name";?></td>
    		<td width="150" align="center"><?php echo "Signature";?></td>
            </tr>
				<?php
			}
			$oldbatch=$batch;
			$olddept=$dept;
				?>
            <tr>   
            <td width="60"><?php echo $regno;?></td>
    		<td width="200"><?php echo $name;?></td>
    		<td width="150">&nbsp;</td>
            </tr>
            <?php
		}
			
			?>
            </table>
            <?php
	
	}
	
	?>
    <hr size="5px" />
</form>
</body>
</html>
<?php
include("footer.php");
?>
