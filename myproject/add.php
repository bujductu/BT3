<?php 
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
require 'db.php';

if ($_POST) {
    $sql = "INSERT INTO violations (bien_so, loai_vi_pham, ngay_vi_pham, dia_diem, muc_phat, trang_thai, ghi_chu) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['bien_so'],
        $_POST['loai_vi_pham'],
        $_POST['ngay_vi_pham'],
        $_POST['dia_diem'],
        $_POST['muc_phat'] ?: 0,
        $_POST['trang_thai'],
        $_POST['ghi_chu']
    ]);
    header("Location: index.php?success=1");
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm vi phạm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"><i class="fas fa-plus"></i> Thêm vi phạm mới</h4>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Biển số xe <span class="text-danger">*</span></label>
                        <input type="text" name="bien_so" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Loại vi phạm <span class="text-danger">*</span></label>
                        <input type="text" name="loai_vi_pham" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ngày vi phạm <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="ngay_vi_pham" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Địa điểm <span class="text-danger">*</span></label>
                        <input type="text" name="dia_diem" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mức phạt (VNĐ)</label>
                        <input type="number" name="muc_phat" class="form-control" step="1000">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Trạng thái</label>
                        <select name="trang_thai" class="form-select">
                            <option value="Chưa nộp">Chưa nộp</option>
                            <option value="Đã nộp">Đã nộp</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Ghi chú</label>
                        <textarea name="ghi_chu" class="form-control" rows="4"></textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-success btn-lg">Lưu thông tin</button>
                    <a href="index.php" class="btn btn-secondary btn-lg">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>