<?php
/*! 
 * \file srcImage.php
 * \brief this file contains basic functions for images such image reading or writing, pixel reading
 * \date 21/08/2011
 * \author Claire Dune, Jean René Tozza
 */
		
/*!
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
 * Example : display the values of the pixel (10,5)
 * \code
 * <?php
 *
 * // read the image on disk using the imageCreateFromPng GD function
 * $imageFile = "images/sorciere.png"
 * $I = imageCreateFromPng($imagefile);
 *
 * // pixel coordinates
 * $i = 10;
 * $j = 5;
 *
 * // get the pixel R, G, and B values
 * list( $r , $g , $b ) = convertImage2Tab( $I );
 *
 * echo "The red value is ".$r;
 * echo "The green value is ".$g;
 * echo "The blue value is ".$b;
 * ?>
 *
 * \example test/displayImage.php
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
 * \brief Set the 3 values of a pixel
 *
 * Set the color of a pixel using 3 rgb values of a pixel (i,j) 
 * using the gd function ImageSetPixel and imageColorAllocate (see gd library documentation for further details)
 *
 * \param $I ressource image 
 * \param $i int x-coordinate
 * \param $j int y-coordinate
 * \return $red int the red componant
 * \return $green int the green componant
 * \return $blue int the blue componant
 *
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
 * \return $w is the image width
 * \return $h is the image height
 * \return $T is a 3D table
 *
 * \sa getPixelValues( $I, $i, $j )
 *
 * Example : read a source image and convert it into a table
 * \code
 * <?php
 * $imageFile = "images/sorciere.png"
 * $I = imageCreateFromPng($imagefile);
 * $T = convertImage2Tab( $I );
 * ?>
 * \endcode
 */
function convertImage2Tab( $I )
{
	$w = imagesx( $I );
	$h = imagesy( $I );
	
	$T = array(array(array())); // not mendatory
		
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
	return array($T , $w , $h );
}
	
	
/*! 
 * \fn convertTab2Image($T,$width,$height)
 * \brief this function convert a table into a RGB image
 *
 * \param $T is a 3D table storing values of an RGB image
 * \param $w is the image width
 * \param $h is the image height
 * \return $I a ressource image
 */
function convertTab2Image( $T , $w , $h )
{
	//create the image	
	$I  = imageCreateTrueColor( $w ,$h );
		
	for( $i=0 ; $i < $width ; $i++ )
	{
		for( $j=0 ; $j < $height ; $j++)
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
 * \fn createCopy( $I )
 * \brief Create a copy of the input image
 * This copy can then be used without changing the source image
 *
 * \param $I ressource image mode rgb 
 * \return 	$Ires ressource image mode rgb
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
	
	
/*!
 * \fn minMaxImage($I)
 * \brief Get min and max value of a greyscale image
 *
 * \param $I ressource image
 * \return $minI minimum value of the greyscale image 
 * \return $maxI maximum value of the greyscale image
*/
function minMaxImage( $I )
{
	// get width and height
	$width = imagesx( $I );
	$height = imagesy( $I );
		
	$minI = 300; // any value > 255
	$maxI = -1 ; // any value < 0 
		
	for( $i=0 ; $i < $width ; $i++)
		{
			for( $j = 0 ; $j < $height ; $j++)
			{
		        list( $r , $g , $b) = getPixelValues( $I , $i , $j );
				
				// test for max
				if( $b > $maxI )
				{
					$maxI = $b;
				}
				
				// test for min
				if( $b < $minI )
				{
					$minI = $b;
				}
				
			}
		}
		// return image
		return array( $minI , $maxI );
		
}

/*!
 * 
 *\brief This function saves a table $T as a PNG image with namefile $name 
 *
 *\param $filename image name
 *\param $T rgb table
 */
function createImagePNG($filename,$T)
{
	$f = fopen($filename,'w');
	fwrite( $f , serialize( $T ) );
	fclose( $f );
}

/*!
 * 
 *\brief This function compress a table $T as a zipped PNG image with namefile $name 
 *
 *\param $filename image name
 *\param $T rgb table
 */

function zip( $filename , $T )
{	
	createImagePNG( $filename , $T );
	exec("gzip $filename");
}


