<?php 
require 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Xử lý cập nhật
if ($_POST && $id > 0) {
    $sql = "UPDATE violations 
            SET bien_so = ?, 
                loai_vi_pham = ?, 
                ngay_vi_pham = ?, 
                dia_diem = ?, 
                muc_phat = ?, 
                trang_thai = ?, 
                ghi_chu = ? 
            WHERE id = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['bien_so'],
        $_POST['loai_vi_pham'],
        $_POST['ngay_vi_pham'],
        $_POST['dia_diem'],
        $_POST['muc_phat'] ?: 0,
        $_POST['trang_thai'],
        $_POST['ghi_chu'],
        $id
    ]);

    header("Location: index.php?success=1");
    exit;
}

// Lấy thông tin vi phạm cần sửa
$stmt = $pdo->prepare("SELECT * FROM violations WHERE id = ?");
$stmt->execute([$id]);
$violation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$violation) {
    die("<div class='alert alert-danger text-center mt-5'>Không tìm thấy dữ liệu!</div>");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin vi phạm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">
                <i class="fas fa-edit"></i> Sửa thông tin vi phạm
            </h4>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Biển số xe <span class="text-danger">*</span></label>
                        <input type="text" name="bien_so" class="form-control" 
                               value="<?= htmlspecialchars($violation['bien_so']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Loại vi phạm <span class="text-danger">*</span></label>
                        <input type="text" name="loai_vi_pham" class="form-control" 
                               value="<?= htmlspecialchars($violation['loai_vi_pham']) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ngày vi phạm <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="ngay_vi_pham" class="form-control" 
                               value="<?= date('Y-m-d\TH:i', strtotime($violation['ngay_vi_pham'])) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Địa điểm <span class="text-danger">*</span></label>
                        <input type="text" name="dia_diem" class="form-control" 
                               value="<?= htmlspecialchars($violation['dia_diem']) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Mức phạt (VNĐ)</label>
                        <input type="number" name="muc_phat" class="form-control" step="1000"
                               value="<?= $violation['muc_phat'] ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Trạng thái</label>
                        <select name="trang_thai" class="form-select">
                            <option value="Chưa nộp" <?= $violation['trang_thai'] == 'Chưa nộp' ? 'selected' : '' ?>>Chưa nộp</option>
                            <option value="Đã nộp" <?= $violation['trang_thai'] == 'Đã nộp' ? 'selected' : '' ?>>Đã nộp</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Ghi chú</label>
                        <textarea name="ghi_chu" class="form-control" rows="4"><?= htmlspecialchars($violation['ghi_chu'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-warning btn-lg">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>
                    <a href="index.php" class="btn btn-secondary btn-lg">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>