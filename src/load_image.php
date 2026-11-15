<?php
$wait = 30;
$db_host = 'db';
$db_name = getenv('DB_DATABASE');
$db_user = getenv('DB_USERNAME');
$db_pass = getenv('DB_PASSWORD');

$start = time();
$connected = false;

$pdo = new PDO(
    "mysql:host=$db_host;dbname=$db_name",
    $db_user,
    $db_pass,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 5
    ]
);



$id = $_GET['id'];

$image = $pdo->query("SELECT * FROM image WHERE id ='$id'")->fetchAll();

$projectid = $image[0]['project'];

$folder = $pdo->query("SELECT * FROM project WHERE id ='$projectid'")->fetchAll();

$dir = 'projects/'.$folder[0]['folder'];

$title = isset($image[0]['title']) ? $image[0]['filename'] : 'add object title';
$description = isset($image[0]['description']) ? $image[0]['description'] : 'add tombstone information';


echo '<input placeholder="'.$title.'"/><br>';
echo '<img width="200px;" src="'.$dir.'/'.$image[0]['filename'].'"/><br>';
echo '<textarea placeholder="'.$description.'"></textarea><br>';


?>