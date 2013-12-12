<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title> <?php echo $title; ?></title>
</head>
<body>
<h1> <?php echo $title?> </h1>
<?php echo $content ?>

<hr/>
<h2>My Friends</h2>
<table border="1">
	<tr>
		<th>id</th>
		<th>name</th>
	</tr>
	<?php for( $i=0; $i< count( $friends ) ; $i++ ): ?>
		<tr>
			<td> <?php echo $friends[$i]["id"] ?> </td>
			<td> <?php echo $friends[$i]["name"] ?> </td>
		</tr>
	
	<?php endfor; ?>
</table>
</body>
</html>
