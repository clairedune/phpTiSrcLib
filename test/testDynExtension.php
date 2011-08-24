
<?php
	/*! 
	 * \file testDynExtension.php
	 * \brief enhance an image dynamics
	 */
	
	require_once("../conf/config.php");
	require_once("src/srcImageIo.php");
	require_once("src/srcHistogram.php");
	
	
	
	?>

<html>
<body>

<H1>Enhance image dynamics </H1>
<p>
Convert an RGB image into a greyscale Image
</p>

<?php
	
	// read the image on disk using the imageCreateFromPng GD function
	$imageSrc = "images/kyoto.png";
	$T = tabCreateFromPng($path.$imageSrc)
		or die ("cannot create tab from png");
	
	// enhance the image extension
	$Text=dynMaxExtension($T);
	
	// write the image on the disk
	$imageRes = "results/kyotoExt.png";
	pngCreateFromTab($Text,$path.$imageRes);	
	
	
	// free memory
	unset($T);
	unset($Text);
	?>

<table border="0">
	<tr>
		<th>Original image</td>
		<th>Enhanced image</td>
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