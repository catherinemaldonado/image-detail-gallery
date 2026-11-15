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

// $id = intval($_GET['id']);

$folder = $_GET['folder'];
$project = $_GET['id'];

$dir = 'projects/'.$folder;
echo 'folder: '.$folder.'project: '.$project;
echo '<ul>';
foreach (new DirectoryIterator($dir) as $fileInfo) {
    $imagename = $fileInfo->getFilename();

    $ext = strtolower(pathinfo($imagename, PATHINFO_EXTENSION));

    if (in_array($ext, array('jpg','jpeg'))) {
    try {
        $sql = "INSERT INTO image (project, filename) SELECT '$project', '$imagename' WHERE NOT EXISTS ( SELECT 1 FROM image WHERE filename = '$imagename' AND project ='$project')";
        $pdo->exec($sql);
        echo '<li>';
        echo $imagename." checked";
        echo '</li>';
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    }
}
echo '</ul>';

?>