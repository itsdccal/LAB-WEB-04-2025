<?php
require_once '../config.php';
check_login();

if ($_SESSION['role'] !== 'super_admin') {
    header("Location: ../dashboard.php?error=Akses ditolak.");
    exit();
}

if (isset($_POST['action']) && $_POST['action'] == 'create') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $pm_id = ($role == 'team_member') ? $_POST['project_manager_id'] : NULL;

    if ($role == 'team_member' && empty($pm_id)) {
        header("Location: ../dashboard.php?error=Team Member harus ditugaskan ke seorang Project Manager.");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $username, $password, $role, $pm_id);
    if ($stmt->execute()) {
        header("Location: ../dashboard.php?message=Pengguna berhasil dibuat.");
    } else {
        header("Location: ../dashboard.php?error=Gagal membuat pengguna. Mungkin username sudah ada.");
    }
    $stmt->close();
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $user_id = $_GET['id'];

    if ($user_id == $_SESSION['user_id']) {
        header("Location: ../dashboard.php?error=Anda tidak dapat menghapus akun Anda sendiri.");
        exit();
    }

    $stmt_check_role = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt_check_role->bind_param("i", $user_id);
    $stmt_check_role->execute();
    $user_to_delete = $stmt_check_role->get_result()->fetch_assoc();
    
    if ($user_to_delete && $user_to_delete['role'] == 'project_manager') {
        $stmt_check_projects = $conn->prepare("SELECT COUNT(*) as project_count FROM projects WHERE manager_id = ?");
        $stmt_check_projects->bind_param("i", $user_id);
        $stmt_check_projects->execute();
        $result = $stmt_check_projects->get_result()->fetch_assoc();
        if ($result['project_count'] > 0) {
            header("Location: ../dashboard.php?error=Tidak bisa menghapus PM ini. Hapus dulu semua proyek yang ia kelola.");
            exit();
        }
    }
    
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        header("Location: ../dashboard.php?message=Pengguna berhasil dihapus.");
    } else {
        header("Location: ../dashboard.php?error=Gagal menghapus pengguna.");
    }
    $stmt->close();
}

$conn->close();
?>