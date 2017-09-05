<?php
include('../connection.php');
include('header.php');

$adminusr="admin";
$adminpass="admin";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>X-assist-Login</title>
</head>
<?php
	if(isset($_POST['login']))
	{
			$usr=$_POST['username'];
			$usrpass=$_POST['txtpass'];
			if($usr==$adminusr)
			{
				if($usr==$adminpass)
				{
					
					header("location:../Admin/HomePage.php");	
				}
				else
				{ 
					echo '<script language="javascript">';
  					echo 'alert("INVALID PASSWORD")';  //not showing an alert box.
  					echo '</script>';
				}
			}
			else
			{
				$selQry="select * from tbl_staff where staff_facid='$usr'";
				$sel=mysql_query($selQry,$con);
				$row=mysql_fetch_array($sel);
				if($row['staff_pwd']==$usrpass && $row['staff_facid']==$usr)
				{
					session_start();
					$usrid=$row['staff_id'];
					$_SESSION['facid']=$usrid;
					$desgid=$row['desg_id'];
					$_SESSION['desgid']=$desgid;
					/*$updQry="update tbl_staff set staff_onstatus=1 where staff_facid='$usr'";
					mysql_query($updQry,$con);*/
					header("location:../Teacher/Homepage.php");
				}
				else
				{ 
					echo '<script language="javascript">';
  					echo 'alert("INVALID PASSWORD")';  //not showing an alert box.
  					echo '</script>';
				}
			}
			
	}
?>

<body>
<ul class="nav">
              <li>
                    <a href="home.php">
                        <i class="pe-7s-science"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="active">
                    <a href="login.php">
                        <i class="pe-7s-user"></i>
                        <p>Login</p>
                    </a>
                </li>
                <li>
                    <a href="about.php">
                        <i class="pe-7s-note2"></i>
                        <p>About Us</p>
                    </a>
                </li>
                <li>
                    <a href="contact.php">
                        <i class="pe-7s-map-marker"></i>
                        <p>Contact Us</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>

    <div class="main-panel">
	


        <div class="content">
            <div class="container-fluid">
                
                   
                        
                            
                            <div class="content" align="center">
                            
                        
                                          <br>
<div class="well well-lg">
<form id="form1" name="form1" method="post" action="">
<table width="482">
<tr>
	<td width="30" height="165" rowspan="3"><img src="../loginicon.png" style="height:165px; width:160px" /></td>
  <div class="form-group">
  <td width="60" height="55"><label for="username">Username:</label></td>
  <td width="200"><input type="text" class="form-control" id="username" name="username" required="required"></td>
</div>
</tr>
<tr>
<div class="form-group">
  <td width="60" height="55"><label for="txtpass">Password:</label></td>
  <td width="200"><input type="password" class="form-control" id="txtpass" name="txtpass" required="required"></td>
</div>
</tr>

<td></td>
<td height="55" align="center" ><input type="submit" name="login" id="login" value="Login" class="btn btn-primary"  />
</td>
</table>
</form>
</body>
</html>
<?php
include('footer.php');
?>
