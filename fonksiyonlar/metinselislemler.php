	<?php
	function CiftBoslukSil($string)
	{
	   $string = preg_replace("/\s+/", " ", $string);
	   $string = trim($string);
	   return $string;
	}
	?>