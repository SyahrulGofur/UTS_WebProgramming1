<?php
session_start();

if (empty($_SESSION['login'])) {
    header("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Menu</title>
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
        <div class="container align-self-center flex-fill d-flex align-items-center vh-100">
            <div class="scrollable w-50 h-100 p-3 overflow-y-auto overflow-x-hidden d-flex flex-column align-items-center" id="itemContainer">
            </div>
            <div class="input p-5 w-50 h-100">
                <h3>Upload Biodata Siswa</h3>
                <form action="../config/siswa/create_siswa.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama :</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM :</label>
                        <input type="number" class="form-control" id="nim" name="nim" required>
                    </div>
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas :</label>
                        <input type="text" class="form-control" id="kelas" name="kelas" required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat :</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Photo :</label>
                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" onchange="previewImage(this);">
                        <img id="preview" class="mt-3" style="max-width: 300px; max-height: 300px; display: none;" alt="Preview Gambar">
                    </div>

                    <button type="submit" class="btn btn-primary">Unggah</button>
                </form>
            </div>
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

    <script>
        fetch('../config/siswa/read_siswa.php')
            .then(response => response.json())
            .then(data => {
                const itemContainer = document.getElementById('itemContainer');
                data.forEach(item => {

                    console.log(JSON.stringify(item));
                    const card = createCard(item);
                    itemContainer.appendChild(card);
                });
            })
            .catch(error => console.error('Error:', error));

        function createCard(item) {
            const card = document.createElement('div');
            card.className = 'card mb-3 w-100';
            card.style = 'max-width: 540px;';

            const cardRow = document.createElement('div');
            cardRow.className = 'row g-0';

            const imgCol = document.createElement('div');
            imgCol.className = 'col-md-4';

            const img = document.createElement('img');
            if (item.gambar == null) {
                img.src = `../assets/image/noimage.jpg`;

            } else {
                img.src = `../assets/upload/${item.gambar}`;
            }
            img.className = 'img-fluid rounded-start h-100';
            img.alt = '...';

            imgCol.appendChild(img);

            const textCol = document.createElement('div');
            textCol.className = 'col-md-8';

            const cardBody = document.createElement('div');
            cardBody.className = 'card-body';

            const title = document.createElement('h5');
            title.className = 'card-title';
            title.textContent = item.nama;

            const nim = document.createElement('p');
            nim.className = 'card-text';
            nim.textContent = item.nim;

            const kelas = document.createElement('p');
            kelas.className = 'card-text';
            kelas.textContent = item.kelas;

            const alamat = document.createElement('p');
            alamat.className = 'card-text';
            alamat.textContent = item.alamat;

            const detailButton = document.createElement('a');
            detailButton.href = 'detail.php?id=' + item.id;
            detailButton.className = 'btn btn-primary me-2';
            detailButton.textContent = 'Detail';

            const deleteButton = document.createElement('a');
            deleteButton.href = '#';
            deleteButton.className = 'btn btn-danger';
            deleteButton.textContent = 'Hapus';
            deleteButton.setAttribute('onclick', `deleteItem(${item.id})`);

            cardBody.appendChild(title);
            cardBody.appendChild(nim);
            cardBody.appendChild(kelas);
            cardBody.appendChild(alamat);
            cardBody.appendChild(detailButton);
            cardBody.appendChild(deleteButton);

            textCol.appendChild(cardBody);

            cardRow.appendChild(imgCol);
            cardRow.appendChild(textCol);

            card.appendChild(cardRow);

            return card;
        }


        function deleteItem(itemId) {
            if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                fetch('../config/siswa/delete_siswa.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            id: itemId,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = data.redirect || 'main.php';
                        } else {
                            alert('Gagal menghapus item.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }


        function fetchAndRenderData() {
            fetch('config/item/data_item.php')
                .then(response => response.json())
                .then(data => {
                    const itemContainer = document.getElementById('itemContainer');
                    itemContainer.innerHTML = '';
                    data.forEach(item => {
                        const card = createCard(item);
                        itemContainer.appendChild(card);
                    });
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>