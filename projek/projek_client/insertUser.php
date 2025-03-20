<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Tambah User</h2>
        <form id="userForm" class="p-4 border rounded">
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Tambah</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
        <div id="responseMessage" class="mt-3"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#userForm").submit(function(e){
                e.preventDefault(); // Mencegah reload halaman

                var formData = {
                    nama: $("#nama").val(),
                    email: $("#email").val(),
                    password: $("#password").val()
                };

                $.ajax({
                    type: "POST",
                    url: "http://10.33.35.19/projek_api/projek_api.php?entity=users",
                    data: JSON.stringify(formData),
                    contentType: "application/json",
                    success: function(response){
                        $("#responseMessage").html('<div class="alert alert-success">'+response.message+'</div>');
                        setTimeout(() => { window.location.href = 'index.php'; }, 2000);
                    },
                    error: function(){
                        $("#responseMessage").html('<div class="alert alert-danger">Gagal menambahkan user.</div>');
                    }
                });
            });
        });
    </script>
</body>
</html>
