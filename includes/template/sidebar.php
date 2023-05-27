  <div class="sidebar close">
    <!-- ========== Logo ============  -->
    <a href="#" class="logo-box">
      <img src="<?php echo $img; ?>favicon.png" alt="" srcset="" />
      <div class="right logo-name">
        <div class="logo_ ">
          <h2>المتجر</h2>
        </div>
        <h2 class="primary">الذكي</h2>
      </div>
    </a>
    <div class="toggle-sidebar">
      <i class="fa fa-caret-right" aria-hidden="true"></i>
    </div>

    <!-- ========== List ============  -->
    <ul class="sidebar-list">
      <li>
        <div class="title">
          <a href="index.php" class="link">
            <span class="icon">
              <i class="fa fa-home" aria-hidden="true"></i>
            </span>
            <h3 class="name">الرئيسية</h3>
          </a>
        </div>
        <div class="submenu">
          <a href="index.php" class="link submenu-title">الرئيسية</a>
        </div>
      </li>

      <li class="dropdown">
        <div class="title">
          <a href="#" class="link">
            <span class="icon">
              <i class="fas fa-tasks" aria-hidden="true"></i>
            </span>
            <h3 class="name">الأقسام</h3>
            <i class="fa fa-sort-down arrow" aria-hidden="true"></i>
          </a>
        </div>
        <div class="submenu">
          <a href="#" class="link submenu-title">الأقسام</a>
          <?php foreach (get_from_table("*", "categories", "", "", "ID", "ASC") as $cat) { ?>
            <a class="nav-link  active" aria-current="page" href="index.php?page-id=<?php echo $cat['ID'] . '&page-name=' . str_replace(" ", "-", $cat['Name']) ?>"><?php echo $cat['Name']; ?></a>
          <?php } ?>
        </div>
      </li>

      <?php if (isset($_SESSION["user_name"])) { ?>
        <li>
          <div class="title">
            <a href="newItem.php">
              <span class="icon">
                <i class="fa fa-tag" aria-hidden="true"></i>
              </span>
              <h3 class="name">منتج جديد</h3>
            </a>
          </div>
          <div class="submenu">
            <a href="newItem.php" class="link submenu-title">منتج جديد</a>
          </div>
        </li>
      <?php } ?>
    </ul>
    <ul class="sidebar-list">
      <li>
        <div class="title">
          <a href="logout.php" class="link">
            <span class="icon">
              <i class="fa fa-sign-out" aria-hidden="true"></i>
            </span>
            <h3 class="name">تسجيل الخروج</h3>
          </a>
        </div>
        <div class="submenu">
          <a href="logout.php" class="link submenu-title">تسجيل الخروج</a>
        </div>
      </li>
    </ul>
  </div>