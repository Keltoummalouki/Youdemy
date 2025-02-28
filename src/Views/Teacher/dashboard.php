<?php
require_once '../../../vendor/autoload.php';

use App\Config\DatabaseConnexion;
use App\Services\SessionManager;

SessionManager::requireAuth();
$user = SessionManager::getUser();

$db = new DatabaseConnexion();
$conn = $db->connect();

$totalTeachers = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'Teacher'")->fetchColumn();
$totalStudents = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'Student'")->fetchColumn();
$totalCourses = $conn->query("SELECT COUNT(*) FROM courses WHERE user_id = " . $user['id'])->fetchColumn();
$totalVisitors = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();

$query = $conn->prepare("
    SELECT 
        c.id, 
        c.title, 
        c.description, 
        c.content AS contenu, 
        cat.category AS category_name,
        c.user_id AS teacher,
        u.username,
        GROUP_CONCAT(t.tag SEPARATOR ', ') AS tags
    FROM 
        COURSES c
    LEFT JOIN 
        CATEGORY cat ON cat.id = c.category_id
    LEFT JOIN 
        USERS u ON u.id = c.user_id
    LEFT JOIN 
        CourseTag ct ON c.id = ct.course_id
    LEFT JOIN 
        TAGS t ON ct.tag_id = t.id
    WHERE 
        c.user_id = :user_id
    GROUP BY 
        c.id, c.title, c.description, c.content, cat.category, c.user_id, u.username
    ORDER BY 
        c.title
");

$query->execute(['user_id' => $user['id']]);
$courses = $query->fetchAll(PDO::FETCH_ASSOC);
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
                    <a href="./src/Views/auth/login.php"><img src="../../../assets/media/image/Profil.png" class="dpicn"></a>
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
                        <a href="./dashboard.php">Dashboard</a>
                    </div>

                    <div class="nav-option option5">
                        <img src="../../../assets/media/image/report.png"
                            class="nav-img"
                            alt="raport">
                        <h3> Report</h3>
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
                    <h1 class="recent-Articles">Recent Course</h1>
                    <div>
                    
                    <button id="add-btn"><a href="./add.php">Add</a></button>

                    </div>
                </div>
                    <div class="table-wrapper">
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th class="t-op">Title</th>
                                    <th class="t-op">Description</th>
                                    <th class="t-op">Content</th>
                                    <th class="t-op">Category</th>
                                    <th class="t-op">tag</th>
                                    <th class="t-op"></th>
                                    <th class="t-op"></th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php if (count($courses) > 0): ?>
                                        <?php foreach ($courses as $course): ?>
                                            <tr class="tr-style">
                                                <td class="output"><?php echo htmlspecialchars($course['title']); ?></td>
                                                <td class="output"><?php echo htmlspecialchars($course['description']); ?></td>
                                                <td class="output"><?php echo htmlspecialchars($course['contenu']); ?></td>
                                                <td class="output"><?php echo htmlspecialchars($course['category_name']); ?></td>
                                                <td class="output"><?php echo htmlspecialchars($course['tags']); ?></td>
                                                <td>
                                                <a href="./update.php?id=<?php echo $course['id']; ?>">
                                                    <button type="submit" class="edit-btn">
                                                        <img src="../../../assets/media/image/edit-button.png" class="icon-output" alt="edit-icon">
                                                    </button>
                                                </a>
                                            </td>
                                            <td>
                                            <form method="POST" action="./delete.php">
                                            <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                            <button type="submit" class="delete-btn">
                                                <img src="../../../assets/media/image/delete-icon.png" class="icon-output" alt="delete-icon">
                                            </button>
                                        </form>
                                            </td> 
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8">No courses found.</td>
                                        </tr>
                                    <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
