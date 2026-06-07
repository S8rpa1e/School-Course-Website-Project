<?php
// Database connection
$host = "localhost";
$dbname = "online_leerplatform";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Pagination settings
$courses_per_page = 16; // 4 columns x 4 rows
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Search query
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build query
if (!empty($search)) {
    $count_stmt = $pdo->prepare("SELECT COUNT(*) FROM courses c JOIN teachers t ON c.teacher_id = t.teacher_id JOIN users u ON t.user_id = u.user_id WHERE c.title LIKE :search OR c.description LIKE :search");
    $count_stmt->execute([':search' => '%' . $search . '%']);
} else {
    $count_stmt = $pdo->query("SELECT COUNT(*) FROM courses c JOIN teachers t ON c.teacher_id = t.teacher_id JOIN users u ON t.user_id = u.user_id");
}
$total_courses = $count_stmt->fetchColumn();
$total_pages = max(1, ceil($total_courses / $courses_per_page));
if ($page > $total_pages) $page = $total_pages;
$offset = ($page - 1) * $courses_per_page;

// Fetch courses
if (!empty($search)) {
    $stmt = $pdo->prepare("
        SELECT c.course_id, c.title, c.description, c.created_at, u.full_name AS teacher_name,
               (SELECT COUNT(*) FROM enrollments e WHERE e.course_id = c.course_id) AS enrollment_count,
               (SELECT COUNT(*) FROM lessons l WHERE l.course_id = c.course_id) AS lesson_count
        FROM courses c
        JOIN teachers t ON c.teacher_id = t.teacher_id
        JOIN users u ON t.user_id = u.user_id
        WHERE c.title LIKE :search OR c.description LIKE :search
        ORDER BY c.created_at DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
} else {
    $stmt = $pdo->prepare("
        SELECT c.course_id, c.title, c.description, c.created_at, u.full_name AS teacher_name,
               (SELECT COUNT(*) FROM enrollments e WHERE e.course_id = c.course_id) AS enrollment_count,
               (SELECT COUNT(*) FROM lessons l WHERE l.course_id = c.course_id) AS lesson_count
        FROM courses c
        JOIN teachers t ON c.teacher_id = t.teacher_id
        JOIN users u ON t.user_id = u.user_id
        ORDER BY c.created_at DESC
        LIMIT :limit OFFSET :offset
    ");
}
$stmt->bindValue(':limit', $courses_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Build pagination URL helper
function pagUrl($p, $search) {
    $url = "courses.php?page=" . $p;
    if (!empty($search)) $url .= "&search=" . urlencode($search);
    return $url;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Courses</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="courses.css">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body>

<!-- Navigation (same as index) -->
<div class="Navigation">
    <ul>
        <li><a href="index.php">Explore</a></li>
        <li>
            <form class="SearchBar" action="courses.php" method="GET">
                <input type="text" name="search" placeholder="Search courses..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="search-btn">Search</button>
            </form>
        </li>
        <li id="AboutLink"><a href="#">About</a></li>
        <li id="LoginButton"><button>Login</button></li>
    </ul>
</div>

<!-- Page Header -->
<div class="courses-header">
    <div class="courses-header-inner">
        <?php if (!empty($search)): ?>
            <h1 class="courses-title">Results for <span class="highlight">"<?= htmlspecialchars($search) ?>"</span></h1>
            <p class="courses-subtitle"><?= $total_courses ?> course<?= $total_courses !== 1 ? 's' : '' ?> found</p>
        <?php else: ?>
            <h1 class="courses-title">Explore <span class="highlight">All Courses</span></h1>
            <p class="courses-subtitle"><?= $total_courses ?> courses available — start learning today</p>
        <?php endif; ?>
    </div>
</div>

<!-- Courses Grid -->
<div class="courses-container">

    <?php if (empty($courses)): ?>
        <div class="no-results">
            <div class="no-results-icon">🔍</div>
            <h2>No courses found</h2>
            <p>Try searching with different keywords.</p>
            <a href="courses.php" class="btn-primary">Browse all courses</a>
        </div>
    <?php else: ?>

        <div class="courses-grid">
            <?php foreach ($courses as $course): ?>
                <div class="course-card">
                    <div class="course-card-accent"></div>
                    <div class="course-card-body">
                        <div class="course-tag">Course</div>
                        <h3 class="course-card-title"><?= htmlspecialchars($course['title']) ?></h3>
                        <p class="course-card-desc"><?= htmlspecialchars($course['description'] ?? 'No description available.') ?></p>
                        <div class="course-card-meta">
                            <span class="meta-teacher">👤 <?= htmlspecialchars($course['teacher_name']) ?></span>
                            <span class="meta-lessons">📖 <?= $course['lesson_count'] ?> lessons</span>
                            <span class="meta-students">🎓 <?= $course['enrollment_count'] ?> students</span>
                        </div>
                    </div>
                    <div class="course-card-footer">
                        <a href="course_detail.php?id=<?= $course['course_id'] ?>" class="btn-enroll">View Course</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="<?= pagUrl(1, $search) ?>" class="page-btn page-edge" title="First">«</a>
                <a href="<?= pagUrl($page - 1, $search) ?>" class="page-btn" title="Previous">‹</a>
            <?php endif; ?>

            <?php
            $range = 2;
            $start = max(1, $page - $range);
            $end   = min($total_pages, $page + $range);
            if ($start > 1) echo '<span class="page-ellipsis">…</span>';
            for ($i = $start; $i <= $end; $i++):
            ?>
                <a href="<?= pagUrl($i, $search) ?>" class="page-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
            <?php if ($end < $total_pages) echo '<span class="page-ellipsis">…</span>'; ?>

            <?php if ($page < $total_pages): ?>
                <a href="<?= pagUrl($page + 1, $search) ?>" class="page-btn" title="Next">›</a>
                <a href="<?= pagUrl($total_pages, $search) ?>" class="page-btn page-edge" title="Last">»</a>
            <?php endif; ?>

            <span class="page-info">Page <?= $page ?> of <?= $total_pages ?></span>
        </div>
        <?php endif; ?>

    <?php endif; ?>
</div>

</body>
</html>
