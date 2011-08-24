<?php
	/*!
	* \file srcFilter.php
	* \author 			Claire Dune
	* \date :	november 2010
	* \brief :			Greyscale image filtering lib
	*/
	 
	/*!
	 * \fn naiveEdgeDetectionX($T)
	 * \brief Detects naive contour in X direction
	 * 
	 * \param $T
	 * \return $Tres
	 */
	 function naiveEdgeDetectionX($T)
	{
		for($i=0;isset($T[$i][0][0]);$i++) 
		{
			for($j=0;isset($T[0][$j][0]);$j++)
			{
				
				// --> Write your code here
				
			}
		}
		
		//return $Tres;
		return tabCreateFromPng("../images/avous.png");
		
	}
	
	/*!
	 * \fn naiveEdgeDetectionY($T)
	 * \brief Detects naive contour in Y direction
	 * 
	 * \param $T
	 * \return $Tres
	 */
	function naiveEdgeDetectionY($T)
	{
		for($i=0;isset($T[$i][0][0]);$i++) 
		{
			for($j=0;isset($T[0][$j][0]);$j++)
			{
				
				// --> Write your code here
				
			}
		}
		
		//return $Tres;
		return tabCreateFromPng("../images/avous.png");
		
	}
	