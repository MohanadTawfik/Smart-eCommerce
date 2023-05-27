<!DOCTYPE html>
<html lang="ar">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="icon" type="image/png" href="<?php echo $img; ?>favicon.png">


  <link rel="stylesheet" href="<?php echo $css; ?>all.min.css" />
  <link rel="stylesheet" href="<?php echo $css; ?>fontawesome.min.css" />
  <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo $css; ?>swiper-bundle.min.css" />
  <link rel="stylesheet" href="<?php echo $css; ?>style.css" />

  <!-- <link rel="stylesheet" href="https://fonts.googlepis.com/icon?family=Material+Icon+Sharp"> -->
  <title> <?php getTitle() ?> </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="dark-them-variables" dir="<?php echo $dir; ?>">

  <!-- preloader area start -->
  <!-- <div class="preloader">
    <div class="lds-ripple">
      <div class="lds-pos"></div>
      <div class="lds-pos"></div>
    </div>
  </div> -->
  <!-- preloader area end -->

  <div class="container">
    <div id="toast" class="toast show">
      <div class="toast-content">
        <i id="check" class="fa fa-solid check"></i>
        <div class="massage">
          <div id="text-title" class="text text-title"></div>
          <div id="text-massage" class="text text-massage"></div>
        </div>
      </div>
      <i id="close" class="fa fa-close close" aria-hidden="true"></i>
      <div class="progress"></div>
    </div>
  </div>