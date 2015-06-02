

My Name is :<?php echo $name; ?>

<h3>friends</h3>

<?php for( $i=0;$i< count($friends); $i++ ): ?>
	<?php echo $friends[$i]["id"]; ?> , <?php echo $friends[$i]["name"]; ?> <br />
<?php endfor; ?>
