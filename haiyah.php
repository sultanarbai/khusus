<?php 

session_start();

if( !isset($_SESSION["login"]) ) {
  header("Location: login.php");
  exit;
}

require 'function.php';

//pagination
//konfigurasi
$jmldataperhalaman = 5;
$jumlahdata = count(query("SELECT * FROM mahasiswa"));
$jumlahhalaman = ceil($jumlahdata / $jmldataperhalaman);
$halamanaktif = (isset($_GET["halaman"]) ) ? $_GET["halaman"] : 1;

$awaldt = ($jmldataperhalaman * $halamanaktif ) - $jmldataperhalaman;


$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awaldt, $jmldataperhalaman  ");




// tommbol cari ditekan
if (isset($_POST["cari"])) {
  $mahasiswa = cari($_POST["keyword"]);

}

 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>sistem informasi sederhana mahasiswa</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" name="keyword" size="50" autofocus class="form-control" placeholder="Search..." autocomplete="off">
           <button type="submit" name="cari" class="btn btn-primary">cari!</button>
            
          </form>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#">Dasboard</a></li>
            <li><a href="cuaca.php">prediksi cuaca !!</a></li>
            <li><a href="#">Analytics</a></li>
            <li><a href="#">Export</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard</h1>

 <?php if($_SESSION["level"] === 'admin') : ?>
<div>
  </form>
  <span class="home"><a href="logout.php"><button>logout!</button></a></span><br> 

</div>
<div><br><a href="tambah.php"><button>add student</button></a>
<br></div>
      <!--End Navigation-->
      <div align="center">
    <h1>daftar mahasiswa bagi admin</h1>
    <?php if( $halamanaktif > 1) : ?>
      <button>
<a href="?halaman=<?php echo $halamanaktif - 1; ?>">&laquo;</a>
</button>
<?php endif; ?>



<?php for( $i = 1; $i <= $jumlahhalaman; $i++ ) : ?>
  <?php if($i == $halamanaktif ) : ?>
    <button>
  <a href="?halaman=<?php echo $i; ?>" style="font-weight: bold; color: red;"><?php echo $i; ?></a>
    </button>
  <?php else : ?>
    <button>
      <a href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a>
    </button>
  <?php endif; ?>
<?php endfor; ?>



<?php if( $halamanaktif < $jumlahhalaman) : ?>
  <button>
    <a href="?halaman=<?php echo $halamanaktif + 1; ?>">&raquo;</a>
  </button>
  
<?php endif; ?>
<hr size="1px" color="lightblue">
   </div>
  
  <div class="row">
    <?php foreach ($mahasiswa as $row) : ?>
    <div class="col-md-4">
      <div class="card">
          <img src="img/<?php echo $row["gambar"]; ?>" class="card-img-top" width="150" height="150">
          <div class="card-body">
              <h5 class="card-title">nama : <?php echo $row["nama"]; ?></h5>
              <p class="card-text">nim :<?php echo $row["nim"] ?></p>
              <h5 class="card-title">jurusan : <?php echo $row["jurusan"]; ?></h5>
              <h5 class="card-title">email : <?php echo $row["email"]; ?></h5>
              <h5 class="card-title">lastupdate : <?php echo $row["tanggal"]; ?></h5>
              <button class="btn btn-primary">
                <a href="ubah.php?id=<?php echo $row["id"];  ?> " style="color: white;">ubah</a>
              </button>||
               <button class="btn btn-primary">
                <a href="hapus.php?id=<?php echo $row["id"];  ?>" style="color: white;" onclick="return confirm('yakin ingin menghapus');">hapus</a>
               </button>
            </div>
      </div>
    </div>
  <?php endforeach; ?>

<?php elseif($_SESSION["level"] === 'dosen') : ?>
  
            <div>
              </form>
              <span class="home"><a href="logout.php"><button>logout!</button></a></span><br> 

            </div>
            <div><br><a href="tambah.php"><button>add student</button></a>
            <br></div>
                  <!--End Navigation-->
                  <div align="center">
                <h1>daftar mahasiswa bagi dosen</h1>
                <?php if( $halamanaktif > 1) : ?>
                  <button>
            <a href="?halaman=<?php echo $halamanaktif - 1; ?>">&laquo;</a>
            </button>
            <?php endif; ?>



            <?php for( $i = 1; $i <= $jumlahhalaman; $i++ ) : ?>
              <?php if($i == $halamanaktif ) : ?>
                <button>
              <a href="?halaman=<?php echo $i; ?>" style="font-weight: bold; color: red;"><?php echo $i; ?></a>
                </button>
              <?php else : ?>
                <button>
                  <a href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a>
                </button>
              <?php endif; ?>
            <?php endfor; ?>



            <?php if( $halamanaktif < $jumlahhalaman) : ?>
              <button>
                <a href="?halaman=<?php echo $halamanaktif + 1; ?>">&raquo;</a>
              </button>
              
            <?php endif; ?>
            <hr size="1px" color="lightblue">
               </div>
              
              <div class="row">
                <?php foreach ($mahasiswa as $row) : ?>
                <div class="col-md-4">
                  <div class="card">
                      <img src="img/<?php echo $row["gambar"]; ?>" class="card-img-top" width="150" height="150">
                      <div class="card-body">
                          <h5 class="card-title">nama : <?php echo $row["nama"]; ?></h5>
                          <p class="card-text">nim :<?php echo $row["nim"] ?></p>
                          <h5 class="card-title">jurusan : <?php echo $row["jurusan"]; ?></h5>
                          <h5 class="card-title">email : <?php echo $row["email"]; ?></h5>
                          <h5 class="card-title">lastupdate : <?php echo $row["tanggal"]; ?></h5>
                          <button class="btn btn-primary">
                            <a href="ubah.php?id=<?php echo $row["id"];  ?> " style="color: white;">ubah</a>
                          </button>||
                           <button class="btn btn-primary">
                            <a href="hapus.php?id=<?php echo $row["id"];  ?>" style="color: white;" onclick="return confirm('yakin ingin menghapus');">hapus</a>
                           </button>
                        </div>
                  </div>
                </div>
              <?php endforeach; ?>

<?php endif; ?>
      </div>
    </div>
  </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script
  src="http://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
    <script src="jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="../../assets/js/docs.min.js"></script>
    <script src="script1.js"></script>
  </body>
</html>
