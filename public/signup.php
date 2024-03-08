<?php
session_start();
require_once '../src/DBConnection.php';
require_once '../src/User.php';
$pdo = DBConnection::getConnection(); // Kết nối đến cơ sở dữ liệu


// Xử lý form đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userManager = new User($pdo);
    // Lấy dữ liệu từ form
    $password = $_POST['password'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $userManager->addUser($email, $password, $name, $address, $phone);
    echo "Đã thêm khách hàng";
    $_POST = array();
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        a {
            text-decoration: none;
        }

        .login-page {
            width: 100%;
            height: 100vh;
            display: inline-block;
            display: flex;
            align-items: center;
        }

        .form-right i {
            font-size: 100px;
        }
    </style>
</head>

<body>
    <div class="login-page bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <h3 class="mb-3">Đăng ký</h3>
                    <div class="bg-white shadow rounded">
                        <div class="row">
                            <div class="col-md-7 pe-0">
                                <div class="form-left h-100 py-5 px-5">
                                    <form method="post" action="./signup.php" class="row g-4">
                                        <div class="col-12">
                                            <label>Email<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
                                                <input type="text" name="email" class="form-control" placeholder="Enter Email" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label>Password<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                                                <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label>Tên<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <i class='bx bxs-edit'></i>
                                                </div>
                                                <input type="text" name="name" class="form-control" placeholder="Tên" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label>Địa chỉ<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="bx bx-home"></i></div>
                                                <input type="text" name="address" class="form-control" placeholder="Địa chỉ" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label>Số điện thoại<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="bi bi-phone"></i></div>
                                                <input type="phone" name="phone" class="form-control" placeholder="SĐT" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="inlineFormCheck">
                                                <!-- <label class="form-check-label" for="inlineFormCheck">Remember me</label> -->
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <a href="./login.php" class="float-end text-primary">Đăng nhập</a>
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" name="submit" class="btn btn-primary px-4 float-end mt-4">Đăng ký</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-5 ps-0 d-none d-md-block">
                                <div class="form-right h-100 bg-primary text-white text-center pt-5">
                                    <i class="bi bi-shop"></i>
                                    <h2 class="fs-1">Welcome!!!</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>


</body>

</html>