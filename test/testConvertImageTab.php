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
	require_once("src/srcImageIo.php");
	
	
	// read the image on disk using the imageCreateFromPng GD function
	$imageSrc = "images/sorciere.png";
	$I = imageCreateFromPng($path.$imageSrc) 
		or die("cannot create the image");
	
	// direct : convert image to tab
	$T = convertImage2Tab( $I )
		or die ("cannot convert image");

	
	// inverse : convert tab to image
	$Ires = convertTab2Image($T)
		or die("cannot convert the tab");
	
	// save image on disk
	$imageRes = "results/sorciere2.png";
	imagePng($Ires,$path.$imageRes)
		or die("cannot create the image res");
	?>

<table border="0">
	<tr>
		<th>Original image</td>
		<th>Copied image</td>
	</tr>
	<tr>
	<!--Here we need url-->
		<td><img src="<?php echo $url.$imageSrc;?>"/></td>
		<td><img src="<?php echo $url.$imageRes;?>"/></td>
	</tr>
	<tr>
		<td><?php echo $imageSrc;?></td>
		<td><?php echo $imageRes;?></td>
	</tr>
</table>




</body>
</html>