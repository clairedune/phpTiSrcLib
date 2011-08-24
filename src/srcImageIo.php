<?php
/*! 
 * \file srcImageIo.php
 * \brief Basic image reading and writing image functions
 * \date 21/08/2011
 * \author Claire Dune, Jean René Tozza
 *
 * This file contains basic functions for images such image reading or writing, pixel reading 
 */
		
/*!
 * \fn getPixelValues( $I , $i , $j )
 * \brief Get the 3 values of a pixel
 *
 * Return the 3 values of a pixel (i,j) using the gd function ImageColorAt (see gd library documentation for further details)
 *
 * \param $I ressource image 
 * \param $i int x-coordinate
 * \param $j int y-coordinate
 * \return $red int the red componant
 * \return $green int the green componant
 * \return $blue int the blue componant
 *
 *
 *
 * Example : display the values of the pixel (10,5)
 * \code
 *	// read the image on disk using the imageCreateFromPng GD function
 *	$imageFile = "images/sorciere.png"
 *	$I = imageCreateFromPng($imagefile);
 *
 *	// pixel coordinates
 *	$i = 10;
 *	$j = 5;
 *
 *	// get the pixel R, G, and B values
 *	list( $r , $g , $b ) = convertImage2Tab( $I );
 *	
 *	echo "The red value is ".$r;
 *	echo "The green value is ".$g;
 *	echo "The blue value is ".$b;
 *  \endcode 
 *
 * \sa  setPixelValues
 *
 */
function getPixelValues( $I , $i , $j )
{	
	$rgb= ImageColorAt( $I , $i , $j ); // gd function
	$red= ( $rgb>>16 ) & 0xFF;
	$green = ( $rgb>>8 ) & 0xFF;
	$blue= ( $rgb ) & 0xFF;
	return array( $red , $green , $blue );
}
	

	
/*!
 * \fn  setPixelValues( $I , $i , $j , $r, $g , $b )
 * \brief Set the 3 values of a pixel
 *
 * Set the color of a pixel using 3 rgb values of a pixel (i,j) 
 * using the gd function ImageSetPixel and imageColorAllocate (see gd library documentation for further details)
 *
 * \param $I ressource image 
 * \param $i int x-coordinate
 * \param $j int y-coordinate
 * \param $r int the red componant
 * \param $g int the green componant
 * \param $b int the blue componant
 * \return $I the modified image
 * \sa getPixelValues
 */
function setPixelValues( $I , $i , $j , $r, $g , $b )
{
	// build the color 
	$c = imageColorAllocate( $I , $r , $g , $b );
	// set the color to the pixel
	imageSetPixel( $I , $i , $j , $c );
	return $I;
}
	
	
/*! 
 * \fn convertImage2Tab($I)
 * \brief Convert a RGB image into a 3D table
 *
 * \param $I a ressource image
 * \return $width is the image width
 * \return $height is the image height
 * \return $T is a 3D table
 *
 * \sa getPixelValues( $I, $i, $j )
 *
 * Example : read a source image and convert it into a table
 * \code
 * $imageFile = "images/sorciere.png"
 * $I = imageCreateFromPng($imagefile);
 * $T = convertImage2Tab( $I );
 * \endcode
 *
 * \sa convertTab2Image
 */
function convertImage2Tab( $I )
{
	$width  = imagesx( $I );
	$height = imagesy( $I );
	
	for( $i = 0 ; $i < $width ; $i++ )
	{
		for( $j = 0 ; $j < $height ; $j++ )
		{
			list( $r , $g , $b ) = getPixelValues( $I , $i , $j );
			$T[ $i ][ $j ][ 0 ] = $r;
			$T[ $i ][ $j ][ 1 ] = $g;
			$T[ $i ][ $j ][ 2 ] = $b;
		}
	}
	return $T;
}
	
	
/*! 
 * \fn convertTab2Image($T)
 * \brief this function convert a table into a RGB image
 *
 * \param $T is a 3D table storing values of an RGB image
 * \return $I a ressource image
 *
 *
 *
 * Example : read an image, convert it to a table and then convert it into an image
 * \code
 *	// read the image on disk using the imageCreateFromPng GD function
 *	$imageSrc = "images/sorciere.png";
 *
 *	$I = imageCreateFromPng($path.$imageSrc) 
 *		or die("cannot create the image");
 *
 *	list($T,$w,$h) = convertImage2Tab( $I )
 *		or die ("cannot convert image");
 *
 *	$Ires = convertTab2Image($T,$w,$h)
 *		or die("cannot convert the tab");
 *
 *	$imageRes = "results/sorciere.png";
 *	imagePng($Ires,$path.$imageRes)
 *		or die("cannot create the image res");
 * \endcode 
 *
 * \sa convertImage2Tab
 */
function convertTab2Image( $T )
{
	
	//get width and height
	$width = sizeof($T);
	$height = sizeof($T[0]);

	//create the image	
	$I  = imageCreateTrueColor( $width ,$height );
		
	for($i=0;isset($T[$i][0][0]);$i++) 
	{
		for($j=0;isset($T[0][$j][0]);$j++)
		{
			// get r, g and b values in the table
			$r = $T[ $i ][ $j ][ 0 ];
			$g = $T[ $i ][ $j ][ 1 ];
			$b = $T[ $i ][ $j ][ 2 ];
			// build the color 
			$c = imageColorAllocate( $I , $r , $g , $b );
			// set the color to the pixel
			imageSetPixel( $I , $i , $j , $c );
		}
	}
	// return the created image
	return $I;
}

	
	
/*! 
 * \fn tabCreateFromPng($filename)
 * \brief store the image data in a table
 * 
 * \param $filename image path
 * \return $T a 3D table containing the image information
 * \return $w the image with
 * \return $h the image height	
 *
 * \sa pngCreateFromTab
 */
function tabCreateFromPng($filename)
{
	$I = imageCreateFromPng($filename);
	return convertImage2Tab( $I );
	
}
	
	
/*! 
 * \fn pngCreateFromTab($T,$filename)
 * \brief create an image png from tab
 * 
 * \param $filename image path
 * \param $T a 3D table containing the image information	
 *
 * Example
 * \code
 * $imageSrc = "images/highway.png";
 * $Trgb = tabCreateFromPng($path.$imageSrc)
 *	or die ("cannot create tab from png");
 * \endcode
 *
 * \sa tabCreateFromPng
 */
function pngCreateFromTab($T,$filename)
{
	$Ires = convertTab2Image($T);
	imagePng($Ires,$filename);		
}
	
	
/*!
 * \fn createCopy( $I )
 * \brief Create a copy of the input image
 *
 * This copy can then be used without changing the source image
 *
 * \param $I ressource image mode rgb 
 * \return 	$Ires ressource image mode rgb
 *
 *
 *
 * Example : read an image and create a copy
 * \code
 *	// read the image on disk using the imageCreateFromPng GD function
 *	$imageSrc = "images/sorciere.png";
 *	$I = imageCreateFromPng($path.$imageSrc) 
 *		or die("ERROR : cannot open the image");
 *
 *	// copy the image and save the result
 *	$Ires = createCopy( $I )
 *		or die("ERROR : cannot create the copy");
 *  \endcode
 */	
function createCopy( $I )
{
	// get width and height
	$width = imagesx( $I );
	$height = imagesy( $I );
		
	// clone image
	$Ires = imageCreateTrueColor($width,$height);
	imageCopy($Ires,$I,0,0,0,0, $width, $height);
		
	// return image
	return $Ires;		
}

/*!
 * \fn difference($I1,$I2)
 * \brief Compute the difference between two images
 *
 * \param $I1 ressource image
 * \param $I2 ressource image
 * \return $Idiff the difference of the two greyscale images
 * 
 * An example of use
 * \code
 *	// read the image on disk using the imageCreateFromPng GD function
 *	$imageSrc = "images/sorciere.png";
 *	$I = imageCreateFromPng($path.$imageSrc) 
 *		or die("ERROR : cannot open the image");
 *
 *	// copy the image and save the result
 *	$Ires = createCopy( $I )
 *		or die("ERROR : cannot create the copy");
 *
 *	// create a difference image
 *	$Idiff = difference ($I,$Ires)
 *		or die ("ERROR cannot compute the difference");
 *
 *	// save the difference image, if image are the same, this image should be black
 *	$imageDiff = "results/sorciereDiff.png";
 *	imagePng( $Ires, $path.$imageDiff )
 *		or die ("ERROR : cannot save the image");
 *	\endcode
 */
function difference( $I1 , $I2 )
{
	// get width and height
	$width = imagesx( $I1 ); //gd function
	$height = imagesy( $I1 ); //gd function
		
	// create the result image
	// its size is the same as the image $I1
	// assuming that $I1 and $I2 have the same size
	$Idiff = createCopy($I1);
		
	for( $i = 0 ; $i < $width ; $i++)
	{
		for( $j = 0 ; $j < $height ; $j++)
		{
			list( $r1 , $g1 , $b1 ) = getPixelValues( $I1 , $i , $j );
			list( $r2 , $g2 , $b2 ) = getPixelValues( $I1 , $i , $j );
			$diff = round( abs( $r1 - $r2 ) );
			$c = imageColorAllocate( $Idiff, $diff , $diff , $diff );
			imageSetPixel( $Idiff, $i, $j, $c );			
		}
	}
				
	// return image
	return $Idiff;
}
	
	
	



