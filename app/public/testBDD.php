<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset='UTF-8'>
	<title>Database Connection Test</title>
	<style>
		body {
			font-family: sans-serif;
		}
		body p{
			font-size: 1em;
		}
		body h1{
			font-size: 1.2em;
		}
		.notification {
			padding: 1em;
			margin-bottom: 1em;
			border-radius: 0.5em;
		}
		.notification.success {
			background-color: #d4edda;
			border-color: #c3e6cb;
			color: #155724;
		}
		.notification.error {
			background-color: #f8d7da;
			border-color: #f5c6cb;
			color: #721c24;
		}

		.notification.info{
			background-color: #cce5ff;
			border-color: #b8daff;
			color: #004085;
		}

		.notification.info h2{
			font-size: 1.1em;
			padding: 5px;
			background-color: white;
			color: black;
			border-radius: 0.5em;
		}

		table {
			border-collapse: collapse;
		}
		table, th, td {
			border: 1px solid black;
		}
		th, td {
			padding: 0.5em;
		}

		span *{
			display: inline;
		}
	</style>
<?php
// Display environment variables
echo '<div class="notification info"><h1>Environment Variables</h1>';
echo '<h2>ADMINER_DEFAULT_SERVER: ' . getenv('ADMINER_DEFAULT_SERVER') . '</h2>';
echo '<h2>MARIADB_DATABASE: ' . getenv('MARIADB_DATABASE') . '</h2>';
echo '<h2>MARIADB_USER: ' . getenv('MARIADB_USER') . '</h2>';
echo '<h2>MARIADB_PASSWORD: ' . getenv('MARIADB_PASSWORD') . '</h2>';
echo '</div>';

$pdo = null;
try {
	$pdo = new PDO(
		// The environment variable ADMINER_DEFAULT_SERVER defined in the .env file
		// replaces the database host name with the service name in the docker-compose.yml
		'mysql:host=' . getenv('ADMINER_DEFAULT_SERVER') .
			';dbname=' . getenv('MARIADB_DATABASE') . '',
		getenv('MARIADB_USER'),
		getenv('MARIADB_PASSWORD')
	);
	echo '<div class="notification success"><h1>Connection Successful</h1></div>';

	// Create a table
	if(isset($_GET['create']))
	{
		if($_GET['create'] == 'table') {
			$stmt = $pdo->prepare('CREATE TABLE IF NOT EXISTS `test` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(255) NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;');
			$stmt->execute();
			echo '<div class="notification success"><h1>Table Creation Query Successful</h1></div>';
		}
	}

	// Retrieve all tables from the database
	$stmt = $pdo->query('SHOW TABLES');
	// Display all tables from the database
	$result = $stmt->fetchAll(PDO::FETCH_COLUMN);
	if(count($result) == 0) {
		echo '<br>There are no tables in the database';
	}
	else{
		echo '<br>There are ' . count($result) . ' tables in the database';
		echo '<table>';
		echo '<tr><th>Table Name</th></tr>';
		foreach ($result as $row) {
			echo '<tr><td>' . $row . '</td></tr>';
		}
	}
	echo '</table>';
} catch (PDOException $e) {
	echo '<div class="notification error"><h1>Connection Failed: ' . $e->getMessage() . '</h1></div>';
}

echo '<p>You can access the tables from <a href="http://localhost:8080/?server=mariadb&username=root&db=my_docker_db">adminer</a> using the password configured in the .docker/mariadb/.env.dev folder</p>';
echo '<span>Click <form action="" method="GET"><button type="submit" name="create" value="table">here</button></form> to create a table</span>';