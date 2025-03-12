<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Tambah Post</h2>
        <form id="postForm" class="p-4 border rounded">
            <div class="mb-3">
                <label>Judul</label>
                <input type="text" name="judul" id="judul" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Konten</label>
                <textarea name="konten" id="konten" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label>Penulis</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    <option value="">Pilih User</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Tambah</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
        <div id="responseMessage" class="mt-3"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            // Ambil daftar users dari API untuk dropdown
            $.getJSON("http://10.33.35.19/projek_api.php?entity=users", function(response) {
                if (response.status === 1) {
                    $.each(response.data, function(key, user) {
                        $("#user_id").append('<option value="'+ user.id +'">'+ user.nama +'</option>');
                    });
                }
            });

            // Submit form dengan AJAX
            $("#postForm").submit(function(e){
                e.preventDefault();

                var formData = {
                    judul: $("#judul").val(),
                    konten: $("#konten").val(),
                    user_id: $("#user_id").val()
                };

                $.ajax({
                    type: "POST",
                    url: "http://10.33.35.19/projek_api.php?entity=posts",
                    data: JSON.stringify(formData),
                    contentType: "application/json",
                    success: function(response){
                        $("#responseMessage").html('<div class="alert alert-success">'+response.message+'</div>');
                        setTimeout(() => { window.location.href = 'index.php'; }, 2000);
                    },
                    error: function(){
                        $("#responseMessage").html('<div class="alert alert-danger">Gagal menambahkan post.</div>');
                    }
                });
            });
        });
    </script>
</body>
</html>
