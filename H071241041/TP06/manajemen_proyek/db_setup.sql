DROP DATABASE IF EXISTS db_manajemen_proyek;
CREATE DATABASE IF NOT EXISTS db_manajemen_proyek;

USE db_manajemen_proyek;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `project_manager_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_project_manager` (`project_manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `users`
  ADD CONSTRAINT `fk_project_manager` FOREIGN KEY (`project_manager_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

INSERT INTO `users` (`id`, `username`, `password`, `role`, `project_manager_id`) VALUES
(1, 'superadmin', '123456', 'super_admin', NULL),
(2, 'manager_andi', '123456', 'project_manager', NULL),
(3, 'manager_budi', '123456', 'project_manager', NULL),
(4, 'member_citra', '123456', 'team_member', 2),
(5, 'member_dina', '123456', 'team_member', 2),
(6, 'member_eko', '123456', 'team_member', 3);

CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_proyek` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `manager_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_manager_id` (`manager_id`),
  CONSTRAINT `fk_manager_id` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `projects` (`id`, `nama_proyek`, `deskripsi`, `tanggal_mulai`, `tanggal_selesai`, `manager_id`) VALUES
(1, 'Desain Ulang Website Perusahaan', 'Perombakan total UI/UX website resmi perusahaan untuk meningkatkan pengalaman pengguna.', '2025-11-01', '2026-02-15', 2),
(2, 'Pengembangan Aplikasi Mobile', 'Membuat aplikasi mobile baru untuk platform iOS dan Android.', '2025-12-01', '2026-06-30', 3),
(3, 'Sistem Inventaris Gudang', 'Membangun sistem untuk melacak inventaris di gudang utama.', '2026-01-10', '2026-04-20', 2);

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_tugas` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'belum',
  `project_id` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_project_id` (`project_id`),
  KEY `fk_assigned_to` (`assigned_to`),
  CONSTRAINT `fk_project_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_assigned_to` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tasks` (`id`, `nama_tugas`, `deskripsi`, `status`, `project_id`, `assigned_to`) VALUES
(1, 'Membuat Wireframe Halaman Utama', 'Merancang tata letak awal untuk homepage baru.', 'proses', 1, 4),
(2, 'Mengembangkan Halaman Login', 'Membuat kode front-end dan back-end untuk otentikasi pengguna.', 'belum', 1, 5),
(3, 'Setup Database Aplikasi', 'Inisialisasi skema database untuk aplikasi mobile.', 'selesai', 2, 6);