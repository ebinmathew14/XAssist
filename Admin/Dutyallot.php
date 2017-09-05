<?php
include('../connection.php');
include('header.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Duty Allocation</title>
</head>
<?php
	if(isset($_POST['allot']))
	{
		
			$prof=mysql_num_rows(mysql_query("select * from tbl_staff where staff_confstatus=1 and desg_id=1",$con));
			$asp=mysql_num_rows(mysql_query("select * from tbl_staff where staff_confstatus=1 and desg_id=2",$con));
			$ascp=mysql_num_rows(mysql_query("select * from tbl_staff where staff_confstatus=1 and desg_id=3",$con));
			$totp=$prof+$asp+$ascp;
			$cntp=($prof/$totp)*100;
			mysql_query("update tbl_designation set desg_duty=$cntp where desg_id=1",$con);
			$cntp=($asp/$totp)*100;
			mysql_query("update tbl_designation set desg_duty=$cntp where desg_id=2",$con);
			$cntp=($ascp/$totp)*100;
			mysql_query("update tbl_designation set desg_duty=$cntp where desg_id=3",$con);
				
			mysql_query("truncate table tbl_dutyselect",$con);
			mysql_query("update tbl_staff set staff_sel=0",$con);
			mysql_query("truncate table tbl_dutyassign",$con);
			mysql_query("truncate table tbl_desigduty",$con);
			mysql_query("truncate table tbl_duty",$con);
			$datesel=mysql_query("select * from tbl_examdate",$con);
			while($daterow=mysql_fetch_array($datesel))
			{
				$did=$daterow['did'];	
				$sesssel=mysql_query("select distinct(sess_id) from tbl_timetable where did=$did",$con);
			while($sessrow=mysql_fetch_array($sesssel))
			{
			$sessid=$sessrow['sess_id'];
			mysql_query("update tbl_class set class_flag=0",$con);		
			mysql_query("truncate table tbl_seating",$con);
			$selqry="select * from tbl_timetable where did=$did and sess_id=$sessid GROUP BY sub_id";
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
								
								if($classdata=mysql_fetch_array($selclass))//to select appropriate class
								{
									$classno=$classdata['cid'];
									$classcapacity=$classdata['capacity'];
									$count=$classcapacity/2;
									
									$fillcount=mysql_num_rows(mysql_query("select * from tbl_seating where cid=$classno",$con));
									if($count<=$fillcount)//to check the case for 24 or 34
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
							$insqryst="insert into tbl_seating(st_regno,cid) values($regno,$classno)";
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
	 //below code for dty count
	 $dtysel=mysql_query("select * from tbl_class where class_flag>0",$con);
	 $dtycount=0;
	 while($dty=mysql_fetch_array($dtysel))
	 {
		 $cf=$dty['class_flag'];
		 if($cf==1 || $cf==3)
		 	$dtycount=$dtycount+1;
		else if($cf==2 || $cf==4)
	 		$dtycount=$dtycount+2;
	 }
	 mysql_query("insert into tbl_duty(did,sess_id,duty_count) values ($did,$sessid,$dtycount)",$con);
		}
	}
	$sel=mysql_query("select * from tbl_duty",$con);	
	while($row=mysql_fetch_array($sel))
	{
		$dutyid=$row['duty_id'];
		$count=$row['duty_count'];
		$seldesg=mysql_query("select * from tbl_designation",$con);
		while($row1=mysql_fetch_array($seldesg))
		{
			$desgid=$row1['desg_id'];
			$dutyper=$row1['desg_duty'];
			if($desgid==1)
			{
				$tcount=ceil(($dutyper/100)*$count);
				mysql_query("insert into tbl_dutyassign(desg_id,duty_id,duty_count) values($desgid,$dutyid,$tcount)",$con);
			}
			else
			if($desgid==2)
			{
				$tcount=ceil(($dutyper/100)*$count);
				mysql_query("insert into tbl_dutyassign(desg_id,duty_id,duty_count) values($desgid,$dutyid,$tcount)",$con);
			}
			else
			if($desgid==3)
			{
				$tcount=ceil(($dutyper/100)*$count);
				mysql_query("insert into tbl_dutyassign(desg_id,duty_id,duty_count) values($desgid,$dutyid,$tcount)",$con);
			}
			
		}
	}
	$sel=mysql_query("select desg_id,sum(duty_count) as totduty from tbl_dutyassign group by desg_id");
	while($row=mysql_fetch_array($sel))
	{
		$desgid=$row['desg_id'];
		$total=$row['totduty'];
		
		$cs=mysql_num_rows(mysql_query("select * from tbl_staff where desg_id=$desgid and staff_confstatus=1",$con));
		$esduty=ceil($total/$cs);
		mysql_query("insert into tbl_desigduty (desg_id,duty_each) values ($desgid,$esduty)",$con);
	}
}
	
?>
<body>
<form id="form1" name="form1" method="post" action="">
  <table width="200" border="0">
    <tr height="55">
          <td width="117">Duty Allotment</td>
      <td width="67"><input type="submit" name="allot" id="allot" value="Allot" class="btn btn-success" /></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
include('footer.php');
?>