<?php 

$config = array(
	'host' => 'localhost',
	'username' => 'root',
	'password' => 'voG2faRhku',
	'database' => 'studyhub'
	);

# Connect to the database
$db = new PDO('mysql:host='.$config['host'].';dbname='.$config['database'],
			$config['username'],
			$config['password']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

# Connect using function
// function connect($config) 
// {
// 	try {
// 		$conn = new PDO("mysql:host=localhost;dbname=". $config['database'],
// 						$config['username'],
// 						$config['password']);
// 		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 		return $conn;
// 	} catch (Exception $e) {
// 		return false;
// 	}
// }


// function query($query, $bindings, $conn)
// {
// 	$stmt = $conn->prepare($query);
// 	$stmt->execute($bindings);

// 	return ($stmt->rowCount() > 0) ? $stmt : false;
// }

// function get($tableName, $conn, $limit = 10)
// {
// 	try {
// 		$result = $conn->query("SELECT * FROM $tableName ORDER BY id DESC LIMIT $limit");

// 		return ( $result->rowCount() > 0 )
// 			? $result
// 			: false;
// 	} catch(Exception $e) {
// 		return false;
// 	}
// }


// function get_by_id($id, $conn)
// {
// 	$query = query(
// 		'SELECT * FROM posts WHERE id = :id LIMIT 1',
// 		array('id' => $id),
// 		$conn
// 	);

// 	if ( $query ) return $query->fetchAll();
// 	// else
// }