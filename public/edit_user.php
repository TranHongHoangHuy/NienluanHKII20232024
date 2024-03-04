<?php
require_once '../src/DBConnection.php';
require_once '../src/User.php';

$user_id = $_POST['user_id'];
$pdo = DBConnection::getConnection(); // Kết nối đến cơ sở dữ liệu
$userManager = new User($pdo);
$users = $userManager->getUserByUserId($user_id);

if (isset($_POST['submit'])) {
    $userManager->updateUser($user_id, $_POST);
    header('Location: ./show_user.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
require '../partials/header_admin.php';
?>

<body>
    <!-- Sidebar -->
    <?php
    require '../partials/sidebar_admin.php';
    ?>
    <!-- End of Sidebar -->

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <?php
        require '../partials/navbar_admin.php';
        ?>
        <!-- End of Navbar -->
        <main>
            <div class="header">
                <div class="left">
                    <h1>Khách hàng</h1>
                </div>
            </div>
            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Chỉnh sửa thông tin</h3>
                    </div>
                    <div class="container">
                        <form method="post" action="">
                            <div class="form-group" style="display:none;">
                                <label for="user_id">user_id</label>
                                <input type="text" class="form-control" id="user_id" name="user_id" value="<?= htmlspecialchars($users['user_id']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="name">Tên khách hàng</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($users['name']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="name">Tên đăng nhập</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($users['username']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($users['email']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="address">Địa chỉ</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($users['address']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="phone">Số điện thoại</label>
                                <input type="tel" class="form-control" pattern="[0-9]{10}" id="phone" name="phone" value="<?= htmlspecialchars($users['phone']) ?>">
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary mt-2">Sửa thông tin</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="../assets/js/admin_dash_board.js"></script>
    <script>
        document.title = "Khách hàng";
    </script>
</body>

</html>