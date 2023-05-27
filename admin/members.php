<?php
ob_start();
session_start();
$pageTitle = "ادارة المستخدمين ";
$dir = 'rtl';
$noNavbar = "";
// error_reporting(0);
if ((!isset($_SESSION["admin_name"])) && (!isset($_SESSION['role'])) && ($_SESSION['role'] != 1)) {
  header("location:index.php");
  exit();
}
include 'init.php'; ?>


<!-- ============= Home Section =============== -->

<section class="home">
  <!-- ==================== START MAIN ==================== -->
  <div class="title-date ">
    <h1 class="me-4">إدارة المستخدمين</h1>
    <div class="date">
      <?php echo Date("d-m-Y"); ?>
      <!-- <input type="date" dir="ltr" value="2023-Apr-02" /> -->
    </div>
  </div>
  <main>


    <div class="insights">
      <div class="sales">
        <a href="members.php?do=manage">
          <i class="fa fa-bar-chart" aria-hidden="true"></i>
          <div class="middle">
            <div class="left">
              <h3>كافة المستخدمين</h3>
              <h1><?php echo countItems("UserID", "users") ?></h1>
            </div>
            <div class="my-progress">
              <div class="circular-progress">
                <span class="progress-value"><?php echo countItems("UserID", "users") ?></span>
              </div>
            </div>
          </div>
          <small class="text-muted">Last 24 Hours</small>
        </a>
      </div>
      <!-- ----------------------- END SALES ----------------------- -->
      <div class="expanses">
        <a href="members.php?do=manage&page=pending">
          <i class="fa fa-bar-chart" aria-hidden="true"></i>
          <div class="middle">
            <div class="left">
              <h3>المستخدمين الغير مفعلين</h3>
              <h1><?php echo count_fields("UserID", "users", "WHERE RegStatus = 0"); ?></h1>
            </div>
            <div class="my-progress">
              <div class="circular-progress">
                <span class="progress-value"><?php echo count_fields("UserID", "users", "WHERE RegStatus = 0"); ?></span>
              </div>
            </div>
          </div>
          <small class="text-muted">Last 24 Hours</small>
        </a>
      </div>
      <!-- ----------------------- END EXPENSES ----------------------- -->
      <div class="income">
        <a href="members.php?do=manage&page=active">
          <i class="fa fa-bar-chart" aria-hidden="true"></i>
          <div class="middle">
            <div class="middle">
              <div class="left">
                <h3>المستخدمين المفعلين</h3>
                <h1><?php echo count_fields("UserID", "users", "WHERE RegStatus = 1"); ?></h1>
              </div>
              <div class="my-progress">
                <div class="circular-progress">
                  <span class="progress-value"><?php echo count_fields("UserID", "users", "WHERE RegStatus = 1"); ?></span>
                </div>
              </div>
            </div>
          </div>
          <small class="text-muted">Last 24 Hours</small>
        </a>
      </div>
      <!-- ----------------------- END INCOME ----------------------- -->
    </div>
    <!-- ----------------------- END INSIGHTS ----------------------- -->
    <div class="recent-orders">
      <a href="members.php?do=add" class="btn btn-primary col-lg-6 col-md-6 col-sm-8"><i class="fa fa-plus"></i> عضو جديد</a>
      <?php
      // start member page 
      $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
      if ($do == "manage") { // manage page

        // latest Registered Users
        $query = "";

        if (isset($_GET["page"])) {
          if ($_GET["page"] == "pending") {
            $query = "AND RegStatus = 0";
          } else if ($_GET["page"] == "active") {
            $query = "AND RegStatus = 1";
          }
        }

        $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query  ");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        if (!empty($rows)) {
      ?>

          <div class="row mb-2">
            <h2 class=" d-flex align-items-center"> آخر المستخدمين </h2>

          </div>
          <table class="data_table table table-responsive">
            <thead>
              <tr>
                <th>ID</th>
                <th></th>
                <th>إسم المستخدم</th>
                <th>الاسم الكامل</th>
                <th>الإيميل</th>
                <th>تاريخ التسجيل</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($rows as $row) { ?>
                <tr>
                  <td> <?php echo $row["UserID"] ?></td>
                  <td>
                    <a href='userProfile.php?userid=<?php echo $row["UserID"] ?>' class="username">
                      <div class="image">
                        <img src="<?php echo $avatars . $row["Avatar"]; ?>">
                      </div>
                    </a>
                  </td>
                  <td class="<?php echo ($row['RegStatus'] == 0) ? 'danger' : ' success';  ?>"><?php echo $row["Username"] ?> </td>
                  <td> <?php echo $row["FullName"] ?></td>
                  <td> <?php echo $row["UserEmail"] ?></td>
                  <td> <?php echo $row["Date"] ?></td>
                  <td class="primary">
                    <span class=" control d-flex gap-2">
                      <a href='members.php?do=edit&userid=<?php echo $row["UserID"] ?>' class='show-tittle round' my_tittle="تعديل الحساب"><i class='fa fa-edit success'></i></a>
                      <a href='members.php?do=delete&userid=<?php echo $row["UserID"] ?>' class='show-tittle confirm round ' my_tittle="حذف الحساب"><i class='fa fa-trash danger'></i></a>
                      <?php if ($row['RegStatus'] == 0) { ?>
                        <a href='members.php?do=active&userid=<?php echo $row["UserID"] ?>' class='show-tittle round ' my_tittle="تفعيل الحساب"><i class='fa fa-check success'></i></a>
                      <?php } else { ?>
                        <a href='members.php?do=disactive&userid=<?php echo $row["UserID"] ?>' class='show-tittle round ' my_tittle="الغاء تفعيل الحساب"><i class='fa fa-close danger'></i></a>
                      <?php } ?>
                    </span>
                  </td>
                </tr>
              <?php } ?>

            </tbody>
          </table>
        <?php
        } ?>
    </div>
  </main>
  <!-- ==================== END MAIN ==================== -->

  <!-- ==================== END LEFT ==================== -->
<?php
      } elseif ($do == "add") { // add page 
?>
  <h1 class="text-center mb-4">إضافة عضو جديد</h1>
  <div class="container">
    <form class="from-horizontal" action="?do=insert" method="POST" enctype="multipart/form-data">
      <div class="mb-3 row ">
        <label for="username">إسم المستخدم </label>
        <div class=" input-container ">
          <input type="text" name="username" class="form-control " id="username" autocomplete="off" placeholder="اسم المستخدم للدخول للمتجر">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="password">كلمة المرور</label>
        <div class=" input-container  ">
          <input type="password" name="Password" class="password form-control" id="password" autocomplete="new-password" placeholder="كلمة المرور ينبغي ان تكون صعبه">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="email">الإيميل</label>
        <div class=" input-container ">
          <input type="email" name="email" class="form-control" id="email" placeholder="الإيميل يجب ان يكون صحيح">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="full">الإسم الكامل</label>
        <div class=" input-container ">
          <input type="text" name="full" class="form-control" id="full" placeholder="الإسم الكامل للعرض في صفحة البرفايل ">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="avatar">الصورة</label>
        <div class=" input-container ">
          <input type="file" name="avatar" class="form-control" id="avatar" required>
        </div>
      </div>
      <div class="row">
        <span></span>
        <div class="input-container ">
          <button type="submit" class="btn btn-primary mb-3"> حفظ <i class="fa fa-save"></i> </button>
        </div>
      </div>
    </form>
  </div>
  <?php

      } elseif ($do == "insert") { // insert page 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  ?>
    <h1 class="text-center mb-4">إضافة المستخدمين</h1>
    <div class="container">
    <?php

          // get variables from from
          $user   = $_POST['username'];
          $pass     = $_POST['Password'];
          $email  = $_POST['email'];
          $full   = $_POST['full'];

          // Uploads Variable
          $avatar_name = $_FILES['avatar']['name'];
          $avatar_type = $_FILES['avatar']['type'];
          $avatar_tmp = $_FILES['avatar']['tmp_name'];
          $avatar_size = $_FILES['avatar']['size'];

          // list of allowed extension to upload
          $allowed_extension = ["jpeg", "jpg", "png", "gif", "ico"];

          // get avatar extension
          // $avatar_extension = strtolower(end(explode('.', $avatar_name)));
          $avatar_extension = pathinfo($avatar_name, PATHINFO_EXTENSION);

          // password trick
          $hashPass = sha1($_POST['Password']);

          // validate the form 
          $formErrors = [];
          if (empty($user)) {
            $formErrors[] = 'اسم المستخدم يجب الا يكون  <b>فارغا</b>';
          }
          if (empty($email)) {
            $formErrors[] = 'الإيميل يجب الا يكون  <b>فارغا</b>';
          }
          if (empty($full)) {
            $formErrors[] = 'الاسم الكامل يجب الا يكون  <b>فارغا</b>';
          }
          if (strlen($user) < 4) {
            $formErrors[] = 'اسم المستخدم يجب الا يكون  <b> اقل من 4 احرف </b>';
          }
          if (strlen($user) > 20) {
            $formErrors[] = 'اسم المستخدم يجب الا يكون  <b> اكبر من 20 حرف </b>';
          }

          if (empty($avatar_name)) {
            $formErrors[] = 'الصورة  <b> مطلوبة</b>';
          }

          if (!empty($avatar_name) && !in_array($avatar_extension, $allowed_extension)) {
            $formErrors[] = 'هذه الصيفة <b> غير مسموح بها</b>';
          }

          if ($avatar_size > 4194304) { // 4MB
            $formErrors[] = "الحجم لا يجب ان يكون اكبر من <b>4MB</b>";
          }

          foreach ($formErrors as $error) {
            if (!empty($error))
              echo  "<div class ='alert alert-danger' role='alert'>$error</div>";
          }

          // check if no error 
          if (empty($formError)) {
            $avatar = rand(0, 100000000000) . '_' . $avatar_name;
            move_uploaded_file($avatar_tmp, $avatars . $avatar);


            // check if user exist in database
            $check = checkItem("Username", 'users', $user);
            if ($check == 0) {
              // insert user info to database 
              $stmt = $con->prepare("INSERT INTO users(Username, `password`, UserEmail, FUllName, RegStatus, `Date`, Avatar) VALUES(:userV, :passV ,:emailV, :fullV, 1,now(), :avatarV)");
              $stmt->execute(array('userV' => $user, 'passV' => $hashPass, 'emailV' => $email, 'fullV' => $full, 'avatarV' => $avatar));
              if ($stmt) {
                redirectHome("success", "تم إضافة البيانات بنجاح", "members.php");
              }
            } else {
              redirectHome("warning", "عذراَ هذا المستحدم غير موجود", "members.php");
            }
          }
        } else {
          redirectHome("danger", "عذراَ لا يمكنك الوصول المباشر لهذه الصفحة", "members.php");
        }

    ?>
    </div>
    <?php

      } elseif ($do == "edit") { // edit page 

        // check if get request userid is numeric & get the integer value of it
        $userid = (isset($_GET["userid"]) && is_numeric($_GET["userid"])) ? intval($_GET['userid']) : 0;;
        $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?  LIMIT 1");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) {
    ?>
      <h1 class="text-center mb-4"> تعديل البيانات </h1>
      <div class="container ">

        <form class="from-horizontal ms-auto me-auto" action="?do=update" method="POST">
          <input type="hidden" name="userid" value="<?php echo $userid; ?>">
          <div class="mb-3 row">
            <label for="username">إسم المستخدم</label>
            <div class="input-container ">
              <input type="text" name="username" value="<?php echo $row["Username"]; ?>" class="form-control" id="username" autocomplete="off" required pattern="[A-z]*">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="password">كلمة المرور</label>
            <div class="input-container  ">
              <input type="hidden" name="oldPassword" value="<?php echo $row["password"]; ?>">
              <input type="password" name="newPassword" class="form-control" id="password" autocomplete="new-password" pattern="[A-z-0-9-@-_-$]*" placeholder="إتركه فارغا اذا كنت لا تريد التغيير ">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="email">الإيميل</label>
            <div class="input-container ">
              <input type="email" name="email" value="<?php echo $row["UserEmail"]; ?>" class="form-control" id="email" required>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="full">الإسم الكامل</label>
            <div class="input-container ">
              <input type="text" name="full" value="<?php echo $row["FullName"]; ?>" class="form-control" id="full" required>
            </div>
          </div>
          <div class="row">
            <span></span>
            <div class="input-container ">
              <button type="submit" class="btn btn-primary mb-3"> حفظ <i class="fa fa-save"></i> </button>
            </div>
          </div>
        </form>
      </div>
    <?php

        } else {
          redirectHome("waring", "عذراَ هذا المستحدم غير موجود", "members.php");
        }
      } elseif ($do == "update") { // update page 
    ?>
    <div class="container">
      <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          // get variables from from
          $id     = $_POST['userid'];
          $user   = $_POST['username'];
          $email  = $_POST['email'];
          $full   = $_POST['full'];

          // password trick
          $pass = (empty($_POST['newPassword'])) ? $_POST['oldPassword'] : sha1($_POST['newPassword']);

          // validate the form 
          $formErrors = [];
          if (empty($user)) {
            $formErrors[] = 'اسم المستخدم يجب الا يكون  <b>فارغا</b>';
          }
          if (empty($email)) {
            $formErrors[] = 'الإيميل يجب الا يكون  <b>فارغا</b>';
          }
          if (empty($full)) {
            $formErrors[] = 'الاسم الكامل يجب الا يكون  <b>فارغا</b>';
          }
          if (strlen($user) < 4) {
            $formErrors[] = 'اسم المستخدم يجب الا يكون  <b> اقل من 4 احرف </b>';
          }
          if (strlen($user) > 20) {
            $formErrors[] = 'اسم المستخدم يجب الا يكون  <b> اكبر من 20 حرف </b>';
          }

          foreach ($formErrors as $error) {
            if (!empty($error)) {
              redirectHome('warning', $error, "members.php");
            }
          }

          // check if no error 
          if (empty($formError)) {
            $stmt2 = $con->prepare("SELECT * FROM users WHERE Username =? AND UserID !=?");
            $stmt2->execute(array($user, $id));
            if ($stmt2->rowCount() == 1) {
              redirectHome("warning", "عذراَ هذا المستحدم موجود مسبقا", "members.php");
            } else {
              // update database with this info
              $stmt = $con->prepare("UPDATE users SET Username = ? , UserEmail = ? , FUllName = ?, `password` = ? WHERE UserID = ?");
              $stmt->execute(array($user, $email, $full, $pass, $id));
              if ($stmt) {
                redirectHome("success", "تم تحديث البيانات بنجاح ", "members.php");
              }
            }
          }
        } else {
          redirectHome("danger", "عذراَ لا يمكنك الوصول المباشر لهذه الصفحة", "members.php");
        } ?>
    </div>
  <?php
      } elseif ($do == "delete") { // delete page
  ?>
    <div class="container">
      <?php

        // check if get request userid is numeric & get the integer value of it
        $userid = (isset($_GET["userid"]) && is_numeric($_GET["userid"])) ? intval($_GET['userid']) : 0;
        //check if user exist in database
        $check = checkItem("UserID", 'users', $userid);

        if ($check > 0) {
          $stmt = $con->prepare("DELETE FROM users WHERE UserID  = :userid");
          $stmt->bindParam("userid", $userid);
          $stmt->execute();
          if ($stmt) {
            redirectHome("success", "تم جذف البيانات بنجاح ", "members.php");
          }
        } else {
          redirectHome("warning", "عذراَ هذا المستحدم غير موجود", "members.php");
        }
      ?>
    </div>
  <?php
      } elseif ($do == "active") { // active page
  ?>
    <div class="container">
      <?php

        // check if get request userid is numeric & get the integer value of it
        $userid = (isset($_GET["userid"]) && is_numeric($_GET["userid"])) ? intval($_GET['userid']) : 0;
        //check if user exist in database
        $check = checkItem("UserID", 'users', $userid);

        if ($check > 0) {
          $stmt = $con->prepare("UPDATE users SET RegStatus = 1  WHERE UserID  = :userid");
          $stmt->bindParam("userid", $userid);
          $stmt->execute();
          if ($stmt) {
            redirectHome("success", "تم تفعيل  المستخدم بنجاح ", "members.php");
          }
        } else {
          redirectHome("warning", "عذراَ هذا المستحدم غير موجود", "members.php");
        }
      ?>
    </div>
  <?php
      } elseif ($do == "disactive") { // active page
  ?>
    <div class="container">
      <?php

        // check if get request userid is numeric & get the integer value of it
        $userid = (isset($_GET["userid"]) && is_numeric($_GET["userid"])) ? intval($_GET['userid']) : 0;
        //check if user exist in database
        $check = checkItem("UserID", 'users', $userid);

        if ($check > 0) {
          $stmt = $con->prepare("UPDATE users SET RegStatus = 0  WHERE UserID  = :userid");
          $stmt->bindParam("userid", $userid);
          $stmt->execute();
          if ($stmt) {
            redirectHome("success", "تم الغاء تفعيل المستخدم بنجاح ", "members.php");
          }
        } else {
          redirectHome("warning", "عذراَ هذا المستحدم غير موجود", "members.php");
        }
      ?>
    </div>
  <?php
      } ?>

</section>


<?php
include $tpl . 'footer.php';

ob_end_flush();
?>