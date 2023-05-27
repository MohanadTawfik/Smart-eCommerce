<?php
/*
================================================
== Manage members page 
== you can add | edit | delete members from here
================================================
*/
ob_start();
session_start();
$dir = 'rtl';
// error_reporting(0);
include 'init.php';
?>

<section class="home">
  <?php if (isset($_GET["page-id"]) && isset($_GET["page-name"]) && is_numeric($_GET['page-id'])) {
    $page_id = intval($_GET['page-id']);
    $page_name = $_GET['page-name'];
    $pageTitle = $_GET['page-name'];
    $items = get_from_table("*", "items", "WHERE Cat_ID = {$page_id} ", " AND Approve = 1", "Item_ID", "DESC");
  } else {
    $pageTitle = " كافة المنتجات ";
    $items = get_from_table('*', "items", "WHERE Approve =1", "", "Item_ID", 'DESC');
  } ?>

  <div class="title-date ">
    <h1 class="me-4"> <?php echo  $pageTitle ?> </h1>
    <div class="date">
      <?php echo Date("d-m-Y"); ?>
    </div>
  </div>
  <main>

    <div class="items-container">
      <?php
      if (!empty($items)) : ?>
        <?php foreach ($items as $item) : ?>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="hidden" name="Item_ID" value="<?php echo $item['Item_ID'] ?>">
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
                  <div class="stars">
                    <div class="star-inner"></div>
                  </div>
                  <p> <?php echo $item['Description'] ?></p>
                </div>
              </div>
              <div class="button">
                <div class="button-layer"></div>
                <button type="submit"> إضافة للسلة <i class="fas fa-shopping-cart"></i> </button>
              </div>
            </div>
          </form>
      <?php
        endforeach;
      endif;
      ?>
    </div>
  </main>
</section>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $itemid = $_POST['Item_ID'];

  // check if there is session items 

  if (!isset($_SESSION['userCart']) || (empty($_SESSION['userCart']))) {
    $sessionItems = array($itemid);
    $_SESSION['userCart'] = $sessionItems;
  } else {
    $sessionItems = $_SESSION['userCart'];
    array_push($sessionItems, $itemid);
    $_SESSION['userCart'] = $sessionItems;
  }

  header("location:index.php");
}

include $tpl . 'footer.php';
ob_end_flush();
