<?php
	/*! 
	 * \file mainpage.php
	 * \brief this file contains the doc mainpage
	 * \author Claire Dune
	 * \date 21/08/2011
	 */

/*!
 * \mainpage Welcome to the SRC Image Library
 *
 *	
 * \section Introduction 
 *
 * You will use this few function for the numerisation class (S2) as well 
 * as the image processing and the compression class (S3)
 *
 * \section install How to install this library ?
 *
 * \subsection install_gd Step 1 : make sure that the library gd is activated 
 * For instance, with easyPhp,configuration—>extension php--->php gd2  
 *
 * \subsection install_step1 Step 2 : simply copy the folder phpTiSrcLib in your www folder
 *
 * \subsection install_step3 Step 3 : include the file you need in your php header
 *
 * \code
 * include('phpTiSrcLib/conf/config.php');
 * include('src/srcImage.php');
 * etc ... 
 * \endcode 
 *
 * \section documentation Where can I fing the documentation ? 
 *
 * The phpTiSrc Toolbox is mainly based on the gd library. 
 * Many image processing php library exists. 
 * We chose the gd library mainly because it is usually available in the php default libraries that you get with Xamp, or Mamp.
 *
 * \subsection documentation_phpTiSrc Documentation on phpTiSrcLib
 * You can find the documentation of the phpTiSrc lib in 
 * \code 
 * phpTiSrc/doc/html
 * \endcode
 * \n
 * This documentation was an automatically generated using Doxygen. If you add new features to the lib and  want to regenerate the documentation,
 * please download Doygen (http://www.stack.nl/~dimitri/doxygen/index.html) and run it in the phpTiSrc. \n
 * The existing Doxyfile is already configured to recursively parse the code in the src folder.
 * \code
 * cd phpTiSrc
 * doxygen
 * \endcode
 *
 * \subsection documentation_gd  Documentation on the gd library
 * PHP is not limited to creating just HTML output. 
 * It can also be used to create and manipulate image files in a variety of different image formats, including GIF, PNG, JPEG, WBMP, and XPM. 
 * Even more convenient, PHP can output image streams directly to a browser. 
 * You will need to compile PHP with the GD library of image functions for this to work. 
 * GD and PHP may also require other libraries, depending on which image formats you want to work with.\n
 * \n
 * You can use the image functions in PHP to get the size of JPEG, GIF, PNG, SWF, TIFF and JPEG2000 images.
 * Read more in french :	http://php.net/manual/fr/book.image.php					   
 * 
 */
