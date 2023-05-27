<?php
/*
================================================
== Manage members page 
== you can add | edit | delete members from here
================================================
*/

ob_start();
session_start();
$pageTitle = "البروفايل";
$dir = 'rtl';
$noNavbar = "";
// error_reporting(0);
if ((!isset($_SESSION["admin_name"])) && (!isset($_SESSION['role'])) && ($_SESSION['role'] != 1)) {
    header("location:index.php");
    exit();
}

include 'init.php';
?>


<?php
if (isset($_GET['userid'])) {

    // check if get request userid is numeric & get the integer value of it
    $userid = (is_numeric($_GET["userid"])) ? intval($_GET['userid']) : 0;
    $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?  LIMIT 1");
    $stmt->execute(array($userid));
    $info = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count > 0) {
        $user_id = $info['UserID']; ?>
        <section class="home">
            <main>
                <div class="container">
                    <?php if (!isset($_GET['edit'])) { ?>
                        <div class="row">
                            <div class="profile ">
                                <div class="user">
                                    <div class="profile-user">
                                        <img src="<?php echo $avatars . $info["Avatar"]; ?>" alt="">
                                    </div>
                                    <div class="profile-name">
                                        <span id="username_profile"><?php echo $info['Username']  ?></span>
                                        <a id="edituser" href="userProfile.php?userid=<?php echo $info['UserID']; ?>&edit">
                                            <i class="fas fa-user-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <form id="update_profile" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                            <input type="hidden" name="username" id="username" value="<?php echo $info['Username']; ?>">
                            <div class="row">
                                <div class="profile ">
                                    <div class="user">
                                        <div class="profile-user">
                                            <img src="<?php echo $avatars . $info["Avatar"]; ?>" alt="">
                                        </div>
                                        <div class="profile-name">
                                            <input type="file" name="avatar" id="upload_avatar_user" accept=".jpg, .jpeg, .png , .gif, .ico">
                                            <label id="avatar_label" for="upload_avatar_user">
                                                <i class="fa fa-camera" aria-hidden="true"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <script>
                            document.getElementById("upload_avatar_user").onchange = function() {
                                document.getElementById("update_profile").submit();
                            }
                        </script>
                    <?php } ?>

                    <div class="information row   profile-info">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fas fa-user-cog"></i>
                                <p> البيانات الشخصية</span>
                            </div>
                            <div class="panel-body">
                                <?php if (!isset($_GET['edit'])) { ?>
                                    <ul class=" list-unstyled">
                                        <li>
                                            <span><i class="fa fa-unlock-alt" aria-hidden="true"></i> اسم المستخدم :</span>
                                            <span><?php echo $info['Username']; ?></span>
                                        </li>
                                        <li>
                                            <span><i class="fa fa-envelope" aria-hidden="true"></i> الإيميل :</span>
                                            <span><?php echo $info['UserEmail']; ?></span>
                                        </li>
                                        <li>
                                            <span> <i class="fa fa-lock"></i> كلمة المرور :</span>
                                            <input id="userpassword" type="password" readonly value="<?php echo $info['password']; ?>">
                                        </li>
                                        <li>
                                            <span> <i class="fa fa-user" aria-hidden="true"></i> الاسم الكامل :</span>
                                            <span><?php echo $info['FullName']; ?></span>
                                        </li>
                                        <li>
                                            <span> <i class="fas fa-calendar-alt    "></i> تاريخ التسجيل: </span>
                                            <span><?php echo $info['Date']; ?></span>
                                        </li>
                                        <?php
                                        if ($info['GroupID'] == 1 && $info['UserID'] == $_SESSION['admin_id']) { // admin 
                                        ?>
                                            <li>
                                                <span> <i class="fa fa-tags" aria-hidden="true"></i> حالة الحساب : </span>
                                                <span class="w-auto">
                                                    أدمن <?php echo $_SESSION['role']; ?>
                                                </span>
                                            </li>
                                        <?php

                                        } else {
                                        ?>
                                            <li>
                                                <span> <i class="fa fa-tags" aria-hidden="true"></i> حالة الحساب : </span>
                                                <span class="w-auto">
                                                    <?php if ($info['RegStatus'] == 0) { ?>
                                                        <div class="alert btn-danger"><i class='fa fa-close'></i> حساب يحتاج لى تفعيل </div>
                                                    <?php } else { ?>
                                                        <div class="alert btn-success"> <i class="fa fa-check"></i> الحساب مفعل </div>
                                                    <?php } ?>
                                                </span>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                <?php } else { ?>
                                    <form action="members.php?do=update" method="POST">
                                        <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                                        <ul class=" list-unstyled">
                                            <li>
                                                <span><i class="fa fa-unlock-alt" aria-hidden="true"></i> اسم المستخدم :</span>
                                                <input type="text" name="username" id="username" value="<?php echo $info['Username']; ?>">
                                            </li>
                                            <li>
                                                <span><i class="fa fa-envelope" aria-hidden="true"></i> الإيميل :</span>
                                                <input class="w-auto" type="email" name="email" id="email" value="<?php echo $info['UserEmail']; ?>">
                                            </li>
                                            <li>
                                                <span> <i class="fa fa-lock"></i> كلمة المرور :</span>
                                                <input type="hidden" name="oldPassword" value="<?php echo $info['password']; ?>">
                                                <input type="password" name="newPassword" id="password" autocomplete="new-password" pattern="[A-z-0-9-@-_-$]*" placeholder="إتركه فارغا اذا كنت لا تريد تغيير كلمة المرور ">
                                            </li>
                                            <li>
                                                <span> <i class="fa fa-user" aria-hidden="true"></i> الاسم الكامل :</span>
                                                <input class="w-auto" type="text" name="full" id="full" value="<?php echo $info['FullName']; ?>">
                                            </li>
                                            <li>
                                                <span> <i class="fas fa-calendar-alt    "></i> تاريخ التسجيل: </span>
                                                <span><?php echo $info['Date']; ?></span>
                                            </li>
                                            <?php
                                            if ($info['GroupID'] == 1 && $info['UserID'] == $_SESSION['admin_id']) {  // admin 
                                            ?>
                                                <li>
                                                    <span> <i class="fa fa-tags" aria-hidden="true"></i> حالة الحساب : </span>
                                                    <span class="w-auto">
                                                        أدمن
                                                    </span>
                                                </li>
                                            <?php
                                            } else {
                                            ?>
                                                <li>
                                                    <span> <i class="fa fa-tags" aria-hidden="true"></i> حالة الحساب : </span>
                                                    <span class="w-auto">
                                                        <?php if ($info['RegStatus'] == 0) { ?>
                                                            <a href='members.php?do=active&userid=<?php echo $info["UserID"] ?>' class=' success'>
                                                                <div class="btn btn-success"><i class='fa fa-check '></i> تفعيل الحساب</div>
                                                            </a>

                                                        <?php } else { ?>
                                                            <a href='members.php?do=disactive&userid=<?php echo $info["UserID"] ?>' class=' danger'>
                                                                <div class="btn btn-danger"><i class='fa fa-close'></i>إلغاء تفعيل الحساب</div>
                                                            </a>
                                                        <?php } ?>
                                                    </span>
                                                </li>
                                            <?php
                                            }
                                            ?>
                                            <button type="submit" class="btn btn-success ">حفظ <i class="fa fa-save"></i> </button>
                                        </ul>
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div id=" my-item" class="row profile-info">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fas fa-user-tag"></i>
                                <p>المنتجات</p>
                            </div>
                            <div class="panel-body">
                                <?php
                                $items = get_from_table("*", "items", "WHERE user_id = $user_id ", "", "Item_ID", "DESC");
                                if (!empty($items)) {
                                ?>
                                    <div class="slide-container swiper">
                                        <div class="slide-content">
                                            <div class="swiper-wrapper">
                                                <?php foreach ($items as $item) { ?>
                                                    <div class="card swiper-slide">
                                                        <div class="image-content">
                                                            <span class="overlay"></span>
                                                            <div class="card-image">
                                                                <img src='<?php echo $itemImg; ?><?php echo (!empty($item["Image"])) ? $item["Image"] : "img.png"; ?>'>
                                                            </div>
                                                            <?php if ($item['Approve'] == 0) {
                                                                echo '<span class="approve-status"> بانتظار التفعيل</span>';
                                                            } ?>
                                                        </div>

                                                        <div class="card-content">
                                                            <h2 class="name"> <?php echo $item['Name'] ?></h2>
                                                            <span class="price-tag"> <?php echo $item['Price']; ?></span>
                                                            <p class="description"><?php echo $item['Description'] ?></p>

                                                            <?php if (isset($_GET['edit'])) { ?>
                                                                <span class="control d-flex gap-4">
                                                                    <a href='items.php?do=edit&itemid=<?php echo $item["Item_ID"] ?>' class='show-tittle round' my_tittle="تعديل المنتج">
                                                                        <button class="button">
                                                                            <i class='fa fa-edit '></i>
                                                                        </button>
                                                                    </a>
                                                                    <a href='items.php?do=delete&itemid=<?php echo $item["Item_ID"] ?>' class='show-tittle confirm round ' my_tittle="حذف المنتج">
                                                                        <button class="button">
                                                                            <i class='fa fa-trash '></i>
                                                                        </button>
                                                                    </a>
                                                                    <?php if ($item['Approve'] == 0) { ?>
                                                                        <a href='items.php?do=approve&itemid=<?php echo $item["Item_ID"] ?>' class='show-tittle round ' my_tittle="تفعيل المنتج">
                                                                            <button class="button">
                                                                                <i class='fa fa-check '></i>
                                                                            </button>
                                                                        </a>
                                                                    <?php } else { ?>
                                                                        <a href='items.php?do=disapprove&itemid=<?php echo $item["Item_ID"] ?>' class='show-tittle round ' my_tittle="الغاء تفعيل المنتج">
                                                                            <button class="button">
                                                                                <i class='fa fa-close '></i>
                                                                            </button>
                                                                        </a>
                                                                    <?php } ?>
                                                                </span>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <?php if (count_from_table("*", "items", "WHERE user_id = $user_id ", "") > 3) { ?>
                                            <div class="swiper-button-next swiper-navBtn"></div>
                                            <div class="swiper-button-prev swiper-navBtn"></div>
                                            <div class="swiper-pagination"></div>
                                        <?php } ?>

                                    </div>
                                <?php
                                } else {
                                    echo "لا توجد اي منتجات حاليا";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div id="my-comment" class="row profile-info">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-commenting" aria-hidden="true"></i>
                                <p> الأراء والتعليقات</p>
                            </div>
                            <div class="panel-body">
                                <?php
                                $comments = get_from_table("Comment", "comments", "WHERE user_id = $user_id ", "", "Item_ID", "DESC");
                                if (!empty($comments)) {
                                    foreach ($comments as $comment) { ?>
                                        <div class="comment-box">
                                            <p class="member-c"> <i class="fa fa-commenting "></i> <?php echo $comment['Comment']; ?></p>
                                        </div>
                                <?php }
                                } else {
                                    echo "لا يوجد اي تعليقات حاليا";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </section>
<?php }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id   = $_POST['userid'];
    $name   = $_POST['username'];

    // Uploads Variable
    $avatar_name = $_FILES['avatar']['name'];
    $avatar_tmp = $_FILES['avatar']['tmp_name'];
    $avatar_size = $_FILES['avatar']['size'];

    // list of allowed extension to upload
    $allowed_extension = ["jpeg", "jpg", "png", "gif", "ico"];

    // get avatar extension
    $avatar_extension = pathinfo($avatar_name, PATHINFO_EXTENSION);

    // validate the form 
    $formErrors = [];
    if (!empty($avatar_name) && !in_array($avatar_extension, $allowed_extension)) {
        $formErrors[] = 'هذه الصيفة <b> غير مسموح بها</b>';
    }

    if ($avatar_size > 4194304) { // 4MB
        $formErrors[] = "الحجم لا يجب ان يكون اكبر من <b>4MB</b>";
    }

    foreach ($formErrors as $error) {
        if (!empty($error)) {
            echo " <div class='container'>";
            echo  "<div class ='alert alert-danger' role='alert'>$error</div>";
            echo " </div>";
        }
    }


    // check if no error 
    if (empty($formError)) {
        $avatar = $name . "-" . date("Y.m.d") . "-" . date("h.i.sa");
        $avatar .= "." . $avatar_extension;
        move_uploaded_file($avatar_tmp, $avatars . $avatar);
        // update database with this info
        $stmt = $con->prepare("UPDATE users SET Avatar = ? WHERE UserID = ?");
        $stmt->execute(array($avatar, $id));
        if ($stmt) {
            header("location:userProfile.php?userid=$id");
        }
    }
}
?>

<?php
include $tpl . 'footer.php';
ob_end_flush();
