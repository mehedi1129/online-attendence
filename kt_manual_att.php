<?php
if(!isset($_SESSION['edusmart_inst'])){
	session_start();
	$_SESSION['edusmart_inst'] = "BDIXAAA111";
	$_SESSION['edusmart_branch_name'] = "N/A";
	$_SESSION['inst_nick'] = "kt";
}
require_once("config.inc");
connect_db();
require_once("functions.php");
require_once("tools.php");
require_once("extract.php");
require_once("institution_info.php");

echo '<style>
	
	a{text-decoration:none;}
	
	input[type="button"]{
		width:100pt;
		height:30pt;
		background-color:#13528C;
		color:#FFF;
		font-size:12pt;
		font-weight:bold;
		font-family:"Lucida Console", Monaco, monospace;
		border-radius:0 10 0 10;
		border:#0CF solid 3px;
	}
	input[type="button"]:hover{
		cursor:pointer;
	}

</style>';

function selectOnlyASectionForAttendance(){

	$edusmart_inst_id = "BDIXAAA111";
	$edusmart_branch_name = "N/A";
	$inst_nick = "kt";

	$mediums = getMediums($edusmart_inst_id, $edusmart_branch_name);
	$versions = getVersions($edusmart_inst_id, $edusmart_branch_name);
	$shifts = getShifts($edusmart_inst_id, $edusmart_branch_name);
	$genders = getGenders($edusmart_inst_id, $edusmart_branch_name);
	$classs = getClasses($edusmart_inst_id, $edusmart_branch_name);
	$depts = getDepts($edusmart_inst_id, $edusmart_branch_name);
	#$sections = getSections();

	$dependend_load = false;

	$form = "myform";
	$module = "";
	$action = "show_std_list";
	$sub_action = "";

	#echo "<form action=\"index.php\" method=\"post\" name=\"$form\" onsubmit=\"return checkRequiredFields($form);\">";
	echo "<form action=\"#\" method=\"post\" name=\"$form\" onsubmit=\"return checkRequiredFields($form);\">";
		#echo "<input name=\"module\" type=\"hidden\" Value=\"${module}\">";
		echo "<input name=\"action\" type=\"hidden\" Value=\"${action}\">";
		#echo "<input name=\"sub_action\" type=\"hidden\" Value=\"${sub_action}\">";

	echo "<table align=\"center\" style=\"border-collapse: collapse;\" border=1 width=280px>";
		echo "<tr>";    
			echo "<td colspan=2 id=waiting align=center>&nbsp;</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td colspan=2 align=center id=\"table_header\">Section of the Students</td>";    
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan=1 width=100 align=left id=\"table_header\">Select Term</td>";
			echo "<td>";
				echo "<select name=term id=term>";
					echo "<option value=47>1st term Exam</option>";
					// echo "<option value=166>Pre-Selection Test</option>";
					// echo "<option value=21>Annual Examination</option>";
					// echo "<option value=50>First Year Final Examination</option>";
				echo "</select>";
			echo "</td>";
		echo "</tr>";


		if( count($mediums)==1 )
		{
			$medium = $mediums[0];
			echo "<input name=\"medium\" type=\"hidden\" Value=\"${medium}\">";
		}
		else
		{
			$dependend_load = true;
			$next_id = "";
			if(count($versions)>1)
			{
				$next_id = "version_id";
			}
			else if(count($shifts)>1)
			{
				$next_id = "shift_id";
			}
			else if(count($genders)>1)
			{
				$next_id = "gender_id";
			}
			/*else if(count($depts)>1)
			{
				$next_id = "dept_id";
			}*/
			else
			{
				$next_id = "class_id";
			}
			echo "<tr>";    
				echo "<td width=\"60px\" id=\"label_left\">Medium</td>";    
				echo "<td id=medium_id>";    
					echo "<select name=\"medium\" id=\"fld\" onchange=\"callhtmlData('institution_info.php', this.form, 'medium='+this.value, '$next_id')\"  >";
						echo "<option value=99>&nbsp;&nbsp;---&nbsp;&nbsp;</option>";
						foreach( $mediums as $medium )
						{
							echo "<option value=$medium>".getMedium($medium)."</option>";    
						}
					echo "</select>";    
				echo "</td>";    
			echo "</tr>";
		}

		if(count($versions)==1)
		{
			$version = $versions[0];
			echo "<input name=\"version\" type=\"hidden\" Value=\"${version}\">";
		}
		else
		{
			$next_id = "";
			if(count($shifts)>1)
			{
				$next_id = "shift_id";
			}
			else if(count($genders)>1)
			{
				$next_id = "gender_id";
			}
			/*else if(count($depts)>1)
			{
				$next_id = "dept_id";
			}*/
			else
			{
				$next_id = "class_id";
			}
			echo "<tr>";    
				if(count($mediums)==1)
				{
					echo "<td width=\"60px\" id=\"label_left\">Medium</td>";
				}
				else
				{
					echo "<td width=\"60px\" id=\"label_left\">Version</td>";
				}
				echo "<td id=version_id>";
				if($dependend_load==false)
				{
					echo "<select name=\"version\" id=\"fld\" onchange=\"callhtmlData('institution_info.php', this.form, 'version='+this.value, '$next_id')\"  >";
						echo "<option value=99>&nbsp;&nbsp;---&nbsp;&nbsp;</option>";
							foreach( $versions as $version )
							{
								echo "<option value=$version>".getVersion($version)."</option>";    
							}
					echo "</select>"; 
					$dependend_load = true;
				}
				else
				{
					echo "<select name=\"version\" id=\"fld\">";
						echo "<option value=99>&nbsp;&nbsp;---&nbsp;&nbsp;</option>";
					echo "</select>"; 
				}
				echo "</td>";    
			echo "</tr>";
		}

		if(count($shifts)==1)
		{
			$shift = $shifts[0];
			echo "<input name=\"shift\" type=\"hidden\" Value=\"${shift}\">";
		}
		else
		{
			$next_id = "";
			if(count($genders)>1)
			{
				$next_id = "gender_id";
			}
			/*else if(count($depts)>1)
			{
				$next_id = "dept_id";
			}*/
			else
			{
				$next_id = "class_id";
			}
			echo "<tr>";    
				echo "<td width=\"60px\" id=\"label_left\">Shift</td>";    
				echo "<td id=shift_id>";
				if($dependend_load==false)
				{
					echo "<select name=shift id=\"fld\" onchange=\"callhtmlData('institution_info.php', this.form, 'shift='+this.value, '$next_id')\"  >";
						echo "<option value=99>&nbsp;&nbsp;---&nbsp;&nbsp;</option>";

							foreach( $shifts as $shift )
							{
								echo "<option value=$shift>".getShift($shift)."</option>";    
							}
					echo "</select>"; 
					$dependend_load = true;
				}
				else
				{
					echo "<select name=shift id=\"fld\">";
						echo "<option value=99>&nbsp;&nbsp;---&nbsp;&nbsp;</option>";
					echo "</select>"; 
				}   
				echo "</td>";    
			echo "</tr>";
		}
		if(count($genders)==1)
		{
			$gender = $genders[0];
			echo "<input name=\"gender\" type=\"hidden\" Value=\"${gender}\">";
		}
		else
		{
			$next_id = "class_id";
			echo "<tr>";    
				echo "<td width=\"60px\" id=\"label_left\">Std. Type</td>";    
				echo "<td id=\"gender_id\">";
				if($dependend_load==false)
				{
					echo "<select name=gender id=\"fld\" onchange=\"callhtmlData('institution_info.php', this.form, 'gender='+this.value, '$next_id')\"  >";
						echo "<option value=99>&nbsp;&nbsp;---&nbsp;&nbsp;</option>";

							foreach( $genders as $gender )
							{
								echo "<option value=$gender>".getStudentGender($gender)."</option>";    
							}
					echo "</select>"; 
					$dependend_load = true;
				}
   			else
				{
					echo "<select name=gender id=\"fld\">";
						echo "<option value=99>&nbsp;&nbsp;---&nbsp;&nbsp;</option>";
					echo "</select>"; 
				}
				echo "</td>";    
			echo "</tr>";
		}


		if(count($depts)==1)
		{
			$next_id = "section_id";
		}
		else
		{
			$next_id = "dept_id";
		}	
		echo "<tr>";    
			echo "<td width=\"60px\" id=\"label_left\">Class</td>";    
			echo "<td id=\"class_id\">";
			if($dependend_load==false)
			{
				echo "<select name=\"class\" id=\"fld\" onchange=\"callhtmlData('institution_info.php', this.form, 'class='+this.value, '$next_id')\"  >";
					echo "<option value=99>&nbsp;&nbsp;---&nbsp;&nbsp;</option>";
					foreach( $classs as $class )
					{
						echo "<option value=$class>".getClass($class)."</option>";    
					}
				echo "</select>"; 
				$dependend_load = true;
			}
  			else
			{
         	echo "<select name=\"class\" id=\"fld\">";
            	echo "<option value=99>&nbsp;&nbsp;---&nbsp;&nbsp;</option>";
				echo "</select>";
			}
			echo "</td>";    
		echo "</tr>";


		if(count($depts)==1)
		{
			$dept = $depts[0];
			echo "<input name=\"dept\" type=\"hidden\" Value=\"${dept}\">";
		}
		else
		{
			$dependend_load = true;
			$next_id = "section_id";

			echo "<tr>";    
				echo "<td width=\"60px\" id=\"label_left\">Dept</td>";    
				echo "<td id=dept_id>";    
				if($dependend_load==false)
				{
					echo "<select name=dept id=\"fld\" onchange=\"callhtmlData('institution_info.php', this.form, 'dept='+this.value, '$next_id')\"  >";
						echo "<option value=99>&nbsp;&nbsp;---&nbsp;&nbsp;</option>";

							foreach( $depts as $dept )
							{
								echo "<option value=$dept>".getDept($dept)."</option>";    
							}
					echo "</select>";   
					$dependend_load = true; 
				}
				else
				{
					echo "<select name=dept id=\"fld\">";
						echo "<option value=99>&nbsp;&nbsp;---&nbsp;&nbsp;</option>";
					echo "</select>";   
				}
				echo "</td>";    
			echo "</tr>";
		}

        echo "<tr>";
            echo "<td id=\"label_left\">Section:</td>";
            echo "<td id=section_id>";
                echo "<select name=section id=\"fld\">";
                   	echo "<option value=99>&nbsp;&nbsp;---&nbsp;&nbsp;</option>";
                echo "</select>";
            echo "</td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td colspan=2 align=right><input name=\"Submit\" type=\"Submit\" Value=\"Go\"></td>";
        echo "</tr>";
    echo "</table>";
echo "</form>";
	
}

#selectOnlyASectionForAttendance();

if(!isset($_REQUEST['action'])){
	echo "<center><h1 style=\"color:red;\">kt Attendance Entry</h1></center>";
	selectOnlyASectionForAttendance();
}
else if(isset($_REQUEST['action']) && $_REQUEST['action']=="show_std_list"){

	#echo "form submitted<hr>";
	$term = $_REQUEST["term"];
	$shift = $_REQUEST["shift"];
	$medium = $_REQUEST["medium"];
	$version = $_REQUEST["version"];
	$class = $_REQUEST["class"];
	$dept = $_REQUEST["dept"];
	$gender = $_REQUEST["gender"];
	$section = $_REQUEST["section"];
	
	$group = $dept;
	// echo "$shift -- $medium -- $version -- $class --- $dept -- $gender -- $section<hr>";
	
	// $q = " SELECT CONCAT_WS(first_name, mid_name, last_name) as name, c_no ";
	// $q.= " FROM kt_student ";
	// $q.= " WHERE `shift`='$shift' AND `medium`='$medium' AND `version`='$version' ";
	// $q.= " AND `class`='$class' AND `dept`='$dept' AND `section`='$section' AND `gender`='$gender' ";
	// $r = mysql_query($q);
	
	$edusmart_inst_id = "BDIXAAA111";
	$edusmart_branch_id = "N/A";
	$inst_nick = "kt";
	$year = 2022;
	#$term = ($class==10) ? 5 : 21;
	
	echo "<center><a href=kt_manual_att.php><input type=button value=Back></a></center>";
	attendance_entry_for_students($edusmart_inst_id,$edusmart_branch_id,$inst_nick,$shift,$medium,$version,$class,$group,$section,$gender,$year,$term);

}


else if(isset($_REQUEST['action']) && $_REQUEST['action']=="attendance_taken"){
	#echo "att saved<hr>";
	
	$edusmart_inst_id = "BDIXAAA111";
	$edusmart_branch_id = "N/A";
	$inst_nick = "kt";
	
	$term = $_REQUEST['term'];
	$shift = $_REQUEST['shift'];
	$medium = $_REQUEST['medium'];
	$version = $_REQUEST['version'];
	$class = $_REQUEST['_class'];
	$dept = $_REQUEST['dept'];
	$section = $_REQUEST['section'];
	$gender = $_REQUEST['gender'];
	

	$year = 2022;
	#$term = 2;
	#$term = ($class==10) ? 5 : 21;

	echo "<center><a href=kt_manual_att.php><input type=button value=Back></a></center>";
	attendance_taken($edusmart_inst_id,$edusmart_branch_id,$inst_nick,$shift,$medium,$version,$class,$dept,$section,$gender,$year,$term);
}



#=========================	ROKON ENDS	===========================#

function attendance_entry_for_students($edusmart_inst_id,$edusmart_branch_id,$inst_nick,$shift,$medium,$version,$class,$group,$section,$gender,$year,$term)
{
	$gender_info = "";
	$gender_sec_id = "";
	if($gender!=-1)
	{
		$gender_info = " AND gender=$gender";
		$gender_sec_id = " (".getStudentGender($gender).")";
	}
	echo '<script>
		function next_tab_index(e,index)
		{
			if (e.keyCode == 38 || e.keyCode == 40)
			{
				if (e.keyCode == 40 )
				{
					index+=3;
				}
				else if(e.keyCode==38)
				{
					if(index>0)
					{
						index-=3;
					}
				}
				else if(e.keyCode==37)
				{
					index--;
				}
				else
				{
					index++;
				}
				document.getElementById("tabindex_"+index).focus();
				e.returnValue = false; // for IE
				if (e.preventDefault) e.preventDefault(); // for Mozilla
			}
		}

		function clearDefault(el)
		{
			if (el.value=="0") el.value = "";
		}
		function resetDefault(el)
		{
			if (el.value=="") el.value = "0";
		}
		
		function showAbsentDays(n,evt){
			var charCode = (evt.which) ? evt.which : event.keyCode;
			//alert(charCode);
			//if (charCode >= 48 && charCode <= 57){
				next = n+1;
				//var totalWorkingDays = 75;
				var totalWorkingDays = parseInt(document.getElementById("twd").value);
				var presentDays = parseInt(document.getElementById("tabindex_"+n).value);
				//alert(totalWorkingDays);
				
				//alert(totalWorkingDays);
				//alert(presentDays);
				
				if(totalWorkingDays!="" || totalWorkingDays!=0){
					if(presentDays<=totalWorkingDays){
						//alert("less");
						var absentDays = totalWorkingDays - presentDays;
						document.getElementById("tabindex_"+next).value = absentDays;
					}
					else{
						//alert("grtr");
						alert("Present Days can\'t be GREATER than Total Working Days !");
						document.getElementById("tabindex_"+n).value = 0;
						document.getElementById("tabindex_"+next).value = 0;
					}
				}
				else{
					alert("Please type Total Working Days first !");
					document.getElementById("tabindex_"+n).value = 0;
					document.getElementById("tabindex_"+next).value = 0;
					return false;
				}
			//}
		}
		
		function showLateDays(n,evt){
			var charCode = (evt.which) ? evt.which : event.keyCode;
			prev = n-1;
			next = n+1;
			var totalWorkingDays = document.getElementById("twd").value;
			var presentDays = document.getElementById("tabindex_"+prev).value;
			var absentDays = document.getElementById("tabindex_"+n).value;
			var present_absent = parseInt(presentDays) + parseInt(absentDays);
			
			if(totalWorkingDays!="" || totalWorkingDays!=0){
				if(present_absent<=totalWorkingDays){
					var lateDays = totalWorkingDays - present_absent;
					document.getElementById("tabindex_"+next).value = lateDays;
				}
				else{
					alert("Present + Absent Days can\'t be GREATER than Total Working Days !");
					document.getElementById("tabindex_"+n).value = 0;
					document.getElementById("tabindex_"+next).value = 0;
				}
			}
			else{
				alert("Please type Total Working Days first !");
				document.getElementById("tabindex_"+n).value = 0;
				document.getElementById("tabindex_"+next).value = 0;
				return false;
			}
		}

		function validateNumeric_res(evt){
			var charCode = (evt.which) ? evt.which : event.keyCode;

			if (charCode > 31 && (charCode < 48 || charCode > 57)){
				alert("Only NUMBERS are allowed !");
				return false;
			}
			return true;
		}


	</script>';

	#prepare_tabulation_sheet($edusmart_inst_id,$edusmart_branch_id,$inst_nick,$shift,$medium,$version,$class,$group,$section,$gender,$term,$year);
/*
	$q = " SELECT edusmart_id, c_no, CONCAT_WS(' ',first_name,mid_name,last_name) as name";
	$q.= " FROM ${inst_nick}_student";
	$q.= " WHERE year=$year";
	$q.= " AND medium=$medium AND version=$version AND class=$class AND dept=$group";
	$q.= " AND shift=$shift AND section=$section";
	$q.= " ORDER BY name ASC";
*/	
	$q = " SELECT `edusmart_id`, CONCAT_WS(' ', `first_name`, `mid_name`, `last_name`) as `name`, `c_no` FROM  ${inst_nick}_student ";
	$q.= " WHERE `medium`='$medium' AND `version`='$version' AND `shift`='$shift' AND `class`='$class' AND `section`='$section' AND `dept`='$group' ";
	$q.= " AND `edusmart_inst`='$edusmart_inst_id' AND `edusmart_branch_name`='$edusmart_branch_id' $gender_info ";
	#$q.= " ORDER BY `name` ASC ";
	$q.= " ORDER BY `c_no` ASC ";
	$r = @mysql_query($q);
	if($r&& mysql_num_rows($r)>0)
	{
		$num_students = mysql_num_rows($r);
	}
	$num_medium = count(getMediums($edusmart_inst_id, $edusmart_branch_id));
	$num_version = count(getVersions($edusmart_inst_id, $edusmart_branch_id));
	$num_shift = count(getShifts($edusmart_inst_id, $edusmart_branch_id));

	echo "<div>";
	echo "<div class=\"box_border\" id=\"banner\">";  
	echo "<form name=\"student_result_form\" action=\"#\" method=\"POST\" onsubmit=\"return checkSubTeacher()\">";
	echo "<input name=\"module\" type=\"hidden\" Value=\"result\">";
	echo "<input name=\"action\" type=\"hidden\" Value=\"attendance_taken\">";   
	echo "<input name=\"medium\" type=\"hidden\" Value=\"$medium\">";
	echo "<input name=\"version\" type=\"hidden\" Value=\"$version\">";
	echo "<input name=\"shift\" type=\"hidden\" Value=\"$shift\">";
	echo "<input name=\"_class\" type=\"hidden\" Value=\"$class\">";
	echo "<input name=\"dept\" type=\"hidden\" Value=\"$group\">";
   	echo "<input name=\"section\" type=\"hidden\" Value=\"$section\">";
	echo "<input name=\"gender\" type=\"hidden\" Value=\"$gender\">";
	echo "<input name=\"save_attendance\" type=\"hidden\" Value=\"\">";
	if($gender!=-1)
	{
   		echo "<input name=\"gender\" type=\"hidden\" Value=\"$gender\">";   
	}
	echo "<input name=\"term\" type=\"hidden\" Value=\"$term\">";
	echo "<input name=\"exam_name_select\" type=\"hidden\" Value=\"$term\">";
	echo "<input name=\"year\" type=\"hidden\" Value=\"$year\">";
	echo "<input name=\"year_select\" type=\"hidden\" Value=\"$year\">";

		echo "<table align=center width=100% style=\"border-collapse: collapse;\" border=0>";
		echo "<tr id=\"label_top\">";
		echo "<td width=\"25%\"></td>";
		echo "<td align=\"right\"></td>";
		echo "<td>";
		echo "</td>";
		echo "<td width=\"25%\"></td>";
		echo "</tr>";
		#echo "<tr id=\"label_top\"><td colspan=\"4\">&nbsp;</td></tr>";
		echo "</table>";
		
			//echo "<span id=msg>$msg</span>";
			echo "<table align=center width=900px style=\"border-collapse: collapse;\" border=1>";
				echo "<tr id=\"label_top\" align=\"center\" bgcolor=\"#333333\" style=\"color:#FFF;\">";
					if($num_shift>1)
					{
						echo "<td>SHIFT</td>";
					}
					if($num_medium>1)
					{
						echo "<td>MEDIUM</td>";
					}
					if($num_version>1)
					{
						if($num_medium==1)
						{
							echo "<td>MEDIUM</td>";
						}
						else 
						{
							echo "<td>VERSION</td>";
						}
					}
					echo "<td>CLASS</td>";
					echo "<td>GROUP</td>";
					echo "<td>SECTION</td>";
					echo "<td>NO. OF STUDENTS</td>";
					echo "<td>EXAM</td>";
					#echo "<td>SUBJECT</td>";
				echo "</tr>";
				echo "<tr id=label2 style=\"color:#000; font-weight:bold;text-align:center\">";
					if($num_shift>1)
					{
						echo "<td>".getShift($shift)."</td>";
					}
					if($num_medium>1)
					{
						echo "<td>".getMedium($medium)."</td>";
					}
					if($num_version>1)
					{
						echo "<td>".getVersion($version)."</td>";
					}
					echo "<td>".getClass($class)."</td>";
					echo "<td>".getDept($group)."</td>";
					echo "<td >".getSection($section, $edusmart_inst_id)."$gender_sec_id</td>";
					echo "<td>$num_students</td>";
					echo "<td>".get_exam_name($edusmart_inst_id,$edusmart_branch_id,$year,$class,$term)."</td>";
				echo "</tr>";
			echo "</table>"; 
		$colspan=11;
		$is_e = false;

	#echo $num_subjects;
	$twd = 0;
	$q_twd = " SELECT `total_working_days` FROM `kt_std_attendance_temp` ";
	$q_twd.= " WHERE `class`='$class' AND `section`='$section' AND `term`='$term' AND `year`='$year' ";
	$r_twd = mysql_query($q_twd);
	if($r_twd && mysql_num_rows($r_twd)>0){
		$row_twd = mysql_fetch_array($r_twd);
		$twd = $row_twd["total_working_days"];
	}


		echo "<table align=center width=900px style=\"border-collapse: collapse;\" border=1>";                
			echo "<tr id=\"label_top\" align=center>";
				echo "<td width=\"80px\" rowspan=\"1\">SL</td>";
				echo "<td width=\"290px\" rowspan=\"1\">Student Name</td>";
				echo "<td width=\"100px\" rowspan=\"1\">Student Id</td>";
				echo "<td width=\"110px\" rowspan=\"1\">Present</td>";
				echo "<td width=\"110px\" rowspan=\"1\">Absent</td>";
				echo "<td width=110px>Late</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=center colspan=6 bgcolor=#DEDEDE>Total Working Days : <input type=text id=\"twd\" name=\"twd\" size=15 onfocus=\"this.select()\" onkeypress=\"return validateNumeric_res(event);\" style=\"color:red;font-weight:bold;text-align:center;\" value=\"$twd\"></td>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";

	if($r && mysql_num_rows($r)>0)
	{
		echo "<div style=\"position:absolute; overflow:auto; width:99%; height:68%;\">";
		echo "<table align=center width=\"890px\" style=\"border-collapse: collapse;\" border=1>";
		$i = 0;
		$sl = 1;
		$index = 0;
		while($row = mysql_fetch_array($r))
		{
			$std_present = 0;
			$std_absent = 0;
			$std_late = 0;
			$edusmart_id = $row["edusmart_id"];
			$name = strtoupper($row['name']);
			$c_no = $row["c_no"];
			$q_att = " SELECT attendance_type, total_attendance FROM kt_std_attendance_temp ";
			$q_att.= " WHERE term=$term AND year=$year AND edusmart_id='$edusmart_id' ";
			#echo "$q_att<hr>";
			$r_att = @mysql_query($q_att);# or die(mysql_error()."<hr>");
			
			if($r_att && mysql_num_rows($r_att)>0)
			{
				while($row_att = mysql_fetch_array($r_att))
				{
					$type = $row_att['attendance_type'];
					if($type==0)
					{
						$std_present = $row_att['total_attendance'];
					}
					else if($type==1)
					{
						$std_absent = $row_att['total_attendance'];
					}
					else if($type==2)
					{
						$std_late = $row_att['total_attendance'];
					}
				}
			}
			@mysql_free_result($r_att);
			$tr_bg=($index%2==0) ? "#FFFFFF" : "#DDDDDD";	

			echo "<tr bgcolor=\"$tr_bg\">"; 
				echo "<input name=\"edusmart_ids[]\" type=\"hidden\" value=\"$edusmart_id\">";
				echo "<td align=center width=80px>$sl</td>";
				echo "<td style=\"font-size:10pt;\" width=\"290px\">&nbsp;&nbsp;$name</td>";
				echo "<td width=\"100px\" align=center>$c_no</td>"; 


//----------------------------PRESENT-----------------------------//
				$i++;
				echo "<td width=\"100px\">";
					echo "<input name=\"present[]\" id=\"tabindex_$i\" value=\"".$std_present."\" style=\"width:90%;text-align:right;background-color:$tr_bg;font-weight:bold;\"
						onkeyup=\"showAbsentDays($i,event);\"
						onkeypress=\"return validateNumeric_res(event);\"
						onfocus=\"clearDefault(this)\"
						onblur=\"resetDefault(this)\"
						onkeydown=\"next_tab_index(event,$i);\" TABINDEX=".($i+1).">";
				echo "</td>";

//----------------------------ABSENT-----------------------------//
				$i++;
				echo "<td width=\"100px\">";
					echo "<input name=\"absent[]\" id=\"tabindex_$i\" value=\"".$std_absent."\" style=\"width:90%;text-align:right;background-color:$tr_bg;font-weight:bold;\"
						onkeyup=\"showLateDays($i,event);\"
						onkeypress=\"return validateNumeric_res(event);\"
						onfocus=\"clearDefault(this)\"
						onblur=\"resetDefault(this)\"
						onkeydown=\"next_tab_index(event,$i);\" TABINDEX=".($i+2)." readonly>";
				echo "</td>";
//----------------------------LATE-----------------------------//
				$i++;
				echo "<td width=100px>";
					echo "<input name=\"late[]\" id=\"tabindex_$i\" value=\"".$std_late."\" style=\"width:90%;text-align:right;background-color:$tr_bg;font-weight:bold;\"
						onkeypress=\"return validateNumeric_res(event);\"
						onfocus=\"clearDefault(this)\"
						onblur=\"resetDefault(this)\"
						onkeydown=\"next_tab_index(event,$i);\" TABINDEX=".($i+2)." readonly>";
				echo "</td>";

			$index++;
			$sl++;
		}//while
		@mysql_free_result($r);
		echo "<tr>"; 
			echo "<td align=\"right\" colspan=\"$colspan\">";
				echo "<input type=\"submit\" name=\"student_attendance_save\" value=\"Save\">";
			echo "</td>";
		echo "</tr>";
	echo "</table>"; 
	echo "</div>";
	}//if
echo "</div>";
echo "</form>";
}

function attendance_taken($edusmart_inst_id,$edusmart_branch_id,$inst_nick,$shift,$medium,$version,$class,$dept,$section,$gender,$year,$term)
{
	#echo "attendance_taken()<hr>";
	$edusmart_ids = $_REQUEST['edusmart_ids'];
	$presents = $_REQUEST['present'];
	$absents = $_REQUEST['absent'];
	$lates = $_REQUEST['late'];
	$twd = $_REQUEST['twd'];
	#print_a($_REQUEST);
	for($i=0; $i<count($edusmart_ids); $i++)
	{
		$edusmart_id = $edusmart_ids[$i];
		$present = $presents[$i];
		$absent = $absents[$i];
		$late = $lates[$i];
		$q_present = " REPLACE INTO `kt_std_attendance_temp` (`edusmart_id`, `class`, `section`, `term`, `year`, `attendance_type`, `total_attendance`, `total_working_days` )";
		$q_present.= " VALUES ('$edusmart_id', '$class', '$section', '$term', '$year', 0, '$present', '$twd') ";
		#echo "$q_present<hr>";
		@mysql_query($q_present) or die(mysql_error());
		$q_absent = " REPLACE INTO `kt_std_attendance_temp` (`edusmart_id`, `class`, `section`, `term`, `year`, `attendance_type`, `total_attendance`, `total_working_days` )";
		$q_absent.= " VALUES ('$edusmart_id', '$class', '$section', '$term', '$year', 1, '$absent', '$twd') ";
		#echo "$q_absent<hr>";
		@mysql_query($q_absent) or die(mysql_error());
		$q_late = " REPLACE INTO `kt_std_attendance_temp` (`edusmart_id`, `class`, `section`, `term`, `year`, `attendance_type`, `total_attendance`, `total_working_days` )";
		$q_late.= " VALUES ('$edusmart_id', '$class', '$section', '$term', '$year', 2, '$late', '$twd') ";
		#echo "$q_late<hr>";
		@mysql_query($q_late) or die(mysql_error());
	}
	
	echo "<script>alert('Saved Successfully !');</script>";
	
	attendance_entry_for_students($edusmart_inst_id,$edusmart_branch_id,$inst_nick,$shift,$medium,$version,$class,$dept,$section,$gender,$year,$term);
}

?>
