<?php ob_start();
require_once "../../config/config.php";
require_once "../../build/inc/kwikfun.php";
require_once "../../build/inc/buildfun.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
    
    $path = "../../assets/uploads/"; //set your folder path
    $vid = $_POST['vid']; 
    $name = $_FILES['myfile']['name']; //get the name of the file
    $size = $_FILES['myfile']['size']; //get the size of the file
    

    if (strlen($name)) { 
    // if ($size < 2098888) { // check if the file size is more than 2 mb
        
        $tmp = $_FILES['myfile']['tmp_name']; 
        
        $file_to_move = time().'-'.$name; // With ext
        
        // find Name without ext.
        $filename_noext = pathinfo($_FILES['myfile']['name'], PATHINFO_FILENAME); 
        $filename_db = time().'-'.$filename_noext; // With ext
 
        // ENCODE HERE........
        
        
        // ...
        
        if (move_uploaded_file($tmp, $path . $file_to_move)) { //check if it the file move successfully.
            echo "File uploaded successfully!!";
        } else {
            echo "failed";
        }
    // } else {
       // echo "File size max 2 MB";
    // }
    } else {
        echo "Please select a file..!";
    }

    $q="UPDATE videos SET
            video_file='".$filename_db."',
            type='1'
            WHERE id='".$vid."'
    ";	
    $r=$db->rq($q);
    exit; 
    }
?>