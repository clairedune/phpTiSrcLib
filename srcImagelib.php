<?php
/*! 
 * \file srcImageLib.php
 * \brief this file contains basic image functions such as pixel reading or image writing
 * \author Claire Dune, Jean René Tozza
 */
	
	
/*! \mainpage Welcome to the SRC Image Library
*
* \section Introduction
*
* You will use this few function for the numerisation class (S2) as well 
* as the image processing and the compression class (S3)
*
* \section How to install this library ?
*
* \subsection Step 1 : simply copy the folder libtisrc in your www folder
* \subsection Step 2 : include the file you need in your php header 
* \code
* <?php
* include('srcImageLib.php');
* ?>
* \endcode 
*/
	
/*!
 * \fn list( $red , $green , $blue )  getPixelValues( $I , $i , $j )
 * \brief Return the 3 values RGB of a pixel (i,j)
 *
 * \author
 *
 * \param $I ressource image 
 * \param $i int x-coordinate
 * \param $j int y-coordinate
 *
 * \return $red int the red componant
 * \return $green int the green componant
 * \return $blue int the blue componant
 *
 *
 \code
 list( $red , $green , $blue )  getPixelValues( $I , $i , $j )
  \endcode
*/
function getPixelValues( $I , $i , $j )
{
	$rgb= ImageColorAt( $I , $i , $j );
	$red = ( $rgb>>16 ) & 0xFF;
	$green = ( $rgb>>8 ) & 0xFF;
	$blue= ( $rgb ) & 0xFF;
	return array( $red , $green , $blue );
}
	
	
/*! 
 * \fn convertImage2Tab($I)
 * \brief this function convert a RGB image into a 3D table
 *
 * \param $I a ressource image
 *
 * \return $w is the image width
 * \return $h is the image height
 * \return $T is a 3D table
 *
 * \sa getPixelValues( $I, $i, $j )
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
 *
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
 *
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
 * \fn
 *
 *
*/
function convertRGB2YUV($T){
		
		for($i=0;isset($T[$i][0][0]);$i++) {
			for($j=0;isset($T[0][$j][0]);$j++){
				
				$Y[$i][$j][0]=round(0.299*$T[$i][$j][0]+0.587*$T[$i][$j][1]+0.114*$T[$i][$j][2]);
				$Y[$i][$j][1]= round(-0.1687*$T[$i][$j][0]-0.3313*$T[$i][$j][1]+0.5*$T[$i][$j][2]+128);
				$Y[$i][$j][2]= round(0.5*$T[$i][$j][0]-0.41874*$T[$i][$j][1]-0.0813*$T[$i][$j][2]+128);
			}
		}
		return $Y;
		
		
	}

/*!
 * \fn difference($I1,$I2)
 * \brief Compute the difference between two images
 *
 * \param $I1 ressource image
 * \param $I2 ressource image
 *
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
 * \param $I ressource image
 * \return $minI minimum value of the greyscale image 
 * \retunr $maxI maximum value of the greyscale image
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