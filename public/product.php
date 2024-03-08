<?php
session_start();
require_once '../src/DBConnection.php';

require_once '../src/Product.php';
require_once '../src/User.php';

$pdo = DBConnection::getConnection(); // Kết nối đến cơ sở dữ liệu

$product_id = $_GET['product_id'];

$productManager = new Product($pdo);
$userManager = new User($pdo);
$products = $pdo->query("SELECT * FROM product ORDER BY RAND() LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

$product = $productManager->getProductByProductId($product_id);
$productListImg = $productManager->getProductImages($product_id);

// add_to_cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity =  intval($_POST['quantity']);
    if (isset($_SESSION['cart'])) {
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] == $product_id) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $_SESSION['cart'][] = array(
                'product_id' => $product_id,
                'quantity' => $quantity
            );
        }
    } else {
        $_SESSION['cart'][] = array(
            'product_id' => $product_id,
            'quantity' => $quantity
        );
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/main.css">

    <title>Trang chủ</title>
</head>

<body>
    <!-- Navbar -->
    <?php
    require '../partials/nabar.php';
    ?>
    <!-- End Navbar -->
    <main>
        <div class="top">
            <div class="container product">
                <div class="row product_detail ">
                    <div class="col-lg-6 product_detail_a">
                        <img src="<?php echo $product['img']; ?>" alt="">
                    </div>

                    <div class="col-lg-6 product_detail_b">
                        <h2 class="name">
                            <?php echo $product['productName']; ?>
                        </h2>
                        <h3 class="author">Studio:
                            <a href="search.php?keyword=<?php echo urlencode($product['studio']); ?>">
                                <?php echo $product['studio']; ?>
                            </a>
                        </h3>
                        <h4 class="price"><?php echo number_format($product['productPrice'], 0, '.', '.'); ?>đ</h4>

                        <h6 class="producCode">Thể loại: <?php echo $product['catalogName'] ?></h6>
                        <h6 class="scale">Tỷ lệ: <?php echo $product['scale'] ?></h6>
                        <h6>Số lượng:</h6>
                        <form action="product.php?product_id=<?= $product['product_id'] ?>" method="post">
                            <div class="quantity-selector">
                                <!-- <button class="btn btn-primary quantity-btn" onclick="decrement()">-</button> -->
                                <input type="number" class="form-control quantity-input" value="1" id="quantity" name="quantity">
                                <!-- <button class="btn btn-primary quantity-btn" onclick="increment()">+</button> -->
                            </div>
                            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                            <button type="submit" class="btn btn-primary" name="add_to_cart"><strong>Mua hàng</strong></button>
                        </form>
                        <ul class="product-list">
                            <li><i class="fa fa-truck"></i> Giao hàng nhanh toàn quốc <a href="#">Xem chi tiết</a></li>
                            <li><i class="fa fa-phone"></i> Tổng đài: 1900.9696.42 (9h00 - 21h00 mỗi ngày)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="bottom">
            <div class="container">
                <div class="row">
                    <!-- Info -->
                    <div class="col-lg-12 product-info">
                        <div class="product-info-btn">
                            <button type="button" class="description-button"><span>Hình ảnh sản phẩm</span></button>
                        </div>
                        <div class="product-info-img" style="color: black;">
                            <div id="description-content">
                                <?php foreach ($productListImg as $listImg) { ?>
                                    <img src="<?php echo $listImg['img_path']; ?>" alt="">
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <!-- Recomment -->
                    <div class="col-lg-12 product-recomment">
                        <div class="product-info-btn">
                            <button type="button" class="description-button"><span>Đề xuất</span></button>
                        </div>
                        <!-- Slide -->
                        <div class="product-recomment-slide">
                            <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php foreach ($products as $key => $product) : ?>
                                        <div class="carousel-item <?php echo $key === 0 ? 'active' : ''; ?>" data-bs-interval="5000">
                                            <div class="text-center">
                                                <div class="row">
                                                    <div class="col-lg-2 col-md-3 col-sm-6 card product">
                                                        <a href="./product.php?product_id=<?php echo $product['product_id']; ?>">
                                                            <div class="card-img">
                                                                <img src="<?php echo $product['img']; ?>" alt="">
                                                            </div>
                                                            <div class="card-info">
                                                                <p class="text-title productTitle"><?php echo $product['productName']; ?></p>
                                                            </div>
                                                        </a>
                                                        <div class="card-footer">
                                                            <span class="text-title"><?php echo number_format($product['productPrice'], 0, '.', '.'); ?>đ</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                        <!-- Slide End -->
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal" id="successModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thông báo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Sản phẩm đã được thêm vào giỏ hàng.
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php
    require '../partials/footer.php';
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../assets/js/main.js"></script>
    <script>
        let items = document.querySelectorAll('.carousel .carousel-item')

        items.forEach((el) => {
            const minPerSlide = 4
            let next = el.nextElementSibling
            for (var i = 1; i < minPerSlide; i++) {
                if (!next) {
                    // wrap carousel by using first child
                    next = items[0]
                }
                let cloneChild = next.cloneNode(true)
                el.appendChild(cloneChild.children[0])
                next = next.nextElementSibling
            }
        })
    </script>
</body>

</html>