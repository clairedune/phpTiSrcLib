<?php
	/*! 
	 * \file testReadPixelValues.php
	 * \brief Reads an image on the disk, reads the values of a pixel and display them
	 */
	?>

<html>
<body>


<?php
	require_once("../conf/config.php");
	require_once("src/srcImageIo.php");
	
	// read the image on disk using the imageCreateFromPng GD function
	$imageSrc = $path."images/sorciere.png";
	
	$I = imageCreateFromPng($imageSrc) 
	or die("cannot create the image");

	
	// pixel coordinates
	$i = 10;
	$j = 5;
	
	// get the pixel R, G, and B values
	list( $r , $g , $b ) = getPixelValues( $I, $i, $j );
	
	echo "The red value is ".$r."<br>";
	echo "The green value is ".$g."<br>";
	echo "The blue value is ".$b."<br>";
	
	?>


</body>
<html>