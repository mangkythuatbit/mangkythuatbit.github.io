<?php
include '../../Config/connect.php';

if (!isset($_GET['id'])) {
    die('Không tìm thấy thông tin Mẹ Việt Nam Anh Hùng');
}

$id = intval($_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM anhhung WHERE anhhung_id = $id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die('Dữ liệu không tồn tại');
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin Mẹ Việt Nam Anh Hùng</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<!-- Roboto (font chính, không lỗi tiếng Việt) -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">

<!-- Style Script (nếu bạn dùng cho tiêu đề trang trí) -->
<link href="https://fonts.googleapis.com/css2?family=Style+Script&display=swap" rel="stylesheet">


    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; 
            background:transparent; }

        body {
            margin: 0;
            min-height: 100vh;
        
            display: flex;
            justify-content: center;
            align-items: center;
        
            background: rgba(0,0,0,0.55); /* NỀN MỜ */
            backdrop-filter: blur(6px);  /* MỜ MỊN (trình duyệt mới) */
            -webkit-backdrop-filter: blur(6px);
        
            padding: 20px;
            font-family: 'Roboto', Arial, sans-serif;
        }
        
        .modal-container {
            position: relative;
            width: 100%;
            max-width: 720px;
            background-color: #fff;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0,0,0,.25);
        }

        .modal-header {
            padding: 22px 60px 22px 20px;
            text-align: center;
            font-weight: 700;
            font-size: 20px;
            letter-spacing: 1px;
            color: #8b0000;
            border-bottom: 1px solid #f0f0f0;
        }

        .close-button {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 36px;
            height: 36px;
            background-color: #f2f2f2;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            border: none;
            transition: all .2s ease;
        }

        .close-button:hover {
            background-color: #e0e0e0;
            transform: rotate(90deg);
        }

        .modal-body { padding: 20px; }

        .profile {
            display: flex;
            gap: 24px;
            margin-bottom: 25px;
        }

@media (max-width: 768px) {
        .profile {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
    }

        .profile-image {
            width: 200px;
            height: 240px;
            border-radius: 14px;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 8px 20px rgba(0,0,0,.2);
        }
        
        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-info {
            flex: 1;
            padding-top: 10px;
        }
        
        .info-row {
            margin-bottom: 14px;
            font-size: 15.5px;
            line-height: 1.6;
        }
        
        .info-label {
            display: inline-block;
            min-width: 110px;
            font-weight: 600;
            color: #555;
        }

        .section-title {
            font-weight: 700;
            font-size: 18px;
            margin: 30px 0 12px;
            color: #8b0000;
        }
        
        .story-text {
            font-size: 15.5px;
            line-height: 1.8;
            color: #333;
            text-align: justify;
        }

        .heart-container {
            display: flex;
            justify-content: center;
            margin: 10px 0;
        }

        .heart-icon {
            font-size: 24px;
            cursor: pointer;
            color: #888;
        }

        .heart-icon.active {
            color: red;
        }
        .detail-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.55); /* giả làm mờ */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
        }

        .detail-modal {
    background: #fff;
    max-width: 900px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    border-radius: 12px;
    position: relative;
    box-shadow: 0 20px 60px rgba(0,0,0,.4);
        }
        /* iframe trang tổng */
.bg-iframe {
    position: fixed;
    inset: 0;
    width: 100%;
    height: 100%;
    border: none;
    pointer-events: none;   /* ❌ không cho thao tác */
    z-index: 1;
}

/* lớp làm mờ */
.bg-mask {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.25);
    backdrop-filter: blur(6px);
    z-index: 2;
}

/* panel chi tiết */
.detail-panel {
    position: relative;
    z-index: 3;
    max-width: 900px;
    margin: 80px auto;
    background: #fff;
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 30px 80px rgba(0,0,0,.45);
}
.detail-header {
    display: flex;
    gap: 8px;
    margin-bottom: 16px;
}

.header-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    opacity: 0.6;
}

.header-dot.red { background: #ff5f56; }
.header-dot.yellow { background: #ffbd2e; }
.header-dot.green { background: #27c93f; }

    </style>
</head>

<body>
<!-- Trang tổng phía sau -->
    <iframe 
        src="/Bang_vinh_danh.php"
        class="bg-iframe">
    </iframe>

    <!-- Lớp blur + khóa thao tác -->
    <div class="bg-mask"></div>

    <!-- Nội dung chi tiết -->
    <div class="detail-panel">
        <div class="detail-header">
        <span class="header-dot red"></span>
        <span class="header-dot yellow"></span>
        <span class="header-dot green"></span>
    </div>
<div class="modal-container">
    <div class="modal-header">
        THÔNG TIN CHI TIẾT MẸ VIỆT NAM ANH HÙNG
    </div>

    <button class="close-button" onclick="history.back()">✕</button>

    <div class="modal-body">

        <div class="profile">
            <div class="profile-image">
                <img src="/assets/img/heroes/<?php echo $data['anhhung_img']; ?>" alt="Mẹ VNAH">
            </div>

            <div class="profile-info">
                <div class="info-row">
                    <span class="info-label">HỌ VÀ TÊN:</span>
                    <span><?php echo mb_strtoupper($data['anhhung_name']); ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">SINH NĂM:</span>
                    <span>
                        <?php
                        echo ($data['anhhung_date'] != "0000-00-00")
                            ? date("Y", strtotime($data['anhhung_date']))
                            : "Chưa rõ";
                        ?>
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">ĐỊA CHỈ:</span>
                    <span><?php echo $data['anhhung_home']; ?></span>
                </div>

                <div class="heart-container">
                    <div class="heart-icon" id="heartIcon">♡</div>
                </div>
            </div>
        </div>

        <div class="section-title">
            HOÀN CẢNH CỦA MẸ <?php echo mb_strtoupper($data['anhhung_name']); ?>
        </div>
        <div class="story-text">
            <?php echo nl2br($data['anhhung_chiencong']); ?>
        </div>
        
        <div class="section-title">GHI CHÚ</div>
        <div class="story-text">
            <?php echo nl2br($data['anhhung_note']); ?>
        </div>

    </div>
</div>

<script>
    const heartIcon = document.getElementById('heartIcon');
    heartIcon.addEventListener('click', () => {
        heartIcon.classList.toggle('active');
        heartIcon.innerHTML = heartIcon.classList.contains('active') ? '♥' : '♡';
    });
</script>

</body>
</html>
