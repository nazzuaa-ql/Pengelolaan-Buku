<?php
    $host       ="localhost";
    $user       ="root";
    $pass       ="";
    $db         ="sistem_buku";

    $koneksi    = mysqli_connect($host,$user,$pass,$db);
    if(!$koneksi){
        die("Tidak Bisa Konek");
    }
    $judul          ="";
    $pengarang      ="";
    $tahunter       ="";
    $sukses         ="";
    $error          ="";
    

        if(isset($_GET['op'])){
            $op = $_GET['op'];
        }else{
            $op ="";
        }

        if($op == 'delete' && isset($_GET['ID'])){
            $id     =$_GET['ID'];
            $sql1   ="delete from tbl_kelolabuku where ID = '$id'";
            $q1     = mysqli_query($koneksi,$sql1);
            if($q1){
                $sukses ="Berhasil Hapus";
                header("Location: index.php");
            }else{
                $error ="Tidak Berhasil";
            }
        }

        if($op == 'edit' && isset($_GET['ID'])){
            $id = $_GET['ID'];
            $sql1       = "select * from tbl_kelolabuku where ID = $id";
            $q1     = mysqli_query($koneksi,$sql1);
            $r1         = mysqli_fetch_array($q1);
            $judul      = $r1['Judul'];
            $pengarang  = $r1['Pengarang'];
            $tahunter   = $r1['Tahun'];

            if($judul==' '){
                $error = "Tidak Ada";
            }
        }

    if(isset($_POST['tambah'])){ //untuk create
        $judul      =$_POST['Judul'];
        $pengarang  =$_POST['Pengarang'];
        $tahunter   =$_POST['Tahun'];

        if($judul && $pengarang && $tahunter){

            if($op== 'edit'){ //untuk update
                $sql1 = "update tbl_kelolabuku set Judul='$judul', Pengarang='$pengarang', Tahun='$tahunter' where ID='$id'";
                $q1 = mysqli_query($koneksi, $sql1);
            if($q1){
                $sukses = "Berhasil Update";
            }else{
                $error = "Tidak Update";
            }
            }else{ //untuk insert
                $sql1   ="insert into tbl_kelolabuku(Judul, Pengarang, Tahun) values ('$judul', '$pengarang', '$tahunter')";
            $q1     = mysqli_query($koneksi,$sql1);

            if($q1){
                $sukses     ="Berhasil";
            }else{
                $error      ="Tidak Berhasil";
            }
            }
            
        }else{
            $error ="Silahkan Lengkapi";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Kalnia:wght@400;500&family=Mulish:ital@1&family=PT+Serif&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Vollkorn&display=swap" rel="stylesheet">
    
    <style>
        .mx-auto{width: 800px;}
        .card{ margin-top: 50px;}
        .card-header{color: #fff;}
        body{ background: url(book.jpeg);}
        .card-header{background-color: #D04848;}
        body h1{
            color: #fff;
            text-align: center;
            font-family: "Poppins", sans-serif;
            padding-top: 50px;
            font-size: 50px;
            font-weight: 700;
            -webkit-text-stroke-width: 1px;
            -webkit-text-stroke-color: #D04848;
        }
        .col-12 input{background-color:  #D04848;}
        
    
       
        
    </style>
</head>
<body>
    <h1>Pengelolaan Buku</h1>
    
    <div class="mx-auto">
        <!-- untuk memasukan data -->
        <div class="card"> 
            <div class="card-header">
                Tambah Buku
            </div>
            <div class="card-body">
                <?php
                if($error){
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error?>
                    </div>
                <?php
                }
                ?>
                <?php
                if($sukses){
                    ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses?>
                    </div>
                <?php
                    header("refresh:0;url=index.php");
                    }
                ?>
               <form action="" method="POST">
                    <div class="mb-3 row">
                            <label for="Judul" class="col-sm-2 col-form-label">Judul</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="Judul" name="Judul" value="<?php echo $judul?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                            <label for="Pengarang" class="col-sm-2 col-form-label">Pengarang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="Pengarang" name="Pengarang" value="<?php echo $pengarang?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                            <label for="Tahun" class="col-sm-2 col-form-label">Tahun</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="Tahun" name="Tahun" value="<?php echo $tahunter?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="tambah" value="Tambah Buku" class="btn btn-primary">
                    </div>
               </form>
            </div>
        </div>
        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header">
                Data Buku
            </div>
            <div class="card-body">
               <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Pengarang</th>
                        <th scope="col">Tahun</th>
                        <th scope="col">Aksi</th>
                    </tr>
                    <tbody>
                        <?php
                            $sql2  = "select * from tbl_kelolabuku order by id desc";
                            $q2    = mysqli_query($koneksi,$sql2);
                            $urut  = 1;
                            while ($r2 = mysqli_fetch_array($q2)) {
                                $id     = $r2['ID'];
                                $judul     = $r2['Judul'];
                                $pengarang     = $r2['Pengarang'];
                                $tahun     = $r2['Tahun'];

                                ?>
                                <tr>
                                    <th scope="row"><?php echo $urut++ ?></th>
                                    <th scope="row"><?php echo $judul ?></th>
                                    <th scope="row"><?php echo $pengarang ?></th>
                                    <th scope="row"><?php echo $tahun ?></th>
                                    <td scope="row">
                                        <a href="index.php?op=edit&ID=<?php echo $id?>"><button button type="button" class="btn btn-warning">Edit</button></a>
                                        <a href="index.php?op=delete&ID=<?php echo $id?>" onclick="return confirm('Yakin Delete?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                                
                                    </td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </thead>
               </table>
            </div>
        </div>
    </div>

</body>
</html>