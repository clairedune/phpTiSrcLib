<?php
	/*! 
	 * \file testConvertImageTab.php
	 * \brief Reads an image on the disk, creates a copy, saves it and displays both
	 */
	?>

<html>
<body>

<p>
Test the conversion from image to table and then from table to image.
</p>



<?php
	require_once("../conf/config.php");
	require_once("src/srcImage.php");
	
	
	// read the image on disk using the imageCreateFromPng GD function
	$filename = "images/sorciere.png";
	$length = strlen($filename);
	echo $filename."<br>";

	echo "length :".$length;
	
	$extension = substr($filename, $length-4, $length);
	echo $extension."<br>";
 	
	$extension=strrchr($filename,'.');
	echo $extension."<br>";
	
	$extension=pathinfo($filename, PATHINFO_EXTENSION);
	echo $extension."<br>";
	?>





</body>
</html>