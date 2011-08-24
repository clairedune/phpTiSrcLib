<?php
	/*! 
	 * \file srcHistogram.php
	 * \brief Contrast related functions
	 * \date 21/08/2011
	 * \author Claire Dune, Jean René Tozza
	 *
	 * Point to point transform function to enhance image contrast, build histogram, etc ...  
	 * \warning The functions implemented in this file can only be used on greyscale images
	 *
	 *
	 */
	
	//require_once("../conf/config.php");
	require_once("src/srcConversion.php");
	
	
	/*!
	 * \fn findMin($T)
	 * \brief find the min value of greyscale image
	 *
	 * \param $T is a greyscale image
	 * \return $minT
	 */
	 function findMin($T)
		{
			$minT = 255;
			
			for($i=0;isset($T[$i][0][0]);$i++) 
			{
				for($j=0;isset($T[0][$j][0]);$j++)
				{
					if  ($T[$i][$j][2] < $minT )
						$minT = $T[$i][$j][2];
				}
			}
			
			return $minT;
		}
	
	/*!
	 * \fn findMax($T)
	 * \brief find the max value of greyscale image
	 *
	 * \param $T is a greyscale image
	 * \return $maxT
	 */
	function findMax($T)
	{
		$maxT = 0;
		
		for($i=0;isset($T[$i][0][0]);$i++) 
		{
			for($j=0;isset($T[0][$j][0]);$j++)
			{
				if  ($T[$i][$j][2] > $maxT )
					$maxT = $T[$i][$j][2];
			}
		}
		
		return $maxT;
	}
	
	
	/*!
	 * \fn dynMaxExtension($T)
	 * \brief Extend the image dynamic to [0,255]         
	 *
	 *
	 * \param $T greyscale image 3d table
	 * \return$Tres a greyscale image 3d table with extended dynamic
	 */
	 function dynMaxExtension($T)
	 {
		
		// compute min and max values of T
		 $minT = findMin($T);
		 $maxT = findMax($T);
		 $ampli= $maxT - $minT;
		 
		 // new image dynamics
		 $maxTres = 255;
		 $minTres = 0;
		 
		 if($ampli> 0)
		 {
			 // for all the pixel in the image I,
			 // change the pixel value
			 // to extend the dynamic
			 for($i=0;isset($T[$i][0][0]);$i++) 
			 {
				 for($j=0;isset($T[0][$j][0]);$j++)
				 {
				 	 $Tres[$i][$j][0] = round($minTres + ($T[$i][$j][2] - $minT)*$maxTres/($ampli))  ;
					 $Tres[$i][$j][1] = $Tres[$i][$j][0];
					 $Tres[$i][$j][2] = $Tres[$i][$j][0];
				 }
			 }
			 return $Tres;// tabCreateFromPng("../images/avous.png");
		 }
		 else
		  {
			return tabCreateFromPng("../images/wrong.png"); //$T;
			  
		  }
	 }
	
	
/*!\fn createHistogram($T)
 * \brief Computes a greyscale image's histogram 
 *  
 * \param $T
 * \return $hist
 *
 * \warning createHist is only defined for greyscale image ! 
 */
 function createHistogram($T)
 {
	 // test if it is a greyscale
	 if(!isGreyImage($T))
		 return NULL;
	 // if the image is grey, let's build the histogram
	 else 
	 {
		// initialise histogramme 
		 for( $i = 0 ; $i < 255 ; $i++ )
		 {
			 $hist[$i] = 0;
		 }
		 
		 for($i=0;isset($T[$i][0][0]);$i++) 
		 {
			 for($j=0;isset($T[0][$j][0]);$j++)
			 {
				 $index =$T[$i][$j][2];
				 //echo "index : ".$index."<br>";
				 $hist[$index]++;
			 }
		 }
		
		 return $hist;
	 }
	 
	 
 }
	
	

/*!
 * \fn createImageHistogram( $hist, $width,$height )
 * 
 * \param $hist an histogram
 * \param $height height of the histogram image
 * \param $width width of the histogramm image
 * \return $ImageHist an image
 */
 function createImageHistogram( $hist, $width,$height )
 {
		

		
	 //create the image	
	 $I          = imageCreate( $width ,$height );
	 $background = imageColorAllocate($I, 255, 255, 255);
	 $red        = imageColorAllocate($I, 100, 180, 220);
	 $black      = imageColorAllocate($I,   240,   250,   250);
	 $grey       = imageColorAllocate($I,   200,   200,   200);
	 $title      = "Histogramme";
	 $fontSize   = 15;
	 
	 imageFilledRectangle($I, 
						  0, 
						  0,
						  $width-1,
						  $height-1,
						  $black);
	 
	 imageRectangle($I, 
						  3, 
						  3,
						  $width-4,
						  $height-4,
						  $grey);
	 
	 imageString($I, 
				 $fontSize,
				 ($width-ImageFontWidth($fontSize)*strlen($title))/2,
				 5,
				 $title, 
				 $red);
	 
	 // compute the size of bars
	 $barWidth = (int)(($width-1)/(sizeOf($hist)));
	 
	 // to compute the vertical scale, first determine the max value
	 $max = 0;
	 for ($i=0; isset($hist[$i]); $i++) 
	 {
		 if ($hist[$i]>$max) 
			 $max = $hist[$i];
	 }
	

	 
	 
	 // draw the bars
	 for ($i=0; $i<sizeOf($hist); $i++)
	 {
		 $x = 10+(int)($barWidth*(0.5+$i*1.5));
		 $barHeight = (int)(($hist[$i]*($height-20))/$max);  
		 
		 imageFilledRectangle($I, 
							  $x, 
							  $height-$barHeight-10,
							  $x+$barWidth,
							  $height-10,
							  $red);
	 }
	 
		// return the created image
		return $I;
	}
	
	

