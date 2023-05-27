<div class="top header">

  <div class="middle">
    <div class="search">
      <input class="form-control" type=" text" placeholder="Search here">
      <i class="fa fa-search search" aria-hidden="true"></i>
    </div>
  </div>


  <?php if (isset($_SESSION["admin_name"])) {
    $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?  LIMIT 1");
    $stmt->execute(array($_SESSION['admin_id']));
    $info = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count > 0) {
  ?>
      <div class="left">
        <div class="buttons ">
          <ul class="view-setting">
            <li id="full-view"><i class="fa fa-maximize " aria-hidden="true"></i></li>
            <li id="full-view-exit"><i class="fa fa-minimize "></i></li>
          </ul>
          
          <div class="theme-toggler">
            <i class="fas fa-sun active"></i>
            <i class="fas fa-moon "></i>
          </div>

          <div class="notification-area">
            <!-- Notification bell -->
            <?php include 'notification.php' ?>
            <!-- notification ends -->
          </div>
        </div>
        <div class="profile">
          <div class="profile-photo">
            <a href='userProfile.php?userid=<?php echo $info['UserID'] ?>' class="username">
              <img src="<?php echo $avatars . $info["Avatar"]; ?>" alt="" />
            </a>
          </div>
        </div>

      </div>
  <?php
    }
  } ?>
</div>