<?php
require_once 'config.php';
check_login(); 

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Manajemen Proyek</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="main-header">
        <h1>Sistem Manajemen Proyek</h1>
        <nav>
            <span>Selamat datang, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!</span>
            <a href="actions/logout.php" class="btn btn-logout">Logout</a>
        </nav>
    </header>

    <main class="container">
        <?php
        if (isset($_GET['message'])) {
            echo '<p class="message success">' . htmlspecialchars($_GET['message']) . '</p>';
        }
        if (isset($_GET['error'])) {
            echo '<p class="message error">' . htmlspecialchars($_GET['error']) . '</p>';
        }
        ?>

        <?php if ($role == 'super_admin'): ?>
        <?php
            $pms = $conn->query("SELECT id, username FROM users WHERE role = 'project_manager'");
            $users = $conn->query("SELECT u.*, pm.username as manager_name FROM users u LEFT JOIN users pm ON u.project_manager_id = pm.id ORDER BY u.role, u.username");
            $projects = $conn->query("SELECT p.*, u.username as manager_name FROM projects p JOIN users u ON p.manager_id = u.id ORDER BY p.id DESC");
        ?>
        <div class="dashboard-section">
            <h2>Manajemen Pengguna</h2>
            <div class="card">
                <h3>Tambah Pengguna Baru</h3>
                <form action="actions/user_action.php" method="POST" id="addUserForm">
                    <input type="hidden" name="action" value="create">
                    <div class="form-row">
                        <div class="input-group"><label>Username</label><input type="text" name="username" required></div>
                        <div class="input-group"><label>Password</label><input type="text" name="password" value="123456" required></div>
                    </div>
                    <div class="form-row">
                        <div class="input-group">
                            <label>Role</label>
                            <select name="role" id="roleSelect" required>
                                <option value="project_manager">Project Manager</option>
                                <option value="team_member">Team Member</option>
                            </select>
                        </div>
                        <div class="input-group" id="pmSelector" style="display:none;">
                            <label>Atasan (Project Manager)</label>
                            <select name="project_manager_id">
                                <option value="">Pilih PM...</option>
                                <?php while($pm = $pms->fetch_assoc()): ?>
                                    <option value="<?php echo $pm['id']; ?>"><?php echo htmlspecialchars($pm['username']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn">Tambah Pengguna</button>
                </form>
            </div>

            <h3>Semua Pengguna</h3>
            <table>
                <thead><tr><th>ID</th><th>Username</th><th>Role</th><th>Atasan</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php while($user = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo str_replace('_', ' ', $user['role']); ?></td>
                        <td><?php echo htmlspecialchars($user['manager_name'] ?? 'N/A'); ?></td>
                        <td>
                            <?php if ($user['id'] != $user_id): // Super Admin tidak bisa hapus diri sendiri (Notes no 4) ?>
                            <a href="actions/user_action.php?action=delete&id=<?php echo $user['id']; ?>" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus pengguna ini?');">Hapus</a>
                            <?php else: echo 'Tidak ada aksi'; endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="dashboard-section">
            <h2>Semua Proyek</h2>
            <table>
                <thead><tr><th>Nama Proyek</th><th>Project Manager</th><th>Tanggal Mulai</th><th>Tanggal Selesai</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php while($project = $projects->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($project['nama_proyek']); ?></td>
                        <td><?php echo htmlspecialchars($project['manager_name']); ?></td>
                        <td><?php echo $project['tanggal_mulai']; ?></td>
                        <td><?php echo $project['tanggal_selesai']; ?></td>
                        <td><a href="actions/project_action.php?action=delete&id=<?php echo $project['id']; ?>" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus proyek ini? Seluruh tugas di dalamnya juga akan terhapus.');">Hapus</a></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <script>
        document.getElementById('roleSelect').addEventListener('change', function() {
            var pmSelector = document.getElementById('pmSelector');
            if (this.value === 'team_member') {
                pmSelector.style.display = 'block';
                pmSelector.querySelector('select').required = true;
            } else {
                pmSelector.style.display = 'none';
                pmSelector.querySelector('select').required = false;
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('roleSelect').dispatchEvent(new Event('change'));
        });
        </script>

        <?php elseif ($role == 'project_manager'): ?>
        <?php
            $stmt_projects = $conn->prepare("SELECT * FROM projects WHERE manager_id = ? ORDER BY id DESC");
            $stmt_projects->bind_param("i", $user_id);
            $stmt_projects->execute();
            $projects = $stmt_projects->get_result();
            
            $stmt_members = $conn->prepare("SELECT id, username FROM users WHERE project_manager_id = ?");
            $stmt_members->bind_param("i", $user_id);
            $stmt_members->execute();
            $team_members = $stmt_members->get_result();
        ?>
        <div class="dashboard-section">
            <h2>Proyek Saya</h2>
            <div class="card">
                <h3>Buat Proyek Baru</h3>
                <form action="actions/project_action.php" method="POST">
                    <input type="hidden" name="action" value="create">
                    <div class="input-group"><label>Nama Proyek</label><input type="text" name="nama_proyek" required></div>
                    <div class="input-group"><label>Deskripsi</label><textarea name="deskripsi" rows="3"></textarea></div>
                    <div class="form-row">
                        <div class="input-group"><label>Tanggal Mulai</label><input type="date" name="tanggal_mulai" required></div>
                        <div class="input-group"><label>Tanggal Selesai</label><input type="date" name="tanggal_selesai" required></div>
                    </div>
                    <button type="submit" class="btn">Buat Proyek</button>
                </form>
            </div>

            <h3>Daftar Proyek</h3>
            <table>
                <thead><tr><th>Nama Proyek</th><th>Tanggal Mulai</th><th>Tanggal Selesai</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php if($projects->num_rows > 0): ?>
                        <?php while($project = $projects->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($project['nama_proyek']); ?></td>
                            <td><?php echo $project['tanggal_mulai']; ?></td>
                            <td><?php echo $project['tanggal_selesai']; ?></td>
                            <td><a href="actions/project_action.php?action=delete&id=<?php echo $project['id']; ?>" class="btn btn-danger" onclick="return confirm('Anda yakin?')">Hapus</a></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4">Anda belum membuat proyek.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="dashboard-section">
            <h2>Manajemen Tugas</h2>
            <div class="card">
                <h3>Beri Tugas Baru</h3>
                <form action="actions/task_action.php" method="POST">
                    <input type="hidden" name="action" value="create">
                    <div class="form-row">
                        <div class="input-group">
                            <label>Pilih Proyek</label>
                            <select name="project_id" required>
                                <option value="">Pilih Proyek...</option>
                                <?php $projects->data_seek(0); while($p = $projects->fetch_assoc()) { echo "<option value='{$p['id']}'>".htmlspecialchars($p['nama_proyek'])."</option>"; } ?>
                            </select>
                        </div>
                        <div class="input-group">
                            <label>Tugaskan ke Anggota Tim</label>
                            <select name="assigned_to" required>
                                <option value="">Pilih Anggota...</option>
                                <?php while($tm = $team_members->fetch_assoc()) { echo "<option value='{$tm['id']}'>".htmlspecialchars($tm['username'])."</option>"; } ?>
                            </select>
                        </div>
                    </div>
                    <div class="input-group"><label>Nama Tugas</label><input type="text" name="nama_tugas" required></div>
                    <div class="input-group"><label>Deskripsi Tugas</label><textarea name="deskripsi"></textarea></div>
                    <button type="submit" class="btn">Tambah Tugas</button>
                </form>
            </div>
            
            <h3>Semua Tugas di Proyek Saya</h3>
            <?php
                $stmt_tasks = $conn->prepare("SELECT t.*, p.nama_proyek, u.username FROM tasks t JOIN projects p ON t.project_id = p.id JOIN users u ON t.assigned_to = u.id WHERE p.manager_id = ? ORDER BY p.id, t.id");
                $stmt_tasks->bind_param("i", $user_id);
                $stmt_tasks->execute();
                $tasks = $stmt_tasks->get_result();
            ?>
            <table>
                <thead><tr><th>Tugas</th><th>Proyek</th><th>Ditugaskan ke</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                <?php if($tasks->num_rows > 0): ?>
                    <?php while($task = $tasks->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($task['nama_tugas']); ?></td>
                        <td><?php echo htmlspecialchars($task['nama_proyek']); ?></td>
                        <td><?php echo htmlspecialchars($task['username']); ?></td>
                        <td><span class="status status-<?php echo strtolower($task['status']); ?>"><?php echo htmlspecialchars($task['status']); ?></span></td>
                        <td><a href="actions/task_action.php?action=delete&id=<?php echo $task['id']; ?>" class="btn btn-danger" onclick="return confirm('Anda yakin?')">Hapus</a></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5">Belum ada tugas di proyek Anda.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php elseif ($role == 'team_member'): ?>
        <?php
            $stmt = $conn->prepare("SELECT t.*, p.nama_proyek FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.assigned_to = ? ORDER BY p.nama_proyek, t.id");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $tasks = $stmt->get_result();
        ?>
        <div class="dashboard-section">
            <h2>Tugas Saya</h2>
            <p>Anda dapat mengubah status tugas Anda langsung dari tabel di bawah ini.</p>
            <table>
                <thead><tr><th>Nama Tugas</th><th>Deskripsi</th><th>Proyek</th><th>Status</th></tr></thead>
                <tbody>
                    <?php if($tasks->num_rows > 0): ?>
                        <?php while($task = $tasks->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($task['nama_tugas']); ?></td>
                            <td><?php echo htmlspecialchars($task['deskripsi']); ?></td>
                            <td><?php echo htmlspecialchars($task['nama_proyek']); ?></td>
                            <td>
                                <form action="actions/task_action.php" method="POST" class="status-form">
                                    <input type="hidden" name="action" value="update_status">
                                    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="belum" <?php if($task['status'] == 'belum') echo 'selected'; ?>>Belum</option>
                                        <option value="proses" <?php if($task['status'] == 'proses') echo 'selected'; ?>>Proses</option>
                                        <option value="selesai" <?php if($task['status'] == 'selesai') echo 'selected'; ?>>Selesai</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4">Anda belum memiliki tugas.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php else: ?>
            <p class="message error">Role pengguna tidak valid.</p>
        <?php endif; ?>

    </main>
</body>
</html>