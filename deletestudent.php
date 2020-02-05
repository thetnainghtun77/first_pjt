<?php 
	$id = $_POST['id'];

	$studentlist = file_get_contents('studentlist.json');

	$studentlist_array = json_decode($studentlist, true);

	// photo delete

	unlink($studentlist_array[$id]['profile']);

	// data delete

	unset($studentlist_array[$id]);

	$mydata = json_encode($studentlist_array, JSON_PRETTY_PRINT);

	file_put_contents("studentlist.json", $mydata);

 ?>