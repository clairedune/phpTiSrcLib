<html>
<body>

<p>
This file is only here to test the functions 
</p>
<?php
	require_once("src/srcImageLib.php");
	
	// read the image on disk using the imageCreateFromPng GD function
	$imageSrc = "images/sorciere.png";

	$I = imageCreateFromPng($imageSrc) 
	or die("cannot create the image");
	
	$Ires= createCopy( $I )
	or die("cannot create the copy");
	
	// pixel coordinates
	$i = 10;
	$j = 5;
	
	// get the pixel R, G, and B values
	list( $r , $g , $b ) = getPixelValues( $I, $i, $j );
	
	echo "The red value is ".$r."<br>";
	echo "The green value is ".$g."<br>";
	echo "The blue value is ".$b."<br>";
	
	$imageRes = "results/sorciere.png";
	imagePng($Ires,$imageRes);
?>


<img src="<?php echo $imageSrc;?>"/> <img src="<?php echo $imageRes;?>"/> 
</body>
</html>