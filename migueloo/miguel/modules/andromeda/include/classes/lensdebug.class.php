<?php
/********************************************************************************
    Debug Variables - show debugging results in another window using javascript.
    
    The original saved into a file then displayed it in a window
        and was written by Alter Gr <alt-gr@gmx.de>.
    
    The new version by John Lim <jlim@natsoft.com.my>
        1. writes directly to the debug window without using an intermediate file
        2. supports all types, including objects, floats and booleans
        3. cleans up strings with < correctly using htmlspecialchars()
        4. added msg()
        5. added recursion check in v2()
    
    Tested with IE 5.5 and Netscape 4.77 and 6.
    
    usage:    
            $D = new LensDebug();
            $D->v($var1,"var1"); // display a variable and its type
            $D->msg('Show a text message');
    
            second parameter is optional
    
    Original (c) by DATABAY AG 2001 - ay@databay.de
    Other portions (c) 2001 by John Lim

    2 Dec 2001
    Fixed $depth bug

    This is free software. Use at your own risk.
********************************************************************************/

class LensDebug 
{
	var $show = false;
	var $depth = 0;

	//------------------------------------------
	// Format variable recursively based on type
	function v2($V,$Name="",$class=false)
	{
		if ($this->depth > 32) {
			return '<p>Recursive Depth Exceeded</p>';
		}
		
		$this->depth += 1;
		$TYPE_COLOR = "RED";
		$NAME_COLOR = "BLUE";
		$VALUE_COLOR = "BLACK";

		$D = "";
    
		$Name = htmlspecialchars($Name);
    
		$type = gettype($V);
		
		if (is_string($V)) {
			$V = htmlspecialchars($V);
			$D = "<FONT COLOR=$TYPE_COLOR><B>$type: </B></FONT>";
			if ($Name!="") { 
				$D .= "<FONT COLOR=$NAME_COLOR>$Name</FONT> = ";
			}
			$D .= "<FONT COLOR=$VALUE_COLOR>&quot;$V&quot;</FONT>";
		} else if (is_object($V)) {
			$D .= $this->v2(get_object_vars($V),$Name,get_class($V));
			$D = substr($D,0,strlen($D)-4); // get rid of last BR
		} else if (is_array($V)) {
    		if ($class) { 
				$t = "Class $class";
			} else {
				$t = 'Array';
			}
			$D = "<FONT COLOR=$TYPE_COLOR><B>$t: </B></FONT>";
        
			if ($Name!="") {
				$D .= " (<FONT COLOR=$NAME_COLOR>$Name</FONT>) ";
			}	
			$D .= "<FONT COLOR=$VALUE_COLOR><UL>";

			foreach($V as $key => $val) {
				$D .= $this->v2($val,$key);
			}
			//$D = substr($D,0,strlen($D)-4); // get rid of last BR
			$D .= "</UL></FONT>";
		} else {
			if ($V === null) { 
				$V = 'null';
			} else if ($V === false) { 
				$V = 'false';
			} else if ($V === true) { 
				$V = 'true';
			}
        
			$D = "<FONT COLOR=$TYPE_COLOR><B>$type: </B></FONT>";
			if ($Name!="") { 
				$D .= "<FONT COLOR=$NAME_COLOR>$Name</FONT> = ";
			}	
			$D .= "<FONT COLOR=$VALUE_COLOR>$V</FONT>";
		}
    
		$D .= "<BR>";
		
		$this->depth -= 1;
		return($D);
	}

	function _show($file, $line)
	{
		if (!$this->show) {
			$file = str_replace('\\','\\\\',$file);

			$D = "<TABLE SIZE=100% CELLSPACING=0 CELLPADDING=0 BORDER=0><TR><TD><HR SIZE=1></TD><TD WIDTH=1%><FONT FACE='Verdana,arial' SIZE=1>".date("d.m.Y")."&nbsp;".date("H:i:s")."</FONT></TD></TR></TABLE>";
?>
<SCRIPT>
lensdebugw=window.open('',"DEBUGVAR","WIDTH=450,HEIGHT=500,scrollbars=yes,resizable=yes");
if (lensdebugw) {
    lensdebugw.focus();
    lensdebugw.document.write("<?php echo $D; ?>");
    lensdebugw.document.write('<a href=javascript:window.close();>Cerrar</a><br><br>');
    lensdebugw.document.write("<font size=-1><?php echo $file.' :: '.$line;?></font><br><br>");
}
</SCRIPT>
<?php
			$this->show = true;
		}
	}

	//---------------------------------
	// display message in debug window
	function msg($D, $file, $line, $encode=true)
	{
		$this->_show($file, $line);
		if ($encode) {
			$D = htmlspecialchars($D).'<p>';
		}
		$D = str_replace('\\','\\\\',$D);
		$D = str_replace('"','\"',$D);
		$D = str_replace("\r",' ',$D);
		$D = str_replace("\n",' ',$D);
		$D = "<font face='Verdana,arial' size=-2>$D</font>"
?>
<SCRIPT>
if (lensdebugw) {
    lensdebugw.document.write("<?php echo $D; ?>");
    lensdebugw.document.write('<HR SIZE=1><a href=javascript:window.close();>Cerrar</a><br><br>');
    lensdebugw.scrollBy(0,100000);
}
</SCRIPT>
<?php
	}

	//---------------------------------
	// display variable in debug window
	function v($V, $file, $line, $Name="")
	{
		$this->_show($file, $line);
        
		$D = $this->v2($V,$Name);
		if (!is_object($V) and !is_array($V)) { 
			$D .= '<br>';
		}
		$this->msg($D, $file, $line, false);
	}

} // LensDebug class
?>