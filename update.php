<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the student id exists, for example update.php?id=1 will get the student with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
        $nim = isset($_POST['nim']) ? $_POST['nim'] : '';
        $jurusan = isset($_POST['jurusan']) ? $_POST['jurusan'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $tahun_masuk = isset($_POST['tahun_masuk']) ? $_POST['tahun_masuk'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE mahasiswa SET id = ?, nama = ?, nim = ?, jurusan = ?, email = ?, tahun_masuk = ? WHERE id = ?');
        $stmt->execute([$id, $nama, $nim, $jurusan, $email, $tahun_masuk, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the student from the students table
    $stmt = $pdo->prepare('SELECT * FROM mahasiswa WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$student) {
        exit('Student doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>



<?=template_header('Read')?>

<div class="content update">
	<h2>Update Student Data #<?=$student['id']?></h2>
    <form action="update.php?id=<?=$student['id']?>" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" value="<?=$student['id']?>" id="id">
        <label for="nama">Nama</label>        
        <input type="text" name="nama" value="<?=$student['nama']?>" id="nama">
        <label for="nim">NIM</label>
        <input type="text" name="nim" value="<?=$student['nim']?>" id="nim">
        <label for="jurusan">Jurusan</label>        
        <input type="text" name="jurusan" value="<?=$student['jurusan']?>" id="jurusan">
        <label for="email">E-mail</label>
        <input type="text" name="email" value="<?=$student['email']?>" id="email">
        <label for="tahun_masuk">Tahun masuk</label>
        <input type="text" name="tahun_masuk" value="<?=$student['tahun_masuk']?>" id="tahun_masuk">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>