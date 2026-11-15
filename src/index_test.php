<?php
// Wait for database to be ready (max 30 seconds)
$wait = 30;
$db_host = 'db';
$db_name = getenv('DB_DATABASE');
$db_user = getenv('DB_USERNAME');
$db_pass = getenv('DB_PASSWORD');

$start = time();
$connected = false;

while (time() - $start < $wait && !$connected) {
    try {
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

        $connected = true;
        echo "<h2>Database connection successful!</h2>";

        // Test query
        // $stmt = $pdo->query("SELECT VERSION()");
        // $version = $stmt->fetchColumn();
        // echo "<p>MySQL version: $version</p>";

        // Testing added tables in myapp database
        // $test = $pdo->query("SELECT table_name FROM information_schema.tables
        // WHERE table_schema = 'myapp'")->fetchAll();

        // foreach ($test as $value) {
        //     print_r($value);
        // }

    // $folders = scandir('projects/');
    // foreach(new DirectoryIterator('projects/') as $folder) { {
    //     if ($folder->isDir()) {
    //     echo '<li>'.$folder->getFilename().'</li>';
    //     }
    // }
    // }

    echo '<p>open an existing project:</p><br><br>';

    $directory = 'projects';
    $items = scandir($directory);
    $subdirs = array();
    
    foreach ($items as $item) {
        if ($item != '.' && $item != '..' && is_dir($directory . '/' . $item)) {
            $subdirs[] = $item;
        }
    }
    echo '<p>create new project from folder: <select>';
    foreach($subdirs as $folder) {
        echo '<option>'.$folder.'</option>';
    }
    echo '</select> <button style="margin: 0 20px;">create new</button></p><br>';


    function listFolderFiles($dir){
        echo '<ul style="height:120px;list-style-type:none;">';
        foreach (new DirectoryIterator($dir) as $fileInfo) {
            if (!$fileInfo->isDot()) {
            $ext = strtolower(pathinfo($fileInfo->getFilename(), PATHINFO_EXTENSION));
                if (in_array($ext, array('jpg','jpeg'))) {
                echo '<li style="float:left;border:1px solid;margin:5px;height:100%; width:120px; overflow:hidden;"><img style="height:auto;max-width:120px;" src="'.$dir.'/' . $fileInfo->getFilename() . '"/></li>';
                }
            }
        }
        echo '</ul>';
    }

    listFolderFiles('projects/test one');
    listFolderFiles('projects/test two');


        // Show users (for debugging)
        // $users = $pdo->query("SELECT user, host FROM mysql.user")->fetchAll();
        // echo "<pre>MySQL Users:\n" . print_r($users, true) . "</pre>";
    } catch (PDOException $e) {
        if (time() - $start >= $wait) {
            echo "<h2>Database connection failed after $wait seconds</h2>";
            echo "<p>Error: " . $e->getMessage() . "</p>";
            echo "<pre>Debug Info:\n";
            echo "Host: $db_host\n";
            echo "DB: $db_name\n";
            echo "User: $db_user\n";

            // Network check
            echo "\nNetwork check:\n";
            echo "Ping result: " . shell_exec("ping -c 2 $db_host 2>&1");
            echo "Telnet test: " . (function_exists('fsockopen')
                ? (fsockopen($db_host, 3306) ? 'Success' : 'Failed')
                : 'fsockopen not available');

            echo "</pre>";
        }
        sleep(2);
    }
}
