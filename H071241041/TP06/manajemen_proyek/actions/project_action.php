<?php
require_once '../config.php';
check_login();

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

if (isset($_POST['action']) && $_POST['action'] == 'create') {
    if ($role !== 'project_manager') {
        header("Location: ../dashboard.php?error=Akses ditolak."); exit();
    }
    
    $nama_proyek = $_POST['nama_proyek'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    
    $stmt = $conn->prepare("INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $user_id);
    
    if ($stmt->execute()) {
        header("Location: ../dashboard.php?message=Proyek berhasil dibuat.");
    } else {
        header("Location: ../dashboard.php?error=Gagal membuat proyek.");
    }
    $stmt->close();
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $project_id = $_GET['id'];
    
    if ($role == 'super_admin') {
        $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->bind_param("i", $project_id);
    } elseif ($role == 'project_manager') {
        $stmt = $conn->prepare("DELETE FROM projects WHERE id = ? AND manager_id = ?");
        $stmt->bind_param("ii", $project_id, $user_id);
    } else {
        header("Location: ../dashboard.php?error=Akses ditolak."); exit();
    }

    if ($stmt->execute()) {
         if ($stmt->affected_rows > 0) {
            header("Location: ../dashboard.php?message=Proyek berhasil dihapus.");
         } else {
             header("Location: ../dashboard.php?error=Gagal menghapus proyek atau tidak diizinkan.");
         }
    } else {
        header("Location: ../dashboard.php?error=Terjadi kesalahan saat menghapus proyek.");
    }
    $stmt->close();
}

$conn->close();
?>