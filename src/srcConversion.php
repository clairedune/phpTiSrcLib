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
 *
 * \author J.R. Tozza
 * \date 2010
 *
 * The algorithm is the following : \n For every pixel in RGB mode, build the corresponding pixel in YUV mode: \n
 * 
 * \f$Y = 0.299R+0.587G+0.114B\f$ \n
 * \f$U = -0.1687R-0.3313G+0.5B+128\f$ \n
 * \f$V = 0.5R-0.41874G-0.0813B+128\f$ \n
 *
 * \param $Trgb a RGB table
 * \return $Tyuv a YUV table
 * 
 */
function convertTabRgb2Yuv( $Trgb )
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
 * \brief 	convert a rgb ressource image into a greyscale image
 * 
 * This function uses the following naive algorithm. 
 * For every pixels in RGB mode,
 * compute the average values of the R,G,B componants
 * and set the destination pixel values to this average value:\n
 * \fn$ X = (R+G+B)/3\fn$\n
 * 
 * Notice that for a greyscale image, the three values R, G and B are equal to X
 *
 *\author Claire Dune
 *\date 21/08/2011
 *
 * \param $Trgb a table that stores a RGB image
 * \return $Tgrey	a table that stores a grey image 
 *
 *\code
 *
 *
 *
 *\endcode
 */
function convertTabRgb2GreyNaive( $Trgb , $w , $h)
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
