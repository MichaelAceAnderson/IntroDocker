<?php
$pdo = null;
try {
    $pdo = new PDO(
        // La variable d'environnement DB_CONTAINER définie dans le fichier .env 
        // remplace ici le nom de l'hôte de la base de données par le nom du conteneur
        'mysql:host=' . getenv('DB_CONTAINER') .
            ';dbname=' . getenv('DB_NAME') . '',
        getenv('DB_USER'),
        getenv('DB_PASS')
    );
    echo 'Connexion réussie';
} catch (PDOException $e) {
    echo 'Connexion échouée: ' . $e->getMessage();
}

# Créer une table de tests vide si elle n'existe pas
$stmt = $pdo->query('CREATE TABLE IF NOT EXISTS `test_table` ( `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY) ENGINE = InnoDB;');
# Récupérer toutes les tables de la base de données
$stmt = $pdo->query('SHOW TABLES');
# Afficher toutes les tables de la base de données
$result = $stmt->fetchAll(PDO::FETCH_COLUMN);
echo "<br>Tables dans la base de données:";
foreach ($result as $row) {
    echo "<br>" . $row;
}
echo "<br>Vous pouvez accéder aux tables depuis <a href=\"adminer.php?server=db&username=root&db=my_docker_db\">adminer</a> grâce au mot de passe configuré dans maria.env";
