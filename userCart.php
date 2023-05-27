<?php

ob_start();
session_start();
$dir = 'rtl';

// error_reporting(0);

if (!isset($_SESSION['userCart']) && (!isset($_SESSION["user_name"]))) {
    header("location:index.php");
    exit(0);
} else {

    $pageTitle = " سلة " . $_SESSION["user_name"];

    include 'init.php';
?>

    <section class="home">

        <div class="title-date ">
            <h1 class="me-4">السعر الكلي </h1>
            <h2 class="date">
                <span class="price">0</span><span class="warning">$</span>
            </h2>
        </div>
        <main>
            <?php
            if (!empty($_SESSION['userCart'])) {
                $carts = $_SESSION['userCart'];
            ?>
                <div class="items-container">
                    <?php foreach ($carts as $cart) {
                        $item = get_one_from_table("*", "items", "WHERE Item_ID={$cart}", "AND Approve = 1", "Item_ID", "DESC");
                        if (!empty($item)) {
                    ?>
                            <div class="product-card" id="item<?php echo $item['Item_ID'] ?>" rating="<?php echo $item['Rating'] ?>">
                                <div class="logo-cart">
                                    <img src="<?php echo $itemImg; ?><?php echo (!empty($item["Image"])) ? $item["Image"] : "img.png"; ?>" alt="logo">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                </div>
                                <div class="main-images">
                                    <img src="<?php echo $itemImg; ?><?php echo (!empty($item["Image"])) ? $item["Image"] : "img.png"; ?>">
                                </div>
                                <div class="shoe-details">
                                    <div class="details">
                                        <span class="shoe_name"> <?php echo $item['Name'] ?></span>
                                        <span class="price_num"><?php echo $item['Price']; ?></span>
                                    </div>
                                    <div class="price">
                                        <p style="width:50%;" for="number">عدد المنتجات :</p>
                                        <input price="<?php echo $item['Price']; ?>" type="number" name="number" id="number" value="0">
                                    </div>
                                </div>
                                <div class="button">
                                    <div class="button-layer"></div>
                                    <button>شراء <i class="fas fa-shopping-cart"></i> </button>
                                </div>
                            </div>
                    <?php  }
                    } ?>
                </div>
            <?php  } else { ?>
                <div class="container text-center mt-5">
                    <span class="alert alert-info"> لا توجد منتجات في سلتك</span>
                </div>
            <?php  } ?>

        </main>
    </section>

<?php
}
include $tpl . 'footer.php';
?>