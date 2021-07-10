<?php
// include '../../libs/session.php';
Session::checkSession();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>UDPT Admin</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo _PUBLIC ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="<?php echo _PUBLIC ?>/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo _PUBLIC ?>/css/admin.css">
    <link rel="stylesheet" href="<?php echo _PUBLIC ?>/css/custom_style.css">
    <script src="<?php echo _PUBLIC ?>/public/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo _PUBLIC ?>/js/admin-crud/function.js"></script>

    <style>
        /* Center the loader */
        #loader {
            border: 16px solid #f3f3f3;
            /* Light grey */
            border-top: 16px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
            text-align: center;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo _WEB_ROOT ?>/Home">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">UDPT Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo _WEB_ROOT ?>/Home">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Quản lý thông tin</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Danh sách bảng:</h6>
                        <a class="collapse-item" href="<?php echo _WEB_ROOT ?>/user_account/Read/1">Danh sách user</a>
                        <a class="collapse-item" href="<?php echo _WEB_ROOT ?>/Category/Read">Danh mục câu hỏi</a>
                        <a class="collapse-item" href="<?php echo _WEB_ROOT ?>/Label/Read">Nhãn câu hỏi</a>
                        <a class="collapse-item" href="<?php echo _WEB_ROOT ?>/Question/Read">Câu hỏi</a>
                        <a class="collapse-item" href="<?php echo _WEB_ROOT ?>/Answer/Read">Câu trả lời</a>
                        <a class="collapse-item" href="<?php echo _WEB_ROOT ?>/Notification/Read">Thông báo của tôi</a>


                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>

                    <span>Chức năng</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Utilities:</h6>
                        <a class="collapse-item" href="#addDanhMucCauHoiRecord" data-toggle="modal">Tạo danh mục câu hỏi</a>
                        <a class="collapse-item" href="#addNhanCauHoiRecord" data-toggle="modal">Tạo nhãn câu hỏi</a>

                    </div>
                </div>
            </li>



        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <!-- {{#section 'searchbar'}}
                    
                    {{/section}}
                    {{{_sections.searchbar}}} -->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a href="<?php echo _WEB_ROOT ?>/..">go to user</a>
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Hello, <?php echo Session::get("admin-name"); ?></span>
                                <img class="img-profile rounded-circle" src="<?php echo _PUBLIC ?>/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <form class="dropdown-item" method="POST" action="
                                    <?php
                                    if (Session::get("notification_yes")) {
                                        echo _WEB_ROOT . "/Notification/TurnOff";
                                    } else {
                                        echo _WEB_ROOT . "/Notification/TurnOn";
                                    }
                                    ?>
                                ">
                                    <input name="id_admin" value="<?php echo Session::get("admin-id") ?>" hidden=true />
                                    <?php
                                    if (Session::get("notification_yes")) {
                                    ?>
                                        <i class="fa fa-bell-slash" aria-hidden="true"></i>
                                        <button name="submitToggleFormBtn" style="padding: 5px; border: none; background: none;" type="submit"> Turn off notification</button>
                                    <?php
                                    } else { ?>
                                        <i class="fa fa-bell" aria-hidden="true"></i>
                                        <button name="submitToggleFormBtn" style="padding: 5px; border: none; background: none;" type="submit"> Turn on notification</button>
                                    <?php
                                    }
                                    ?>
                                </form>
                                <a class="dropdown-item" href="<?php echo _WEB_ROOT ?>/Home/ChangePassword">
                                    <i class="fa fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Change pasword
                                </a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>

                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div id="content">
                        <?php require_once   "./mvc/views/" . $data["View"] . ".php" ?>
                    </div>
                    <!-- {{{body}}} -->
                    <!-- end Page Content -->
                    <!-- Footer -->
                    <footer class="sticky-footer bg-white">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>Copyright &copy; Your Website 2020</span>
                            </div>
                        </div>
                    </footer>
                    <!-- End of Footer -->

                </div>
                <!-- End of Content Wrapper -->

            </div>
            <!-- End of Page Wrapper -->

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

            <!-- Logout Modal-->
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <a class="btn btn-primary" href="<?php echo _WEB_ROOT ?>/Login/Logout">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="addDanhMucCauHoiRecord" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="addForm2" method="POST" action="<?php echo _WEB_ROOT ?>/Category/Create">
                            <div class="modal-header">
                                <h4 class="modal-title">Thêm danh mục</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Tên: </label>
                                    <input name="id_admin" value="<?php echo Session::get("admin-id") ?>" type="text" class="form-control" hidden=true>
                                    <input name="cate_name" type="text" class="form-control" required maxlength="200">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                <input name="submitAddCategoryFormBtn" type="submit" class="btn btn-success" value="Add">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="addNhanCauHoiRecord" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="addForm2" method="POST" action="<?php echo _WEB_ROOT ?>/Label/Create">
                            <div class="modal-header">
                                <h4 class="modal-title">Thêm nhãn</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Tên: </label>
                                    <input name="id_admin" value="<?php echo Session::get("admin-id") ?>" type="text" class="form-control" hidden=true>
                                    <input name="label_description" type="text" class="form-control" required maxlength="200">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                <input name="submitAddLabelFormBtn" type="submit" class="btn btn-success" value="Add">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Bootstrap core JavaScript-->
            <script src="<?php echo _PUBLIC ?>/vendor/jquery/jquery.min.js"></script>
            <script src="<?php echo _PUBLIC ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="<?php echo _PUBLIC ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="<?php echo _PUBLIC ?>/js/sb-admin-2.min.js"></script>

</body>

</html>