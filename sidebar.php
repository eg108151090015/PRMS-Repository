<!-- Fixed Top Header -->
<nav class="navbar navbar-dark bg-custom fixed-top shadow">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Patient Record Management System</span>
    </div>
</nav>

<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-sidebar-custom"
     style="width: 250px; height: 93vh; position: fixed; margin-top: 50px;">

    <!-- Header -->
    <div class="text-center mb-2">
        <a href="admindash.php" class="text-decoration-none">
            <img src="pictures/logo_hospital.png" alt="Hospital Logo" width="120" height="120">
        </a>
    </div>

    <hr>

    <!-- Label Buttons -->
    <ul class="nav nav-pills flex-column mb-auto">

        <!-- Home/Dashboard -->
        <li class="nav-item">
            <a href="admindash.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) === 'admindash.php' ? 'active' : '' ?>">
                <i class="bi bi-house-door-fill me-2"></i> Home
            </a>
        </li>

        <!-- Patient Records -->
        <li class="nav-item dropdown position-relative content-dropdown">
            <a href="adminpatient.php" class="nav-link text-white d-flex justify-content-between align-items-center"
               id="patientDropdown">
                <span><i class="bi bi-table me-2"></i>Patient Records</span>
                <i class="bi bi-caret-down-fill"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow position-absolute"
                aria-labelledby="patientDropdown">
                <li><a class="dropdown-item" href="adminpatient.php">View Patients Lists</a></li>
                <li><a class="dropdown-item" href="adminpatient.php?add=true">Add Patients</a></li>
                <li><a class="dropdown-item" href="archivedpatient.php">Archived Patients</a></li>
            </ul>
        </li>

        <!-- Users -->
        <li class="nav-item dropdown position-relative content-dropdown">
            <a href="adminusers.php" class="nav-link text-white d-flex justify-content-between align-items-center"
               id="userDropdown">
                <span><i class="bi bi-people-fill me-2"></i>Users</span>
                <i class="bi bi-caret-down-fill"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow position-absolute"
                aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="adminusers.php">View Users</a></li>
                <li><a class="dropdown-item" href="adminusers.php?add=true">Add User</a></li>
                <li><a class="dropdown-item" href="archiveduser.php">Deactivated Users</a></li>
            </ul>
        </li>

        <!-- Reports -->
        <li>
            <a href="adminreports.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) === 'adminreports.php' ? 'active' : '' ?>">
                <i class="bi bi-clipboard-fill me-2"></i> Reports
            </a>
        </li>

        <!-- Logs -->
        <li>
            <a href="adminlogs.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) === 'adminlogs.php' ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-text me-2"></i> Logs
            </a>
        </li>

    </ul>
    <hr>

    <!-- Dropdown/Profile/Settings -->
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
           id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="pictures/profile.png" alt="" width="34" height="45" class="rounded-circle me-2">
            <strong><?php echo $_SESSION["name"]; ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="logout.php"
                   onclick="return confirm('Are you sure you want to logout?');">Sign out</a></li>
        </ul>
    </div>
</div>
