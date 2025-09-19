<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    
    <title>Website Pendataan</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="..//images/9.png" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light">Welcome</div>
            <div class="list-group">
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="home.php?page=data-siswa">
                    <i class="bi bi-people-fill"></i> Data Siswa
                </a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="home.php?page=data-nilai">
                    <i class="bi bi-people-fill"></i> Data Nilai
                </a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="home.php?page=pelaporan">
                    <i class="bi bi-file-earmark-text-fill"></i> Pelaporan
                </a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../index.php">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">Toggle Menu</button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item active"><a class="nav-link" href="#!"></a></li>
                            <li class="nav-item"><a class="nav-link" href="#!"></a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#!"></a>
                                    <a class="dropdown-item" href="#!"></a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#!"></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Page content-->
            <div class="container-fluid">
                <?php 
                // Cek parameter 'page' dan include file yang sesuai
                if (isset($_GET['page'])) {
                    switch ($_GET['page']) {
                        case 'data-siswa':
                            include 'data-siswa.php';
                            break;
                        case 'data-nilai':
                            include 'data-nilai.php';
                            break;
                        case 'pelaporan': 
                            include 'pelaporan.php';
                            break; 
                        default:
                            include 'data-siswa.php'; // Halaman default jika tidak ada parameter 'page'
                    }   
                } else {
                    include 'data-siswa.php'; // Halaman default jika tidak ada parameter 'page'
                }  
                ?>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>
</html>
