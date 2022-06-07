<pre>
<?php
$dir = "../img/";
$scss_file = "../scss/_masks.scss";
$slim_file = "../slim/_masks.slim";

if(is_dir($dir)){
    $arrFiles = array();
    $handle = opendir($dir);

    if ($handle) {
        while (($entry = readdir($handle)) !== FALSE) {
            if(is_file($dir.$entry)){
                $arrFiles[] = $entry;
            }
        }
    }

    sort($arrFiles);
    closedir($handle);
}
else{
    die('Image directory <strong>'.$dir.'</strong> not found!');
}

$scss  = '$shapes:('."\n";
$slim  = "- masks =[\\\n";

foreach ($arrFiles as $file) {
    $path = pathinfo($dir.$file);
    if($path['extension'] === 'svg'){
        $scss .= "\t"."\"".$path['filename']."\": '../img/".$path['filename'].".".$path['extension']."',\n";
        $slim .= "\t[\\\n\t\t'".$path['filename']."',\\\n\t\t'".$path['filename'].".".$path['extension']."'\\\n\t],\\\n";
    }
}
$scss = substr(trim($scss), 0, -1);
$scss .= "\n);";

$slim .= "]";

if(file_put_contents($scss_file, $scss)){
    echo "SCSS file written!";
}
if(file_put_contents($slim_file, $slim)){
    echo "SLIM file written!";
}
?>
</pre>
