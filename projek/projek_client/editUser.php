<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Edit User</h2>
        <form id="userForm" class="p-4 border rounded">
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
        <div id="responseMessage" class="mt-3"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            var userId = new URLSearchParams(window.location.search).get('id');

            // Ambil data user dari API
            $.getJSON("http://10.33.35.19/projek_api.php?entity=users&id=" + userId, function(response) {
                if (response.status === 1) {
                    var user = response.data;
                    $("#nama").val(user.nama);
                    $("#email").val(user.email);
                } else {
                    $("#responseMessage").html('<div class="alert alert-danger">User tidak ditemukan.</div>');
                }
            });

            // Submit form dengan AJAX
            $("#userForm").submit(function(e){
                e.preventDefault();

                var formData = {
                    id: userId,
                    nama: $("#nama").val(),
                    email: $("#email").val()
                };

                $.ajax({
                    type: "PUT",
                    url: "http://10.33.35.19/projek_api.php?entity=users",
                    data: JSON.stringify(formData),
                    contentType: "application/json",
                    success: function(response){
                        $("#responseMessage").html('<div class="alert alert-success">'+response.message+'</div>');
                        setTimeout(() => { window.location.href = 'index.php'; }, 2000);
                    },
                    error: function(){
                        $("#responseMessage").html('<div class="alert alert-danger">Gagal mengupdate user.</div>');
                    }
                });
            });
        });
    </script>
</body>
</html>