<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Users & Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        div.scroll {
            width: 100%;
            height: 400px;
            overflow: scroll;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Daftar Users</h2>
        <div class="scroll">
        <?php
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, 'http://10.33.35.19/projek_api/projek_api.php?entity=users'); // Ganti dengan IP VPS Anda
        $res = curl_exec($curl);
        $users = json_decode($res, true);

        echo '<table class="table table-bordered">';
            echo "<thead class='table-dark'>";
                echo "<tr>";
                    echo "<th>ID</th>";
                    echo "<th>Nama</th>";
                    echo "<th>Email</th>";
                echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($users["data"] as $user) {
                echo "<tr>";
                    echo "<td>{$user['id']}</td>";
                    echo "<td>{$user['nama']}</td>";
                    echo "<td>{$user['email']}</td>";
                echo "</tr>";
            }
            echo "</tbody>";                            
        echo "</table>";
        curl_close($curl);
        ?>
        </div>

        <hr>

        <h2 class="text-center mt-4">Daftar Posts</h2>
        <div class="scroll">
        <?php
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, 'http://10.33.35.19/projek_api/projek_api.php?entity=posts'); // Ganti dengan IP VPS Anda
        $res = curl_exec($curl);
        $posts = json_decode($res, true);

        echo '<table class="table table-bordered">';
            echo "<thead class='table-dark'>";
                echo "<tr>";
                    echo "<th>ID</th>";
                    echo "<th>Judul</th>";
                    echo "<th>Konten</th>";
                    echo "<th>Penulis</th>";
                echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($posts["data"] as $post) {
                echo "<tr>";
                    echo "<td>{$post['id']}</td>";
                    echo "<td>{$post['judul']}</td>";
                    echo "<td>".substr($post['konten'], 0, 50)."...</td>";
                    echo "<td>{$post['nama']}</td>";
                echo "</tr>";
            }
            echo "</tbody>";                            
        echo "</table>";
        curl_close($curl);
        ?>
        </div>
    </div>
</body>
</html>
