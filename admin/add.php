<?php
 require '../config/config.php';
session_start();
 if($_POST){
   $tilte = $_POST['title'];
   $desc =  $_POST['desc'];
   $created_at =  $_POST['created_at'];
   $imageName = 'images/'.$_FILES['file']['name'];
   $imagePath = pathinfo($imageName,PATHINFO_EXTENSION);
    if($imagePath == 'jpg' || $imagePath == 'png'){
        move_uploaded_file($_FILES['file']['tmp_name'],$imageName);
        $sql = "INSERT INTO post(title,description,image,created_at,author_id) values(:title,:description,:image,:created_at,:author_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(
            array(
                ':title'=>$tilte,
                ':description'=>$desc,
                ':image'=> $imageName,
                ':created_at'=>$created_at,
                ':author_id'=>$_SESSION['user-id']
            )
        );
    }else{
        echo "<script>
         alert('image must be jpg or png');
       </script>";
    }

    }
   

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
      <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

</head>
<style>
    .container{
          margin-top: 30px;
          width: 400px;
          padding : 20px;
    }
    form div{
        margin : 10px;
    }
</style>
<body>

<div class="container">
<form action="" method="post" enctype="multipart/form-data" class="border p-4 rounded bg-light">
  <h2 class="text-center mb-4">Create Your Blog</h2><br>

  <div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Your Title" required>
  </div>

  <div class="mb-3">
    <label for="desc" class="form-label">Description</label>
    <textarea class="form-control" id="desc" name="desc" placeholder="Enter Your Description" required></textarea>
  </div>

  <div class="mb-3">
    <label for="file" class="form-label">File</label>
    <input type="file" class="form-control" id="file" name="file" accept=".jpg, .jpeg, .png, .gif" required>
  </div>
  <div class="mb-3">
    <label for="created_at" class="form-label">Date</label>
    <input type="date" id="created_at" name="created_at" class="form-control" required>
  </div>

  <div class="mb-3">
    <button type="submit" class="btn btn-primary btn-block">Add</button>
  </div>

  <div class="mb-3 text-center">
    <a href="index.php" class="btn btn-danger btn-block">Back</a>
  </div>
</form>


  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>
