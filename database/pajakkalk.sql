-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Jun 2025 pada 06.51
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pajakkalk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anonymous_users`
--

CREATE TABLE `anonymous_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `anon_id` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `calculations`
--

CREATE TABLE `calculations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `anon_id` char(36) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `calculations`
--

INSERT INTO `calculations` (`id`, `anon_id`, `data`, `created_at`, `updated_at`) VALUES
(1, '3c4cff79-3dcb-46d5-8610-bac88b64c8b9', '{\"input\":{\"_token\":\"yYnHNmztBTDhiKa0UMs7oaQGebx2Q6LVb5YogbXa\",\"pendapatan\":\"8000000\",\"tunjangan\":\"0\",\"iuran_pensiun\":\"0\",\"status\":\"lajang\",\"tanggungan\":\"0\"},\"hasil\":{\"bruto_setahun\":96000000,\"total_pengurang_setahun\":4800000,\"neto_setahun\":91200000,\"total_ptkp\":54000000,\"pkp\":37200000,\"pajak_setahun\":1860000},\"type\":\"pph\"}', '2025-06-20 03:15:10', '2025-06-20 03:15:10'),
(2, '3c4cff79-3dcb-46d5-8610-bac88b64c8b9', '{\"input\":{\"_token\":\"yYnHNmztBTDhiKa0UMs7oaQGebx2Q6LVb5YogbXa\",\"pendapatan\":\"1000000\",\"tunjangan\":\"0\",\"iuran_pensiun\":\"0\",\"status\":\"lajang\",\"tanggungan\":\"0\"},\"hasil\":{\"bruto_setahun\":12000000,\"total_pengurang_setahun\":600000,\"neto_setahun\":11400000,\"total_ptkp\":54000000,\"pkp\":0,\"pajak_setahun\":0},\"type\":\"pph\"}', '2025-06-20 03:32:54', '2025-06-20 03:32:54'),
(3, '3c4cff79-3dcb-46d5-8610-bac88b64c8b9', '{\"input\":{\"_token\":\"yYnHNmztBTDhiKa0UMs7oaQGebx2Q6LVb5YogbXa\",\"njkb\":\"15000000\",\"jenis_kendaraan\":\"motor_dibawah_250cc\",\"provinsi\":\"dki_jakarta\",\"kepemilikan\":\"1\"},\"hasil\":{\"njkb\":15000000,\"pkb_pokok\":300000,\"opsen_pkb\":198000,\"swdkllj\":35000,\"total_bayar\":533000,\"koefisien\":1,\"tarif_pajak\":0.02},\"type\":\"pkb\"}', '2025-06-20 05:25:48', '2025-06-20 05:25:48'),
(4, '3c4cff79-3dcb-46d5-8610-bac88b64c8b9', '{\"input\":{\"_token\":\"yYnHNmztBTDhiKa0UMs7oaQGebx2Q6LVb5YogbXa\",\"njkb\":\"100000000\",\"jenis_kendaraan\":\"sedan_jeep_minibus\",\"provinsi\":\"dki_jakarta\",\"kepemilikan\":\"1\"},\"hasil\":{\"njkb\":100000000,\"pkb_pokok\":2049999.9999999998,\"opsen_pkb\":1353000,\"swdkllj\":143000,\"total_bayar\":3546000,\"koefisien\":1.025,\"tarif_pajak\":0.02},\"type\":\"pkb\"}', '2025-06-20 05:48:13', '2025-06-20 05:48:13'),
(5, '1377386d-504c-4359-93f1-35eaff1eddaa', '{\"input\":{\"_token\":\"0VPQrWPRkGedqf4fDhKQd7Or3R591SLWRPsVkdAC\",\"njkb\":\"150000000\",\"jenis_kendaraan\":\"sedan_jeep_minibus\",\"provinsi\":\"dki_jakarta\",\"kepemilikan\":\"1\"},\"hasil\":{\"njkb\":150000000,\"pkb_pokok\":3075000,\"opsen_pkb\":2029500,\"swdkllj\":143000,\"total_bayar\":5247500,\"koefisien\":1.025,\"tarif_pajak\":0.02},\"type\":\"pkb\"}', '2025-06-20 17:31:09', '2025-06-20 17:31:09'),
(6, '3c4cff79-3dcb-46d5-8610-bac88b64c8b9', '{\"input\":{\"_token\":\"cjqOJYWmxqLKHBrx4OCf2xgpChjyUgws6c00B1qz\",\"pendapatan\":\"15000000\",\"tunjangan\":\"0\",\"iuran_pensiun\":\"0\",\"status\":\"menikah\",\"tanggungan\":\"1\"},\"hasil\":{\"bruto_setahun\":180000000,\"total_pengurang_setahun\":6000000,\"neto_setahun\":174000000,\"total_ptkp\":63000000,\"pkp\":111000000,\"pajak_setahun\":10650000},\"type\":\"pph\"}', '2025-06-20 18:20:36', '2025-06-20 18:20:36'),
(7, '3c4cff79-3dcb-46d5-8610-bac88b64c8b9', '{\"input\":{\"_token\":\"cjqOJYWmxqLKHBrx4OCf2xgpChjyUgws6c00B1qz\",\"njkb\":\"20000000\",\"jenis_kendaraan\":\"motor_diatas_250cc\",\"provinsi\":\"dki_jakarta\",\"kepemilikan\":\"1\"},\"hasil\":{\"njkb\":20000000,\"pkb_pokok\":400000,\"opsen_pkb\":264000,\"swdkllj\":83000,\"total_bayar\":747000,\"koefisien\":1,\"tarif_pajak\":0.02},\"type\":\"pkb\"}', '2025-06-20 18:20:56', '2025-06-20 18:20:56'),
(8, '343d0839-69a9-4681-ac3b-a66f7133065a', '{\"input\":{\"_token\":\"MRnl6DMD2xle0yfNRBC1wlFDiwf3eQ9TZpwbL9ic\",\"pendapatan\":\"80000000\",\"tunjangan\":\"0\",\"iuran_pensiun\":\"0\",\"status\":\"lajang\",\"tanggungan\":\"0\"},\"hasil\":{\"bruto_setahun\":960000000,\"total_pengurang_setahun\":6000000,\"neto_setahun\":954000000,\"total_ptkp\":54000000,\"pkp\":900000000,\"pajak_setahun\":214000000},\"type\":\"pph\"}', '2025-06-20 19:05:17', '2025-06-20 19:05:17'),
(9, '343d0839-69a9-4681-ac3b-a66f7133065a', '{\"input\":{\"_token\":\"MRnl6DMD2xle0yfNRBC1wlFDiwf3eQ9TZpwbL9ic\",\"mekanisme\":\"standar\",\"nilai_transaksi\":\"10000000\"},\"hasil\":{\"dpp\":10000000,\"ppn\":1100000,\"total\":11100000,\"keterangan_hasil\":\"PPN = Tarif Umum (11%) \\u00d7 DPP\"},\"type\":\"ppn\"}', '2025-06-20 19:36:18', '2025-06-20 19:36:18'),
(10, '343d0839-69a9-4681-ac3b-a66f7133065a', '{\"input\":{\"_token\":\"MRnl6DMD2xle0yfNRBC1wlFDiwf3eQ9TZpwbL9ic\",\"njkb\":\"15000000\",\"jenis_kendaraan\":\"motor_dibawah_250cc\",\"provinsi\":\"dki_jakarta\",\"kepemilikan\":\"1\"},\"hasil\":{\"njkb\":15000000,\"pkb_pokok\":300000,\"opsen_pkb\":198000,\"swdkllj\":35000,\"total_bayar\":533000,\"koefisien\":1,\"tarif_pajak\":0.02},\"type\":\"pkb\"}', '2025-06-20 19:36:29', '2025-06-20 19:36:29'),
(11, '343d0839-69a9-4681-ac3b-a66f7133065a', '{\"input\":{\"_token\":\"MRnl6DMD2xle0yfNRBC1wlFDiwf3eQ9TZpwbL9ic\",\"mekanisme\":\"standar\",\"nilai_transaksi\":\"10000000\"},\"hasil\":{\"dpp\":10000000,\"ppn\":1100000,\"total\":11100000,\"keterangan_hasil\":\"PPN = Tarif Umum (11%) \\u00d7 DPP\"},\"type\":\"ppn\"}', '2025-06-20 20:17:12', '2025-06-20 20:17:12'),
(12, '343d0839-69a9-4681-ac3b-a66f7133065a', '{\"input\":{\"_token\":\"MRnl6DMD2xle0yfNRBC1wlFDiwf3eQ9TZpwbL9ic\",\"mekanisme\":\"dpp_nilai_lain\",\"nilai_transaksi\":\"200000000\",\"persentase_dpp\":\"15\"},\"hasil\":{\"dpp\":200000000,\"ppn\":3300000,\"total\":203300000,\"keterangan_hasil\":\"PPN = Tarif Umum (11%) \\u00d7 (DPP Nilai Lain: 15% \\u00d7 Harga Jual)\"},\"type\":\"ppn\"}', '2025-06-20 20:25:33', '2025-06-20 20:25:33'),
(13, '3c4cff79-3dcb-46d5-8610-bac88b64c8b9', '{\"input\":{\"_token\":\"1nhQkUJuUdnGh99aUtY49ziPSOrX7lkjLEpNY3w2\",\"pendapatan\":\"15000000\",\"tunjangan\":\"150000\",\"iuran_pensiun\":\"1000000\",\"status\":\"menikah\",\"tanggungan\":\"3\"},\"hasil\":{\"bruto_setahun\":181800000,\"total_pengurang_setahun\":18000000,\"neto_setahun\":163800000,\"total_ptkp\":72000000,\"pkp\":91800000,\"pajak_setahun\":7770000},\"type\":\"pph\"}', '2025-06-21 06:59:20', '2025-06-21 06:59:20'),
(14, '3c4cff79-3dcb-46d5-8610-bac88b64c8b9', '{\"input\":{\"_token\":\"1nhQkUJuUdnGh99aUtY49ziPSOrX7lkjLEpNY3w2\",\"mekanisme\":\"dpp_nilai_lain\",\"nilai_transaksi\":\"200000000\",\"persentase_dpp\":\"10\"},\"hasil\":{\"dpp\":200000000,\"ppn\":2200000,\"total\":202200000,\"keterangan_hasil\":\"PPN = Tarif Umum (11%) \\u00d7 (DPP Nilai Lain: 10% \\u00d7 Harga Jual)\"},\"type\":\"ppn\"}', '2025-06-21 06:59:55', '2025-06-21 06:59:55'),
(15, '3c4cff79-3dcb-46d5-8610-bac88b64c8b9', '{\"input\":{\"_token\":\"1nhQkUJuUdnGh99aUtY49ziPSOrX7lkjLEpNY3w2\",\"mekanisme\":\"besaran_tertentu\",\"nilai_transaksi\":\"50000000\",\"tarif_efektif\":\"1.1\"},\"hasil\":{\"dpp\":50000000,\"ppn\":550000,\"total\":50550000,\"keterangan_hasil\":\"PPN = Tarif Efektif (1.1%) \\u00d7 Harga Jual\"},\"type\":\"ppn\"}', '2025-06-21 07:00:17', '2025-06-21 07:00:17'),
(16, '3c4cff79-3dcb-46d5-8610-bac88b64c8b9', '{\"input\":{\"_token\":\"1nhQkUJuUdnGh99aUtY49ziPSOrX7lkjLEpNY3w2\",\"njkb\":\"150000000\",\"jenis_kendaraan\":\"sedan_jeep_minibus\",\"provinsi\":\"dki_jakarta\",\"kepemilikan\":\"1\"},\"hasil\":{\"njkb\":150000000,\"pkb_pokok\":3075000,\"opsen_pkb\":2029500,\"swdkllj\":143000,\"total_bayar\":5247500,\"koefisien\":1.025,\"tarif_pajak\":0.02},\"type\":\"pkb\"}', '2025-06-21 07:00:42', '2025-06-21 07:00:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_19_095530_create_anonymous_users_table', 1),
(5, '2025_06_20_094552_create_calculations_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3fNNtVrTp7MnSeG4GejEtZ9a3OZukNw68NDt193C', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOGJMcTY3eTd2UkVJUFd4SjdzSGVhenhIVUxlckJwUmp6cWIxcHJ0ZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9wYWphay1hcHAudGVzdC9wa2IiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750331814),
('3oeYCE5aSQH5BjjH7nitqxmuGsWlPzwvPJVl323e', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoid1VSaHJ4VTlDRG9ER0hoeWl5VDRVZXJYeVg5RjA2NUtET3BLY0phayI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1750331740),
('58sPCxo24EgfmrPcwW4sOBK10VfG7QeUXM5Tfpfy', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaE9ZcGVuNEhVd3ZIOXlONlRnNXBtaWNHZENTQnUwYnRSM0JqbG01OSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9wYWphay1hcHAudGVzdC9wcG4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750331815),
('7RDIPdo9B1fIsVLcvBzJ5pE1olPI9mwPQ8w9nsZZ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiWDVEa2FsbG95YVZKRjlxa1Q0M1lSSllNb2JjWnlYRk1rMGNXbnE3ciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1750331698),
('8a1s6Co67PaSn7LhWsYS1AbkXkREQizioiPSfN1n', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYmFYVGVuZFRRaFJoN0Y0emxuc09ZaG00SndVVEdnNURRQWpPVmdycCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9wYWphay1hcHAudGVzdC9wcGgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750331673),
('8ZlVGTb1IMRtJZ5meO0dqrr5kJUZaYSuyK5pMm44', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoienM4U0hoTXdlQXl2NUFlZjlXQjByN0pib3Z6RmFYaVo4emZiTm5GcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9wYWphay1hcHAudGVzdC9wcG4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750331809),
('Aj5Z8RWS1Kt7QcTVDjsoF2fU0PrVEi6NskDsb7d9', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiaE13Smc2TDJaWXRHbUlyVjFlNEltSzRDekhLZG51dmJzWGZOM3NWWiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1750332705),
('bFec2mNhIoPxQ9zgiLh5seN8nCctqY2pXO3V7qXn', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicXlpalRncGl0WnBwc3hNY2dmTE1FcUtZeWlWSDhVRHlLdVlGSE44ayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9wYWphay1hcHAudGVzdC9wa2IiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750331830),
('BO23OLrQFxJS3Bou4EJXRq8fNIwbIdIEVQko9ZU2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSTBZZlVPbnl5NkpHSVAxSFd2Y3hJUjJNQzl1bDZhSzlwYTNpbURqaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9wYWphay1hcHAudGVzdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750331666),
('CvLQDiqk9YZFYzN8L2yr0irEupmk7QEItUeE5yWe', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV1ZCM2ZlUmdzVkJ0R1d6QXpUSWNYalB3TVV1SmRSQWlDNmV3cGd1NSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9wYWphay1hcHAudGVzdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750331662),
('d9eJTNrsWRUcsO6FuqRH5kWEEXTOSldYnov1y5s7', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieEV4REVCTkxWVDBBNjF6dzRxYTdJVDM1OW04MVJjalMyZWplTWlUTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9wYWphay1hcHAudGVzdC9wa2IiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750331812),
('GmKwaZB8pSMjrNmve0F9BvYaGCMKhlxwQz9t8tf8', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSVM2Z2I3RUpWY3c1QTl0M0pIVjM3RkNVMjcwOUZZcmwwdDNLaEhYYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9wYWphay1hcHAudGVzdC9wcGgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750331807),
('hO0OKgYzEieFZCOSnYTIkTOINfxsaPvFeJb3sxr4', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRjNUMXNuYUdxZU1CblRoZHc0ekpETTQwbHhsNUhMVmloaHBjVVdlQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9wYWphay1hcHAudGVzdC9wcGgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750331736),
('iA6apdsZCq8g4OaEyLJBKwFAWqPvqEWhjwGeReap', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiRnJNWHJ1YlVLMDgzaVNiN1piQWZVa09sMWFKTTk2clh2eDdOMEFPbCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1750331825),
('KuFomkdKBnrUJ4P0R9MUScB29KYWSIdHvzSsnHfX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZnFxbHRiZkFkY3hQY05DSXNBd0pyTlMycXBPTUZxQ3hRQ0NrUk02WiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1750331726),
('nc9MlkbW6GO7KhM70SW74JEG6S3tliFwg5CXHWRd', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib1I3SmZzZFg1cm1JVENIR3kyUll5VVpXSzhvVHd4cFc3dE9FczhLaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9wYWphay1hcHAudGVzdC9wa2IiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750332686),
('O5rHbBJl34Id77cf9w77uDxmQlef2nbgnA5HIuyx', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZTdKenVOMFJuVG1BSGhKQmVsU0xFMVVwTUtFN25ObU1IZ1Fia3pwZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9wYWphay1hcHAudGVzdC9wcG4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750331828),
('UFqZqlYkw5BzM281AK6VuGrVmqD5OIoSmK5fqRsc', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS3UxdWl2aG9ZZWkxZ3l1eDhiRUZ5cExKYWJ0SEpwaU1VSWdyT0VERyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9wYWphay1hcHAudGVzdC9wcGgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750331720),
('zfOBxPYk2XKT1cdadTGZ7BdG6F7eemwMbMuInXtR', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiOExUYTNQREkzMzFDaWdOY0ptT3Z2TWhDT1JuQjFiSDdLb0pYM0dqUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1750331717);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anonymous_users`
--
ALTER TABLE `anonymous_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `anonymous_users_anon_id_unique` (`anon_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `calculations`
--
ALTER TABLE `calculations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `anonymous_users`
--
ALTER TABLE `anonymous_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `calculations`
--
ALTER TABLE `calculations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
