<nav>
    <ul>
        <li><a href="../index.html">Home</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php elseif (isset($_SESSION['admin_id'])): ?>
            <li><a href="admin_dashboard.php">Admin Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="../login.html">Login</a></li>
            <li><a href="../register.html">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>
