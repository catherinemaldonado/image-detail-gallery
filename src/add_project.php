<?php
// Wait for database to be ready (max 30 seconds)
$wait = 30;
$db_host = 'db';
$db_name = getenv('DB_DATABASE');
$db_user = getenv('DB_USERNAME');
$db_pass = getenv('DB_PASSWORD');

$start = time();
$connected = false;

$folder = $_GET['folder'];

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

$last_id='';

    try{
        $sql = "INSERT INTO project (title, folder)
        VALUES ('$folder project', '$folder')";
        $pdo->exec($sql);
        $last_id = $pdo->lastInsertId();

        echo "<div id='proj'><div id='new_folder' name='".$folder."'></div><div id='new_id' name='".$last_id."'></div></div>";
        echo "New project created. Refresh the page to see it in the list. id of project: ".$last_id;
        
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    } finally{
        
    }

?>   

<body>
    <head>
        <script>
            
        </script>
    </head>
</body>
