<div class="top header">
  <div class="middle">
    <div class="search">
      <input class="form-control" type=" text" placeholder="Search here">
      <i class="fa fa-search search" aria-hidden="true"></i>
    </div>

  </div>


  <?php if (isset($_SESSION["user_name"])) {
    $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?  LIMIT 1");
    $stmt->execute(array($_SESSION['ID']));
    $info = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count > 0) {
  ?>
      <div class="left">
        <div class="profile">
          <div class="buttons ">
            <div class="theme-toggler">
              <i class="fas fa-sun active"></i>
              <i class="fas fa-moon "></i>
            </div>

            
            <div class="cart-area">
              <a href="userCart.php">
                <i class="fa fa-shopping-cart ">
                  <span class="translate-middle badge bg-danger ">
                    <?php
                    echo ((isset($_SESSION["user_name"])) && (!empty($_SESSION['userCart']))) ? count($_SESSION['userCart']) : "0";
                    ?>
                  </span>
                </i>
              </a>
            </div>


            <div class="notification-area">
              <!-- Notification bell -->
              <?php include 'notification.php' ?>
              <!-- notification ends -->
            </div>

          </div>
        </div>
        <div class="profile-photo">
          <a href='userProfile.php?userid=<?php echo $_SESSION['ID'] ?>' class="username">
            <img src="<?php echo $avatars; ?><?php echo (!empty($info["Avatar"])) ? $info["Avatar"] : "user.ico"; ?>" alt="" />
          </a>
        </div>
      </div>
    <?php
    }
  } else { ?>

    <div class="buttons">
      <a class="btn-login show-tittle" href="login.php" my_tittle="تسجيل الدخول">
        <span id="login_button">
          <i class="fas fa-right-to-bracket"></i>
          تسجيل الدخول
        </span>
      </a>
    </div>
  <?php } ?>

</div>