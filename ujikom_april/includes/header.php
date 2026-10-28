<?php
require_once __DIR__ . '/../functions/helper.php';
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-width: 240px;
            --sidebar-bg: #1e3a8a; /* Soft Navy Blue matching Pict 1 */
            --sidebar-active: #2563eb;
            --main-bg: #f3f4f6;
        }
        body {
            background-color: var(--main-bg);
            color: #1f2937;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
        }
        
        .wrapper {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            color: #ffffff;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar .brand {
            padding: 1.25rem 1.5rem;
            font-size: 1.1rem;
            font-weight: 700;
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .sidebar .nav-link {
            color: #93c5fd;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-radius: 0;
            transition: all 0.2s ease;
        }
        .sidebar .nav-link:hover {
            color: #ffffff;
            background-color: rgba(255,255,255,0.08);
        }
        .sidebar .nav-link.active {
            color: #ffffff;
            background-color: var(--sidebar-active);
            font-weight: 600;
        }
        .sidebar .logout-link {
            color: #93c5fd;
            padding: 1rem 1.5rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.95rem;
        }
        .sidebar .logout-link:hover {
            color: #ffffff;
        }
        
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .top-navbar {
            background-color: #ffffff;
            padding: 0.85rem 2rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .content-body {
            padding: 2rem;
            flex-grow: 1;
        }
        .footer {
            background-color: #ffffff;
            border-top: 1px solid #e5e7eb;
            padding: 1rem 2rem;
            text-align: center;
            font-size: 0.875rem;
            color: #6b7280;
        }

        /* Card Styling to mirror Pict 1 */
        .card-stat-box {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 1.25rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
            position: relative;
        }
        .card-stat-box .icon-badge {
            position: absolute;
            right: 1.25rem;
            top: 1.25rem;
            color: #9ca3af;
            font-size: 1.2rem;
        }

        .table-custom-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }

        @media (max-width: 768px) {
            .wrapper {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<?php if (isset($_SESSION['user_id'])): ?>
<div class="wrapper">
    <!-- Sidebar matching Pict 1 -->
    <aside class="sidebar">
        <div>
            <a href="dashboard.php" class="brand">
                <i class="bi bi-box-seam"></i> Inventaris Barang
            </a>
            <div class="nav flex-column mt-3">
                <a href="dashboard.php" class="nav-link <?= $current_page === 'dashboard.php' ? 'active' : ''; ?>">
                    <i class="bi bi-grid-fill"></i> Dashboard
                </a>
                <a href="barang.php" class="nav-link <?= in_array($current_page, ['barang.php', 'barang_tambah.php', 'barang_edit.php']) ? 'active' : ''; ?>">
                    <i class="bi bi-box"></i> Data Barang
                </a>
                <a href="laporan.php" class="nav-link <?= $current_page === 'laporan.php' ? 'active' : ''; ?>">
                    <i class="bi bi-file-earmark-text"></i> Laporan
                </a>
            </div>
        </div>
        <div class="mb-3">
            <a href="logout.php" class="logout-link">
                <i class="bi bi-box-arrow-left"></i> Logout
            </a>
        </div>
    </aside>

    <div class="main-content">
        <!-- Top Navbar -->
        <header class="top-navbar d-flex justify-content-between align-items-center">
            <div class="fw-semibold text-dark">Dashboard</div>
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-person-circle text-secondary fs-5"></i>
                <span class="small text-secondary"><?= escape($_SESSION['username']); ?></span>
            </div>
        </header>

        <!-- Main Body -->
        <main class="content-body">
<?php else: ?>
<div class="container my-5">
<?php endif; ?>
