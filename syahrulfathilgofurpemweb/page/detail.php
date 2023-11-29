<?php
session_start();

if (empty($_SESSION['login'])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container">
            <a class="navbar-brand fs-6" href="main.php">
                <img src="../assets/image/logo.png" style="width: 50px; height: 40px;" class="navbar-logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../config/akun/logout_akun.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container d-flex flex-column w-100 vh-100">
        <div class="container align-self-center flex-fill d-flex align-items-center">
            <?php
            require('../config/siswa/read_spesific_siswa.php');

            if (isset($_GET['id'])) {
                $itemId = $_GET['id'];
                $itemData = getItemById($itemId);
                $nama = $itemData['nama'];
                $nim = $itemData['nim'];
                $kelas = $itemData['kelas'];
                $alamat = $itemData['alamat'];
                if ($itemData['gambar'] == null) {
                    $gambar = 'noimage.jpg';
                } else {
                    $gambar = $itemData['gambar'];
                }

                if ($itemData) {
            ?>
                    <div class="image w-50 d-flex">
                        <img src="../assets/upload/<?php echo $gambar; ?>" style="max-width: 500px; max-height: 500px;" alt="" class="gambar">
                    </div>
                    <div class="input p-5 w-50">
                        <h3>Biodata Siswa</h3>
                        <form action="../config/siswa/update_siswa.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $itemId; ?>">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama :</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM :</label>
                                <input type="number" class="form-control" id="nim" name="nim" value="<?php echo $nim; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="kelas" class="form-label">Kelas :</label>
                                <input type="text" class="form-control" id="kelas" name="kelas" value="<?php echo $kelas; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat :</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?php echo $alamat; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Photo :</label>
                                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" onchange="previewImage(this);">
                                <img id="preview" class="mt-3" style="max-width: 300px; max-height: 300px; display: none;" alt="Preview Gambar">
                            </div>

                            <button type="submit" class="btn btn-primary">Unggah</button>
                        </form>
                    </div>
            <?php }
            } ?>
        </div>
    </div>
    <?php include 'utils/footer.php' ?>

    <script>
        function previewImage(input) {
            var preview = document.getElementById('preview');
            var file = input.files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
                preview.style.display = 'none';
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>