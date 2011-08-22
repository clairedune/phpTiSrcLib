<?php
	//---------------------------------------------------------------//
	// author :			cd
	// creation date :	november 2010
	// brief :			this library contains a set of functions
	//					for image conversion and decomposition
	//					- conversion from RGB to grey
	//					- RGB decomposition
	//					- RGB composition
	// ------------------------------------------------------------- //
	
	require_once("basicImageLib.php");
	
	
	//-----CONVERT RGB TO GREY NAIVE-----//
	// brief :	convert a rgb ressource image 
	//			into a greyscale image
	//			using a naive algorithm
	// input :	source ressource image $I
	// output:	dest ressource image $Igrey
	function convertRGBtoGreyNaive($I)
	{
		
		// create dest image, copy I image//
		$Igrey = createCopy($I);
		
		// get image size (assuming that the 2 images have the same size)// 
		$width = imagesx($I);
		$height = imagesy($I);
		
		// naive Conversion : for all the pixels of the image,
		// compute the average values of the r,g,b componants
		// and use it to set the destination pixel values
		for( $i=0 ; $i<$width ; $i++ )
		{
			for( $j=0 ; $j<$height ; $j++ )
			{
				// for the current pixel I(i,j)
				// read the rgb value
				list( $r , $g , $b ) = getPixelValues( $I , $i , $j );
				
				// compute the mean of the 3 color componants
				$x = round( $r + $g + $b ) / 3;
				
				// create the gd color with the gd function imageColorAllocate 
				$color = imageColorAllocate( $Igrey , $x , $x , $x );
				
				// write the pixel color at the current position in the dest image
				// using the gd function imageSetPixel
				imageSetPixel( $Igrey , $i , $j , $color );
			}
		}
		
		// return the resulting greyscale image
		return $Igrey;
		
	}
	
	//-----CONVERT RGB TO GREY GAMMA-----//
	// brief :	convert a rgb ressource image 
	//			into a greyscale image
	//			with gamma screen correction
	// input :	source ressource image $I
	// output:	dest ressource image $Igrey
	function convertRGBtoGreyGamma($I)
	{
		// create dest image, copy I image//
		
		$Igrey = createCopy($I);
		
		// get image size (assuming that the 2 images have the same size)// 
		$width = imagesx($I);
		$height = imagesy($I);
		
		// conversion with gamma correction : 
		// for all the pixels of the image,
		// compute the greyscale pixelvalue x=0.299r + 0.587g + 0.114b 
		// and use it to set the destination pixel values
		for( $i=0 ; $i<$width ; $i++ )
		{
			for( $j=0 ; $j<$height ; $j++ )
			{
				// for the current pixel I(i,j)
				// read the rgb value
				list( $r , $g , $b ) = getPixelValues( $I , $i , $j );
				
				// compute the weighted sum of the values $r, $g, $b
				$x = round(0.299*$r + 0.587*$g + 0.114*$b);
				
				
				
				// create the gd color with the gd function imageColorAllocate 
				$color = imageColorAllocate( $Igrey , $x , $x , $x );
				
				// write the pixel color at the current position in the dest image
				// using the gd function imageSetPixel
				imageSetPixel( $Igrey , $i , $j , $color );
			}
		}
		
		// return the resulting greyscale image
		return $Igrey;
	}
	
	
	//-----DECOMPOSE RGB-----//
	// brief :	decompose a rgb ressource image 
	//			into 3 greyscale images
	//			which corresponds to the three componant
	//          r, g, b.
	// input :	source ressource image $I
	// output:	an array of 3 dest ressource image $Ir, $Ig, $Ib
	function decomposeRGB($I)
	{
		
	    // create the three resulting images
		$Ir = createCopy($I);
		$Ig = createCopy($I);
		$Ib = createCopy($I);
		
		// get image size
		$width = imagesx($I);
		$height = imagesy($I);
		
		
		// for all the pixel of the image $I
		// get the pixel R,G,B value
		// and set these values to the current pixel 
		// in $Ir, $Ig, $Ib respectively
		for( $i=0 ; $i<$width ; $i++ )
			for( $j=0 ; $j<$height ; $j++ )
			{
				// get the current pixel r,g,b values
				list( $r , $g , $b ) = getPixelValues( $I , $i , $j );
				
				// set the red value to the current pixel in image $Ir
				$colorRed = imagecolorallocate($Ir,$r,$r,$r);
				imagesetpixel($Ir, $i,$j, $colorRed);
				
				// set the green value to the current pixel in image $Ir
				$colorGreen = imagecolorallocate($Ig,$g,$g,$g);
				imagesetpixel($Ig, $i,$j, $colorGreen);
				
				// set the blue value to the current pixel in image $Ir
				$colorBlue = imagecolorallocate($Ib,$b,$b,$b);
				imagesetpixel($Ib, $i,$j, $colorBlue);   
			}
		
		return array($Ir,$Ig,$Ib);
		
	}
	
	
	//-----COMPOSE RGB-----//
	// brief :	compose a rgb ressource image 
	//			from 3 greyscale images
	//			which corresponds to the three componant
	//          r, g, b.
	// input :	3 ressource image $Ir, $Ig, $Ib
	// output:	a rgb image 
	function composeRGB($Ir,$Ig,$Ib)
	{
		// clone one of the images to build the result
		$I = createCopy($Ir);
		
		// we assume that the 3 images have the same size
		$width = imagesx($Ir);
		$height = imagesy($Ir);
		
		
		// for all the pixel of the image $I
		// read the current pixel in 
		// the three input images 
		// use the three values to compose a color
		// set this color to the current pixel in $I 
		for($i=0 ; $i<$width ; $i++)
		{
			for($j=0 ; $j<$height ; $j++)
			{
				list($red,$tmp,$tmp) = getPixelValues($Ir, $i, $j);
				list($green,$tmp,$tmp) = getPixelValues($Ig, $i, $j);
				list($blue,$tmp,$tmp) = getPixelValues($Ib, $i, $j);
				
				$color = imagecolorallocate($I,$red,$green,$blue);
				imagesetpixel($I, $i,$j, $color);
			}
		}
		return $I;
		
	}
	

	//-----DYN EXTENSION-----//
	// brief :	extend the dynamic to [0,255]
	//         
	// input :	a greyscale image
	// output:	a greyscale image with extended dynamic
	function dynExtension($I)
	{
		// create the result image
		$Ires = createCopy($I);
		
		// compute min and max values of I
		list($minI,$maxI) = minMaxImage($I);
		
		 
		// get the image size
		$width = imagesx($I);
		$height = imagesy($I);
		
		
		// for all the pixel in the image I,
		// change the pixel value
		// to extend the dynamic
		for($i=0 ; $i<$width ; $i++)
		{
			for($j=0 ; $j<$height ; $j++)
			{
				
				// the image is greyscale, so
				// only one of the three rgb values is needed
				list($tmp,$tmp,$b) = getPixelValues($I, $i, $j);
		
				
				if($maxI-$minI!=0)
				{
					
					$x = round(($b - $minI)*255/($maxI-$minI))  ;
					
				}
				else
				{
					
					$x=$b;
				}
				$color = imagecolorallocate($Ires,$x,$x,$x);
				imagesetpixel($Ires, $i,$j, $color);
			}
		}
		
		
		
		return $Ires;
	}
	
	
