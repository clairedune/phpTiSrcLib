<?php
	//---------------------------------------------------------------//
	// author :			cd
	// creation date :	november 2010
	// brief :			this library contains a set of functions
	//					for image filtering
	// ------------------------------------------------------------- //
	require_once("colorlib.php");
	
	//This function detect naive contour in i direction//
	function naiveEdgeX($I)
	{
		
		// copy I image//
		$Iedge = createCopy($I);
		
		// get Image size// 
		$width = imagesx($I);
		$height = imagesy($I);
		
		// Naive Conversion
		//----->Insert code here double for loop<--------//
		for($i=0;$i<$width;$i++){
			for($j=0;$j<$height;$j++){
		
				}
		}
		
		//----->Insert code here change this line to return the result image<----//
		return $Iedge;
		
	}
	
	//This function detect naive contour in j direction//
	function naiveEdgeY($I)
	{
		
		// copy I image//
		$Iedge = createCopy($I);
		
		// get Image size// 
		$width = imagesx($I);
		$height = imagesy($I);
		
		// Naive Conversion
		//----->Insert code here double for loop<--------//
		//for($i=0;$i<$width;$i++){
		//	for($j=0;$j<$height;$j++){
		//
		//		}
		//	}
		
		//----->Insert code here change this line to return the result image<----//
		return $Iedge;
		
	}
	