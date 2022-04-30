<?php

    session_start();
    require_once "config/db.php";

    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        $deletestmt = $conn->query("DELETE FROM users WHERE id = $delete_id");

        if ($deletestmt) {
            echo "<script>alert('Data has been deleted successfully');</script>";
            $_SESSION['success'] = "Data has been deleted successfully";
            header("refresh:1; url=index.php");
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD PDO & Bootstrap 5</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

    <div class="modal fade" id="usermodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="insert.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="firstname" class="col-form-label">First Name:</label>
                <input type="text" required class="form-control" name="firstname">
            </div>
            <div class="mb-3">
                <label for="lastname" class="col-form-label">last Name:</label>
                <input type="text" required class="form-control" name="lastname">
            </div>
            <div class="mb-3">
                <label for="position" class="col-form-label">position:</label>
                <input type="text" required class="form-control" name="position">
            </div>
            <div class="mb-3">
                <label for="img" class="col-form-label">img:</label>
                <input type="file" required class="form-control" id="imgInput" name="img">
                <img width="100%" id="previewImg" alt="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-success">submit</button>
            </div>
            </form>
        </div>
        
        </div>
    </div>
    </div>
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h1>CRUD Bootstrap 5</h1>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#usermodal">Add User</button>
            </div>
        </div>
        <hr>
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success">
                <?php 
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php } ?>
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger">
                <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php } ?>
        <!--Users data-->
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Number</th>
                <th scope="col">Firstname</th>
                <th scope="col">Lastname</th>
                <th scope="col">Position</th>
                <th scope="col">Img</th>
                <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $stmt = $conn->query("SELECT * FROM users");
                    $stmt->execute();
                    $users = $stmt->fetchall();

                    if (!$users) {
                        echo "<p><td colspan='6' class='text-center'>No users found</td></p>";
                    } else {
                    foreach ($users as $user) {
                            
                      
                ?>
                <tr>
                    <th scope="row"><?= $user['id']; ?></th>
                    <td><?= $user['firstname']; ?></td>
                    <td><?= $user['lastname']; ?></td>
                    <td><?= $user['position']; ?></td>
                    <td width="250px"><img width="100%" src="uploads/<?= $user ['img']; ?>" calss="rounded" alt=""></td>
                    <td>
                        <a href="edit.php?id=<?= $user['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="?delete=<?= $user['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                    </td>
                </tr>
                <?php   }
                    } ?>
                <tr>
            </tbody>
            </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file);
            }
        }
    </script>
</body>
</html>