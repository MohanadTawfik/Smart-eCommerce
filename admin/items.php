<?php
ob_start();
session_start();
$pageTitle = "ادارة المنتجات ";
$dir = 'rtl';
$noNavbar = "";
// error_reporting(0);
if ((!isset($_SESSION["admin_name"])) && (!isset($_SESSION['role'])) && ($_SESSION['role'] != 1)) {
  header("location:index.php");
  exit();
}

include 'init.php';
?>

<section class="home">
  <!-- ==================== START MAIN ==================== -->
  <div class="title-date ">
    <h1 class="me-4">
      <div class="date">
        <?php echo Date("d-m-Y"); ?>
        <!-- <input type="date" dir="ltr" value="2023-Apr-02" /> -->
      </div>
    </h1>
  </div>

  <main>
    <div class="insights">
      <div class="sales">
        <a href="items.php?do=manage">
          <i class="fa fa-bar-chart" aria-hidden="true"></i>
          <div class="middle">
            <div class="left">
              <h3>كافة المنتجات</h3>
              <h1><?php echo countItems("Item_ID", "items") ?></h1>
            </div>
            <div class="my-progress">
              <div class="circular-progress">
                <span class="progress-value"><?php echo countItems("Item_ID", "items") ?></span>
              </div>
            </div>
          </div>
          <small class="text-muted">Last 24 Hours</small>
        </a>
      </div>
      <!-- ----------------------- END SALES ----------------------- -->
      <div class="expanses">
        <a href="items.php?do=manage&page=pending">
          <i class="fa fa-bar-chart" aria-hidden="true"></i>
          <div class="middle">
            <div class="left">
              <h3>المنتجات الغير مفعلة</h3>
              <h1><?php echo count_fields("Item_ID", "items", "WHERE Approve = 0"); ?></h1>
            </div>
            <div class="my-progress">
              <div class="circular-progress">
                <span class="progress-value"><?php echo count_fields("Item_ID", "items", "WHERE Approve = 0"); ?></span>
              </div>
            </div>
          </div>
          <small class="text-muted">Last 24 Hours</small>
        </a>
      </div>
      <!-- ----------------------- END EXPENSES ----------------------- -->
      <div class="income">
        <a href="items.php?do=manage&page=active">
          <i class="fa fa-bar-chart" aria-hidden="true"></i>
          <div class="middle">
            <div class="middle">
              <div class="left">
                <h3>المنتجات المفعلة</h3>
                <h1><?php echo count_fields("Item_ID", "items", "WHERE Approve = 1"); ?></h1>
              </div>
              <div class="my-progress">
                <div class="circular-progress">
                  <span class="progress-value"><?php echo count_fields("Item_ID", "items", "WHERE Approve = 1"); ?></span>
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

      <?php



      // start member page 
      $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

      if ($do == "manage") { // manage page
      ?>
        <a href="items.php?do=add" class="btn btn-primary col-lg-6 col-md-6 col-sm-8"><i class="fa fa-plus"></i> منتج جديد</a>
        <?php
        // latest Registered Items
        $query = "";

        if (isset($_GET["page"])) {
          if ($_GET["page"] == "pending") {
            $query = "AND Approve = 0";
          } else if ($_GET["page"] == "active") {
            $query = "AND Approve = 1";
          }
        }

        $sort = "desc";


        $sort_array = ["asc", "desc"];
        $stmt = $con->prepare("SELECT items.* ,categories.Name AS cat_name, users.Username  
                          FROM items
                          INNER JOIN categories ON  categories.ID = items.Cat_ID 
                          INNER JOIN users ON users.UserID = items.User_ID 
                          $query
                           ");
        $stmt->execute();
        $rows = $stmt->fetchAll();

        if (!empty($rows)) {
        ?>

          <div class="row mb-2">
            <h2 class=" d-flex align-items-center"> آخر المنتجات</h2>

          </div>

          <table class="data_table table table-responsive">
            <thead>
              <tr>
                <th>ID</th>
                <th></th>
                <th>إسم المنتج</th>
                <th>الوصف</th>
                <th>السعر</th>
                <th>دولة الصنع</th>
                <th>القسم</th>
                <th>المالك</th>
                <th>التقييم</th>
                <th>تاريخ التسجيل</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($rows as $row) { ?>
                <tr>
                  <td> <?php echo $row["Item_ID"]  ?></td>
                  <td>
                    <a href='#' class="username">
                      <div class="image"><img src='<?php echo $itemImg; ?><?php echo (!empty($row["Image"])) ? $row["Image"] : "img.png"; ?>'></div>
                    </a>
                  </td>
                  <td class="<?php echo ($row['Approve'] == 0) ? 'danger' : ' success';  ?>"><?php echo $row["Name"] ?> </td>
                  <td> <?php echo $row["Description"] ?></td>
                  <td> <?php echo $row["Price"] ?></td>
                  <td> <?php echo $row["Country_Made"] ?></td>
                  <td> <?php echo $row["cat_name"] ?></td>
                  <td> <?php echo $row["Username"] ?></td>
                  <td> <?php echo $row["Rating"] ?></td>
                  <td> <?php echo $row["Add_Date"] ?></td>
                  <td class="primary">
                    <span class=" control d-flex gap-2">
                      <a href='items.php?do=edit&itemid=<?php echo $row["Item_ID"] ?>' class='show-tittle round' my_tittle="تعديل المنتج"><i class='fa fa-edit success'></i></a>
                      <a href='items.php?do=delete&itemid=<?php echo $row["Item_ID"] ?>' class='show-tittle confirm round ' my_tittle="حذف المنتج"><i class='fa fa-trash danger'></i></a>
                      <?php if ($row['Approve'] == 0) { ?>
                        <a href='items.php?do=approve&itemid=<?php echo $row["Item_ID"] ?>' class='show-tittle round ' my_tittle="تفعيل المنتج"><i class='fa fa-check success'></i></a>
                      <?php } else { ?>
                        <a href='items.php?do=disapprove&itemid=<?php echo $row["Item_ID"] ?>' class='show-tittle round ' my_tittle="الغاء تفعيل المنتج"><i class='fa fa-close danger'></i></a>
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
  <h1 class="text-center mb-4"> إضافة منتج </h1>
  <div class="container">
    <form class="from-horizontal" action="?do=insert" method="POST" enctype="multipart/form-data">
      <div class="mb-3 row ">
        <label for="Name">اسم المنتج</label>
        <div class=" input-container ">
          <input type="text" name="name" class="form-control " id="Name" autocomplete="off" required placeholder="اسم المنتج">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="description">الوصف</label>
        <div class="input-container ">
          <input type="text" name="description" class=" form-control" id="description" placeholder="وصف المنتج">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="price">السعر</label>
        <div class=" input-container ">
          <input type="text" name="price" class="form-control" id="price" required placeholder="سعر المنتج">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="country">دولة الصنع</label>
        <div class=" input-container ">
          <input type="text" name="country" class="form-control" id="country" required placeholder="دولة الصنع">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="status">الحالة</label>
        <div class=" input-container ">
          <select class="form-control form-select" name="status" id="status" aria-label="Default select example">
            <option selected>إختر حالة المنتج</option>
            <option value="1">جديد</option>
            <option value="2">شبه جديد</option>
            <option value="3">مستخدم</option>
            <option value="4">قديم</option>
          </select>
        </div>
      </div>
      <div class="mb-3 row">
        <label for="category">القسم</label>
        <div class=" input-container ">
          <select class="form-select" name="category" id="category" aria-label="Default select example">
            <option selected>إختر القسم </option>
            <?php
            $cats = get_from_table('*', "categories",  "WHERE Parent = 0", "", "ID");
            foreach ($cats as $cat) {
              echo "<option value=" . $cat['ID'] . ">" . $cat['Name'] . "</option>";
              $childCats = get_from_table('*', "categories",  "WHERE Parent = {$cat['ID']}", "", "ID");
              foreach ($childCats as $child) {
                echo "<option value=" . $child['ID'] . ">--- " . $child['Name'] . "</option>";
              }
            }
            ?>
          </select>
        </div>
      </div>
      <div class="mb-3 row">
        <label for="member">المالك</label>
        <div class=" input-container ">
          <select class="form-select" name="member" id="member" aria-label="Default select example">
            <option selected>إختر اسم المالك</option>
            <?php
            $users = get_from_table('*', "users",  "", "", "UserID");
            foreach ($users as $user) {
              echo "<option value=" . $user['UserID'] . ">" . $user['Username'] . "</option>";
            }
            ?>
          </select>
        </div>
      </div>

      <div class="mb-3 row">
        <!-- <input name="tags" placeholder="write some tags" value="predefined tags here"> -->
        <label for="tags">هاشتاج</label>
        <div class=" input-container ">
          <input type="text" name="tags" class="form-control" id="tags" placeholder="افصل بين التاجات بالفاصلة  (,)">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="avatar">الصورة</label>
        <div class="input-container ">
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
    <div class="container">
    <?php
          // get variables from from

          $name   = $_POST['name'];
          $desc  = $_POST['description'];
          $price     = $_POST['price'];
          $country   = $_POST['country'];
          $status  = $_POST['status'];
          $member  = $_POST['member'];
          $cat  = $_POST['category'];
          $tags  = $_POST['tags'];



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




          // validate the form 
          $formErrors = [];
          if (empty($name)) {
            $formErrors[] = 'الاسم <b>فارغ</b>';
          }
          if (empty($price)) {
            $formErrors[] = ' السعر<b>فارغ</b>';
          }
          if (empty($country)) {
            $formErrors[] = 'مكان الصنع <b>فارغ</b>';
          }
          if ($status == 0) {
            $formErrors[] = 'يجب ان تختار حالة الاستخدام';
          }
          if ($member == 0) {
            $formErrors[] = 'يجب ان تختار المالك';
          }
          if ($cat == 0) {
            $formErrors[] = 'يجب ان تختار القسم ';
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
            if (!empty($error)) {
              echo "<div class='container'>";
              echo  "<div class ='alert alert-danger' role='alert'>$error</div>";
              echo "</div>";
            }
          }

          // check if no error 
          if (empty($formError)) {
            $image = rand(0, 100000000000) . '_' . $avatar_name;
            move_uploaded_file($avatar_tmp, "<?php  echo $itemImg ;?>" . $image);


            // insert Item info to database 
            $stmt = $con->prepare("INSERT INTO items(`Name` ,`Description`, Price , Country_Made, `Status` , Cat_ID , `User_ID` ,tags,`Image`, Add_Date) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, now())");
            $stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $tags, $image));
            $count = $stmt->rowCount();
            echo "<div class='container'>";
            echo "<div class ='alert alert-success' role='alert'>تمت الاضافة</div>";
            echo "</div>";
          }
        } else {
          redirectHome("danger", "عذراَ لا يمكنك الوصول المباشر لهذه الصفحة", "items.php");
        }
    ?>
    </div>
    <?php

      } elseif ($do == "edit") { // edit page 

        // check if get request item id is numeric & get the integer value of it
        $itemid = (isset($_GET["itemid"]) && is_numeric($_GET['itemid'])) ? intval($_GET['itemid']) : 0;
        $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");
        $stmt->execute(array($itemid));
        $Item = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) {
    ?>
      <h1 class="text-center mb-4"> تعديل البيانات </h1>
      <div>
        <div class="container ">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="row live-review">
                <!-- live review -->

                <div>
                  <div class="card h-auto item-box live-preview" style="max-width: 16rem;">
                    <span class="price-tag"><span class="live-price"><?php echo (!empty($Item["Price"])) ? $Item["Price"] : "0"; ?></span></span>
                    <img class="live-image img-responsive card-img-top object-fit-cover" src='<?php echo $itemImg; ?><?php echo (!empty($Item["Image"])) ? $Item["Image"] : "img.png"; ?>' alt="...">
                    <div class="card-body caption text-center align-middle pt-3 pe-3 ">
                      <div class="d-flex justify-content-start gap-3"> اسم المنتج : <h5 class="card-title live-title"><?php echo (!empty($Item["Name"])) ? $Item["Name"] : " "; ?></h5>
                      </div>
                      <div class="d-flex justify-content-start gap-3">وصف المنتج : <p class="card-text live-desc"><?php echo (!empty($Item["Description"])) ? $Item["Description"] : " "; ?></p>
                      </div>

                      <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                    </div>
                  </div>
                </div>
                <div>
                  <form class="from-horizontal main-form" action="?do=update" method="POST">
                    <input type="hidden" name="itemid" value="<?php echo $itemid; ?>">
                    <div class="mb-3 row ">
                      <label for="Name">اسم المنتج</label>
                      <div class=" input-container ">
                        <input type="text" name="name" value="<?php echo $Item["Name"]; ?>" class="form-control live" pattern=".{4,}" title="This Field Require At Least 4 Characters" data-class=".live-title" id="Name" autocomplete="off" required placeholder="اسم المنتج">
                      </div>
                    </div>

                    <div class="mb-3 row">
                      <label for="description">وصف المنتج</label>
                      <div class=" input-container ">
                        <input type="text" name="description" value="<?php echo $Item["Description"]; ?>" class=" form-control live" pattern=".{10,}" title="This Field Require At Least 10 Characters" data-class=".live-desc" id="description" required placeholder="وصف المنتج  ">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="price">سعر المنتج</label>
                      <div class=" input-container ">
                        <input type="text" name="price" value="<?php echo $Item["Price"]; ?>" class="form-control live" data-class=".live-price" id="price" required placeholder="سعر المنتج ">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="country">دولة الصنع</label>
                      <div class=" input-container ">
                        <input type="text" name="country" value="<?php echo $Item["Country_Made"]; ?>" class="form-control" id="country" required placeholder="دولة الصنع">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="status">حالة المنتج</label>
                      <div class=" input-container ">
                        <select class="form-select" name="status" id="status" required aria-label="Default select example">
                          <option value="1" <?php if ($Item["Status"] == 1) echo "selected"; ?>>جديد</option>
                          <option value="2" <?php if ($Item["Status"] == 2) echo "selected"; ?>>شبه جديد</option>
                          <option value="3" <?php if ($Item["Status"] == 3) echo "selected"; ?>>مستخدم</option>
                          <option value="4" <?php if ($Item["Status"] == 4) echo "selected"; ?>>قديم</option>
                        </select>
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="category">القسم</label>
                      <div class=" input-container ">
                        <select class="form-select" name="category" id="category" required aria-label="Default select example">
                          <?php
                          $stmt_cat = $con->prepare("SELECT * FROM categories WHERE Visibility = 0");
                          $stmt_cat->execute();
                          $cats = $stmt_cat->fetchAll();
                          foreach ($cats as $cat) { ?>
                            <option value=" <?php echo $cat['ID']; ?>" <?php if ($Item["Cat_ID"] == $cat['ID']) echo "selected"; ?>>
                              <?php echo $cat['Name']; ?>
                            </option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="member">المالك</label>
                      <div class="  input-container ">
                        <select class="form-select" name="member" id="member" aria-label="Default select example">
                          <?php
                          $stmt_users = $con->prepare("SELECT * FROM users");
                          $stmt_users->execute();
                          $users = $stmt_users->fetchAll();
                          foreach ($users as $user) { ?>
                            <option value=" <?php echo $user['UserID']; ?>" <?php if ($Item["User_ID"] == $user['UserID']) echo "selected"; ?>>
                              <?php echo $user['Username']; ?>
                            </option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>

                    <div class="mb-3 row">
                      <!-- <input name="tags" placeholder="write some tags" value="predefined tags here"> -->
                      <label for="tags">هاشتاج</label>
                      <div class=" input-container ">
                        <input type="text" name="tags" value="<?php echo $Item['tags']; ?>" class="form-control" id="tags" placeholder="افصل بين الهشتاجات بالفاصلة  (,)">
                      </div>
                    </div>

                    <div class="mb-3 row">
                      <label for="image">الصورة</label>
                      <div class="  input-container ">
                        <input type="file" name="image" class="form-control" data-class=".live-image" id="image">
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


              </div>
            </div>
          </div>
        </div>
      </div>


    <?php
        } else {
          redirectHome("warning", "عذرا هذا المنتج غير موجود", "back");
        }
      } elseif ($do == "update") { // update page 

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    ?>
      <h1 class="text-center mb-4">Update Item</h1>
      <div class="container">
      <?php
          // get variables from from

          $id   = $_POST['itemid'];
          $name   = $_POST['name'];
          $desc  = $_POST['description'];
          $price     = $_POST['price'];
          $country   = $_POST['country'];
          $status  = $_POST['status'];
          $member  = $_POST['member'];
          $cat  = $_POST['category'];
          $tags  = $_POST['tags'];

          // Uploads Variable
          $avatar_name = $_FILES['image']['name'];
          $avatar_type = $_FILES['image']['type'];
          $avatar_tmp = $_FILES['image']['tmp_name'];
          $avatar_size = $_FILES['image']['size'];

          // list of allowed extension to upload
          $allowed_extension = ["jpeg", "jpg", "png", "gif", "ico"];

          // get image extension
          // $avatar_extension = strtolower(end(explode('.', $avatar_name)));
          $avatar_extension = pathinfo($avatar_name, PATHINFO_EXTENSION);

          // validate the form 
          $formErrors = [];
          if (empty($name)) {
            $formErrors[] = 'الاسم <b>فارغ</b>';
          }
          if (empty($price)) {
            $formErrors[] = ' السعر<b>فارغ</b>';
          }
          if (empty($country)) {
            $formErrors[] = 'مكان الصنع <b>فارغ</b>';
          }
          if ($status == 0) {
            $formErrors[] = 'يجب ان تختار حالة الاستخدام';
          }
          if ($member == 0) {
            $formErrors[] = 'يجب ان تختار المالك';
          }
          if ($cat == 0) {
            $formErrors[] = 'يجب ان تختار القسم ';
          }

          // if (empty($avatar_name)) {
          //   $formErrors[] = 'الصورة  <b> مطلوبة</b>';
          // }

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
            // insert Item info to database 
            $stmt = $con->prepare("UPDATE items SET `Name` = ?, `Description` =?, Price =?,Country_Made =?,`Status` =?, Cat_ID = ?,`User_ID`=?, tags=?, `Image`=? WHERE Item_ID =?");
            $stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $tags, $image, $id));
            $count = $stmt->rowCount();
            redirectHome("success", "تم تحديث المنتج بنجاح", "items.php");
          }
        } else {
          redirectHome("danger", "عذراَ لا يمكنك الوصول المباشر لهذه الصفحة", "items.php");
        }
      ?>
      </div>
    <?php
      } elseif ($do == "delete") { // delete page
    ?>
      <div class="container">
        <?php

        // check if get request itemid is numeric & get the integer value of it
        $itemid = (isset($_GET["itemid"]) && is_numeric($_GET["itemid"])) ? intval($_GET['itemid']) : 0;
        //check if item exist in database
        $check = checkItem("Item_ID", 'items', $itemid);

        if ($check > 0) {
          $stmt = $con->prepare("DELETE FROM items WHERE Item_ID  = :itemid");
          $stmt->bindParam("itemid", $itemid);
          $stmt->execute();
          $count = $stmt->rowCount();
          redirectHome("success", "تم حذف المنتج بنجاح", "items.php");
        } else {
          redirectHome("warning", "عذرا هذا المنتج غير موجود", "items.php");
        }
        ?>
      </div>
    <?php
      } elseif ($do == "approve") { // approve page
    ?>
      <div class="container">
        <?php

        // check if get request itemid is numeric & get the integer value of it
        $itemid = (isset($_GET["itemid"]) && is_numeric($_GET["itemid"])) ? intval($_GET['itemid']) : 0;
        //check if item exist in database
        $check = checkItem("Item_ID", 'items', $itemid);

        if ($check > 0) {
          $stmt = $con->prepare("UPDATE items SET Approve = 1  WHERE Item_ID  = :itemid");
          $stmt->bindParam("itemid", $itemid);
          $stmt->execute();
          $count = $stmt->rowCount();
          redirectHome("success", "تم تفعيل المنتج بنجاح", "items.php");
        } else {
          redirectHome("warning", "عذرا هذا المنتج غير موجود", "items.php");
        }
        ?>
      </div>
    <?php
      } elseif ($do == "disapprove") { // active page
    ?>
      <div class="container">
        <?php

        // check if get request itemid is numeric & get the integer value of it
        $itemid = (isset($_GET["itemid"]) && is_numeric($_GET["itemid"])) ? intval($_GET['itemid']) : 0;
        //check if item exist in database
        $check = checkItem("Item_ID", 'items', $itemid);

        if ($check > 0) {
          $stmt = $con->prepare("UPDATE items SET Approve = 0  WHERE Item_ID  = :itemid");
          $stmt->bindParam("itemid", $itemid);
          $stmt->execute();
          $count = $stmt->rowCount();
          redirectHome("success", "تم الغاء تفعيل المنتج بنجاح", "items.php");
        } else {
          redirectHome("warning", "عذرا هذا المنتج غير موجود", "items.php");
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