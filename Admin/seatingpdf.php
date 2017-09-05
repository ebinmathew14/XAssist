<?php
$con = @mysql_connect('localhost','root','');
mysql_select_db('eaa');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Seating Chart</title>

</head>

<body>
<!--
<a href="Seating.php">Back</a>
<input type="button" onclick="myFunction()" align="center" value="Print this page"/>
<script>
function myFunction() {
    window.print();
}
</script>-->

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

</body>
</html>
