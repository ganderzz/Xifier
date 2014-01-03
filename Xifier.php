<?php
/*
: Xifier by Dylan Paulus
: -----------------------
: Creates minified code based on the file/s given to the $script variable
: -----------------------
:
: &script - Names of all scripts being used. (Do Not lead with /)
:			Scripts can be comma separated &script=`script1.js,script2.js`
:			If code is already Minified, use ! to not run the minifier &script=`!script1.js`
:
: &path  -  Path to script files, the default is set to you system's assets path
:
: &time  -  The amount of time the code will be cached before the code is checked for changed, the default is 2 hours.
:
: &prefix - Directory right after &path. Useful if using default assets path and have a javascript folder. 
:			example: &prefix=`js/` ~ total output will be &path/js/&script
:
*/
$script = !empty($script)? $script : false;
$path = !empty($path)? $path : $modx->getOption('assets_path');
$time = !empty($time)? $time : 7200;
$prefix = !empty($prefix)? $prefix : "";

if($script == false)
	return;

/* Parse out whitespace, and make a list of scripts (array) */
$script = preg_replace("/(\s+)/","", $script);
$script = explode(",",$script);

/* Cache */
$cache = $modx->cacheManager;

if(!$cache->get("Xifier" . $script[0])) {

	$output;

	foreach($script as $key => $file) {

		$nonparse_flag = false;

		if(strstr($file,"!") != false)
		{
			$nonparse_flag = true;
			$file = substr($file, 1, strlen($file));
		}

		/* Set up path to script */
		$assets_path = $path . $prefix . $file;

		/* Get File contents as String */
		$temp .= file_get_contents($assets_path, true);

		/* Strip Comments and Whitespace From Code */
		if(!$nonparse_flag)
			$temp = preg_replace("((\/\*.+\*\/)|(\/\/(.+))|(\s)|(\t))", "" , $temp);

		$output .= $temp;
	}

	/* Cache minified code based on name of file */
	$cache->set("Xifier" . $script[0], $output, $time);
}

return $cache->get("Xifier" . $script[0]);