<?php
	/*! 
	 * \file testConvertImageTab.php
	 * \brief Reads an image on the disk, creates a copy, saves it and displays both
	 */
	?>

<html>
<body>

<p>
Creates a table from a png image 
</p>



<?php
	require_once("../conf/config.php");
	require_once("src/srcImageIo.php");
	
	// read the image on disk using the imageCreateFromPng GD function
	$imageSrc = "images/sorciere.png";
	$T = tabCreateFromPng($path.$imageSrc);
	
	// convert the table into an image
	$imageRes = "results/sorciereFromTable.png";
	pngCreateFromTab($T,$path.$imageRes);
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