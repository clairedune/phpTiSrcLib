<?php
/*! 
 * \file srcConversion.php
 * \brief This files contains function to convert an image table from one color mode to another
 * \date 21/08/2011
 * \author Claire Dune, Jean René Tozza
 */


 /*!
 * \fn convertRgb2Yuv($Trgb)
 * \brief Convert a table that represents a RGB image into a table that represents a YUV image
 * \author J.R. Tozza
 * \date 2010
 *
 * The algorithm is the following : \n For every pixel in RGB mode, build the corresponding pixel in YUV mode: \n
 * 
 * \f$ Y = 0.299R+0.587G+0.114B\f$ \n
 * \f$ U = -0.1687R-0.3313G+0.5B+128\f$ \n
 * \f$ V = 0.5R-0.41874G-0.0813B+128\f$ \n
 * 
 * \param $Trgb a RGB table
 * \return $Tyuv a YUV table
 *
 *
 * Example : 
 * 
 * \code
 * // read the image on disk using the imageCreateFromPng GD function
 * $imageSrc = "images/highway.png";
 * $Trgb = tabCreateFromPng($path.$imageSrc)
 *		or die ("ERROR : cannot create tab from png");
 *  
 * // convert to an YUV image
 * $Tyuv = convertRgb2Yuv( $Trgb )
 *		or die ("ERROR: conversion rgb to yuv");
 *
 *   .... 
 *
 * // free memory
 * unset($Trgb);
 * unset($Tyuv);
 * \endcode
 *
 *
 * \sa convertYuv2Rgb
 */
	
	
function convertRgb2Yuv( $Trgb )
{
	for($i=0;isset($Trgb[$i][0][0]);$i++) 
	{
		for($j=0;isset($Trgb[0][$j][0]);$j++)
		{
			$Tyuv[$i][$j][0]= round( 0.299 * $Trgb[$i][$j][0] + 0.587 * $Trgb[$i][$j][1] + 0.114 * $Trgb[$i][$j][2] );
			$Tyuv[$i][$j][1]= round( -0.1687 * $Trgb[$i][$j][0] - 0.3313 * $Trgb[$i][$j][1] + 0.5 * $Trgb[$i][$j][2] + 128 );
			$Tyuv[$i][$j][2]= round( 0.5 * $Trgb[$i][$j][0] - 0.41874 * $Trgb[$i][$j][1] - 0.0813 * $Trgb[$i][$j][2] + 128 );
		}
	}
	return $Tyuv;
}
	
	
	
/*!
 * \fn convertYuv2Rgb($Y)
 * \brief Convert a table that represents a YUV image into a table that represents a RGB image
 * \author J.R. Tozza
 * \date 2010
 *
 * The algorithm is the following : \n For every pixel in YUV mode, build the corresponding pixel in RGB mode: \n
 * 
 * \f$ R = Y + 1.402 (V - 128 )                         \f$ \n
 * \f$ G = Y - 0.34414 ( U - 128 )- 0.71414( V - 128 )  \f$ \n
 * \f$ B = Y + 1.772 ( U - 128 )                        \f$ \n
 *
 * \param $Y a YUV table
 * \return $T a RGB table
 *
 *
 *Example
 * \code
 * // read the image on disk using the imageCreateFromPng GD function
 * $imageSrc = "images/highway.png";
 * $Trgb = tabCreateFromPng($path.$imageSrc)
 *		or die ("ERROR : cannot create tab from png");
 *  
 * // convert to an YUV image
 * $Tyuv = convertRgb2Yuv( $Trgb )
 *		or die ("ERROR: conversion rgb to yuv");
 *
 * // convert the YUV image into a RGB image
 * $Trgb2=convertYuv2Rgb($Tyuv)
 *		or die ("ERROR: conversion yuv to rgb");
 *	
 *
 * // write the image on the disk
 * $imageResRGB = "results/highwayRGB.png";
 * pngCreateFromTab($Trgb2,$path.$imageResRGB);
 *
 * // free memory
 * unset($Trgb);
 * unset($Tyuv)
 * unset($Trgb2);
 *
 * \endcode
 *
 * \sa convertRgb2Yuv
 */	
 function convertYuv2Rgb($Y)
{		
		
		for($i=0;isset($Y[$i][0][0]);$i++) 
		{
			
			for($j=0;isset($Y[0][$j][0]);$j++)
			{
				
				$T[$i][$j][0]=round($Y[$i][$j][0]+1.402*($Y[$i][$j][2]-128));
				$T[$i][$j][1]=round($Y[$i][$j][0]-0.34414*($Y[$i][$j][1]-128)-0.71414*($Y[$i][$j][2]-128));
				$T[$i][$j][2]=round($Y[$i][$j][0]+1.772*($Y[$i][$j][1]-128));
				
			}
		}
		return $T;
	}
	
	
	
/*!
 *\fn convertRgb2GreyNaive( $Trgb)
 * \brief 	convert a rgb ressource image into a greyscale image
 * \author Claire Dune
 * \date 21/08/2011
 *
 * This function uses the following naive algorithm. 
 * For every pixels in RGB mode,
 * compute the average values of the R,G,B componants
 * and set the destination pixel values to this average value:\n
 * \fn$ X = (R+G+B)/3\fn$\n
 * 
 * Notice that for a greyscale image, the three values R, G and B are equal to X
 *
 * \param $Trgb a table that stores a RGB image
 * \return $Tgrey	a table that stores a grey image 
 *
 *
 *
 * An example of use : 
 *\code
 * // read the image on disk using the imageCreateFromPng GD function
 * $imageSrc = "images/highway.png";
 * $Trgb = tabCreateFromPng($path.$imageSrc)
 *	or die ("cannot create tab from png");
 * 
 * // convert to greyscale image
 * $TgreyNaive = convertRgb2GreyNaive($Trgb);
 * // write the image on the disk
 * $imageResNaive = "results/highwayNaiveGreyNaive.png";
 * pngCreateFromTab($TgreyNaive,$path.$imageResNaive);
 *
 *
 * // free memory
 * unset($TgreyGamma);
 *
 * \endcode
 *
 *
 * 
 * \sa convertRgb2GreyGamma
 */
 function convertRgb2GreyNaive( $Trgb)
 {
	for( $i=0 ; isset( $Trgb[$i][0][0]); $i++ ) 
	{
		for( $j=0 ; isset( $Trgb[0][$j][0]); $j++ )
		{
				$Tgrey[$i][$j][0] = round( ($Trgb[$i][$j][0] + $Trgb[$i][$j][1] + $Trgb[$i][$j][2])/3 );
				$Tgrey[$i][$j][1] = $Tgrey[$i][$j][0];
				$Tgrey[$i][$j][2] = $Tgrey[$i][$j][0];
				
		}
	}
	return $Tgrey;
 }
	
	
/*!
 * \fn convertRgb2GreyGamma( $Trgb)
 * \brief Convert a rgb ressource image into a greyscale image with a gamma correction
 * \author Claire Dune
 * \date 21/08/2011 
 *
 *	 This function convert an RGB image to a greyscale image with a gamma correction.  
 *	 For every pixels in RGB mode, 
 *	 compute the corresponding greyscale value:\n
 *	 
 *	 \fn$ $x = round(0.299*$r + 0.587*$g + 0.114*$b); \fn$\n
 * 	 
 *	 Notice that for a greyscale image, the three values R, G and B are equal to X
 * 	 
 * 	 \param $Trgb a table that stores a RGB image
 * 	 \return $Tgrey	a table that stores a grey image 
 *	 
 * Example : 
 * \code
 *	 
 * // read the image on disk using the imageCreateFromPng GD function
 * $imageSrc = "images/highway.png";
 * $Trgb = tabCreateFromPng($path.$imageSrc)
 *	or die ("cannot create tab from png");
 * 
 *
 * // convert to greyscale image with gamma correction
 * $TgreyGamma = convertRgb2GreyGamma( $Trgb);
 *
 * // write the image on the disk
 * $imageResGamma = "results/highwayNaiveGreyGamma.png";
 * pngCreateFromTab($TgreyGamma,$path.$imageResGamma);
 * 
 * // free memory
 * unset($TgreyGamma);
 * 	 \endcode
 *
 * \sa convertRgb2GreyNaive
 */
function convertRgb2GreyGamma( $Trgb)
{
	for( $i=0 ; isset( $Trgb[$i][0][0]); $i++ ) 
	{
		for( $j=0 ; isset( $Trgb[0][$j][0]); $j++ )
		{
			
			$Tgrey[$i][$j][0] = round( 0.299*$Trgb[$i][$j][0] + 0.587*$Trgb[$i][$j][1] + 0.114*$Trgb[$i][$j][2]);
			$Tgrey[$i][$j][1] = $Tgrey[$i][$j][0];
			$Tgrey[$i][$j][2] = $Tgrey[$i][$j][0];
			
		}
	}
	return $Tgrey;
}
	
	
/*!
 * \fn isGreyImage($T)
 * \brief Tests isf an image is a color image or an RGB image	
 *
 * If an image is a greyscale image, then for all the pixel, R=G=B=X, where X is the grey value
 * 	
 * \param $T an image
 * \return $test true if the image is a greyscale image and false if it is not 
 *
 * Example	
 * \code
 * // read an image on the disk 
 * $imageSrc = "images/highway.png";
 * $Trgb = tabCreateFromPng($path.$imageSrc)
 *	or die ("cannot create tab from png");
 * // test if this image is a greyscale image
 * if(isGreyImage($Trgb))
 *	echo $imageSrc." is a greyscale image<br>";
 * else
 * 	echo $imageSrc." is a color image<br>";
 *  	
 */ 

 function isGreyImage($T)
	{
		for( $i=0 ; isset( $T[$i][0][0]); $i++ ) 
		{
			for( $j=0 ; isset( $T[0][$j][0]); $j++ )
			{
			  if($T[$i][$j][0]!=$T[$i][$j][1]
				 || $T[$i][$j][0]!=$T[$i][$j][2]
				 || $T[$i][$j][1]!=$T[$i][$j][2])
				{
					return FALSE;
				}		
			}
		}
		return TRUE;
	}
	
