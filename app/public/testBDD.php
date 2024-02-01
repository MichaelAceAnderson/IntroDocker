<!DOCTYPE html>
<html lang='fr'>
<head>
	<meta charset='UTF-8'>
	<title>Test de connexion à la base de données</title>
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
// Afficher les variables d'environnement
echo '<div class="notification info"><h1>Variables d\'environnement</h1>';
echo '<h2>ADMINER_DEFAULT_SERVER: ' . getenv('ADMINER_DEFAULT_SERVER') . '</h2>';
echo '<h2>MARIADB_DATABASE: ' . getenv('MARIADB_DATABASE') . '</h2>';
echo '<h2>MARIADB_USER: ' . getenv('MARIADB_USER') . '</h2>';
echo '<h2>MARIADB_PASSWORD: ' . getenv('MARIADB_PASSWORD') . '</h2>';
echo '</div>';

$pdo = null;
try {
    $pdo = new PDO(
        // La variable d'environnement ADMINER_DEFAULT_SERVER définie dans le fichier .env 
        // remplace ici le nom de l'hôte de la base de données par le nom du service dans le docker-compose.yml
        'mysql:host=' . getenv('ADMINER_DEFAULT_SERVER') .
            ';dbname=' . getenv('MARIADB_DATABASE') . '',
        getenv('MARIADB_USER'),
        getenv('MARIADB_PASSWORD')
    );
    echo '<div class="notification success"><h1>Connexion réussie</h1></div>';

	// Créer une table
	if(isset($_GET['create']))
	{
		if($_GET['create'] == 'table') {
			$stmt = $pdo->prepare('CREATE TABLE IF NOT EXISTS `test` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(255) NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;');
			$stmt->execute();
			echo '<div class="notification success"><h1>Requête de création de table réussie</h1></div>';
		}
	}

	// Récupérer toutes les tables de la base de données
	$stmt = $pdo->query('SHOW TABLES');
	// Afficher toutes les tables de la base de données
	$result = $stmt->fetchAll(PDO::FETCH_COLUMN);
	if(count($result) == 0) {
		echo '<br>Il n\'y a pas de table(s) dans la base de données';
	}
	else{
		echo '<br>Il y a ' . count($result) . ' tables dans la base de données';
		echo '<table>';
		echo '<tr><th>Nom de la table</th></tr>';
		foreach ($result as $row) {
			echo '<tr><td>' . $row . '</td></tr>';
		}
	}
	echo '</table>';
} catch (PDOException $e) {
    echo '<div class="notification error"><h1>Connexion échouée: ' . $e->getMessage() . '</h1></div>';
}

echo '<p>Vous pouvez accéder aux tables depuis <a href="http://localhost:8080/?server=mariadb&username=root&db=my_docker_db">adminer</a> grâce au mot de passe configuré dans le dossier .docker/mariadb/.env.dev</p>';
echo '<span>Cliquez <form action="" method="GET"><button type="submit" name="create" value="table">ici</button></form> pour créer une table</span';