<?php
$connection = mysqli_connect("localhost", "root", "", "devan_data");

if (!$connection) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = trim(htmlspecialchars($_POST['name']));
    $email   = trim(htmlspecialchars($_POST['email']));
    $message = trim(htmlspecialchars($_POST['message']));

    if (!empty($name) && !empty($email) && !empty($message)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $sql = "INSERT INTO contacts (name, email, message, created_at) VALUES (?, ?, ?, NOW())";

            if ($stmt = mysqli_prepare($connection, $sql)) {
                mysqli_stmt_bind_param($stmt, "sss", $name, $email, $message);

                if (mysqli_stmt_execute($stmt)) {
                    echo "Oke, makasih yaa!";
                } else {
                    echo "Terjadi kesalahan.";
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "Error dalam menyiapkan query.";
            }
        } else {
            echo "Email tidak valid.";
        }
    } else {
        echo "Wajib diisi semua kolom.";
    }
}

mysqli_close($connection);
?>
