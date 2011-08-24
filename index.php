<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<title>SRC Image Processing Toolbox</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<body>

<?php
	require_once("conf/config.php");
?>


<H1> Sci3 : traitement de l''image </H1>
<H2> SRC2 2011-2012</H2>

<H3>1. Introduction</H3>
<p>
Cette bibliothèque de fonctions a été développée dans le cadre des cours de traitement d''image du département SRC de Saint Raphaël. 
</p>
<p>
Vous y trouverez l''arborescence de fichiers suivantes :
<ul>
<li> ./ : index.php, le point d''entrée de ce projet, un fichier Doxyfile pour générer la documentation et un fichier README ;
<li> conf/: les fichier de configuration qu''il vous faudra éditer pour les adapter à la configuration de votre machine ;
<li> src/ : l''implémentation des fonctions à proprement parler ;
<li> test/ : des tests unitaires ; 
<li> images/: des images .png (nous n''utiliserons que ce format) à ne pas modifier ; 
<li> results/: un repertoire d''enregistrement de vos créations.
</ul>

</p>



<H3>2. Documentation</H3>

<H4>2.1. Notre toolbox </H4>

<p>
Vous trouverez la documentation de cette library à la racine du répertoire que vous avez téléchargé : 
</p>
<ul>
<li> <a href="<?php echo $url."doc/html"; ?>"> Documentation phpTiSrcLib</a>.
</ul>

<H4>2.2 Php documentation </H4>
<p>
Nous avons basé le code sur les fonctions de la bibliothèque de traitement d''images GD qui est 
native avec la plupart des version de phpTiSrcLib que vous avez installées. 
</p>
<p>
Nous avons signalé dans les commentaires
des codes sources lorsque nous utilisions une fonction de la bibliothèque GD. A vous ensuite de rechercher le prototype 
de cette fonction et son utilisation dans la documentation de GD.
</p>

<p>
La documentation en  ligne de php est très bien faite et traduite en français. Elle inclue la documentation de gd. 
Vous pouvez retrouver ces documentations en ligne ou télécharger leur version pdf aux adresses suivantes :
</p>
<ul>
<li> <a href="http://www.php.net/manual/fr/index.php">Documentation PHP</a> ;
<li> <a href="http://www.php.net/manual/fr/book.image.php">Documentation GD</a>. 
</ul>


<H3>3.Tests unitaires</H3>

<H4>3.1. Les functions de base : lecture, ecriture et conversion en tableaux</H4>
<ul>
<li> <a href="<?php echo $url."test/testDisplayImage.php"; ?>"> Afficher une image </a> ;
<li> <a href="<?php echo $url."test/testReadPixelValues.php"; ?>"> Afficher les valeurs d'un pixel </a> ;
<li> <a href="<?php echo $url."test/testConvertImageTab.php"; ?>"> Conversion image-tableau </a> ;
</ul>

<H4>3.2. Modes couleurs</H4>
<ul>
<li> <a href="<?php echo $url."test/testColorConversion.php"; ?>"> Conversion de modes couleurs  </a> ;
</ul>

<H4>3.3. Histogrammes et amélioration de contraste </H4>
<ul>
<li> <a href="<?php echo $url."test/testDynExtension.php"; ?>"> Amélioration automatique du contraste </a> ;
<li> <a href="<?php echo $url."test/testHistogram.php"; ?>"> Construction et affichage d'histogrammes </a> 
</ul>



</body>
</html>