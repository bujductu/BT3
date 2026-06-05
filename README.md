Bước 1: Mở file cấu hình MySQL
Trong XAMPP:
Config → Service and Port Settings
Chọn tab:
MySQL
Đổi:
3306 → 3307
Save.
Bước 2: Sửa file my.ini
Trong XAMPP:
MySQL → Config → my.ini
Tìm:
port=3306
Đổi thành:
port=3307
Tìm tất cả dòng 3306 và đổi sang 3307.

Bước 1: Mở file config của phpMyAdmin
Vào:
C:\xampp\phpMyAdmin\config.inc.php

Bước 2: Tìm dòng port
Tìm:
$cfg['Servers'][$i]['host'] = 'localhost';
Ngay dưới nó thêm:
$cfg['Servers'][$i]['port'] = '3307';
Bước 3: Sửa tài khoản đăng nhập
Tìm:
$cfg['Servers'][$i]['user'] = 'root';
$cfg['Servers'][$i]['password'] = '';
Nếu không có thì thêm:
$cfg['Servers'][$i]['user'] = 'root';
$cfg['Servers'][$i]['password'] = '';
Bước 4: Tắt controluser (rất hay gây lỗi)
Tìm các dòng:
$cfg['Servers'][$i]['controluser']
$cfg['Servers'][$i]['controlpass']
Comment hoặc xóa:
