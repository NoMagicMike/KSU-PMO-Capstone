<?php
  require 'pmo_functions.php';
  $conn = pdo_connect_mysql();

  $file_id = $_GET['file_id'];

  $stmt = $conn->prepare('SELECT * FROM project_file WHERE project_file.file_id = ?');
  $stmt->execute([$_GET['file_id']]);

  $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
  unlink($records[0]['file_path']);

  $stmt = $conn->prepare('DELETE FROM project_file WHERE project_file.file_id = ?');
  $stmt->execute([$_GET['file_id']]);

  echo "<script type='text/JavaScript'>
        window.location=document.referrer;
        alert('Record was Deleted!');
        </script>";
?>
