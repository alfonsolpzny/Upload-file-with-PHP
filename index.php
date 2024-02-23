<?php
//References: https://oregoom.com/php/files/


//if you have more of 1 input diferent of type file to can use if(!empty($_POST)){}

if (isset($_FILES['archivos'])) { //&& $_FILES['archivos']['error'] == 0
    
    //if this does not work change these valuaes in your php.ini

    // Establecer el tamaño máximo de archivo a 2 MB
    ini_set('upload_max_filesize', '20M');
    // Establecer el tamaño máximo de datos POST a 8 MB
    ini_set('post_max_size', '20M');
    // Establecer el tiempo máximo de ejecución a 5 minutos
    ini_set('max_execution_time', 300);

    $nombre = $_FILES['archivos']['name'];
    $tipo = $_FILES['archivos']['type'];
    $tamano = $_FILES['archivos']['size'];
    $temporal = $_FILES['archivos']['tmp_name'];
    $error = $_FILES['archivos']['error'];

    echo "nombre: " . $nombre . "<br>";
    echo "tipo: " . $tipo . "<br>";
    echo "tamaño: " . $tamano . "<br>";
    echo "temporal: " . $temporal . "<br>";
    echo "error: " . $error . "<br>";

    //directory what you what to upload files
    $target_dir = "files/";
    $target_file = $target_dir . basename($_FILES["archivos"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    echo $target_file . "<br>";
    echo $imageFileType . "<br>";

    //Step 1: Check if file exist
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
        // echo '<script type="text/javascript">
        //             alert("Sorry, file already exists.");
        //             window.history.go(-1);
        //         </script>';
    }

    //Step 2: Check file size
    $maxSize = 2 * 1024 * 1024; //2mb
    if ($_FILES["archivos"]["size"] > $maxSize) {
        echo "Sorry, your file is too large." . "<br>";
        $uploadOk = 0;
    }

    //step 2: Chek file type
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!(in_array($_FILES['archivos']['type'], $allowedTypes))) {
        echo "Sorry, your file is not requeried type." . "<br>";
        $uploadOk = 0;
    }

    $allowedTypes2 = ['jpeg', 'png', 'jpg'];
    if (!(in_array($imageFileType, $allowedTypes2))) {
        echo "Sorry, your file is not requeried type. by method 2" . "<br>";
        $uploadOk = 0;
    }

    if (move_uploaded_file($_FILES["archivos"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["archivos"]["name"])) . " has been uploaded." . "<br>";
    } else {
        echo "Sorry, there was an error uploading your file." . "<br>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BOOTSTRAP 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Upload file</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <div class="row">
            <h1>Upload files in PHP</h1>
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
                <div class="col">
                    <label for="formFileLg" class="form-label">Click to select a file</label>
                    <input type="file" class="form-control form-control-lg" name="archivos" id="archivos">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-success">Upload</button>
                </div>
            </form>
        </div>
        <div class="row">
            <?php
            $documentos = glob('files/*.{pdf,docx,jpg,jpeg,png}', GLOB_BRACE);

            echo "<ul>";
            foreach ($documentos as $documento) {
                $nombreDocumento = basename($documento);
                echo '<li><a href="' . $documento . '">' . $nombreDocumento . '</a></li>';
            }
            echo "</ul>";
            ?>
        </div>
    </div>
</body>
<!-- BOOTSTRAP 5`JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Scrip for live search -->


</html>