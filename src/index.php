<?php
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
?>
<!DOCTYPE html>
<html>
<head>
<title>File Listing: <?=$_SERVER[REQUEST_URI]?></title>
<style>
@import url('/.main.css');*{font-family:'Roboto';font-weight:300;}a{color:blue;text-decoration:none;}img{height:1em;}h1{font-weight:400;}
</style>
</head>
<body>
<h1>File listing for: <?=$_SERVER[REQUEST_URI]?></h1>
<form>
<label for="searchbox">Enter query:</label>
<input id="searchbox" name="q">
<button type="submit">Search</button>
<?php
if (isset($_GET['q'])) {
    echo '<p><a href="./">Clear search</a></p>';
}
?>
</form>
<p><img src="/.folder.png"> = Folder</p>
<p><img src="/.file.png"> = File</p>
<br><br>
<?php
if (is_dir('$_SERVER[DOCUMENT_ROOT]../')) {
    echo '<a href="../"><img src="/.up.png"> Parent Directory</a>';
}
?>
<br>
<?php
$dirlist = preg_grep('/^([^.])/', scandir("$_SERVER[DOCUMENT_ROOT]$_SERVER[REQUEST_URI]"));
// if (isset($_GET['q'])) {
// } else {
    if (isset($_GET['q'])) {
        $q = $_GET['q'];
        $blank = true;
        foreach($dirlist as $dir) {
            if ($dir == 'index.php') {
                //Hide index.php file
            } elseif (str_contains(strtolower($dir), strtolower($q))) {
                if (is_dir($dir)) {
                    echo "<a href=\"$dir\"><img src=\"/.folder.png\"> $dir</a><br><br>";
                    $blank = false;
                } else {
                    echo "<a href=\"$dir\"><img src=\"/.file.png\"> $dir - <a href=\"$dir\" download>[Download]</a></a><br><br>";
                    $blank = true;
                }
            }
        }
        if ($blank) {
            echo '<i>No files found!</i>';
        }
    } else {
        $blank = true;
        foreach ($dirlist as $dir) {
            if ($dir == 'index.php') {
                //Hide index.php file
            } elseif (is_dir($dir)) {
                echo "<a href=\"$dir\"><img src=\"/.folder.png\"> $dir</a><br><br>";
            } else {
                echo "<a href=\"$dir\"><img src=\"/.file.png\"> $dir - <a href=\"$dir\" download>[Download]</a></a><br><br>";
            }

            if (is_dir($dir) OR file_exists($dir)) {
                $blank = false;
            }
        }
        if ($blank) {
            echo '<i>No files found!</i>';
        }
    }
// }


?>
    <p><b>&copy;2021-<?=date('Y')?>. All rights reserved.</b></p>
    <p><small>Powered by <a href="https://www.github.com/fakerybakery/goodFile" target="_blank">goodFile on GitHub</a>.</small></p>
</body>
</html>