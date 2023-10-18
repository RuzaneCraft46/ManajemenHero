<?php 
include '../config.php';

if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $subjudul = $_POST['subjudul'];
    $status = $_POST['status'];
    $namagambar = $_FILES['gambar']['name'];
    $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg');
    $x = explode('.', $namagambar);
    
    if (count($x) > 1) {
        $ekstensi = strtolower(end($x));
        $ukuran = $_FILES['gambar']['size'];

        if (in_array($ekstensi, $ekstensi_diperbolehkan) && $ukuran < 1044070) {
            $file_tmp = $_FILES['gambar']['tmp_name'];
            move_uploaded_file($file_tmp, '../assets/img/' . $namagambar);
            $koneksi->query("INSERT INTO hero (gambar, judul, subjudul, status) VALUES ('$namagambar','$judul','$subjudul','$status')");
            header("location:index.php");
        } else {
            $_SESSION['gagalposting'] = "Maaf, postingan tidak berhasil disimpan karena format tidak sesuai atau ukuran terlalu besar.";
            header("location:index.php?gagal");
        }
    } else {
        $_SESSION['gagalposting'] = "Maaf, postingan tidak berhasil disimpan karena nama file tidak memiliki ekstensi.";
        header("location:index.php?gagal");
    }
}

if (isset($_GET['delete'])) {
    $idHero = $_GET['delete'];
    $koneksi->query("DELETE FROM hero WHERE idHero = '$idHero'");
    header("location:index.php");
}

if (isset($_POST['editposting'])) {
    $idHero = $_POST['idHero'];
    $judul = $_POST['judul'];
    $subjudul = $_POST['subjudul'];
    $status = $_POST['status'];
    $namagambar = $_FILES['gambar']['name'];
    
    if (!empty($namagambar)) {
        $file_tmp = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($file_tmp, '../assets/img/' . $namagambar);
        $koneksi->query("UPDATE hero SET judul='$judul',subjudul='$subjudul', gambar='$namagambar', status='$status' WHERE idHero='$idHero'");
    } else {
        $koneksi->query("UPDATE hero SET judul='$judul',subjudul='$subjudul', status='$status' WHERE idHero='$idHero'");
    }

    header("location:index.php");
}
?>
