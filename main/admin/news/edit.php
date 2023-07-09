<?php

session_start();

include('../../../path.php');

include(ROOT_PATH . '/main/controllers/newspanel.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="GCESports" />

    <title>Edit News</title>

    <!-- custom styling -->
    <link rel="stylesheet" href="../css/panelheader.css?v=<?php echo time(); ?>" />
    <link rel="stylesheet" href="../css/newspanel.css?v=<?php echo time(); ?>" />

    <!-- goggle fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>

<body>

    <!-- header: nav-bar & sidebar -->

    <?php include(ROOT_PATH . '/main/admin/includes/header.php') ?>

    <!-- section: news-panel-form -->

    <section class="news-panel-form">
        <h1>Edit News</h1>
        <form action="edit.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <div>
                <label for="title">Title:</label><br />
                <input type="text" name="title" id="title" value="<?php echo $title; ?>" required />
            </div>
            <div>
                <label for="body">Body:</label><br />
                <textarea name="body" id="body" rows="5" style="resize: none;" required><?php echo $body; ?></textarea>
            </div>
            <div>
                <label for="image">Images:</label><br />
                <input type="file" id="image" name="image" required>
            </div>
            <div>
                <label for="date">Date:</label><br />
                <input type="date" id="date" name="date" required>
            </div>
            <div>
                <input type="submit" name="edit-news" id="submit-btn" value="UPDATE NEWS">
            </div>
        </form>
        <div>
            <a href="./index.php">MANAGE NEWS</a>
        </div>
    </section>

    <!-- font-awesome -->
    <script src="https://kit.fontawesome.com/d3be705053.js" crossorigin="anonymous"></script>

</body>

</html>