<html>
<body>

<p>
Display the image "sorciere.png".
</p>

<?php
	// read the image on disk using the imageCreateFromPng GD function
	$imageSrc = "../images/sorciere.png";
	$I = imageCreateFromPng($imageSrc) 
		or die("cannot create the image");
?>

<img src="<?php echo $imageSrc;?>"/> 

</body>
</html>