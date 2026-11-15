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

$projects = $pdo->query("SELECT * FROM `project`
")->fetchAll();
$projectFolders = array();


$directory = 'projects';
$items = scandir($directory);
$subdirs = array();
$newfolders = array();

// array of all folders
foreach ($items as $item) {
    if ($item != '.' && $item != '..' && is_dir($directory . '/' . $item)) {
        $subdirs[] = $item;
    }
}

// array of existing project folders
foreach ($projects as $item) {
        $projectFolders[] = $item['folder'];
}

// array of new project folders

foreach ($subdirs as $subdir) {
    if(!in_array($subdir, $projectFolders)){
        $newFolders[] = $subdir;
    }
}

if(isset($newFolders)){
    echo '<div class="projects"><h2>Create a new project from folder</h2>';

        foreach ($newFolders as $new) {
            $safe = urlencode($new);
            echo ("<button onClick='addProject(\"$safe\")'><i class='fa-solid fa-folder-plus' style='font-size:36px;'></i><p>$new</p></button>");
        }
    echo '</div>';
}


if(isset($projects)){
    echo '<div class="projects"><h2>Open an existing project</h2>';
    foreach ($projects as $project) {
        echo ("<button onClick='loadProject($project[id],\"$project[title]\")'><i class='fa-solid fa-box-archive' style='font-size:36px;'></i><p>$project[title]</p></button>");
    }
    echo '</div>';
}



?>

<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css">
<style>
body{
    font-family: arial;
    margin:0;
    padding:0;
    opacity:0;
    animation: fade-in 2s forwards;
}
a:link, a:visited{
    cursor:pointer;
    margin:10px;
    text-decoration:none;
    font-size:12px;
    text-transform:uppercase;
    color:black;
    font-weight:bold;
}
a:hover{
    underine: solid;
}
.projects{
    background-color: #e6e6e6;
    margin:2% 1%;
    padding:20px;
    float:left; 
    width:40%;
}
h2{
    font-size:20px;
    text-transform:capitalize;
    text-align:center;
    margin:0 0 40px 0;
}
button{
    margin: 0 10px 0 0;
    height:90px;
    width:90px;
    cursor:pointer;
    float:left;
    position:relative;
}
button i{
    position:absolute;
    top:8px;
    left: 0; 
    right: 0; 
    margin-inline: auto; 
    width: fit-content;
}
button p{
    position:absolute;
    top:50%;
    left: 0; 
    right: 0; 
    width:100%;
    margin:0;
    padding:0;
    text-align:center;
    font-size:13px;
}
.load{
    background-color: #e6e6e6;
    margin:20px 10px;
    padding:20px;
    opacity:0;
    animation: fade-in 2s forwards;
    clear:both;
    width:94.5%;
}
.image-buttons{
    list-style-type:none;
    display:grid;
    gap: 10px;
    grid-template-columns: repeat(10, 1fr);
    grid-template: repeat(4, 1fr);
    grid-auto-columns: 120px;
}

.image-buttons li{
    border: 2px solid #cccccc;
    cursor:pointer;
}

.image-buttons li img{
    width: 100%;
}

.done{
    opacity:1;
}
.incomplete{
    border: 2px solid #cccccc;
    opacity:.5;
    &:hover{
        opacity: 1;
        background-color: #cccccc;
    }
}

#addImages{
    clear:both;
    margin:20px;
}


@keyframes fade-in {
  0%,95%{
    opacity:0;
  }
  95%,100% {
    opacity:1;
  }
}
</style>
<script>
function loadProject(str,title) {
  if (str == "") {
    document.getElementById("projectImages").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("projectImages").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","load_project.php?id="+str+"&title="+title,true);
    xmlhttp.send();
    document.querySelectorAll(".projects").forEach(el => {
    el.style.display = 'none';
    });
  }
}
function loadImage(str) {
  if (str == "") {
    document.getElementById("addImages").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("addImages").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","load_image.php?id="+str,true);
    xmlhttp.send();
  }
}
function addProject(str) {
  if (str == "") {
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("projectImages").innerHTML = this.responseText;
        addImages();
      }
    };
    xmlhttp.open("GET","add_project.php?folder="+str,true);
    xmlhttp.send();
  }
}

function addImages(){
    var newid =  document.getElementById("new_id").getAttribute("name");;
    var newfolder = document.getElementById("new_folder").getAttribute("name");;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
                document.getElementById("addImages").innerHTML = this.responseText;
        }
    };
    
    xmlhttp.open("GET","add_image.php?id="+newid+"&folder="+newfolder,true);
    xmlhttp.send();
}

function saveImageDetail(){
    // onChange, get input name and value
    // update image title or description based on input name
}

function reload(){
    window.location.reload();
}
</script>
</head>
<body>


<br>
<div id="projectImages"></div>
<div id="addImages"></div>

</body>
</html>