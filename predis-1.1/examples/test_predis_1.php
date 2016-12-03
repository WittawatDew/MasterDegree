<?php

	require __DIR__.'/shared.php';
	$client = new Predis\Client($single_server);
	$client->set('library', 'predis');
	$response = $client->get('library');

	echo $response.":"; 
	$value = array( );
 	for ($i=0; $i < 100; $i++) 
 	{ 
 		$client->set('foo:'.$i, 'bar'.$i);
 		$value = $client->get('foo:'.$i);
 		print_r($value);
 		echo $value."<br/>";
 	}
	//$client->set('foo', 'bar');
	//$value = $client->get('foo');
	//echo $value;
	/*for ($i=0; $i < 100; $i++) 
 	{ 
 		$value = $client->get('foo:'.$i);
 		echo $value[$i];
 	}*/
?>