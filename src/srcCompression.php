<?php

	/*! 
	 * \file srcCompression.php
	 * \brief This files contains specific functions for the compression class
	 * \date 21/08/2011
	 * \author Claire Dune, Jean René Tozza
	 */
	
	
	/*!
	 *
	 * \brief reduces the U and V planes by 2
	 *
	 * \param $Y est un tableau 3D qui correspond aux 3 plans Y U V 
	 * \return $quu tableau 3D dont les plan U et V sont 4 fois plus petit
	 *
	 */ 
	function quatreunun($Y)
	{
		
		for($i=0;isset($Y[2*$i][0][0]);$i++) 
		{
			for($j=0;isset($Y[0][2*$j][0]);$j++)
			{
				$quu[2*$i]  [2*$j]  [0]= $Y[2*$i]  [2*$j]  [0];
				$quu[2*$i]  [2*$j+1][0]= $Y[2*$i]  [2*$j+1][0];
				$quu[2*$i+1][2*$j]  [0]= $Y[2*$i+1][2*$j]  [0];
				$quu[2*$i+1][2*$j+1][0]= $Y[2*$i+1][2*$j+1][0];
				
				$quu[$i][$j][1]        = $Y[2*$i]  [2*$j]  [1];
				$quu[$i][$j][2]        = $Y[2*$i]  [2*$j]  [2];
			}
		}
		
		return $quu;
	}
	
	
	/*!
	 *
	 * \brief recompose an yuv image from a reduced one
	 *
	 * \param $quu a 3D table where the  U and V planes are 4 times smaller
	 * \return $Y is a 3D table that represents an yuv image
	 */
	function inv_quatreunun($quu){
		
		
		for($i=0;isset($quu[$i][0][1]);$i++) {
			for($j=0;isset($quu[0][$j][1]);$j++){
				
				$Y[2*$i][2*$j][0]=$quu[2*$i][2*$j][0];
				$Y[2*$i+1][2*$j][0]=$quu[2*$i+1][2*$j][0];
				$Y[2*$i][2*$j+1][0]=$quu[2*$i][2*$j+1][0];
				$Y[2*$i+1][2*$j+1][0]=$quu[2*$i+1][2*$j+1][0];
				
				
				
				$Y[2*$i][2*$j][1]=$quu[$i][$j][1];
				$Y[2*$i+1][2*$j][1]=$quu[$i][$j][1];
				$Y[2*$i][2*$j+1][1]=$quu[$i][$j][1];
				$Y[2*$i+1][2*$j+1][1]=$quu[$i][$j][1];
				
				$Y[2*$i][2*$j][2]=$quu[$i][$j][2];
				$Y[2*$i+1][2*$j][2]=$quu[$i][$j][2];
				$Y[2*$i][2*$j+1][2]=$quu[$i][$j][2];
				$Y[2*$i+1][2*$j+1][2]=$quu[$i][$j][2];		
				
			}
		}
		
		return $Y;
		
		
		
	}
	
	
	/*!
	*\fn jrTransform($T) 
	*\brief time to frequency transform 
	* 
	*\param $T is a 3D table where YUV layers are 4:4:4 or 4:1:1;
	*\return $jrt the frequency response 
	*/ 
	function jrTransform($T){
		
		for($p=0;$p<3;$p++){
			for($i=0;isset($T[4*$i][0][$p]);$i++) {
				for($j=0;isset($T[0][$j][$p]);$j++){
					
					$jrt[4*$i][$j][$p]=($T[4*$i][$j][$p]+$T[4*$i+1][$j][$p]+$T[4*$i+2][$j][$p]+$T[4*$i+3][$j][$p])/4;
					$jrt[4*$i+1][$j][$p]=($T[4*$i][$j][$p]+$T[4*$i+1][$j][$p]-$T[4*$i+2][$j][$p]-$T[4*$i+3][$j][$p])/4;
					$jrt[4*$i+2][$j][$p]=($T[4*$i][$j][$p]-$T[4*$i+1][$j][$p]-$T[4*$i+2][$j][$p]+$T[4*$i+3][$j][$p])/4;
					$jrt[4*$i+3][$j][$p]=($T[4*$i][$j][$p]-$T[4*$i+1][$j][$p]+$T[4*$i+2][$j][$p]-$T[4*$i+3][$j][$p])/4;		
					
				}	
			}
		}
		
		return $jrt;
		
	}
	
	
	/*!
	 *\fn inv_jrTransform($JRT) 
	 *\brief frequency to time transform 
	 *
	 *\param $JRT the frequency representation
	 *\return $ijrt is a 3D table where YUV layers are 4:4:4 or 4:1:1;
	 *
	 */ 
	
	function inv_jrTransform($JRT){
		
		for($p=0;$p<3;$p++){
			for($i=0;isset($JRT[4*$i][0][$p]);$i++) {
				for($j=0;isset($JRT[0][$j][$p]);$j++){
					
					$ijrt[4*$i][$j][$p]=$JRT[4*$i][$j][$p]+$JRT[4*$i+1][$j][$p]+$JRT[4*$i+2][$j][$p]+$JRT[4*$i+3][$j][$p];
					$ijrt[4*$i+1][$j][$p]=$JRT[4*$i][$j][$p]+$JRT[4*$i+1][$j][$p]-$JRT[4*$i+2][$j][$p]-$JRT[4*$i+3][$j][$p];
					$ijrt[4*$i+2][$j][$p]=$JRT[4*$i][$j][$p]-$JRT[4*$i+1][$j][$p]-$JRT[4*$i+2][$j][$p]+$JRT[4*$i+3][$j][$p];
					$ijrt[4*$i+3][$j][$p]=$JRT[4*$i][$j][$p]-$JRT[4*$i+1][$j][$p]+$JRT[4*$i+2][$j][$p]-$JRT[4*$i+3][$j][$p];		
					
				}	
			}
		}
		
		return $ijrt;
		
	}
	
	
	
	/*!
	 * \fn quantifie ( $JRT , $Q )
	 * \brief Quantify a frequency response with the quality factor Q
	 *
	 * \param $JRT a frequency response
	 * \param $Q a quality factor
	 * \return  $quan the quantified frequency response
	 */
	 function quantifie($JRT,$Q)
	{
		
		for($p=0;$p<3;$p++){
			for($i=0;isset($JRT[4*$i][0][$p]);$i++) {
				for($j=0;isset($JRT[0][$j][$p]);$j++){
					
					$quan[4*$i][$j][$p]=round($JRT[4*$i][$j][$p]/(2*$Q));
					$quan[4*$i+1][$j][$p]=round($JRT[4*$i+1][$j][$p]/(4*$Q));
					$quan[4*$i+2][$j][$p]=round($JRT[4*$i+2][$j][$p]/(8*$Q));
					$quan[4*$i+3][$j][$p]=round($JRT[4*$i+3][$j][$p]/(16*$Q));		
					
				}	
			}
		}
		
		return $quan;
		
		
		
		
	}
	
	/*!
	 * \fn requantifie ( $JRT , $Q )
	 * \brief Recompose the original amplitude of a quantifiedfrequency response with the quality factor Q
	 *
	 * \param $JRT a quantified frequency response
	 * \param $Q a quality factor
	 * \return  $quan the recomposed frequency response
	 */	function requantifie($JRT,$Q){
		
		for($p=0;$p<3;$p++){
			for($i=0;isset($JRT[4*$i][0][$p]);$i++) {
				for($j=0;isset($JRT[0][$j][$p]);$j++){
					
					$quan[4*$i][$j][$p]=round($JRT[4*$i][$j][$p]*2*$Q);
					$quan[4*$i+1][$j][$p]=round($JRT[4*$i+1][$j][$p]*4*$Q);
					$quan[4*$i+2][$j][$p]=round($JRT[4*$i+2][$j][$p]*8*$Q);
					$quan[4*$i+3][$j][$p]=round($JRT[4*$i+3][$j][$p]*16*$Q);		
					
				}	
			}
		}
		
		return $quan;
	
	}