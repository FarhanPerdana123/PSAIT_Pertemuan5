<?php
require_once "config.php";
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if ($entity == "users") {
            !empty($_GET["id"]) ? get_user(intval($_GET["id"])) : get_users();
        } elseif ($entity == "posts") {
            !empty($_GET["id"]) ? get_post(intval($_GET["id"])) : get_posts();
        } else {
            response(0, "Invalid Entity");
        }
        break;
    
    case 'POST':
        if ($entity == "users") {
            !empty($_GET["id"]) ? update_user(intval($_GET["id"])) : insert_user();
        } elseif ($entity == "posts") {
            !empty($_GET["id"]) ? update_post(intval($_GET["id"])) : insert_post();
        } else {
            response(0, "Invalid Entity");
        }
        break;

    case 'DELETE':
        if ($entity == "users") {
            delete_user(intval($_GET["id"]));
        } elseif ($entity == "posts") {
            delete_post(intval($_GET["id"]));
        } else {
            response(0, "Invalid Entity");
        }
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_users() {
    global $mysqli;
    $query = "SELECT * FROM users";
    $result = $mysqli->query($query);
    $data = $result->fetch_all(MYSQLI_ASSOC);
    response(1, "Get Users Successfully", $data);
}

function get_user($id) {
    global $mysqli;
    $query = "SELECT * FROM users WHERE id = $id LIMIT 1";
    $result = $mysqli->query($query);
    response(1, "Get User Successfully", $result->fetch_assoc());
}

function insert_user() {
    global $mysqli;
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data["nama"]) && isset($data["email"])) {
        $nama = $data["nama"];
        $email = $data["email"];
        $result = $mysqli->query("INSERT INTO users (nama, email) VALUES ('$nama', '$email')");
        response($result ? 1 : 0, $result ? "User Added Successfully" : "User Addition Failed");
    } else {
        response(0, "Parameter Do Not Match");
    }
}

function update_user($id) {
    global $mysqli;
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data["nama"]) && isset($data["email"])) {
        $nama = $data["nama"];
        $email = $data["email"];
        $result = $mysqli->query("UPDATE users SET nama='$nama', email='$email' WHERE id=$id");
        response($result ? 1 : 0, $result ? "User Updated Successfully" : "User Updation Failed");
    } else {
        response(0, "Parameter Do Not Match");
    }
}

function delete_user($id) {
    global $mysqli;
    $result = $mysqli->query("DELETE FROM users WHERE id=$id");
    response($result ? 1 : 0, $result ? "User Deleted Successfully" : "User Deletion Failed");
}

function get_posts() {
    global $mysqli;
    $query = "SELECT posts.id, posts.judul, posts.konten, users.nama FROM posts JOIN users ON posts.user_id = users.id";
    $result = $mysqli->query($query);
    $data = $result->fetch_all(MYSQLI_ASSOC);
    response(1, "Get Posts Successfully", $data);
}

function get_post($id) {
    global $mysqli;
    $query = "SELECT posts.id, posts.judul, posts.konten, users.nama FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = $id LIMIT 1";
    $result = $mysqli->query($query);
    response(1, "Get Post Successfully", $result->fetch_assoc());
}

function insert_post() {
    global $mysqli;
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data["user_id"]) && isset($data["judul"]) && isset($data["konten"])) {
        $user_id = $data["user_id"];
        $judul = $data["judul"];
        $konten = $data["konten"];
        $result = $mysqli->query("INSERT INTO posts (user_id, judul, konten) VALUES ('$user_id', '$judul', '$konten')");
        response($result ? 1 : 0, $result ? "Post Added Successfully" : "Post Addition Failed");
    } else {
        response(0, "Parameter Do Not Match");
    }
}

function update_post($id) {
    global $mysqli;
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data["user_id"]) && isset($data["judul"]) && isset($data["konten"])) {
        $user_id = $data["user_id"];
        $judul = $data["judul"];
        $konten = $data["konten"];
        $result = $mysqli->query("UPDATE posts SET user_id='$user_id', judul='$judul', konten='$konten' WHERE id=$id");
        response($result ? 1 : 0, $result ? "Post Updated Successfully" : "Post Updation Failed");
    } else {
        response(0, "Parameter Do Not Match");
    }
}

function delete_post($id) {
    global $mysqli;
    $result = $mysqli->query("DELETE FROM posts WHERE id=$id");
    response($result ? 1 : 0, $result ? "Post Deleted Successfully" : "Post Deletion Failed");
}

function response($status, $message, $data = null) {
    echo json_encode(["status" => $status, "message" => $message, "data" => $data]);
}
?>