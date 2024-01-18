<?php
    require '../config/config.php';
    if($_POST){
      $tilte = $_POST['title'];
      $desc =  $_POST['desc'];
      $created_at =  $_POST['created_at'];

       if($_FILES){
        $imageName = 'images/'.$_FILES['file']['name'];
        $imagePath = pathinfo($imageName,PATHINFO_EXTENSION);
        if($imagePath == 'jpg' || $imagePath == 'png'){
          move_uploaded_file($_FILES['file']['tmp_name'],$imageName);
          $sql = "update post set title ='$tilte',description='$desc',image='$imageName',updated_at='$created_at' WHERE id=".$_GET['id'];
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
      }else{
        echo "<script>
        alert('image must be png and jpg');
      </script>";
      }
       }else{
        echo "<script>
        alert('Erro');
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
    img{
        width: 200px;
        height: 100px;
    }
    form div{
        margin : 10px;
    }
</style>
<body>
<?php
    $sql = "SELECT * FROM post where id=".$_GET['id'];
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetchall();
?>
<div class="container">
<form action="" method="post" enctype="multipart/form-data" class="border p-4 rounded bg-light">
  <h2 class="text-center mb-4">Edit Your Blog</h2><br>

  <div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" class="form-control" value="<?php echo $row[0]['title']?>" name="title" placeholder="Enter Your Title" required>
  </div>

  <div class="mb-3">
    <label for="desc" class="form-label">Description</label>
    <textarea class="form-control" name="desc" placeholder="Enter Your Description" required>
    <?php echo $row[0]['description']?>
    </textarea>
  </div>

  <div class="mb-3">
  <img src="<?php echo $row[0]['image']?>" alt="" >
    <label for="file" class="form-label">File</label>
    
    <input type="file" class="form-control" name="file" accept=".jpg, .jpeg, .png, .gif" >
  </div>

  <div class="mb-3">
    <label for="created_at" class="form-label">Date</label>
    <input type="date" value="<?php echo date('Y-m-d',strtotime($row[0]['created_at'])); ?>"" name="created_at" class="form-control" required>
  </div>

  <div class="mb-3">
    <button type="submit" class="btn btn-primary btn-block">Update</button>
  </div>

  <div class="mb-3 text-center">
    <a href="index.php" class="btn btn-danger btn-block">Back</a>
  </div>
</form>


  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>