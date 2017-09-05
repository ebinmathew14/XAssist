<option>--select--</option>
<?php
include("../connection.php");
$sid=$_GET['sid'];
$did=$_GET['did'];
$selQry="select * from tbl_subject sub, tbl_syllabus sy, tbl_semester s,tbl_department d where sy.sub_id=sub.sub_id and sy.sem_id=s.sem_id and sy.dept_id=d.dept_id and s.sem_id='$sid' and d.dept_id='$did'";
		   $sel=mysql_query($selQry,$con);
		   while($row=mysql_fetch_array($sel))
		   {
			   ?>
               <option value="<?php echo $row['sub_id'];?>">
			   <?php echo $row['sub_code'].' - '.$row['sub_name'];?></option>
		<?php	   
		   }
		?>