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
          <a href="dashboard.php" class="link">
            <span class="icon">
              <i class="fa fa-dashboard" aria-hidden="true"></i>
            </span>
            <h3 class="name">لوحة التحكم</h3>
          </a>
        </div>
        <div class="submenu">
          <a href="dashboard.php" class="link submenu-title">لوحة التحكم</a>
        </div>
      </li>

      <li class="dropdown">
        <div class="title">
          <a class="link">
            <span class="icon">
              <i class="fas fa-tasks" aria-hidden="true"></i>
            </span>
            <h3 class="name">الأقسام</h3>
            <i class="fa fa-sort-down arrow" aria-hidden="true"></i>
          </a>
        </div>
        <div class="submenu">
          <a href="categories.php" class="link submenu-title"> إدارة الأقسام</a>
          <a href="categories.php?do=add" class="link">إضافة قسم </a>
        </div>
      </li>


      <li class="dropdown">
        <div class="title">
          <a class="link">
            <span class="icon">
              <i class="fa fa-tags" aria-hidden="true"></i>
            </span>
            <h3 class="name">المنتجات</h3>
            <i class="fa fa-sort-down arrow" aria-hidden="true"></i>
          </a>
        </div>
        <div class="submenu">
          <a href="items.php" class="link submenu-title"> إدارة المنتجات</a>
          <a href="items.php?do=manage&page=active" class="link"> المنتجات المفعلة</a>
          <a href="items.php?do=manage&page=pending" class="link"> المنتجات الغير مفعلة</a>
          <a href="items.php?do=add" class="link">إضافة منتج </a>
        </div>
      </li>


      <li class="dropdown">
        <div class="title">
          <a class="link">
            <span class="icon">
              <i class="fa fa-users" aria-hidden="true"></i>
            </span>
            <h3 class="name">المستخدمين</h3>
            <i class="fa fa-sort-down arrow" aria-hidden="true"></i>
          </a>
        </div>
        <div class="submenu">
          <a href="members.php" class="link submenu-title"> إدارة المستخدمين</a>
          <a href="members.php?do=manage&page=active" class="link"> المستخدمين المفعلين</a>
          <a href="members.php?do=manage&page=pending" class="link"> المستخدمين الغير مفعلين</a>
          <a href="members.php?do=add" class="link">إضافة مستخدم </a>
        </div>
      </li>

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
          <a href="#" class="link submenu-title">تسجيل الخروج</a>
        </div>
      </li>
    </ul>
  </div>