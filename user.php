<?php
    require 'config/config.php';
    $sql = "SELECT * From post";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchall();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Three Cards Example</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <?php 
        foreach ($result as  $value) {
    ?>
      <div class="row">
    <div class="col-md-4">
      <div class="card card-widget">
        <div class="card-header">
            <?php
                echo $value['title'];
            ?>
        </div>
        <div class="card-body">
          <a href="userdetails.php?id=<?php echo $value['id'] ?>">
          <img class="img-fluid pad" src="admin/<?php echo $value['image'] ?>" alt="Photo">
          </a>
        </div>
      </div>
    </div>
  </div>
  <?php
        }
  ?>
</div>

<!-- Bootstrap JS and Popper.js (required for Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

