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

// pass in project id, cycle through all images in folder, check if image exists, add image if not

$project = intval($_GET['id']);
$title = $_GET['title'];

$folder = $pdo->query("SELECT * FROM project WHERE id ='$project'")->fetchAll();

$images = $pdo->query("SELECT * FROM image WHERE project ='$project'")->fetchAll();

$dir = 'projects/'.$folder[0]['folder'];
echo '<a href="" onClick="reload();"><i class="fa-regular fa-house"></i> Return to project home</a>';
echo '<div class="load">';
echo '<h2><i class="fa-solid fa-images"></i>'.$title.' Images</h2><p>Choose an image to edit details</p>';
echo '<ul class="image-buttons">';

foreach ($images as $image) {
    $class = isset($image['title']) ? 'done' : 'incomplete';
    try {
        echo '<li onClick="loadImage('.$image['id'].')" class="'.$class.'"><img src="'.$dir.'/'.$image['filename'].'"/>';
        echo '</li>';
    } catch(PDOException $e) {
        // echo $sql . "<br>" . $e->getMessage();
    }
}
echo '</ul>';
echo '</div>';

?>