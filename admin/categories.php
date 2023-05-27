<?php
ob_start();
session_start();
$pageTitle = "ادارة الاقسام ";
$dir = 'rtl';
$noNavbar = "";
error_reporting(0);

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
      <div class="income">
        <a href="categories.php?do=manage">
          <i class="fa fa-bar-chart" aria-hidden="true"></i>
          <div class="middle">
            <div class="left">
              <h3>كافة الاقسام</h3>
              <h1><?php echo countItems("ID", "categories") ?></h1>
            </div>
            <div class="my-progress">
              <div class="circular-progress">
                <span class="progress-value"><?php echo countItems("ID", "categories") ?></span>
              </div>
            </div>
          </div>
          <small class="text-muted">Last 24 Hours</small>
        </a>
      </div>
      <div class="sales">
        <a href="categories.php?do=manage&filter=parent">
          <i class="fa fa-bar-chart" aria-hidden="true"></i>
          <div class="middle">
            <div class="left">
              <h3>الاقسام الرئيسية</h3>
              <h1><?php echo count_fields("ID", "categories", "WHERE Parent = 0"); ?></h1>
            </div>
            <div class="my-progress">
              <div class="circular-progress">
                <span class="progress-value"><?php echo count_fields("ID", "categories", "WHERE Parent = 0"); ?></span>
              </div>
            </div>
          </div>
          <small class="text-muted">Last 24 Hours</small>
        </a>
      </div>
      <div class="sales">
        <a href="categories.php?do=manage&filter=child">
          <i class="fa fa-bar-chart" aria-hidden="true"></i>
          <div class="middle">
            <div class="left">
              <h3>الاقسام الفرعية</h3>
              <h1><?php echo count_fields("ID", "categories", "WHERE Parent != 0"); ?></h1>
            </div>
            <div class="my-progress">
              <div class="circular-progress">
                <span class="progress-value"><?php echo count_fields("ID", "categories", "WHERE Parent != 0"); ?></span>
              </div>
            </div>
          </div>
          <small class="text-muted">Last 24 Hours</small>
        </a>
      </div>
      <div class="expanses">
        <a href="categories.php?do=manage&filter=visible">
          <i class="fa fa-bar-chart" aria-hidden="true"></i>
          <div class="middle">
            <div class="left">
              <h3>المخفية </h3>
              <h1><?php echo count_fields("ID", "categories", "WHERE Visibility = 1"); ?></h1>
            </div>
            <div class="my-progress">
              <div class="circular-progress">
                <span class="progress-value"><?php echo count_fields("ID", "categories", "WHERE Visibility = 1"); ?></span>
              </div>
            </div>
          </div>
          <small class="text-muted">Last 24 Hours</small>
        </a>
      </div>
      <div class="expanses">
        <a href="categories.php?do=manage&filter=comment">
          <i class="fa fa-bar-chart" aria-hidden="true"></i>
          <div class="middle">
            <div class="left">
              <h3> التعليق غير مسموح </h3>
              <h1><?php echo count_fields("ID", "categories", "WHERE Allow_Comment = 1"); ?></h1>
            </div>
            <div class="my-progress">
              <div class="circular-progress">
                <span class="progress-value"><?php echo count_fields("ID", "categories", "WHERE Allow_Comment = 1"); ?></span>
              </div>
            </div>
          </div>
          <small class="text-muted">Last 24 Hours</small>
        </a>
      </div>

      <div class="expanses">
        <a href="categories.php?do=manage&filter=ads">
          <i class="fa fa-bar-chart" aria-hidden="true"></i>
          <div class="middle">
            <div class="left">
              <h3> الاعلان غير مسموح </h3>
              <h1><?php echo count_fields("ID", "categories", "WHERE Allow_Ads = 1"); ?></h1>
            </div>
            <div class="my-progress">
              <div class="circular-progress">
                <span class="progress-value"><?php echo count_fields("ID", "categories", "WHERE Allow_Ads = 1"); ?></span>
              </div>
            </div>
          </div>
          <small class="text-muted">Last 24 Hours</small>
        </a>
      </div>
    </div>
    <!-- ----------------------- END INSIGHTS ----------------------- -->
    <div class="recent-orders">

      <?php
      // start member page 
      $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

      if ($do == "manage") { // manage page
      ?>
        <a href="categories.php?do=add" class="btn btn-primary col-lg-6 col-md-6 col-sm-8"><i class="fa fa-plus"></i> قسم جديد</a>
        <?php
        // latest Registered Items
        $query = "";
        $isParent = false;
        if (isset($_GET["filter"])) {
          if ($_GET["filter"] == "parent") {
            $query = "WHERE parent = 0";
            $isParent = true;
          } else if ($_GET["filter"] == "child") {
            $query = "WHERE parent != 0";
          } else if ($_GET["filter"] == "visible") {
            $query = "WHERE Visibility = 1";
          } else if ($_GET["filter"] == "comment") {
            $query = "WHERE Allow_Comment = 1";
          } else if ($_GET["filter"] == "ads") {
            $query = "WHERE Allow_Ads = 1";
          }
        }




        $stmt = $con->prepare("SELECT * FROM categories $query ");
        $stmt->execute();
        $rows = $stmt->fetchAll();

        if (!empty($rows)) {
        ?>

          <div class="row mb-2">
            <h2 class=" d-flex align-items-center"> آحر الاقسام </h2>

          </div>

          <table class="data_table table table-responsive">
            <thead>
              <tr>
                <th>ID</th>
                <th></th>
                <th>إسم القسم</th>
                <th>الوصف</th>
                <th><?php if ($isParent == false) {
                      echo   "عدد الاقسام الفرعية / القسم الرئيسي ";
                    } else {
                      echo ($_GET["filter"] == "parent") ? "عدد الاقسام الفرعية" : " القسم الرئيسي ";
                    } ?></th>
                <th>عدد المنجات</th>
                <th>الترتيب</th>
                <th>ظاهر/مخفي</th>
                <th>يسمح بالإعلان</th>
                <th>يسمح بالتعليقات</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($rows as $row) { ?>
                <tr>
                  <td> <?php echo $row["ID"]  ?></td>
                  <td>
                    <a href='#' class="username">
                      <div class="image"><img src='<?php echo $itemImg . "img.png "; ?>'></div>
                    </a>
                  </td>
                  <td><?php echo $row["Name"] ?> </td>
                  <td> <?php echo $row["Description"] ?></td>
                  <td><?php if ($row["Parent"] == 0) {
                        echo count_from_table("*", "categories", "WHERE Parent = {$row["ID"]}", "", "ID");
                      } else {
                        $cats = $con->prepare("SELECT `Name` FROM categories  WHERE  {$row["ID"]} = Parent LIMIT 1");
                        $cats->execute();
                        $rows = $cats->fetch();
                        echo $row["Name"];
                      } ?>
                  </td>
                  <td> <?php echo count_from_table("*", "items", "WHERE Cat_ID = {$row["ID"]}", "", "Cat_ID"); ?></td>
                  <td> <?php echo $row["Ordering"] ?></td>
                  <td>
                    <?php if ($row["Visibility"] == 1) { ?>
                      <a href='categories.php?do=show&catid=<?php echo $row["ID"] ?>' class='show-tittle round ' my_tittle="إظهار القسم "><i class='fa fa-close danger'></i></a>
                    <?php } else { ?>
                      <a href='categories.php?do=hide&catid=<?php echo $row["ID"] ?>' class='show-tittle round ' my_tittle=" إخفاء القسم"><i class='fa fa-check success'></i></a>
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($row["Allow_Ads"] == 1) { ?>
                      <a href='categories.php?do=allow_Ads&catid=<?php echo $row["ID"] ?>' class='show-tittle round ' my_tittle=" السماح بالاعلانات "><i class='fa fa-close danger'></i></a>
                    <?php } else { ?>
                      <a href='categories.php?do=no_Ads&catid=<?php echo $row["ID"] ?>' class='show-tittle round ' my_tittle="  عدم السماح بالاعلانات"><i class='fa fa-check success'></i></a>
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($row["Allow_Comment"] == 1) { ?>
                      <a href='categories.php?do=allow_comment&catid=<?php echo $row["ID"] ?>' class='show-tittle round ' my_tittle="السماح بالتعليقات"><i class='fa fa-close danger'></i></a>
                    <?php } else { ?>
                      <a href='categories.php?do=no_comment&catid=<?php echo $row["ID"] ?>' class='show-tittle round ' my_tittle=" عدم السماح بالتعليقات"><i class='fa fa-check success'></i></a>
                    <?php } ?>
                  </td>
                  <td class="primary">
                    <span class=" control d-flex gap-2">
                      <a href='categories.php?do=edit&catid=<?php echo $row["ID"] ?>' class='show-tittle round' my_tittle="تعديل القسم"><i class='fa fa-edit success'></i></a>
                      <a href='categories.php?do=delete&catid=<?php echo $row["ID"] ?>' class='show-tittle confirm round ' my_tittle="حذف القسم"><i class='fa fa-trash danger'></i></a>
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
  <h1 class="text-center mb-4">إضافة قسم جديد</h1>
  <div class="container">
    <form class="from-horizontal" action="categories.php?do=insert" method="POST">
      <div class="mb-3 row ">
        <label for="Name">الأسم</label>
        <div class=" input-container ">
          <input type="text" name="name" class="form-control " id="Name" autocomplete="off" required placeholder="إسم القسم">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="description">الوصف</label>
        <div class=" input-container ">
          <input type="text" name="description" class=" form-control" id="description" placeholder="وصف القسم">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="parent">النوع</label>
        <div class=" ">
          <select class="form-select" name="parent" id="cat-type" aria-label="Default select example">
            <option value="0">None</option>
            <?php
            $allCats = get_from_table("*", "categories", "where Parent = 0", "", "ID");
            foreach ($allCats as $cat) {
              echo "<option value=" . $cat['ID'] . ">" . $cat['Name'] . "</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <div class="mb-3 row">
        <label for="ordering">الترتيب</label>
        <div class=" input-container ">
          <input type="text" name="ordering" class="form-control" id="ordering" placeholder="عدد الأقسام المطلوبه">
        </div>
      </div>
      <div class="mb-3 row">
        <label></label>
        <div class="check-input-container">
          <div class="form-check  form-switch">
            <input class="form-check-input" role="switch" type="checkbox" name="visibility" id="visibility" checked>
            <label class="form-check-label" for="visibility">قسم ظاهر </label>
          </div>
          <div class="form-check  form-switch">
            <input class="form-check-input" role="switch" type="checkbox" name="commenting" id="commenting" checked>
            <label class="form-check-label" for="commenting"> يسمح بالتعليق </label>
          </div>
          <div class="form-check  form-switch">
            <input class="form-check-input" role="switch" type="checkbox" name="allow_ads" id="ads" checked>
            <label class="form-check-label" for="ads"> يسمح بالإعلان </label>
          </div>
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
          $parent     = $_POST['parent'];
          $order     = $_POST['ordering'];

          $visible = (isset($_POST['visibility']) && !empty($_POST['visibility'])) ? 0 : 1;
          $comment = (isset($_POST['commenting']) && !empty($_POST['commenting'])) ? 0 : 1;
          $ads = (isset($_POST['allow_ads']) && !empty($_POST['allow_ads'])) ? 0 : 1;


          //  check if no error 
          if (!empty($name)) {
            //check if Category exist in database
            $check = checkItem("Name", 'categories', $name);
            if ($check == 0) {
              // insert Category info to database 
              $stmt = $con->prepare("INSERT INTO categories(`Name`,`Description`,Parent,Ordering,Visibility,Allow_Comment,Allow_Ads) 
                                              VALUES(:nameV, :descV ,:parentV,:orderV, :visibleV,:commentV,:adsV)");
              $stmt->execute(array(
                "nameV" => $name,
                "descV" => $desc,
                "parentV" => $parent,
                "orderV" => $order,
                "visibleV" => $visible,
                "commentV" => $comment,
                "adsV" => $ads
              ));
              redirectHome("success", "تم إضافة القسم بنجاح", "categories.php");
            } else {
              redirectHome("warning", "عذرا هذا القسم موجود مسبقا", "categories.php");
            }
          } else {
            redirectHome("warning", "عذرا الاسم لا يجب ان يكون <b>فارغا</b>", 'back');
          }
        } else {
          redirectHome("danger", "عذراَ لا يمكنك الوصول المباشر لهذه الصفحة");
        }

    ?>
    </div>
    <?php

      } elseif ($do == "edit") { // edit page 

        // check if get request Category id is numeric & get the integer value of it
        $catid = (isset($_GET["catid"]) && is_numeric($_GET['catid'])) ? intval($_GET['catid']) : 0;

        $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");
        $stmt->execute(array($catid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) {
    ?>

      <h1 class="text-center mb-4">تعديل القسم</h1>

      <form class="from-horizontal ms-auto me-auto" action="categories.php?do=update" method="POST">
        <input type="hidden" name="catid" value="<?php echo $catid; ?>">
        <div class="mb-3 row">
          <label for="Name">الإسم</label>
          <div class=" input-container ">
            <input type="text" name="name" value="<?php echo $row["Name"]; ?>" class="form-control " id="Name" required placeholder="Name of Category">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="description">الوصف</label>
          <div class=" input-container ">
            <input type="text" name="description" value="<?php echo $row["Description"]; ?>" class=" form-control" id="description" placeholder="Description the Category">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="parent">النوع</label>
          <div class=" ">
            <select class="form-select" name="parent" id="cat-type" aria-label="Default select example">
              <option value="0">None</option>
              <?php
              $allCats = get_from_table("*", "categories", "where Parent = 0", "", "ID");
              foreach ($allCats as $cat) { ?>
                <option value=" <?php echo $cat['ID']; ?>" <?php if ($row["Parent"] == $cat['ID']) echo "selected"; ?>>
                  <?php echo $cat['Name']; ?>
                </option>
              <?php
              }
              ?>
            </select>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="ordering">الترتيب</label>
          <div class=" input-container ">
            <input type="text" name="ordering" value="<?php echo $row["Ordering"]; ?>" class="form-control" id="ordering" placeholder="Number to Order Categories">
          </div>
        </div>
        <div class="mb-3 row">
          <label></label>
          <div class="check-input-container">
            <div class="form-check  form-switch">
              <input class="form-check-input" role="switch" type="checkbox" name="visibility" id="visibility" <?php echo ($row["Visibility"] == 0) ? "checked" : ""; ?>>
              <label class="form-check-label" for="visibility">قسم ظاهر </label>
            </div>
            <div class="form-check  form-switch">
              <input class="form-check-input" role="switch" type="checkbox" name="commenting" id="commenting" <?php echo ($row["Allow_Comment"] == 0) ? "checked" : ""; ?>>
              <label class="form-check-label" for="commenting"> يسمح بالتعليق </label>
            </div>
            <div class="form-check  form-switch">
              <input class="form-check-input" role="switch" type="checkbox" name="allow_ads" id="ads" <?php echo ($row["Allow_Ads"] == 0) ? "checked" : ""; ?>>
              <label class="form-check-label" for="ads"> يسمح بالإعلان </label>
            </div>
          </div>
        </div>
        <div class="row">
          <span></span>
          <div class="input-container ">
            <button type="submit" class="btn btn-primary mb-3"> حفظ <i class="fa fa-save"></i> </button>
          </div>
        </div>
      </form>
  <?php
        } else {
          redirectHome("warning", "عذرا هذا القسم غير موجود ", "categories.php");
        }
      } elseif ($do == "update") { // update page 

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          // get variables from from

          $id   = $_POST['catid'];
          $name   = $_POST['name'];
          $desc  = $_POST['description'];
          $parent     = $_POST['parent'];
          $order  = $_POST['ordering'];

          $visible = (isset($_POST['visibility']) && !empty($_POST['visibility'])) ? 0 : 1;
          $comment = (isset($_POST['commenting']) && !empty($_POST['commenting'])) ? 0 : 1;
          $ads = (isset($_POST['allow_ads']) && !empty($_POST['allow_ads'])) ? 0 : 1;

          // check if no error 
          if (!empty($name)) {
            //check if item exist in database
            $statement = $con->prepare("SELECT * FROM categories WHERE `Name` = ? AND ID != ? ");
            $statement->execute(array($name, $id));
            $check = $statement->rowCount();
            if ($check == 0) {
              // update database with this info 
              $stmt = $con->prepare("UPDATE categories SET `Name` = ?, `Description` =?, Parent = ?, Ordering =?, Visibility =?, Allow_Comment =?, Allow_Ads =? WHERE ID =?");
              $stmt->execute(array($name, $desc, $parent, $order, $visible, $comment, $ads, $id));

              redirectHome("success", "تم تحديث القسم بنجاح", "categories.php");
            } else {
              redirectHome("warning", "عذرا هذا القسم غير موجود", "categories.php");
            }
          } else {
            redirectHome("warning", "عذرا هذا القسم موجود مسبقا", "categories.php");
          }
        } else {
          redirectHome("danger", "عذراَ لا يمكنك الوصول المباشر لهذه الصفحة");
        }
      } elseif ($do == "delete") { // delete page


        // check if get request catid is numeric & get the integer value of it
        $catid = (isset($_GET["catid"]) && is_numeric($_GET["catid"])) ? intval($_GET['catid']) : 0;
        //check if Category exist in database
        $check = checkItem("ID", 'categories', $catid);

        if ($check > 0) {
          $stmt = $con->prepare("DELETE FROM categories WHERE ID  = :catid");
          $stmt->bindParam("catid", $catid);
          $stmt->execute();
          $count = $stmt->rowCount();
          redirectHome("success", "تم حذف القسم بنجاح", "categories.php");
        } else {
          redirectHome("warning", "عذرا هذا القسم غير موجود", "categories.php");
        }
      } elseif ($do == "show") {

        // check if get request catid is numeric & get the integer value of it
        $catid = (isset($_GET["catid"]) && is_numeric($_GET["catid"])) ? intval($_GET['catid']) : 0;
        $check = checkItem("ID", 'categories', $catid);

        if ($check > 0) {
          $stmt = $con->prepare("UPDATE categories SET Visibility = 0 WHERE ID =?");
          $stmt->execute(array($catid));

          redirectHome("success", "تم إظهار القسم بنجاح", "categories.php");
        } else {
          redirectHome("warning", "عذرا هذا القسم غير موجود", "categories.php");
        }
      } elseif ($do == "hide") {

        // check if get request catid is numeric & get the integer value of it
        $catid = (isset($_GET["catid"]) && is_numeric($_GET["catid"])) ? intval($_GET['catid']) : 0;
        $check = checkItem("ID", 'categories', $catid);

        if ($check > 0) {
          $stmt = $con->prepare("UPDATE categories SET Visibility = 1 WHERE ID =?");
          $stmt->execute(array($catid));
          redirectHome("success", "تم إخفاء القسم بنجاح", "categories.php");
        } else {
          redirectHome("warning", "عذرا هذا القسم غير موجود", "categories.php");
        }
      } elseif ($do == "allow_Ads") {

        // check if get request catid is numeric & get the integer value of it
        $catid = (isset($_GET["catid"]) && is_numeric($_GET["catid"])) ? intval($_GET['catid']) : 0;
        $check = checkItem("ID", 'categories', $catid);

        if ($check > 0) {
          $stmt = $con->prepare("UPDATE categories SET Allow_Ads = 0 WHERE ID =?");
          $stmt->execute(array($catid));
          redirectHome("success", "تم السماح بالاعلانات في هذا القسم بنجاح", "categories.php");
        } else {
          redirectHome("warning", "عذرا هذا القسم غير موجود", "categories.php");
        }
      } elseif ($do == "no_Ads") {

        // check if get request catid is numeric & get the integer value of it
        $catid = (isset($_GET["catid"]) && is_numeric($_GET["catid"])) ? intval($_GET['catid']) : 0;
        $check = checkItem("ID", 'categories', $catid);

        if ($check > 0) {
          $stmt = $con->prepare("UPDATE categories SET Allow_Ads = 1 WHERE ID =?");
          $stmt->execute(array($catid));
          redirectHome("success", "تم منع الاعلانات في هذا القسم بنجاح", "categories.php");
        } else {
          redirectHome("warning", "عذرا هذا القسم غير موجود", "categories.php");
        }
      } elseif ($do == "allow_comment") {

        // check if get request catid is numeric & get the integer value of it
        $catid = (isset($_GET["catid"]) && is_numeric($_GET["catid"])) ? intval($_GET['catid']) : 0;
        $check = checkItem("ID", 'categories', $catid);

        if ($check > 0) {
          $stmt = $con->prepare("UPDATE categories SET Allow_Comment = 0 WHERE ID =?");
          $stmt->execute(array($catid));
          redirectHome("success", "تم السماح بالتعليقات في هذا القسم بنجاح", "categories.php");
        } else {
          redirectHome("warning", "عذرا هذا القسم غير موجود", "categories.php");
        }
      } elseif ($do == "no_comment") {

        // check if get request catid is numeric & get the integer value of it
        $catid = (isset($_GET["catid"]) && is_numeric($_GET["catid"])) ? intval($_GET['catid']) : 0;
        $check = checkItem("ID", 'categories', $catid);

        if ($check > 0) {
          $stmt = $con->prepare("UPDATE categories SET Allow_Comment = 1 WHERE ID =?");
          $stmt->execute(array($catid));
          redirectHome("success", "تم منع التعليقات في هذا القسم بنجاح", "categories.php");
        } else {
          redirectHome("warning", "عذرا هذا القسم غير موجود", "categories.php");
        }
      }

  ?>

</section>
<?php
include $tpl . 'footer.php';

ob_end_flush();
?>