<?php
	function microtime_float()
	{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
	}
	function getDataFromtextfile_explode($file_name)
	{
		$file_get = file_get_contents($file_name, FILE_USE_INCLUDE_PATH);
		ini_set('memory_limit', '-1');
		$lines = explode("\n", $file_get);

		for($i = 0;$i<count($lines);$i++)
		{
			$kum[$i] = explode("|", $lines[$i]);
		}

			return $kum;
	}	
	function redis_write_departments()
	{
		//$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		

		//echo $response.":"; 
		$data = getDataFromtextfile_explode("data/departments.txt");
		$data = array_slice($data, 0, count($data)-1); 
		//print_r($data);
		$value = array();
	 	for($i = 0; $i < count($data); $i++)
	 	{
	 		//$client->hmset('metavars', array('foo' => 'bar', 'hoge' => 'piyo', 'lol' => 'wut'));
	 		$client->hmset('departments:'.$i,'dept_no',$data[$i][0],'dept_name',$data[$i][1]);
	 		//$redis->zAdd('key', 0, 'val0');
	 		$client->zadd('departments:dept_no:'.$data[$i][0],1,$i);
	 		$client->zadd('departments:dept_name:'.$data[$i][1],2,$i);
	 	}
	 	//$time_end = microtime_float();
		//$time = $time_end - $time_start;
		//echo "insert only $time seconds\n";
	}
	 function redis_read_departments()
	{
		$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		
	 	//$redis->hmset("hash", array("field:1" => "value:1", "field:2" => "value:2"));
		//$values = $redis->hmget("hash", array("field:1", "field:2"));
		$data = getDataFromtextfile_explode("data/departments.txt");
		$data = array_slice($data, 0, count($data)-1);
		$value = array(); 
		for($i = 0; $i < count($data); $i++)
		 	{
			 	$value = $client->hmget('departments:'.$i,'dept_no','dept_name');
			 	echo $value[0]."  ".$value[1]."<br/>";
		 	}
		 	$value1 = array();
		 	$value2 = array();
		 	for($i = 0; $i < count($data); $i++)
		 	{
		 		//zRange('key1', 0, -1);
			 	$value1 = $client->zrange('departments:dept_no:'.$data[$i][0],0,-1);
			 	$value2 = $client->zrange('departments:dept_name:'.$data[$i][1],0,-1);
			 echo $value1[0].$value2[0]."<br/>";
		 	}
		 	//$time_end = microtime_float();
			//$time = $time_end - $time_start;
			//echo "read only $time seconds\n";
 	}
	function redis_write_dept_emp()
	{
		//$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		

		//echo $response.":"; 
		$data = getDataFromtextfile_explode("data/dept_emp.txt");
		$data = array_slice($data, 0, count($data)-1); 
		//print_r($data);
		$value = array();
	 	for($i = 0; $i < count($data); $i++)
	 	{
	 		//$client->hmset('metavars', array('foo' => 'bar', 'hoge' => 'piyo', 'lol' => 'wut'));
	 		$client->hmset('dept_emp:'.$i,'emp_no',$data[$i][0],'dept_no',$data[$i][1],'from_date',$data[$i][2],'to_date',$data[$i][3]);
	 		//$redis->zAdd('key', 0, 'val0');
	 		$client->zadd('dept_emp:emp_no:'.$data[$i][0],1,$i);
	 		$client->zadd('dept_emp:dept_no:'.$data[$i][1],2,$i);
	 		$client->zadd('dept_emp:from_date:'.$data[$i][2],3,$i);
	 		$client->zadd('dept_emp:to_date:'.$data[$i][3],4,$i);
	 	}
	 	
	 	//$time_end = microtime_float();
		//$time = $time_end - $time_start;
		//echo "insert only $time seconds\n";
	}
	function redis_read_dept_emp()
	{
		$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		
	 	//$redis->hmset("hash", array("field:1" => "value:1", "field:2" => "value:2"));
		//$values = $redis->hmget("hash", array("field:1", "field:2"));
		$data = getDataFromtextfile_explode("data/dept_emp.txt");
		$data = array_slice($data, 0, count($data)-1);
		$value = array(); 
		for($i = 0; $i < count($data); $i++)
	 	{
		 	$value = $client->hmget('dept_emp:'.$i,'emp_no','dept_no','from_date','to_date');
		 	echo $value[0]."|".$value[1]."|".$value[2]."|".$value[3]."<br/>";
	 	}
	/* 	$value1 = array();
	 	$value2 = array();
	 	$value3 = array();
	 	$value4 = array();
	 	for($i = 0; $i < count($data); $i++)
	 	{
	 		//zRange('key1', 0, -1);
		 	$value1 = $client->zrange('dept_emp:emp_no:'.$data[$i][0],0,-1);
		 	$value2 = $client->zrange('dept_emp:dept_no:'.$data[$i][1],0,-1);
		 	$value3 = $client->zrange('dept_emp:from_date:'.$data[$i][2],0,-1);
		 	$value4 = $client->zrange('dept_emp:to_date:'.$data[$i][3],0,-1);
		 echo $value1[0]."|".$value2[0]."|".$value3[0]."|".$value4[0]."<br/>";
	 	}*/
		 	//$time_end = microtime_float();
			//$time = $time_end - $time_start;
			//echo "read only $time seconds\n";
 	}
	function redis_write_dept_manager()
	{
		//$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		

		//echo $response.":"; 
		$data = getDataFromtextfile_explode("data/dept_manager.txt");
		$data = array_slice($data, 0, count($data)-1); 
		//print_r($data);
		$value = array();
	 	for($i = 0; $i < count($data); $i++)
	 	{
	 		//$client->hmset('metavars', array('foo' => 'bar', 'hoge' => 'piyo', 'lol' => 'wut'));
	 		$client->hmset('dept_manager:'.$i,'dept_no',$data[$i][0], 'emp_no',$data[$i][1],'from_date',$data[$i][2], 'to_date',$data[$i][3]);
	 		//$redis->zAdd('key', 0, 'val0');
	 		$client->zadd('dept_manager:dept_no:'.$data[$i][0],1,$i);
	 		$client->zadd('dept_manager:emp_no:'.$data[$i][1],2,$i);
	 		$client->zadd('dept_manager:from_date:'.$data[$i][2],3,$i);
	 		$client->zadd('dept_manager:to_date:'.$data[$i][3],4,$i);
	 	}
	 	
	 	//$time_end = microtime_float();
		//$time = $time_end - $time_start;
		//echo "insert only $time seconds\n";
	}
	function redis_read_dept_manager()
	{
		$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		
	 	//$redis->hmset("hash", array("field:1" => "value:1", "field:2" => "value:2"));
		//$values = $redis->hmget("hash", array("field:1", "field:2"));
		$data = getDataFromtextfile_explode("data/dept_manager.txt");
		$data = array_slice($data, 0, count($data)-1);
		$value = array(); 
		for($i = 0; $i < count($data); $i++)
	 	{
		 	$value = $client->hmget('dept_manager:'.$i,'dept_no','emp_no','from_date','to_date');
		 	echo $value[0]."|".$value[1]."|".$value[2]."|".$value[3]."<br/>";
	 	}
	 	
	 	
	 	
	 	
		 	//$time_end = microtime_float();
			//$time = $time_end - $time_start;
			//echo "read only $time seconds\n";
 	}
	function redis_write_employees()
	{
		//$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		

		//echo $response.":"; 
		$data = getDataFromtextfile_explode("data/employees.txt");
		$data = array_slice($data, 0, count($data)-1); 
		//print_r($data);
		$value = array();
	 	for($i = 0; $i < count($data); $i++)
	 	{
	 		//$client->hmset('metavars', array('foo' => 'bar', 'hoge' => 'piyo', 'lol' => 'wut'));
	 		$client->hmset('employees:'.$i,'emp_no',$data[$i][0],'birth_date',$data[$i][1],'first_name',$data[$i][2],'last_name',$data[$i][3],'gender',$data[$i][4],'hire_date',$data[$i][5]);
	 		//$redis->zAdd('key', 0, 'val0');
	 		$client->zadd('employees:emp_no:'.$data[$i][0],1,$i);
	 		$client->zadd('employees:birth_date:'.$data[$i][1],2,$i);
	 		$client->zadd('employees:first_name:'.$data[$i][2],3,$i);
	 		$client->zadd('employees:last_name:'.$data[$i][3],4,$i);
	 		$client->zadd('employees:gender:'.$data[$i][4],5,$i);
	 		$client->zadd('employees:hire_date:'.$data[$i][5],6,$i);
	 	}
	 	
	}
	function read_redis_select_command_1()
 	{
 		$time_start = microtime_float();
 		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		//zadd('employees:gender:'.$data[$i][4],5,$i);
		
		$value = array();
		 //print_r($data);
		
		$value1 = $client->zrange('employees:gender:M',0,-1);
		for($i=0;$i<count($value1);$i++)
		{
			$value = $client->hmget('employees:'.$value1[$i],'emp_no','birth_date','first_name','last_name','gender','hire_date');
			echo $value[0]."|".$value[1]."|".$value[2]."|".$value[3]."|".$value[4]."|".$value[5]."<br/>"; 
		}
		$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "read command 1 redis only $time seconds\n";
 	}
 	function read_redis_pipeline_select_command_1()
 	{
 		$time_start = microtime_float();
 		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		//zadd('employees:gender:'.$data[$i][4],5,$i);
		$value1 = $client->zrange('employees:gender:M',0,-1);
		//$responses = $client->pipeline()->set('foo', 'bar')->get('foo')->execute();
		$responses = $client->pipeline(function ($pipe) use($value1){
		for($i=0;$i<count($value1);$i++)
		{
			$pipe->hmget('employees:'.$value1[$i],'emp_no','birth_date','first_name','last_name','gender','hire_date');
		}
});
		$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "read command 1 redis only $time seconds\n";
		//print_r($responses);
		for($i=0;$i<count($responses);$i++)
		{
			
			echo $responses[$i][0]."|".$responses[$i][1]."|".$responses[$i][2]."|".$responses[$i][3]."|".$responses[$i][4]."|".$responses[$i][5]."<br/>";
		}
		
		
		
 	}
	function redis_read_employees()
	{
		$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		
	 	//$redis->hmset("hash", array("field:1" => "value:1", "field:2" => "value:2"));
		//$values = $redis->hmget("hash", array("field:1", "field:2"));
		$data = getDataFromtextfile_explode("data/employees.txt");
		$data = array_slice($data, 0, count($data)-1);
		$value = array(); 
		for($i = 0; $i < count($data); $i++)
	 	{
		 	$value = $client->hmget('employees:'.$i,'emp_no','birth_date','first_name','last_name','gender','hire_date');
		 	echo $value[0]."|".$value[1]."|".$value[2]."|".$value[3]."|".$value[4]."|".$value[5]."<br/>";
	 	}
	 
 	}
	function redis_write_salaries()
	{
		$data = getDataFromtextfile_explode("data/salaries_1000000.txt");
		$data = array_slice($data, 0, count($data)-1); 
		$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		

		//echo $response.":"; 

		
		//print_r($data);
		$value = array();
	 	for($i = 0; $i < 100000; $i++)
	 	{
	 		//$client->hmset('metavars', array('foo' => 'bar', 'hoge' => 'piyo', 'lol' => 'wut'));
	 		$client->hmset('salaries:'.$i,'emp_no',$data[$i][0], 'salary',$data[$i][1],'from_date',$data[$i][2], 'to_date',$data[$i][3]);
	 		//$redis->zAdd('key', 0, 'val0');
	 		$client->zadd('salaries:emp_no:'.$data[$i][0],1,$i);
	 		$client->zadd('salaries:salary:'.$data[$i][1],2,$i);
	 		$client->zadd('salaries:from_date:'.$data[$i][2],3,$i);
	 		$client->zadd('salaries:to_date:'.$data[$i][3],4,$i);
	 	}
	 	
	 	$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "insert redis only $time seconds\n";
	}
	function redis_write_pipeline_salaries_version2()
	{
		$data = getDataFromtextfile_explode("data/salaries_1000000.txt");
		$data = array_slice($data, 0, count($data)-1); 
		
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		
		$time_start = microtime_float();
	 		$responses = $client->pipeline(function ($pipe) use ($data)
	 		{
			 		for($i = 0; $i < 1000; $i++)
			 		{
			 		//$client->hmset('metavars', array('foo' => 'bar', 'hoge' => 'piyo', 'lol' => 'wut'));
			 		$pipe->hmset('salaries:'.$i,'emp_no',$data[$i][0], 'salary',$data[$i][1],'from_date',$data[$i][2], 'to_date',$data[$i][3]);
			 		//$redis->zAdd('key', 0, 'val0');
			 		$pipe->zadd('salaries:emp_no:'.$data[$i][0],1,$i);
			 		$pipe->zadd('salaries:salary:'.$data[$i][1],2,$i);
			 		$pipe->zadd('salaries:from_date:'.$data[$i][2],3,$i);
			 		$pipe->zadd('salaries:to_date:'.$data[$i][3],4,$i);
			 		}
			 	
	 		});
	 			$time_end = microtime_float();
				$time = $time_end - $time_start;
				echo "insert pipeline redis only $time seconds\n";
			
	 	
	}
	function redis_write_pipeline_salaries()
	{
		
		
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		

		//echo $response.":"; 

		
		//print_r($data);
		$value = array();
		
	 		$responses = $client->pipeline(function ($pipe) 
	 		{
	 			$data = getDataFromtextfile_explode("data/salaries_1000000.txt");
				$data = array_slice($data, 0, count($data)-1); 
				$count = 0;
				
				$time_start = microtime_float();
			 		for($i = 0; $i < 100000; $i++)
			 		{
			 		//$client->hmset('metavars', array('foo' => 'bar', 'hoge' => 'piyo', 'lol' => 'wut'));
			 		$pipe->hmset('salaries:'.$i,'emp_no',$data[$count][0], 'salary',$data[$count][1],'from_date',$data[$count][2], 'to_date',$data[$count][3]);
			 		//$redis->zAdd('key', 0, 'val0');
			 		//$pipe->zadd('salaries:emp_no:'.$data[$count][0],1,$count);
			 		//$pipe->zadd('salaries:salary:'.$data[$count][1],2,$count);
			 		//$pipe->zadd('salaries:from_date:'.$data[$count][2],3,$count);
			 		//$pipe->zadd('salaries:to_date:'.$data[$count][3],4,$count);
			 		$count++;
			 		}
			 	$time_end = microtime_float();
				$time = $time_end - $time_start;
				echo "insert pipeline redis only $time seconds\n";
	 		});
	 			
			
	 	
	}
	
	function redis_read_salaries()
	{
		//$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		

		//echo $response.":"; 
		$data = getDataFromtextfile_explode("data/salaries_1000000.txt");
		$data = array_slice($data, 0, count($data)-1); 
		//print_r($data);
		$value = array();
		$time_start = microtime_float();
		for($i = 0; $i < 100000; $i++)
	 	{
		 	$value = $client->hmget('salaries:'.$i,'emp_no','salary','from_date','to_date');
		 	echo $value[0]."|".$value[1]."|".$value[2]."|".$value[3]."<br/>";
	 	}
	 	$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "insert pipeline redis only $time seconds\n";
	 	
	}
	function redis_read_pipeline_salaries()
	{
		
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		
		$time_start = microtime_float();
		$responses = $client->pipeline(function ($pipe) 
	 	{
		
		for($i = 0; $i < 100000; $i++)
	 	{
		 	$pipe->hmget('salaries:'.$i,'emp_no','salary','from_date','to_date');
	 	}
	 	});
	 	
	 	for($i=0;$i<count($responses);$i++)
		{
			
			echo $responses[$i][0]."|".$responses[$i][1]."|".$responses[$i][2]."|".$responses[$i][3]."<br/>";
		}
		$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "read pipeline redis only $time seconds\n";
	 	
	}
	function redis_write_titles()
	{
		//$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		

		//echo $response.":"; 
		$data = getDataFromtextfile_explode("data/titles.txt");
		$data = array_slice($data, 0, count($data)-1); 
		//print_r($data);
		$value = array();
	 	for($i = 0; $i < count($data); $i++)
	 	{
	 		//$client->hmset('metavars', array('foo' => 'bar', 'hoge' => 'piyo', 'lol' => 'wut'));
	 		$client->hmset('titles:'.$i,'emp_no',$data[$i][0], 'title',$data[$i][1],'from_date',$data[$i][2], 'to_date',$data[$i][3]);
	 		//$redis->zAdd('key', 0, 'val0');
	 		$client->zadd('titles:emp_no:'.$data[$i][0],1,$i);
	 		$client->zadd('titles:title:'.$data[$i][1],2,$i);
	 		$client->zadd('titles:from_date:'.$data[$i][2],3,$i);
	 		$client->zadd('titles:to_date:'.$data[$i][3],4,$i);
	 	}
	 	
	}
 	function redis_read_titles()
 	{
 		//$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		

		//echo $response.":"; 
		$data = getDataFromtextfile_explode("data/titles.txt");
		$data = array_slice($data, 0, count($data)-1); 
		//print_r($data);
		for($i = 0; $i < count($data); $i++)
	 	{
		 	$value = $client->hmget('titles:'.$i,'emp_no','title','from_date','to_date');
		 	echo $value[0]."|".$value[1]."|".$value[2]."|".$value[3]."<br/>";
	 	}
	/* 	$value1 = array();
	 	$value2 = array();
	 	$value3 = array();
	 	$value4 = array();
	 	for($i = 0; $i < count($data); $i++)
	 	{
	 		//zRange('key1', 0, -1);
		 	$value1 = $client->zrange('titles:emp_no:'.$data[$i][0],0,-1);
		 	$value2 = $client->zrange('titles:title:'.$data[$i][1],0,-1);
		 	$value3 = $client->zrange('titles:from_date:'.$data[$i][2],0,-1);
		 	$value4 = $client->zrange('titles:to_date:'.$data[$i][3],0,-1);
		 echo $value1[0]."|".$value2[0]."|".$value3[0]."|".$value4[0]."<br/>";
	 	}
	 	//$time_end = microtime_float();
		//$time = $time_end - $time_start;
		//echo "insert only $time seconds\n";*/
 	}
 	function redis_join_1_version1()
 	{
 		$data = getDataFromtextfile_explode("data/dept_emp.txt");
		$data = array_slice($data, 0, count($data)-1);
 		$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		
	 	//$redis->hmset("hash", array("field:1" => "value:1", "field:2" => "value:2"));
		//$values = $redis->hmget("hash", array("field:1", "field:2"));
		
		$value = array(); 
		$index=array();
		$departments_name=array();
		for($i = 0; $i < count($data); $i++)
	 	{
		 	$value[$i] = $client->hmget('dept_emp:'.$i,'dept_no');
		 	//echo $i.":".$value[$i][0]."<br/>";
	 	}
	 	//$value1 = $client->zrange('dept_emp:emp_no:'.$data[$i][0],0,-1);
	 	//print_r(count($value));
	 	for($j=0;$j<count($value);$j++)
	 	{
	 		$index[$j]= $client->zrange('departments:dept_no:'.$value[$j][0],0,-1);
	 		$departments_name[$j] =$client->hmget('departments:'.$index[$j][0],'dept_name');
	 		//echo $index[$j][0]."|".$departments_name[$j][0]."<br/>";

	 	}
	 	//print_r(count($data));
	 	for($i = 0; $i < count($data); $i++)
	 	{
		 	$value = $client->hmget('dept_emp:'.$i,'emp_no','dept_no','from_date','to_date');
		 	echo $value[0]."|".$value[1]."|".$departments_name[$i][0]."|".$value[2]."|".$value[3]."<br/>";
	 	}
	 	
		 	$time_end = microtime_float();
			$time = $time_end - $time_start;
			echo "read only $time seconds\n";
 	}
 	function redis_join_1_pipeline_version1()
 	{
 		$data = getDataFromtextfile_explode("data/dept_emp.txt");
		$data = array_slice($data, 0, count($data)-1);
 		$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		
	 	//$redis->hmset("hash", array("field:1" => "value:1", "field:2" => "value:2"));
		//$values = $redis->hmget("hash", array("field:1", "field:2"));
		
		
		$departments_name=array();
		$value = $client->pipeline(function ($pipe) use($data){
		for($i=0;$i<count($data);$i++)
		{
			$pipe->hmget('dept_emp:'.$i,'dept_no');
		}
});
	 	//$value1 = $client->zrange('dept_emp:emp_no:'.$data[$i][0],0,-1);
	 	//print_r(count($value));
	 	$index = $client->pipeline(function ($pipe) use($data,$value){
		for($i=0;$i<count($value);$i++)
		{
			$pipe->zrange('departments:dept_no:'.$value[$i][0],0,-1);
		}
});
	 	$departments_name = $client->pipeline(function ($pipe) use($data,$value,$index){
		for($i=0;$i<count($value);$i++)
		{
			$pipe->hmget('departments:'.$index[$i][0],'dept_name');
		}
});

	 	//print_r(count($data));
		$responses = $client->pipeline(function ($pipe) use($data,$value,$index,$departments_name){
		for($i=0;$i<count($data);$i++)
		{
			$pipe->hmget('dept_emp:'.$i,'emp_no','dept_no','from_date','to_date');
		}
});
		
	 	for($i = 0; $i < count($responses); $i++)
	 	{
		 	echo $responses[$i][0]."|".$responses[$i][1]."|".$departments_name[$i][0]."|".$responses[$i][2]."|".$responses[$i][3]."<br/>";
	 	}
	 	$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "read only $time seconds\n";
		 	
 	}
 	function redis_join_1_version2()
 	{
 		$data = getDataFromtextfile_explode("data/dept_emp.txt");
		$data = array_slice($data, 0, count($data)-1);
 		$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		
	 	//$redis->hmset("hash", array("field:1" => "value:1", "field:2" => "value:2"));
		//$values = $redis->hmget("hash", array("field:1", "field:2"));
		
		$value = array(); 
		for($i = 0; $i < count($data); $i++)
	 	{
		 	$value = $client->hmget('dept_emp:'.$i,'emp_no','dept_no','from_date','to_date');
		 	//echo $value[0]."|".$value[1]."|".$value[2]."|".$value[3]."<br/>";
		 	if($value[1]=="d009")
		 	{
		 		echo $value[0]."|".$value[1]."|"."Customer Service"."|".$value[2]."|".$value[3]."<br/>";
		 	}
		 	else if($value[1]=="d005")
		 	{
		 		echo $value[0]."|".$value[1]."|"."Development"."|".$value[2]."|".$value[3]."<br/>";
		 	}
		 	else if($value[1]=="d002")
		 	{
		 		echo $value[0]."|".$value[1]."|"."Finance"."|".$value[2]."|".$value[3]."<br/>";
		 	}
		 	else if($value[1]=="d003")
		 	{
		 		echo $value[0]."|".$value[1]."|"."Human Resources"."|".$value[2]."|".$value[3]."<br/>";
		 	}
		 	else if($value[1]=="d001")
		 	{
		 		echo $value[0]."|".$value[1]."|"."Marketing"."|".$value[2]."|".$value[3]."<br/>";
		 	}
		 	else if($value[1]=="d004")
		 	{
		 		echo $value[0]."|".$value[1]."|"."Production"."|".$value[2]."|".$value[3]."<br/>";
		 	}
		 	else if($value[1]=="d006")
		 	{
		 		echo $value[0]."|".$value[1]."|"."Quality Management"."|".$value[2]."|".$value[3]."<br/>";
		 	}
		 	else if($value[1]=="d008")
		 	{
		 		echo $value[0]."|".$value[1]."|"."Research"."|".$value[2]."|".$value[3]."<br/>";
		 	}
		 	else if($value[1]=="d007")
		 	{
		 		echo $value[0]."|".$value[1]."|"."Sales"."|".$value[2]."|".$value[3]."<br/>";
		 	}
	 	}
	 	$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "read only $time seconds\n";
	 }
	 function redis_join_1_pipeline_version2()
 	{
 		$data = getDataFromtextfile_explode("data/dept_emp.txt");
		$data = array_slice($data, 0, count($data)-1);
 		$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		
	 	//$redis->hmset("hash", array("field:1" => "value:1", "field:2" => "value:2"));
		//$values = $redis->hmget("hash", array("field:1", "field:2"));
		$responses = $client->pipeline(function ($pipe) use($data){
		for($i=0;$i<count($data);$i++)
		{
			$pipe->hmget('dept_emp:'.$i,'emp_no','dept_no','from_date','to_date');
		}
});
		
		//print_r($responses);
		for($i=0;$i<count($responses);$i++)
		{
		 	//echo $value[0]."|".$value[1]."|".$value[2]."|".$value[3]."<br/>";
		 	if($responses[$i][1]=="d009")
		 	{
		 		echo $responses[$i][0]."|".$responses[$i][1]."|"."Customer Service"."|".$responses[$i][2]."|".$responses[$i][3]."<br/>";
		 	}
		 	else if($responses[$i][1]=="d005")
		 	{
		 		echo $responses[$i][0]."|".$responses[$i][1]."|"."Development"."|".$responses[$i][2]."|".$responses[$i][3]."<br/>";
		 	}
		 	else if($responses[$i][1]=="d002")
		 	{
		 		echo $responses[$i][0]."|".$responses[$i][1]."|"."Finance"."|".$responses[$i][2]."|".$responses[$i][3]."<br/>";
		 	}
		 	else if($responses[$i][1]=="d003")
		 	{
		 		echo $responses[$i][0]."|".$responses[$i][1]."|"."Human Resources"."|".$responses[$i][2]."|".$responses[$i][3]."<br/>";
		 	}
		 	else if($responses[$i][1]=="d001")
		 	{
		 		echo $responses[$i][0]."|".$responses[$i][1]."|"."Marketing"."|".$responses[$i][2]."|".$responses[$i][3]."<br/>";
		 	}
		 	else if($responses[$i][1]=="d004")
		 	{
		 		echo $responses[$i][0]."|".$responses[$i][1]."|"."Production"."|".$responses[$i][2]."|".$responses[$i][3]."<br/>";
		 	}
		 	else if($responses[$i][1]=="d006")
		 	{
		 		echo $responses[$i][0]."|".$responses[$i][1]."|"."Quality Management"."|".$responses[$i][2]."|".$responses[$i][3]."<br/>";
		 	}
		 	else if($responses[$i][1]=="d008")
		 	{
		 		echo $responses[$i][0]."|".$responses[$i][1]."|"."Research"."|".$responses[$i][2]."|".$responses[$i][3]."<br/>";
		 	}
		 	else if($responses[$i][1]=="d007")
		 	{
		 		echo $responses[$i][0]."|".$responses[$i][1]."|"."Sales"."|".$responses[$i][2]."|".$responses[$i][3]."<br/>";
		 	}
	 	}
	 	$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "read only $time seconds\n";
	 }
	 function redis_single_entity_3()
	{
		//$data = getDataFromtextfile_explode("data/dept_emp.txt");
		//$data = array_slice($data, 0, count($data)-1);
		
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		
	 	//$redis->hmset("hash", array("field:1" => "value:1", "field:2" => "value:2"));
		//$values = $redis->hmget("hash", array("field:1", "field:2"));
		
			//$value = array(); 
			//$index = $client->zrange('dept_emp:emp_no:10021',0,-1);
			//print_r($index);
			$time_start = microtime_float();
				$value = $client->hmget('dept_emp:22','emp_no','dept_no','from_date','to_date');
				//print_r($value);
		 		echo $value[0]."|".$value[1]."|".$value[2]."|".$value[3]."<br/>";
			
		 	
		 	$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "read only $time seconds\n";
	 }
	  function redis_single_pipeline_entity_3()
	{
		//$data = getDataFromtextfile_explode("data/dept_emp.txt");
		//$data = array_slice($data, 0, count($data)-1);
		
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		
	 	//$redis->hmset("hash", array("field:1" => "value:1", "field:2" => "value:2"));
		//$values = $redis->hmget("hash", array("field:1", "field:2"));
		
			//$value = array(); 
			$index = $client->zrange('dept_emp:emp_no:10021',0,-1);
			//print_r($index);
			$time_start = microtime_float();
		 	
		$responses = $client->pipeline(function ($pipe) use($index){
		
			$pipe->hmget('dept_emp:'.$index[0],'emp_no','dept_no','from_date','to_date');
});
		 $time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "read only $time seconds\n";
		echo $responses[0][0]."|".$responses[0][1]."|".$responses[0][2]."|".$responses[0][3]."<br/>";
	 }
	function redis_join_2()
	{
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		$data = getDataFromtextfile_explode("data/dept_manager.txt");
		$data = array_slice($data, 0, count($data)-1); 
		//print_r($data);
		$value = array();
		$time_start = microtime_float();
	 	for($i = 0; $i < count($data); $i++)
	 	{
	 		$value[$i] = $client->hmget('dept_manager:'.$i,'dept_no');
	 		//echo $value[0]."<br/>";
	 	}
	 	for($i = 0; $i < count($value); $i++)
	 	{
			$index[$i]=$client->zrange('departments:dept_no:'.$value[$i][0],0,-1);
			$departments_name[$i] =$client->hmget('departments:'.$index[$i][0],'dept_name');
			$emp_no[$i] = $client->hmget('dept_manager:'.$i,'emp_no');
			echo $departments_name[$i][0]."|".$emp_no[$i][0]."<br/>";
		}
		 $time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "read only $time seconds\n";
	}
	function redis_join_pipeline_2()
	{
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		$data = getDataFromtextfile_explode("data/dept_manager.txt");
		$data = array_slice($data, 0, count($data)-1); 
		//print_r($data);
		$time_start = microtime_float();
		$value = $client->pipeline(function ($pipe) use($data){
		for($i = 0; $i < count($data); $i++)
	 	{
			$pipe->hmget('dept_manager:'.$i,'dept_no');
		}
});
		$index = $client->pipeline(function ($pipe) use($value){
		for($i = 0; $i < count($value); $i++)
	 	{
			$pipe->zrange('departments:dept_no:'.$value[$i][0],0,-1);
		}
});
		$departments_name = $client->pipeline(function ($pipe) use($value,$index){
		for($i = 0; $i < count($value); $i++)
	 	{
			$pipe->hmget('departments:'.$index[$i][0],'dept_name');
		}
});
		$emp_no = $client->pipeline(function ($pipe) use($value,$index,$departments_name){
		for($i = 0; $i < count($value); $i++)
	 	{
			$pipe->hmget('dept_manager:'.$i,'emp_no');
		}
});
		
	 	for($i = 0; $i < count($value); $i++)
	 	{
			echo $departments_name[$i][0]."|".$emp_no[$i][0]."<br/>";
		}
		 $time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "read only $time seconds\n";
	}
 	function redis_join_3()
	{
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		$data = getDataFromtextfile_explode("data/dept_manager.txt");
		$data = array_slice($data, 0, count($data)-1); 
		//print_r($data);
		$value = array();
		$time_start = microtime_float();
	 	for($i = 0; $i < count($data); $i++)
	 	{
	 		$value[$i] = $client->hmget('dept_manager:'.$i,'dept_no');
	 		//echo $value[0]."<br/>";
	 	}
	 	for($i = 0; $i < count($value); $i++)
	 	{
			$index[$i]=$client->zrange('departments:dept_no:'.$value[$i][0],0,-1);
			$departments_name[$i] =$client->hmget('departments:'.$index[$i][0],'dept_name');
			$emp_no[$i] = $client->hmget('dept_manager:'.$i,'emp_no');
			$emp_id[$i] = $client->zrange('employees:emp_no:'.$emp_no[$i][0],0,-1);
			$emp_name[$i] = $client->hmget('employees:'.$emp_id[$i][0],'first_name','last_name');
			echo $departments_name[$i][0]."|".$emp_no[$i][0].$emp_name[$i][0]."|".$emp_name[$i][1]."<br/>";
		}
		 $time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "read only $time seconds\n";
	}
	function redis_join_pipeline_3()
	{
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		$data = getDataFromtextfile_explode("data/dept_manager.txt");
		$data = array_slice($data, 0, count($data)-1); 
		//print_r($data);
		$time_start = microtime_float();
		$value = $client->pipeline(function ($pipe) use($data){
		for($i = 0; $i < count($data); $i++)
	 	{
			$pipe->hmget('dept_manager:'.$i,'dept_no');
		}
});
		$index = $client->pipeline(function ($pipe) use($value){
		for($i = 0; $i < count($value); $i++)
	 	{
			$pipe->zrange('departments:dept_no:'.$value[$i][0],0,-1);
		}
});
		$departments_name = $client->pipeline(function ($pipe) use($value,$index){
		for($i = 0; $i < count($value); $i++)
	 	{
			$pipe->hmget('departments:'.$index[$i][0],'dept_name');
		}
});
		$emp_no = $client->pipeline(function ($pipe) use($value,$index,$departments_name){
		for($i = 0; $i < count($value); $i++)
	 	{
			$pipe->hmget('dept_manager:'.$i,'emp_no');
		}
});
		$emp_id = $client->pipeline(function ($pipe) use($emp_no){
		for($i = 0; $i < count($emp_no); $i++)
	 	{
			$pipe->zrange('employees:emp_no:'.$emp_no[$i][0],0,-1);
		}
});
		$emp_name = $client->pipeline(function ($pipe) use($emp_id){
		for($i = 0; $i < count($emp_id); $i++)
	 	{
			$pipe->hmget('employees:'.$emp_id[$i][0],'first_name','last_name');
		}
});
		 
	 	for($i = 0; $i < count($value); $i++)
	 	{
			echo $departments_name[$i][0]."|".$emp_no[$i][0]."|".$emp_name[$i][0]."|".$emp_name[$i][1]."<br/>";
		}
		$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "read only $time seconds\n";
	}
	function redis_join_4()
	{
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		$data = getDataFromtextfile_explode("data/titles.txt");
		$data = array_slice($data, 0, count($data)-1); 
		//print_r($data);
		$value = array();
		$time_start = microtime_float();
	 	for($i = 0; $i < count($data); $i++)
	 	{
	 		$value[$i] = $client->hmget('titles:'.$i,'emp_no');
	 		//echo $value[$i][0]."<br/>";
	 	}
	 	for($i = 0; $i < count($value); $i++)
	 	{
	 		$index[$i] = $client->zrange('employees:emp_no:'.$value[$i][0],0,-1);
	 		//echo $index[$i][0]."<br/>";
	 	}
	 	for($i = 0; $i < count($index); $i++)
	 	{
	 		$emp_name[$i] = $client->hmget('employees:'.$index[$i][0],'emp_no','first_name','last_name');
	 		$value1[$i] = $client->hmget('titles:'.$i,'title');
	 		echo $emp_name[$i][0]."|".$value1[$i][0]."|".$emp_name[$i][1]."|".$emp_name[$i][2]."<br/>";
	 	}
	 	$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "read only $time seconds\n";
	}
	function redis_join_pipeline_4()
	{
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		$data = getDataFromtextfile_explode("data/titles.txt");
		$data = array_slice($data, 0, count($data)-1); 
		//print_r($data);
		$value = array();
		$time_start = microtime_float();
		$value = $client->pipeline(function ($pipe) use($data){
		for($i = 0; $i < count($data); $i++)
	 	{
			$pipe->hmget('titles:'.$i,'emp_no');
		}
});
		$index = $client->pipeline(function ($pipe) use($data,$value){
		for($i = 0; $i < count($value); $i++)
	 	{
			$pipe->zrange('employees:emp_no:'.$value[$i][0],0,-1);
		}
});
		$emp_name = $client->pipeline(function ($pipe) use($index){
		for($i = 0; $i < count($index); $i++)
	 	{
			$pipe->hmget('employees:'.$index[$i][0],'emp_no','first_name','last_name');
			
		}
});
		$value1 = $client->pipeline(function ($pipe) use($index){
		for($i = 0; $i < count($index); $i++)
	 	{
			$pipe->hmget('titles:'.$i,'title');
			
		}
});
		$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "read only $time seconds\n";
	 	for($i = 0; $i < count($index); $i++)
	 	{
	 		echo $emp_name[$i][0]."|".$value1[$i][0]."|".$emp_name[$i][1]."|".$emp_name[$i][2]."<br/>";
	 	}
	 	
	}
	function redis_subquery_1()
	{
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		$data = getDataFromtextfile_explode("data/dept_manager.txt");
		$data = array_slice($data, 0, count($data)-1); 
		$time_start = microtime_float();
		for($i = 0; $i < count($data); $i++)
	 	{
	 		$value[$i] = $client->hmget('dept_manager:'.$i,'emp_no');
	 		//echo $value[$i][0]."<br/>";
	 		$emp_id[$i] = $client->zrange('employees:emp_no:'.$value[$i][0],0,-1);
	 		//echo $value[$i][0]."|".$emp_id[$i][0]."<br/>";
	 		$employee[$i]=$client->hmget('employees:'.$emp_id[$i][0],'emp_no','birth_date','first_name','last_name','gender','hire_date');
	 	echo $employee[$i][0]."|".$employee[$i][1]."|".$employee[$i][2]."|".$employee[$i][3]."|".$employee[$i][4]."|".$employee[$i][5]."<br/>";
	 	}
	 	$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "read only $time seconds\n";
	}
	function redis_subquery_1_pipeline()
	{
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		$data = getDataFromtextfile_explode("data/dept_manager.txt");
		$data = array_slice($data, 0, count($data)-1); 
		$time_start = microtime_float();
		$value = $client->pipeline(function ($pipe) use($data){
		for($i = 0; $i < count($data); $i++)
	 	{
			$pipe->hmget('dept_manager:'.$i,'emp_no');
		}
});
		$emp_id = $client->pipeline(function ($pipe) use($value){
		for($i = 0; $i < count($value); $i++)
	 	{
			$pipe->zrange('employees:emp_no:'.$value[$i][0],0,-1);
		}
});
		$employee = $client->pipeline(function ($pipe) use($emp_id){
		for($i = 0; $i < count($emp_id); $i++)
	 	{
			$pipe->hmget('employees:'.$emp_id[$i][0],'emp_no','birth_date','first_name','last_name','gender','hire_date');
		}
});
		$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "read only $time seconds\n";
		for($i = 0; $i < count($employee); $i++)
	 	{
	 		echo $employee[$i][0]."|".$employee[$i][1]."|".$employee[$i][2]."|".$employee[$i][3]."|".$employee[$i][4]."|".$employee[$i][5]."<br/>";
	 	}
	 
	}
	function redis_subquery_2()
	{
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		$data = getDataFromtextfile_explode("data/salaries_100000.txt");
		$data = array_slice($data, 0, count($data)-1);
		//print_r($data);
		$value = array();
		$index = array();

		for($i = 0; $i < count($data); $i++)
	 	{
	 		//(in_array("Glenn", $people))
	 		if($data[$i][1] <= 50000)
	 		{
	 			if(!in_array($data[$i][0], $value,TRUE))
	 			{
	 				array_push($value, $data[$i][0]);
	 			}
	 			
	 		}
	 		
	 	} 
	 
	 	//print_r($value);
	 	
	 	//print_r(count($value));
	 	$time_start = microtime_float();
	 	for($i = 0; $i < count($value); $i++)
	 	{
	 		$emp_id = $client->zrange('employees:emp_no:'.$value[$i],0,-1);
	 		array_push($index,$emp_id);
	 		$employee[$i]=$client->hmget('employees:'.$index[$i][0],'emp_no','birth_date','first_name','last_name','gender','hire_date');
	 		echo $employee[$i][0]."|".$employee[$i][1]."|".$employee[$i][2]."|".$employee[$i][3]."|".$employee[$i][4]."|".$employee[$i][5]."<br/>";
	 	}
	 	$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "read only $time seconds\n";
	}
	function redis_subquery_2_pipeline()
	{
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		$data = getDataFromtextfile_explode("data/salaries_100000.txt");
		$data = array_slice($data, 0, count($data)-1);
		//print_r($data);
		$value = array();
		$index = array();
		
		for($i = 0; $i < count($data); $i++)
	 	{
	 		//(in_array("Glenn", $people))
	 		if($data[$i][1] <= 50000)
	 		{
	 			if(!in_array($data[$i][0], $value,TRUE))
	 			{
	 				array_push($value, $data[$i][0]);
	 			}
	 			
	 		}
	 		
	 	} 
	 
	 	//print_r($value);
	 	
	 	//print_r(count($value));
	 	$time_start = microtime_float();
	 	$index = $client->pipeline(function ($pipe) use($value){
		for($i = 0; $i < count($value); $i++)
	 	{
			$pipe->zrange('employees:emp_no:'.$value[$i],0,-1);
		}
});
	 	$employee= $client->pipeline(function ($pipe) use($index){
		for($i = 0; $i < count($index); $i++)
	 	{
			$pipe->hmget('employees:'.$index[$i][0],'emp_no','birth_date','first_name','last_name','gender','hire_date');
		}
});
	 	$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "read only $time seconds\n";
	 	for($i = 0; $i < count($employee); $i++)
	 	{
	 		echo $employee[$i][0]."|".$employee[$i][1]."|".$employee[$i][2]."|".$employee[$i][3]."|".$employee[$i][4]."|".$employee[$i][5]."<br/>";
	 	}
	 	
	}
	function update_salary()
	{
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		$data = getDataFromtextfile_explode("data/salaries_100000.txt");
		$data = array_slice($data, 0, count($data)-1);
		$time_start = microtime_float();
		$value = array();
	 	/*for($i = 0; $i < 100000; $i++)
	 	{
	 		//$client->hmset('metavars', array('foo' => 'bar', 'hoge' => 'piyo', 'lol' => 'wut'));
	 		$client->hmset('salaries:'.$i,'emp_no',$data[$i][0], 'salary',$data[$i][1],'from_date',$data[$i][2], 'to_date',$data[$i][3]);
	 		//$redis->zAdd('key', 0, 'val0');
	 		$client->zadd('salaries:emp_no:'.$data[$i][0],1,$i);
	 		$client->zadd('salaries:salary:'.$data[$i][1],2,$i);
	 		$client->zadd('salaries:from_date:'.$data[$i][2],3,$i);
	 		$client->zadd('salaries:to_date:'.$data[$i][3],4,$i);
	 	}*/
	 	for($i = 0; $i < 100000; $i++)
	 	{
	 		//$client->hdel('salaries:'.$i,'emp_no');
	 		$xxx =12345;
	 		$client->hmset('salaries:'.$i,'emp_no',$data[$i][0], 'salary',$xxx,'from_date',$data[$i][2], 'to_date',$data[$i][3]);
	 		//$client->del('salaries:salary:12345');
	 		$client->del('salaries:salary:55555');
	 		//$client->del('salaries:salary:'.$data[$i][1]);
	 		$client->zadd('salaries:salary:'.$xxx,1,$i);
	 		//$client->zadd('salaries:salary:'.$data[$i][1],2,$i);
	 		//$client->zadd('salaries:from_date:'.$data[$i][2],3,$i);
	 		//$client->zadd('salaries:to_date:'.$data[$i][3],4,$i);
	 	}
	 	$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "insert redis only $time seconds\n";
		for($i = 0; $i < 100000; $i++)
	 	{
	 		$value = $client->hmget('salaries:'.$i,'emp_no','salary','from_date','to_date');
		 	echo $value[0]."|".$value[1]."|".$value[2]."|".$value[3]."<br/>";
	 	}
	 	//$allKeys = $client->keys('*');
	 	//print_r($allKeys);
	 	
	}
	function update_salary_pipeline()
	{
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		$data = getDataFromtextfile_explode("data/salaries_100000.txt");
		$data = array_slice($data, 0, count($data)-1);
		
		$value = array();
		$xxx = 12345;
		$time_start = microtime_float();
		$employee= $client->pipeline(function ($pipe) use($xxx,$data){
		for($i = 0; $i < 100000; $i++)
	 	{
	 		
	 		$pipe->hmset('salaries:'.$i,'emp_no',$data[$i][0], 'salary',$xxx,'from_date',$data[$i][2], 'to_date',$data[$i][3]);
	 		$pipe->del('salaries:salary:55555');
	 		//$pipe->del('salaries:salary:12345');
	 		//$pipe->del('salaries:salary:'.$data[$i][1]);
	 		$pipe->zadd('salaries:salary:'.$xxx,1,$i);
		}
});
		$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "insert redis only $time seconds\n";
	/* for($i = 0; $i < 10000; $i++)
	 	{
	 		//$client->hmset('metavars', array('foo' => 'bar', 'hoge' => 'piyo', 'lol' => 'wut'));
	 		$client->hmset('salaries:'.$i,'emp_no',$data[$i][0], 'salary',$data[$i][1],'from_date',$data[$i][2], 'to_date',$data[$i][3]);
	 		//$redis->zAdd('key', 0, 'val0');
	 		$client->zadd('salaries:emp_no:'.$data[$i][0],1,$i);
	 		$client->zadd('salaries:salary:'.$data[$i][1],2,$i);
	 		$client->zadd('salaries:from_date:'.$data[$i][2],3,$i);
	 		$client->zadd('salaries:to_date:'.$data[$i][3],4,$i);
	 	}*/
	 	for($i = 0; $i < 100000; $i++)
	 	{
	 		$value = $client->hmget('salaries:'.$i,'emp_no','salary','from_date','to_date');
		 	echo $value[0]."|".$value[1]."|".$value[2]."|".$value[3]."<br/>";
	 	}
	 	$allKeys = $client->keys('*');
	 	print_r($allKeys);
	 	
	}
	function redis_delete()
	{
		$data = getDataFromtextfile_explode("data/salaries_100000.txt");
		$data = array_slice($data, 0, count($data)-1);
		$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		for($i = 0; $i < 100000; $i++)
	 	{
	 		//$client->hdel('salaries:'.$i,'emp_no');
	 		$client->del('salaries:'.$i);
	 		//$client->del('salaries:salary:12345');
	 		//$client->del('salaries:salary:55555');
	 		
	 		
	 	}
	 	$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "insert redis only $time seconds\n";
	}
	function redis_delete_pipeline()
	{
		$data = getDataFromtextfile_explode("data/salaries_100000.txt");
		$data = array_slice($data, 0, count($data)-1);
		$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		$employee= $client->pipeline(function ($pipe) use($data){
		for($i = 0; $i < 100000; $i++)
	 	{
	 		
	 		$pipe->del('salaries:'.$i);
			
		}
});
		$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "insert redis only $time seconds\n";
	}
	function flushall()
	{
		$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);
		$client->flushall();
		$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "insert redis only $time seconds\n";
	}
	function update_by_condition_1()
	{
		$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);

		 		//zRange('key1', 0, -1);
		$update = "Marketing";//Software development
		//$update = "Software development";
		$value1 = $client->zrange('departments:dept_no:d001',0,-1);
		for ($i=0; $i < count($value1) ; $i++) 
		{ 
			$client->hmset('departments:'.$value1[0],'dept_no','d001','dept_name',$update);
			$client->del('departments:dept_name:Software development');
			//$client->del('departments:dept_name:Marketing');
			//$client->zadd('departments:dept_name:Software development',2,$value1[0]);
			$client->zadd('departments:dept_name:Marketing',2,$value1[0]);
		}
		$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "update redis only $time seconds\n"; 	
		$data = getDataFromtextfile_explode("data/departments.txt");
		$data = array_slice($data, 0, count($data)-1);
		$value = array(); 
		for($i = 0; $i < count($data); $i++)
		 	{
			 	$value = $client->hmget('departments:'.$i,'dept_no','dept_name');
			 	echo $value[0]."  ".$value[1]."<br/>";
		 	}
		 	$value3 = $client->zrange('departments:dept_name:Software development',0,-1);
		 	print_r($value3);
		 	$value4 = $client->zrange('departments:dept_name:Marketing',0,-1);
		 	print_r($value4);
	}
	function update_by_condition_1_pipeline()
	{
		
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);

		 		//zRange('key1', 0, -1);
		$value1 = $client->zrange('departments:dept_no:d001',0,-1);
		$update = "Marketing";//Software development
		//$update = "Software development";
		$time_start = microtime_float();
		$employee= $client->pipeline(function ($pipe) use($update,$value1){
		for ($i=0; $i < count($value1) ; $i++) 
		{ 
			$pipe->hmset('departments:'.$value1[0],'dept_no','d001','dept_name',$update);
			$pipe->del('departments:dept_name:Software development');
			//$pipe->del('departments:dept_name:Marketing');
			//$pipe->zadd('departments:dept_name:Software development',2,$value1[0]);
			$pipe->zadd('departments:dept_name:Marketing',2,$value1[0]);
		}
});
		$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "update redis only $time seconds\n"; 	
		$data = getDataFromtextfile_explode("data/departments.txt");
		$data = array_slice($data, 0, count($data)-1);
		$value = array(); 
		for($i = 0; $i < count($data); $i++)
		 	{
			 	$value = $client->hmget('departments:'.$i,'dept_no','dept_name');
			 	echo $value[0]."  ".$value[1]."<br/>";
		 	}
		 	$value3 = $client->zrange('departments:dept_name:Software development',0,-1);
		 	print_r($value3);
		 	$value4 = $client->zrange('departments:dept_name:Marketing',0,-1);
		 	print_r($value4);
	}
	function update_by_condition_2()
	{
		$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);

		 		//zRange('key1', 0, -1);
		$update = "System analysis";//Software development
		//$update = "Staff";
		$to_dateup= "2016-10-23";
		//$to_dateup= "1991-06-16";
		$value1 = $client->zrange('titles:emp_no:10277',0,-1);
		$value2 = $client->zrange('titles:from_date:1985-06-16',0,-1);
		//print_r($value1);
		//print_r($value2);
		for ($i=0; $i <count($value2) ; $i++) 
		{ 
			if($value1[1] == $value2[$i])
			{
				$index = $value2[$i];
			}
		}
		//print_r($index);
		//$client->zadd('titles:emp_no:'.$data[$i][0],1,$i);
	 		//$client->zadd('titles:title:'.$data[$i][1],2,$i);
	 		//$client->zadd('titles:from_date:'.$data[$i][2],3,$i);
	 		//$client->zadd('titles:to_date:'.$data[$i][3],4,$i);
		//$value7 = $client->hmget('titles:412','emp_no','title','from_date','to_date');
		//echo $value7[0]."|".$value7[1]."|".$value7[2]."|".$value7[3]."<br/>";
		for ($i=0; $i < count($index); $i++) 
		{ 
			//hmset('titles:'.$i,'emp_no',$data[$i][0], 'title',$data[$i][1],'from_date',$data[$i][2], 'to_date',$data[$i][3]);
			//$client->del('titles:412');
			$client->hmset('titles:'.$index,'emp_no','10277','title',$update,'from_date','1985-06-16','to_date',$to_dateup);
			//$client->del('titles:title:Staff');
			$client->zrem('titles:to_date:1991-06-16',4,412);
			$client->zrem('titles:title:Staff',2,412);
			//$client->zrem('titles:to_date:2016-10-23',4,412);
			//$client->zrem('titles:title:System analysis',2,412);
			//$client->del('titles:to_date:1991-06-16');
			//$client->del('titles:title:System analysis');
			//$client->del('titles:to_date:2016-10-23');
			//$client->del('departments:dept_name:Marketing');
			//$client->zadd('departments:dept_name:Software development',2,$value1[0]);
			$client->zadd('titles:title:'.$update,2,$index);
			$client->zadd('titles:to_date:'.$to_dateup,4,$index);
		}


		$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "update redis only $time seconds\n"; 	
		//$data = getDataFromtextfile_explode("data/titles.txt");
		//$data = array_slice($data, 0, count($data)-1); 
		
		//$v1 = $client->zrange('titles:to_date:'.$to_dateup,0,-1);
		//$v2 = $client->zrange('titles:title:'.$update,0,-1);
		$v3= $client->zrange('titles:to_date:1991-06-16',0,-1);
		$v4 = $client->zrange('titles:title:Staff',0,-1);
		//print_r($v1);
		//print_r($v2);
		//print_r($v3);
		//print_r($v4);
		
		
		if( in_array(412,$v4))
		{
			echo "true";
		}
		else if (in_array(412,$v3)) {
			echo "true";
		}
		else
		{
			echo "false";
		}
		$data = getDataFromtextfile_explode("data/titles.txt");
		$data = array_slice($data, 0, count($data)-1); 
		for($i = 0; $i < count($data); $i++)
	 	{
		 	$value = $client->hmget('titles:'.$i,'emp_no','title','from_date','to_date');
		 	echo $value[0]."|".$value[1]."|".$value[2]."|".$value[3]."<br/>";
	 	}

	}
	function update_by_condition_2_pipeline()
	{
		$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);

		 		//zRange('key1', 0, -1);
		$update = "System analysis";//Software development
		//$update = "Staff";
		$to_dateup= "2016-10-23";
		//$to_dateup= "1991-06-16";
		$value1 = $client->zrange('titles:emp_no:10277',0,-1);
		$value2 = $client->zrange('titles:from_date:1985-06-16',0,-1);
		//print_r($value1);
		//print_r($value2);
		for ($i=0; $i <count($value2) ; $i++) 
		{ 
			if($value1[1] == $value2[$i])
			{
				$index = $value2[$i];
			}
		}
		//print_r($index);
		$employee= $client->pipeline(function ($pipe) use($update,$to_dateup,$index){
		for ($i=0; $i < count($index) ; $i++) 
		{ 
			$pipe->hmset('titles:'.$index,'emp_no','10277','title',$update,'from_date','1985-06-16','to_date',$to_dateup);
			//$client->del('titles:title:Staff');
			$pipe->zrem('titles:to_date:1991-06-16',4,412);
			$pipe->zrem('titles:title:Staff',2,412);
			//$pipe->zrem('titles:to_date:2016-10-23',4,412);
			//$pipe->zrem('titles:title:System analysis',2,412);
			
			$pipe->zadd('titles:title:'.$update,2,$index);
			$pipe->zadd('titles:to_date:'.$to_dateup,4,$index);
		}
});

		$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "update redis only $time seconds\n"; 	
		//$data = getDataFromtextfile_explode("data/titles.txt");
		//$data = array_slice($data, 0, count($data)-1); 
		
		//$v1 = $client->zrange('titles:to_date:'.$to_dateup,0,-1);
		//$v2 = $client->zrange('titles:title:'.$update,0,-1);
		$v3= $client->zrange('titles:to_date:1991-06-16',0,-1);
		$v4 = $client->zrange('titles:title:Staff',0,-1);
		//print_r($v1);
		//print_r($v2);
		//print_r($v3);
		//print_r($v4);
		
		
		if( in_array(412,$v4))
		{
			echo "true";
		}
		else if (in_array(412,$v3)) {
			echo "true";
		}
		else
		{
			echo "false";
		}
		$data = getDataFromtextfile_explode("data/titles.txt");
		$data = array_slice($data, 0, count($data)-1); 
		for($i = 0; $i < count($data); $i++)
	 	{
		 	$value = $client->hmget('titles:'.$i,'emp_no','title','from_date','to_date');
		 	echo $value[0]."|".$value[1]."|".$value[2]."|".$value[3]."<br/>";
	 	}

	}
	function delete_condition_1()
	{
		$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);

		$value = $client->zrange('salaries:emp_no:10004',0,-1);
		//print_r($value);
		for($i=0;$i<count($value);$i++)
		{
			$client->del('salaries:'.$value[$i]);
		}
		//$client->del('salaries:emp_no:10004');
		$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "delete redis only $time seconds\n"; 	

		$data = getDataFromtextfile_explode("data/salaries_1000000.txt");
		$data = array_slice($data, 0, count($data)-1); 
		for($i = 0; $i < 100000; $i++)
	 	{
		 	$value = $client->hmget('salaries:'.$i,'emp_no','salary','from_date','to_date');
		 	echo $value[0]."|".$value[1]."|".$value[2]."|".$value[3]."<br/>";
	 	}
	}
	function delete_condition_1_pipeline()
	{
		$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);

		$value = $client->zrange('salaries:emp_no:10004',0,-1);
		//print_r($value);
		$employee= $client->pipeline(function ($pipe) use($value){
		for ($i=0; $i < count($value) ; $i++) 
		{ 
			$pipe->del('salaries:'.$value[$i]);
		}
});
		//$client->del('salaries:emp_no:10004');
		$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "delete redis only $time seconds\n"; 	

		$data = getDataFromtextfile_explode("data/salaries_1000000.txt");
		$data = array_slice($data, 0, count($data)-1); 
		for($i = 0; $i < 100000; $i++)
	 	{
		 	$value = $client->hmget('salaries:'.$i,'emp_no','salary','from_date','to_date');
		 	echo $value[0]."|".$value[1]."|".$value[2]."|".$value[3]."<br/>";
	 	}
	}
	function delete_condition_2()
	{
		$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);

		$value9 = $client->zrange('departments:dept_no:d009',0,-1);
		print_r($value9);
		
		for($i=0;$i<count($value9);$i++)
		{
			$client->del('departments:'.$value9[$i]);
			$client->del('departments:dept_no:d009');
			$client->del('departments:dept_no:Customer Service');
		}
		//$client->del('salaries:emp_no:10004');
		$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "delete redis only $time seconds\n"; 	


		$data = getDataFromtextfile_explode("data/departments.txt");
		$data = array_slice($data, 0, count($data)-1);
		$value = array(); 
		for($i = 0; $i < 9; $i++)
		 	{
			 	$value = $client->hmget('departments:'.$i,'dept_no','dept_name');
			 	echo $value[0]."  ".$value[1]."<br/>";
		 	}
		 	$value1 = array();
		 	$value2 = array();
		 	for($i = 0; $i < 9; $i++)
		 	{
		 		//zRange('key1', 0, -1);
			 	$value1 = $client->zrange('departments:dept_no:'.$data[$i][0],0,-1);
			 	$value2 = $client->zrange('departments:dept_name:'.$data[$i][1],0,-1);
			 	echo $value1[0].$value2[0]."<br/>";
		 	}
		
	}
	function delete_condition_2_pipeline()
	{
		$time_start = microtime_float();
		require __DIR__.'/shared.php';
		$client = new Predis\Client($single_server);

		$value9 = $client->zrange('departments:dept_no:d009',0,-1);
		print_r($value9);
		$employee= $client->pipeline(function ($pipe) use($value9){
		for ($i=0; $i < count($value9) ; $i++) 
		{ 
			$pipe->del('departments:'.$value9[$i]);
			$pipe->del('departments:dept_no:d009');
			$pipe->del('departments:dept_no:Customer Service');
		}
});
		//$client->del('salaries:emp_no:10004');
		$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "delete redis only $time seconds\n"; 	


		$data = getDataFromtextfile_explode("data/departments.txt");
		$data = array_slice($data, 0, count($data)-1);
		$value = array(); 
		for($i = 0; $i < 9; $i++)
		 	{
			 	$value = $client->hmget('departments:'.$i,'dept_no','dept_name');
			 	echo $value[0]."  ".$value[1]."<br/>";
		 	}
		 	$value1 = array();
		 	$value2 = array();
		 	for($i = 0; $i < 9; $i++)
		 	{
		 		//zRange('key1', 0, -1);
			 	$value1 = $client->zrange('departments:dept_no:'.$data[$i][0],0,-1);
			 	$value2 = $client->zrange('departments:dept_name:'.$data[$i][1],0,-1);
			 	echo $value1[0].$value2[0]."<br/>";
		 	}
		
	}
?>
