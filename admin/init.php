<?php

// Routes 
$tpl = 'includes/template/'; // templates directory
$lng = 'includes/languages/'; // languages directory
$func = 'includes/functions/'; // functions directory
$css = 'layout/css/'; // css directory
$js = 'layout/js/'; // js directory
$img = 'layout/images/'; // js directory
$itemImg = '../data/uploads/itemsPhoto/'; // js directory
$avatars = '../data/uploads/avatars/'; // js directory


include $tpl . 'connect.php';

// include the important
include $func . 'function.php';
// include $lng . 'english.php';
// include $lng . 'arabic.php';
include $tpl . 'header.php';

if (!isset($no_head_and_nav)) {
?>
  <div class="grid-container ">
  <?php
  // include navbar on all pages except the one with $noNavbar variable
  include $tpl . 'headerbar.php';
  include $tpl . "sidebar.php";
}
  ?>