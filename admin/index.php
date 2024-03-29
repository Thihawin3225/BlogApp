<?php
require '../config/config.php';
session_start();

if(empty($_SESSION['user-id']) || empty($_SESSION['logintime'])){
  header('Location: login.php');
}



?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blog/App</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
     <ul class="navbar-nav ml-auto">
     <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline" method="post" action="index.php">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" name= "search" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
    </ul>


    <!-- Right navbar links -->
    
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">
        Blog
      </span>
    </a>
    <!-- Sidebar -->
    <?php
    $sql = "Select * from user where id=".$_SESSION['user-id'];
    $pst = $pdo->prepare($sql);
    $pst->execute();
    $result = $pst->fetchAll();

    ?>
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
            <?php echo $result[0]['name'] ?>
          </a>
        </div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Simple Link
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Starter Page</h1>
          </div>
          <br>
        </div>
      </div>
      <div>
          <a href="add.php" class="btn btn-warning">
              Create Blog
          </a>
      </div>
    </div>
    <!-- /.content-header -->
  
    <!-- Main content -->
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Bordered Table</h3>
            </div>


            <!-- /.card-header -->
            <?php
            if(!empty($_GET['pageno'])){
              $pageno =$_GET['pageno'];
            }else{
              $pageno = 1;
            }
            if(empty($_POST['search'])){
              $numofrec = 2;
              $offest = ($pageno-1)* $numofrec;
              $sql = "SELECT * From post";
              $stmt = $pdo->prepare($sql);
              $stmt->execute();
              $rawresult = $stmt->fetchall();
              $totalpage = ceil(count($rawresult)/$numofrec);
              $sql = "SELECT * From post Limit $offest,$numofrec";
              $stmt = $pdo->prepare($sql);
              $stmt->execute();
              $result = $stmt->fetchall();
            }else{
              $searchkey = $_POST['search'];
              $numofrec = 2;
              $offest = ($pageno-1)* $numofrec;
              $sql = "SELECT * From post";
              $stmt = $pdo->prepare($sql);
              $stmt->execute();
              $rawresult = $stmt->fetchall();
              $totalpage = ceil(count($rawresult)/$numofrec);
              $sql = "SELECT * From post where title Like '%$searchkey%' Limit $offest,$numofrec";
              $stmt = $pdo->prepare($sql);
              $stmt->execute();
              $result = $stmt->fetchall();
            }


          ?>
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th style="width: 10px">id</th>
                    <th>titel</th>
                    <th>description</th>
                    <th>created_at</th>
                    <th style="width: 40px">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    
                    if($result){
                       $i = 0;
                      foreach ($result as $key ) {
                        
                  ?>
                    <tr>
                      <td>
                        <?php echo  $i ?>
                      </td>
                      <td>
                        <?php echo $key['title'] ?>
                      </td>
                      <td>
                      <?php echo $key['description'] ?>
                      </td>
                      <td>
                      <?php echo date('d-m-Y',strtotime($key['created_at'])) ?>
                      </td>
                      <td class="d-flex">
                      <div class="mr-2">
                          <a href="edit.php?id=<?php echo $key['id'] ?>" type="button" class="btn btn-primary">Edit</a>
                      </div>
                      <div>
                          <a href="delete.php?id=<?php echo $key['id'] ?>" type="button" class="btn btn-secondary">Delete</a>
                      </div>
                      </td>
                    </tr>
                  <?php
                    $i++;
                      }
                    }

                  ?>
                  
                </tbody>
              </table>
              <br>
              <nav aria-label="Page navigation example" style="float:right">
              <ul class="pagination">
                <li class="page-item">
                  <a class="page-link" href="?pageno=1">First</a>
                </li>
                <li class="page-item <?php if($pageno <=1){ echo "disabled";} ?>">
                <a class="page-link" href="<?php if($pageno <=1 ) {"#";} else{echo "?pageno=".($pageno-1);}?>">Previous</a>
              </li>
                <li class="page-item">
                  <a class="page-link" href="#"><?php echo $pageno ?></a></li>
                <li class="page-item <?php if($pageno >= $totalpage){ echo "disabled";} ?>">
                  <a class="page-link" href="<?php if($pageno >= $totalpage ) {"#";} else{ echo "?pageno=".($pageno+1);}?>">Next</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="?pageno=<?php echo $totalpage ?>">Last</a>
                </li>
              </ul>
            </nav>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </div>

    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <a href="logout.php" type="button" class="btn btn-danger">
        Logout
      </a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2023-2024 <a href="#">Blog App</a>.</strong> 
      
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>
