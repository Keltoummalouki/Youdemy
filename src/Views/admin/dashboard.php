<?php
require_once '../../../vendor/autoload.php';

use App\Config\DatabaseConnexion;
use App\Controllers\UserController;

$db = new DatabaseConnexion();
$conn = $db->connect();
$userController = new UserController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['new_status'])) {
    $userId = $_POST['user_id'];
    $newStatus = $_POST['new_status'];
    $userController->updateUserStatus($userId, $newStatus);
}


$totalTeachers = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'Teacher'")->fetchColumn();
$totalStudents = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'Student'")->fetchColumn();
$totalCourses = $conn->query("SELECT COUNT(*) FROM courses")->fetchColumn();
$totalVisitors = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();; 

$users = $conn->query("SELECT * FROM Users")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../../assets/styles/dashboard.css">
</head>

<body>
    <header>
        <div class="logosec">
        <div class="logo">You<span>demy</span></div>
        </div>

        <div class="searchbar">
            <input type="text"
                placeholder="Search">
            <div class="searchbtn">
                <img src="../../../assets/media/image/search.png"
                    class="icn srchicn"
                    alt="search-icon">
            </div>
        </div>

        <div class="message">
            <div class="circle"></div>
            <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210183322/8.png"
                class="icn"
                alt="">
            <div class="dp">
                <img src="../../../../assets/media/image/Profil.png"
                    class="dpicn"
                    alt="dp">
                    <a href="../../auth/login.php"></a>
            </div>
        </div>
    </header>

    <div class="main-container">

        <div class="navcontainer">
            <nav class="nav">
                <div class="nav-upper-options">
                    <div class="nav-option option1">
                        <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210182148/Untitled-design-(29).png"
                            class="nav-img"
                            alt="dashboard">
                        <a href="#">Dashboard</a>
                    </div>

                    <div class="nav-option option2">
                        <img src="../../../assets/media/image/teacherblack.png"
                            class="nav-img"
                            alt="institution">
                        <a href="./courses/index.php"> Course</a>
                    </div>

                    <div class="option3 nav-option">
                        <img src="../../../assets/media/image/category.png"
                            class="nav-img"
                            alt="articles">
                        <a href="./categorys/index.php"> Category</a>
                    </div>

                    <div class="nav-option option4">
                        <img src="../../../assets/media/image/tag icon.png"
                            class="nav-img"
                            alt="report">
                        <a href="./tags/index.php"> Tag</a>
                    </div>

                    <div class="nav-option option5">
                        <img src="../../../assets/media/image/report.png"
                            class="nav-img"
                            alt="raport">
                            <a href="./statistics.php"> Statistiques</a>
                    </div>

                    <div class="nav-option option6">
                        <img src="../../../assets/media/image/settings.png"
                            class="nav-img"
                            alt="settings">
                        <a href="#"> Settings</a>
                    </div>

                    <div class="nav-option logout">
                        <img src="../../../assets/media/image/login.png"
                            class="nav-img"
                            alt="logout">
                        <a href="../auth/logout.php">Logout</a>
                    </div>

                </div>
            </nav>
        </div>

        <div class="main">

            <div class="searchbar2">
                <input type="text"
                    name=""
                    id=""
                    placeholder="Search">
                <div class="searchbtn">
                    <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210180758/Untitled-design-(28).png"
                        class="icn srchicn"
                        alt="search-button">
                </div>
            </div>

            <div class="box-container">
                <div class="box box1">
                    <div class="text">
                        <h2 class="topic-heading"><?php echo $totalTeachers ?></h2>
                        <h2 class="topic">ToTal Teacher</h2>
                    </div>

                    <img src="../../../assets/media/image/teacher white.png"
                        alt="visitors">
                </div>

                <div class="box box2">
                    <div class="text">
                        <h2 class="topic-heading"><?php echo $totalStudents  ?></h2>
                        <h2 class="topic">Total Student</h2>
                    </div>

                    <img src="../../../assets/media/image/students.png"
                        alt="recruiter">
                </div>

                <div class="box box3">
                    <div class="text">
                        <h2 class="topic-heading"><?php echo $totalCourses ?></h2>
                        <h2 class="topic">Total Course</h2>
                    </div>

                    <img src="../../../assets/media/image/coursewhite.png"
                        alt="candidate">
                </div>

                <div class="box box4">
                    <div class="text">
                        <h2 class="topic-heading">
                            <?php echo $totalVisitors ?>
                        </h2>
                        <h2 class="topic">Total Visitors</h2>
                    </div>

                    <img src="../../../assets/media/image/visiteur-white.png" alt="active">
                </div>
            </div>

            <div class="report-container">
                <div class="report-header">
                    <h1 class="recent-Articles">Recent Users</h1>
                </div>
                    <div class="table-wrapper">
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th class="t-op">UserName</th>
                                    <th class="t-op">Email</th>
                                    <th class="t-op">Role</th>
                                    <th class="t-op">account status</th>
                                    <th class="t-op"></th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php if (count($users) > 0): ?>
                                        <?php foreach ($users as $user): ?>
                                            <tr class="tr-style">
                                                <td class="output"><?php echo htmlspecialchars($user['username']); ?></td>
                                                <td class="output"><?php echo htmlspecialchars($user['email']); ?></td>
                                                <td class="output"><?php echo htmlspecialchars($user['role']); ?></td>
                                                <td class="output">
                                                <form method="POST" action="">
                                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                    <select name="new_status" class="account-status" id="accountStatus" onchange="submitStatus(this)">
                                                        <option value="Activated" data-color="green" <?php if ($user['account_status'] == 'Activated') echo 'selected'; ?>>Activated</option>
                                                        <option value="Not Activated" data-color="orange" <?php if ($user['account_status'] == 'Not Activated') echo 'selected'; ?>>Not Activated</option>
                                                        <option value="Suspended" data-color="red" <?php if ($user['account_status'] == 'Suspended') echo 'selected'; ?>>Suspended</option>
                                                        <option value="Deleted" data-color="gray" <?php if ($user['account_status'] == 'Deleted') echo 'selected'; ?>>Deleted</option>
                                                    </select>
                                                </form>
                                                </td> 
                                                <td>
                                                <form method="POST" action="./users/delete.php">
                                                    <input type="hidden" name="player_id" value="<?php echo $user['id']; ?>">
                                                    <button type="submit" class="delete-btn">
                                                        <img src="../../../assets/media/image/delete-icon.png" class="icon-output" alt="delete-icon">
                                                    </button>
                                                </form> 
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td>No users found.</td>
                                        </tr>
                                    <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../../assets/js/main.js"></script>
    
</body>

</html>
