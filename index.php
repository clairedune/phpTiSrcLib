<html>
<body>

<p>
This file is only here to test the functions 
</p>
<?php
	require_once("src/srcImageTable.php");
	SrcImageTable::display();
	
	$a = new SrcImageTable();
	$a->display();
?>


</body>
</html>