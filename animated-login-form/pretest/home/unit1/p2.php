<?php
session_start();
$percentage = 90; // เปอร์เซ็นต์ความคืบหน้า (เช่น 70%)
// ตรวจสอบว่าผู้ใช้ล็อกอินหรือยัง
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงค่า pretest_score และสถานะของแต่ละบท
$sql = "SELECT pretest_score, posttest_score, congratulation,end_date, 
               chapter_1_status, chapter_2_status, chapter_3_status, 
               chapter_4_status, chapter_5_status, chapter_6_status 
        FROM users WHERE username = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>วิธีปกป้องอัตลักษณ์ออนไลน์</title>
    <link rel="stylesheet" href="../chapter/css/style.css"> <!-- Link to the CSS file -->
    <link rel="stylesheet" href="../bar/style.css"> <!-- Link to the CSS file -->
</head>
<body>
<span class="username-display"><?php echo htmlspecialchars($username); ?></span>
    
    <!-- Navigation Menu -->
    <div class="nav">
    <input type="checkbox" id="menu-toggle" />
    <svg>
        <use xlink:href="#MENU1" />
        <use xlink:href="#MENU1" />
    </svg>
</div>

<!-- ปุ่ม SETTING และ LOGOUT (ซ่อนก่อน) -->
<div class="menu-buttons">
    <button class="home-btn">HOME</button>
    <button id="setting-btn" class="setting-btn">SETTING</button>
    <button class="logout-btn">LOGOUT</button>
</div>
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
<symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 56" id="MENU1">
    <path d="M48.33,45.6H18a14.17,14.17,0,0,1,0-28.34H78.86a17.37,17.37,0,0,1,0,34.74H42.33l-21-21.26L47.75,4"/>
</symbol>
</svg>
<!-- Settings Modal -->
<div id="settings-modal" class="settings-modal">
    <div class="settings-content">
        <h2>Settings</h2>
        <label for="bgm-volume">BGM Volume:</label>
        <input type="range" id="bgm-volume" min="0" max="1" step="0.001" value="1">
        <label for="sfx-volume">SFX Volume:</label>
        <input type="range" id="sfx-volume" min="0" max="1" step="0.001" value="1">
        <label for="mute">Mute:</label>
        <input type="checkbox" id="mute">
        <button id="close-settings">Close</button>
    </div>
</div>
<!-- Header Navigation -->
    <script defer src="../bar/script.js"></script>

    <!-- Content Section -->
    <section class="content-section">
        <h1>วิธีปกป้องอัตลักษณ์ออนไลน์</h1>

        <div class="content-text">
            <p><strong>4. วิธีปกป้องอัตลักษณ์ออนไลน์</strong></p>
            <ul>
                <li>ตรวจสอบการตั้งค่าความเป็นส่วนตัวในโซเชียลมีเดีย</li>
                <li>หลีกเลี่ยงการโพสต์ข้อมูลส่วนตัวที่ละเอียดอ่อน</li>
                <li>ใช้รหัสผ่านที่ปลอดภัยและไม่ซ้ำกันในแต่ละบัญชี</li>
                <li>จำกัดการเข้าถึงโพสต์เก่าๆ ที่อาจมีข้อมูลสำคัญ</li>
                <li>ค้นหาชื่อตัวเองใน Google เพื่อตรวจสอบว่ามีข้อมูลใดหลุดออกไปบ้าง</li>
            </ul>
        </div>
    </section>

    <!-- Footer Buttons -->
    <footer class="footer-buttons">
        <button class="back-button" onclick="window.location.href='p1.php'">back</button>
        <button class="next-button" onclick="window.location.href='lab_unit.php'">next</button>
    </footer>
</body>
</html>