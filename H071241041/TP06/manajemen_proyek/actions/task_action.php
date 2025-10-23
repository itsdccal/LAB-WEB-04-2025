<?php
require_once '../config.php';
check_login();

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

if (isset($_POST['action']) && $_POST['action'] == 'create') {
    if ($role !== 'project_manager') {
         header("Location: ../dashboard.php?error=Akses ditolak."); exit();
    }
    $project_id = $_POST['project_id'];
    $assigned_to = $_POST['assigned_to'];
    $nama_tugas = $_POST['nama_tugas'];
    $deskripsi = $_POST['deskripsi'];

    $stmt_verify = $conn->prepare("SELECT id FROM projects WHERE id = ? AND manager_id = ?");
    $stmt_verify->bind_param("ii", $project_id, $user_id);
    $stmt_verify->execute();
    if ($stmt_verify->get_result()->num_rows == 0) {
        header("Location: ../dashboard.php?error=Anda tidak bisa menambah tugas pada proyek milik orang lain."); exit();
    }

    $stmt = $conn->prepare("INSERT INTO tasks (project_id, assigned_to, nama_tugas, deskripsi) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $project_id, $assigned_to, $nama_tugas, $deskripsi);
    if ($stmt->execute()) {
        header("Location: ../dashboard.php?message=Tugas berhasil dibuat dan ditugaskan.");
    } else {
        header("Location: ../dashboard.php?error=Gagal membuat tugas.");
    }
    $stmt->close();
}

if (isset($_POST['action']) && $_POST['action'] == 'update_status') {
     if ($role !== 'team_member') {
         header("Location: ../dashboard.php?error=Akses ditolak."); exit();
    }
    $task_id = $_POST['task_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ? AND assigned_to = ?");
    $stmt->bind_param("sii", $status, $task_id, $user_id);
     if ($stmt->execute() && $stmt->affected_rows > 0) {
        header("Location: ../dashboard.php?message=Status tugas berhasil diperbarui.");
    } else {
        header("Location: ../dashboard.php?error=Gagal memperbarui status.");
    }
    $stmt->close();
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    if ($role !== 'project_manager') {
         header("Location: ../dashboard.php?error=Akses ditolak."); exit();
    }
    $task_id = $_GET['id'];
    
    $stmt = $conn->prepare("DELETE t FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.id = ? AND p.manager_id = ?");
    $stmt->bind_param("ii", $task_id, $user_id);
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        header("Location: ../dashboard.php?message=Tugas berhasil dihapus.");
    } else {
        header("Location: ../dashboard.php?error=Gagal menghapus tugas atau tidak diizinkan.");
    }
    $stmt->close();
}

$conn->close();
?>