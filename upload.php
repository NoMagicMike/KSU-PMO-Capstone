<?php
require 'pmo_functions.php';
$conn = pdo_connect_mysql();

$target_dir = getcwd() . "var/www/KSU-PMO-Capstone/uploads/";

$file_ary = reArrayFiles($_FILES['fileToUpload']);

    foreach ($file_ary as $file) {
        $target_file = $target_dir . $file['name'];
        $uploadOk = 1;

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "<script type='text/JavaScript'>
                  window.location=document.referrer;
                  alert('Sorry, this file already exists!');
                  </script>";
            $uploadOk = 0;
        }

        // In case $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "<script type='text/JavaScript'>
                  window.location=document.referrer;
                  alert('Your file could not be uploaded!');
                  </script>";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                $stmt = $conn->prepare('INSERT INTO project_file (file_id, file_name, file_path, project_id)
                VALUES(NULL, :file_name, :file_path, :project_id)');
                $stmt->bindValue(':file_name', $file['name']);
                $stmt->bindValue(':file_path', $target_file);
                $stmt->bindValue(':project_id', $_POST['project_id']);
                $stmt->execute();
                //echo "The file ". basename( $file["name"]). " has been uploaded.";
            } else {
                    echo "<script type='text/JavaScript'>
                          window.location=document.referrer;
                          alert('Sorry there was an error with your file upload.');
                          </script>";
                    // echo $target_file;
            }
              echo "<script type='text/JavaScript'>
                    window.location=document.referrer;
                    alert('Files have been uploaded successfully.');
                    </script>";
        }
    }

function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
    }

?>
