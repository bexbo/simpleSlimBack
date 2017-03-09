<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require 'vendor/autoload.php';

$app = new \Slim\App;
$app->post('/postJSON', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    echo $data;

});
$app->run();

?>




<?php //initiates the database
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mydb";
try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    // set the PDO error mode to exception

    $createDB = "CREATE DATABASE myDB;";
    $conn-> exec($createDB); //did not work when put inside of the big query
    $createTables = " USE myDB; 
    CREATE TABLE Objects
(
 id INT PRIMARY KEY,
 type VARCHAR (255)
 );
   CREATE TABLE General(
id INT,
valNum INT,
val VARCHAR (255),
FOREIGN KEY id REFERENCES Objects(id)
);
    CREATE TABLE Others(
id INT,
valType VARCHAR (50),
val VARCHAR (100),
FOREIGN KEY id REFERENCES Objects(id)
    )";


    $conn->exec($createTables);//creates the tables
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //settings


    $stmt = $conn->prepare("select type from objects where id=5");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    print_r($result); //testing


    echo "Connected successfully";
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>
