<?php

require 'pmo_functions.php';
$conn = pdo_connect_mysql();


$stmt = $conn->prepare('SELECT * FROM project_file WHERE project_file.project_id = ?');
$stmt->execute([$_GET['project_id']]);

$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<?=template_header('Project Files')?>

<div class="container">

    <h3>Project File Details</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>File Name</th>
                    <th>File Path</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($records as $record){?>
                  
                    <tr>
                        <td><a href="<?=$record['file_path']?>"><?=$record['file_name']?></a></td>
                        <td><?=$record['file_path']?></td>
                        <td><a  href="delete_files.php?file_id=<?=$record['file_id']?>"><i class="fas fa-trash fa-xs"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h3> Upload Files </h3>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <p>Select the file you want to upload</p>
            <input type="file" name="fileToUpload[]" multiple>
            <input type="hidden" name="project_id" value="<?=$_GET['project_id']?>">
            <input type="submit" value="Upload the file" name="submit">
        </form>
</div>

<?=template_footer()?>
