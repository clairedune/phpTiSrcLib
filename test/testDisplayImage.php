<?php
	/*! 
	 * \file testDisplayImage.php
	 * \brief Reads an image on the disk, creates a copy, saves it and displays both
	 */
?>
	
<html>
<body>

<p>
Display the image "sorciere.png".
</p>

<?php
	
	require_once("../conf/config.php");
	require_once("src/srcImageIo.php");

	
	// read the image on disk using the imageCreateFromPng GD function
	$imageSrc = "images/sorciere.png";
	$I = imageCreateFromPng($path.$imageSrc) 
		or die("ERROR : cannot open the image");
	
	// copy the image and save the result
	$Ires = createCopy( $I )
		or die("ERROR : cannot create the copy");
	
    // save the copied image
	$imageCopy = "results/sorciere.png";
	imagePng( $Ires, $path.$imageCopy )
		or die ("ERROR : cannot save the image");
	
	// create a difference image
	$Idiff = difference ($I,$Ires)
		or die ("ERROR cannot compute the difference");
	
	// save the difference image, if image are the same, this image should be black
	$imageDiff = "results/sorciereDiff.png";
	imagePng( $Ires, $path.$imageDiff )
		or die ("ERROR : cannot save the image");
	
	
?>

<table border="0">
	<tr>
		<th>Original image</td>
		<th>Copied image</td>
		<th>Difference</td>
	</tr>
	<tr>
		<!--Here we need url-->
		<td><img src="<?php echo $url.$imageSrc;?>"/></td>
		<td><img src="<?php echo $url.$imageCopy;?>"/></td>
		<td><img src="<?php echo $url.$imageDiff;?>"/></td>
	</tr>
	<tr>
		<td><?php echo $imageSrc;?></td>
		<td><?php echo $imageCopy;?></td>
		<td><?php echo $imageDiff;?></td>
	</tr>
</table>
  



</body>
</html>