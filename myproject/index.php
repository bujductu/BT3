<?php 
session_start();
require 'db.php'; 

$is_logged_in = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tra cứu Vi phạm Giao thông</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .table th { background-color: #0d6efd; color: white; }
    </style>
</head>
<body>
<div class="container mt-4">

    <!-- Phần header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="text-primary">
        <i class="fas fa-car"></i> TRA CỨU VI PHẠM GIAO THÔNG
    </h1>
    
    <?php if ($is_logged_in): ?>
        <div>
            <span class="badge bg-success me-2">👤 Admin</span>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">
                <i class="fas fa-sign-out-alt"></i> Đăng xuất
            </a>
        </div>
    <?php else: ?>
        <a href="login.php" class="btn btn-primary">
            <i class="fas fa-sign-in-alt"></i> Đăng nhập Admin
        </a>
    <?php endif; ?>
</div>

    <!-- Form tìm kiếm -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Nhập biển số xe..." 
                           value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                </div>
                <?php if ($is_logged_in): ?>
                <div class="col-md-2">
                    <a href="add.php" class="btn btn-success w-100">
                        <i class="fas fa-plus"></i> Thêm mới
                    </a>
                </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <?php
    $search = $_GET['search'] ?? '';
    $sql = "SELECT * FROM violations";
    if ($search) {
        $sql .= " WHERE bien_so LIKE ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["%$search%"]);
    } else {
        $stmt = $pdo->query($sql);
    }
    $violations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Danh sách vi phạm (<?= count($violations) ?> bản ghi)</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Biển số</th>
                            <th>Loại vi phạm</th>
                            <th>Ngày vi phạm</th>
                            <th>Địa điểm</th>
                            <th>Mức phạt</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($violations as $v): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($v['bien_so']) ?></strong></td>
                            <td><?= htmlspecialchars($v['loai_vi_pham']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($v['ngay_vi_pham'])) ?></td>
                            <td><?= htmlspecialchars($v['dia_diem']) ?></td>
                            <td class="text-end"><?= number_format($v['muc_phat']) ?> đ</td>
                            <td>
                                <?php if ($v['trang_thai'] == 'Đã nộp'): ?>
                                    <span class="badge bg-success">Đã nộp</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Chưa nộp</span>
                                <?php endif; ?>
                            </td>
                            <td>
                             <?php if ($is_logged_in): ?>
                                    <a href="edit.php?id=<?= $v['id'] ?>" class="btn btn-sm btn-warning">
                                     <i class="fas fa-edit"></i>
                                 </a>
                                 <a href="delete.php?id=<?= $v['id'] ?>" 
                                    class="btn btn-sm btn-danger"
                                     onclick="return confirm('Xác nhận xoá vi phạm này?')">
                                        <i class="fas fa-trash"></i>
                                 </a>
                            <?php else: ?>
                                 <span class="text-muted small">Đăng nhập để sửa/xoá</span>
                             <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>