<?php
ob_start();
session_start();
$pageTitle = "لوحة التحكم ";
$dir = 'rtl';
$noNavbar = '';
// error_reporting(0);

if ((!isset($_SESSION["admin_name"])) && (!isset($_SESSION['role'])) && ($_SESSION['role'] != 1)) {
    header("location:index.php");
    exit();
}
include 'init.php';
// start Dashboard

// latest Registered Users
$user_limit = 3;
$latest_users = getLatest('*', 'users', 'UserID', $user_limit);


// latest Registered items
$item_limit = 3;
$stmt = $con->prepare("SELECT items.* ,categories.Name AS cat_name
                          FROM items
                          INNER JOIN categories ON  categories.ID = items.Cat_ID 
                          ORDER BY Item_ID DESC
                          LIMIT $item_limit ");
$stmt->execute();
$latest_items = $stmt->fetchAll();


// latest comments
$cat_limit = 3;
$latest_catagories = getLatest('*', 'categories', 'Ordering', $cat_limit);

?>

<section class="home ">

    <div class="title-date ">
        <h1>لوحة التحكم</h1>
        <h1 class="me-4">
            <div class="date">
                <?php echo Date("d-m-Y"); ?>
                <!-- <input type="date" dir="ltr" value="2023-Apr-02" /> -->
            </div>
        </h1>
    </div>
    <main>
        <div class="insights ">
            <div class="sales">
                <i class="fa fa-bar-chart" aria-hidden="true"></i>
                <div class="middle">
                    <div class="left">
                        <h3>عدد المستخدمين</h3>
                        <h1><?php echo countItems("UserID", "users") ?></h1>
                    </div>
                    <div class="my-progress">
                        <div class="circular-progress">
                            <span class="progress-value"><?php echo countItems("UserID", "users") ?></span>
                        </div>
                    </div>
                </div>
                <small class="text-muted">Last 24 Hours</small>
            </div>

            <div class="expanses">
                <a href="categories.php?do=manage">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    <div class="middle">
                        <div class="left">
                            <h3>عدد المنتجات</h3>
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

            <div class="income">
                <i class="fa fa-bar-chart" aria-hidden="true"></i>
                <div class="middle">
                    <div class="left">
                        <h3>عدد الاقسام</h3>
                        <h1><?php echo countItems("ID", "categories"); ?></h1>
                    </div>
                    <div class="my-progress">
                        <div class="circular-progress">
                            <span class="progress-value"><?php echo countItems("ID", "categories"); ?> </span>
                        </div>
                    </div>
                </div>
                <small class="text-muted">Last 24 Hours</small>
            </div>
        </div>
        <div class="page-container">
            <div class="control-analytics">
                <h2> آخر <?php echo $user_limit ?> أعضاء مسجلين</h2>
                <?php
                if (!empty($latest_users)) {
                    foreach ($latest_users as $user) { ?>
                        <a href='userProfile.php?userid=<?php echo $user["UserID"] ?>'>
                            <div class="item online">
                                <div class="profile-photo">
                                    <img src='<?php echo $avatars . $user["Avatar"]; ?>' alt=''>
                                </div>
                                <div class="right">
                                    <div class="info">
                                        <h3><?php echo $user['Username']; ?></h3>
                                        <small class="text-muted">Last 24 Hours</small>
                                    </div>
                                    <h5 class="<?php echo ($user['RegStatus'] == 0) ? 'danger' : ' success';  ?>"><?php echo ($user['RegStatus'] == 0) ? 'غير مفعل ' : ' مفعل';  ?></h5>
                                    <h3><?php echo count_from_table("Item_ID", "items", " WHERE User_ID = $user[UserID]", " "); ?> منتج </h3>
                                </div>
                            </div>
                        </a>
                <?php     }
                } else {
                    echo "لا يوجد مستخدمين ";
                }
                ?>
                <div class="item add">
                    <a href='members.php'>
                        <i class="fas fa-users    "></i>
                        <h3>لوحة تحكم المستخدمين</h3>
                    </a>
                </div>
            </div>
            <div class="control-analytics">
                <h2> آخر <?php echo $item_limit ?> منتجات تم اضافتها</h2>
                <?php
                if (!empty($latest_items)) {
                    foreach ($latest_items as $item) { ?>

                        <div class="item online">
                            <div class="profile-photo">
                                <img src='<?php echo $itemImg;
                                            echo (!empty($item["Image"])) ? $item["Image"] : "img.png"; ?>'>
                            </div>
                            <div class="right">
                                <div class="info">
                                    <h3><?php echo $item["Name"] ?></h3>
                                    <small class="text-muted">Last 24 Hours</small>
                                </div>
                                <h5 class="<?php echo ($item['Approve'] == 0) ? 'danger' : ' success';  ?>"><?php echo ($item['Approve'] == 0) ? 'غير مفعل ' : ' مفعل';  ?></h5>
                                <h3><?php echo $item["cat_name"] ?></h3>
                            </div>
                        </div>

                <?php     }
                } else {
                    echo "لا توجد منتجات ";
                }
                ?>
                <div class="item add">
                    <a href='items.php'>
                        <i class="fas fa-tags"></i>
                        <h3>لوحة تحكم المنتجات</h3>
                    </a>
                </div>
            </div>

            <div class="control-analytics">
                <h2> آخر <?php echo $cat_limit ?> اقسام مسجلة</h2>
                <?php
                if (!empty($latest_catagories)) {
                    foreach ($latest_catagories as $cat) { ?>
                        <div class="item online">
                            <div class="cat-photo">
                                <i class="fa fa-bar-chart" aria-hidden="true"></i>
                            </div>
                            <div class="right">
                                <div class="info">
                                    <h3><?php echo $cat['Name']; ?></h3>
                                    <small class="text-muted"><?php echo $cat['Description']; ?></small>
                                </div>
                                <h5 class=""><?php echo $cat['Ordering']; ?></h5>
                            </div>
                        </div>

                <?php     }
                } else {
                    echo "لا يوجد أقسام مسجلة ";
                }
                ?>
                <div class="item add">
                    <a href='categories.php'>
                        <i class="fa fa-comments" aria-hidden="true"></i>
                        <h3>لوحة تحكم الاقسام</h3>
                    </a>
                </div>
            </div>

        </div>
    </main>

</section>


<?php
include $tpl . 'footer.php';

ob_end_flush();
?>