<?php
function redis_write()
{
	$time_start = microtime_float();
	require __DIR__.'/shared.php';
	$client = new Predis\Client($single_server);
	

	//echo $response.":"; 
	$counter = 1;
	$value = array( ); 
 		for($j = 1; $j <= 10000; $j++){
            for($i = 1; $i <= 10; $i++){
 		//$client->hmset('metavars', array('foo' => 'bar', 'hoge' => 'piyo', 'lol' => 'wut'));
 		$client->hmset('user','user_id:'.$counter,$counter, 'value:'.$counter,'test test test');
 		$counter++;
 		}
 	}
 	$time_end = microtime_float();
	$time = $time_end - $time_start;
	echo "insert only $time seconds\n";
 }
 function redis_write_pipeline()
{
	$time_start = microtime_float();
	require __DIR__.'/shared.php';
	$client = new Predis\Client($single_server);
	$responses = $client->pipeline(function ($pipe) {
    $counter = 1;
 		for($j = 1; $j <= 10000; $j++){
            for($i = 1; $i <= 10; $i++){
 		//$client->hmset('metavars', array('foo' => 'bar', 'hoge' => 'piyo', 'lol' => 'wut'));
 		$pipe->hmset('user','user_id:'.$counter,$counter, 'value:'.$counter,'test test test');
 		$counter++;
 		}
 	}
});
	
	//echo $response.":"; 
	
 	$time_end = microtime_float();
	$time = $time_end - $time_start;
	echo "insert pipeline only $time seconds\n";
 }
 function redis_read_pipeline()
{
	$time_start = microtime_float();
	require __DIR__.'/shared.php';
	$client = new Predis\Client($single_server);
	$value = array( ); 
	$responses = array();
	$responses = $client->pipeline(function ($pipe) {
    $counters = 1;
 		for($j = 1; $j <= 1000; $j++){
            for($i = 1; $i <= 100; $i++){
 		//$client->hmset('metavars', array('foo' => 'bar', 'hoge' => 'piyo', 'lol' => 'wut'));
 		$pipe->hmget('user', 'user_id:'.$counters, 'value:'.$counters);
 		$counters++;
 		//echo $value[0].$value[1]."<br/>";
 		}
 	}
});
	//print_r($responses);
	for($i=0;$i<100000;$i++)
	{
		echo $responses[$i][0].$responses[$i][1]."<br/>";
	}
 	$time_end = microtime_float();
	$time = $time_end - $time_start;
	echo "read pipeline only $time seconds\n";
 }
 function redis_read()
{
	$time_start = microtime_float();
	require __DIR__.'/shared.php';
	$client = new Predis\Client($single_server);
	
 	//$redis->hmset("hash", array("field:1" => "value:1", "field:2" => "value:2"));
	//$values = $redis->hmget("hash", array("field:1", "field:2"));
	$value = array( ); 
	$counters = 1;
	for($j = 1; $j <= 1000; $j++){
            for($i = 1; $i <= 100; $i++){
 		$value = $client->hmget('user', 'user_id:'.$counters, 'value:'.$counters);
 		$counters++;
 		//print_r($value);
 		echo $value[0].$value[1]."<br/>";
 		
 		}
 	}
 	$time_end = microtime_float();
	$time = $time_end - $time_start;
	echo "insert only $time seconds\n";
 }
 function microtime_float()
	{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
	}
?>