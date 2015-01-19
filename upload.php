<?php //http://www.w3schools.com/php/php_file_upload.asp //They don't want you to copy
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$FileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
 //TODO
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($FileType != "c" && $FileType != "bak") {
    echo "Sorry, only .c and .bak files are allowed.\n";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "<p>Sorry, your file was not uploaded.</p>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

exec("gcc uploads/simple.c");
//exec("a.exe");
echo "<h2> Did it work? </h2>";
echo exec("whoami");
//Error Checking
echo "<h2> Errors </h2>";
$lines = file($target_file); 
$numLines = count($lines);
if($numLines > 130){
echo "<p>There are <strong>$numLines </strong>lines. Limit is 130</p>";
}
foreach($lines as $line){
if(strlen($line) > 90){
	echo "<p>".$line." <strong>line too long maxlength = 90</strong></p>";
	}
} 
?>