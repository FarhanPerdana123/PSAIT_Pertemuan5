<?php
require_once "config.php"; // Menghubungkan ke file config.php

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (!empty($_GET["id_user"])) {
            get_user(intval($_GET["id_user"]));
        } elseif (!empty($_GET["id_post"])) {
            get_post(intval($_GET["id_post"]));
        } else {
            response(1, "Get Users and Posts List Successfully.", [
                "users" => get_user_list(),
                "posts" => get_post_list()
            ]);
        }
        break;

    case 'POST':
        if (!empty($_GET["id_user"])) {
            update_user(intval($_GET["id_user"]));
        } elseif (!empty($_GET["id_post"])) {
            update_post(intval($_GET["id_post"]));
        } else {
            insert_user_or_post();
        }
        break;

    case 'DELETE':
        if (!empty($_GET["id_user"])) {
            delete_user(intval($_GET["id_user"]));
        } elseif (!empty($_GET["id_post"])) {
            delete_post(intval($_GET["id_post"]));
        }
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_user_list() {
    global $mysqli;
    $query = "SELECT * FROM users";
    $result = $mysqli->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function get_user($id) {
    global $mysqli;
    $query = "SELECT * FROM users WHERE id = $id LIMIT 1";
    $result = $mysqli->query($query);
    response(1, "Get User Successfully.", $result->fetch_assoc());
}

function insert_user_or_post() {
    global $mysqli;
    $data = json_decode(file_get_contents('php://input'), true);

    if (!empty($data["nama"]) && !empty($data["email"]) && !empty($data["password"])) {
        $nama = $data["nama"];
        $email = $data["email"];
        $password = password_hash($data["password"], PASSWORD_DEFAULT);
        $result = $mysqli->query("INSERT INTO users (nama, email, password) VALUES ('$nama', '$email', '$password')");
        response($result ? 1 : 0, $result ? "User Added Successfully." : "User Addition Failed.");
    } elseif (!empty($data["user_id"]) && !empty($data["judul"]) && !empty($data["konten"])) {
        $user_id = $data["user_id"];
        $judul = $data["judul"];
        $konten = $data["konten"];
        $result = $mysqli->query("INSERT INTO posts (user_id, judul, konten) VALUES ('$user_id', '$judul', '$konten')");
        response($result ? 1 : 0, $result ? "Post Added Successfully." : "Post Addition Failed.");
    } else {
        response(0, "Invalid Input");
    }
}

function update_user($id) {
    global $mysqli;
    $data = json_decode(file_get_contents('php://input'), true);

    if (!empty($data["nama"]) && !empty($data["email"])) {
        $nama = $data["nama"];
        $email = $data["email"];
        $result = $mysqli->query("UPDATE users SET nama='$nama', email='$email' WHERE id=$id");
        response($result ? 1 : 0, $result ? "User Updated Successfully." : "User Update Failed.");
    } else {
        response(0, "Invalid Input");
    }
}

function delete_user($id) {
    global $mysqli;
    $result = $mysqli->query("DELETE FROM users WHERE id=$id");
    response($result ? 1 : 0, $result ? "User Deleted Successfully." : "User Deletion Failed.");
}

function get_post_list() {
    global $mysqli;
    $query = "SELECT posts.id, posts.judul, posts.konten, users.nama FROM posts JOIN users ON posts.user_id = users.id";
    $result = $mysqli->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function get_post($id) {
    global $mysqli;
    $query = "SELECT posts.id, posts.judul, posts.konten, users.nama FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = $id LIMIT 1";
    $result = $mysqli->query($query);
    response(1, "Get Post Successfully.", $result->fetch_assoc());
}

function update_post($id) {
    global $mysqli;
    $data = json_decode(file_get_contents('php://input'), true);

    if (!empty($data["user_id"]) && !empty($data["judul"]) && !empty($data["konten"])) {
        $user_id = $data["user_id"];
        $judul = $data["judul"];
        $konten = $data["konten"];
        $result = $mysqli->query("UPDATE posts SET user_id='$user_id', judul='$judul', konten='$konten' WHERE id=$id");
        response($result ? 1 : 0, $result ? "Post Updated Successfully." : "Post Update Failed.");
    } else {
        response(0, "Invalid Input");
    }
}

function delete_post($id) {
    global $mysqli;
    $result = $mysqli->query("DELETE FROM posts WHERE id=$id");
    response($result ? 1 : 0, $result ? "Post Deleted Successfully." : "Post Deletion Failed.");
}

function response($status, $message, $data = null) {
    echo json_encode(["status" => $status, "message" => $message, "data" => $data]);
}
?>
