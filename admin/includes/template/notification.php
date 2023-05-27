<div class="dropdown notifying">
    <?php
    $userid = $_SESSION["admin_id"];
    $isread = 0;
    $query = $con->prepare("SELECT notify.* , users.* from notify , users  where notify.fromuser = users.UserID AND isread = $isread AND touser = $userid");
    $query->execute();
    $results = $query->fetchAll();
    if ($query->rowCount() > 0) {
        $unreadcount = $query->rowCount();
    } else {
        $unreadcount = 0;
    }


    ?>
    <i class="bell-notify fa fa-bell" data-bs-toggle="dropdown">
        <span class="translate-middle badge bg-danger "><?php echo $unreadcount; ?></span>
    </i>

    <div class="dropdown-menu bell-notify-box notify-box">
        <span class="notify-title">
            <strong class="ms-auto"> لديك <?php echo $unreadcount; ?> اشعارات </strong>
            <small class="text-body-secondary">الان</small>
            <i class="fa fa-close me-3 close" data-bs-dismiss="toast" aria-label="Close" aria-hidden="true"></i>
        </span>

        <div class="notify-list">
            <?php
            if (!empty($results)) {
                foreach ($results as $result) {
            ?>
                    <div class="notify-item dropdown-item">
                        <div class="notify-thumb profile-photo">
                            <img src="<?php echo $avatars; ?><?php echo (!empty($result["Avatar"])) ? $result["Avatar"] : "user.ico"; ?>" alt="" />
                        </div>
                        <div class="notify-text">
                            <div>
                                <i class="fas fa-user"></i>
                                <h3> <?php echo $result['Username']; ?></h3>
                            </div>
                            <div>
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <p> <?php echo $result['massage']; ?></p>
                            </div>
                        </div>
                        <div class="notify-control">
                            <a href="?makeread&id=<?php echo $result['id']; ?>"><i class="fa-solid fa-envelope-circle-check "></i></a>
                            <a href="?delete&id=<?php echo $result['id']; ?>"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
            <?php }
            }
            ?>

        </div>
    </div>

</div>

<?php
if (isset($_GET['makeread'])) {
    $id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    $check = checkItem("id", 'notify', $id);
    if ($check > 0) {
        $stmt = $con->prepare("UPDATE notify SET isread = 1 WHERE id =?");
        $stmt->execute(array($id));
        redirectHome("success", "تم قراءة الرسالة بنجاح", "back", 0);
    } else {
        redirectHome("danger", "عذرا هناك خطأ ما", "back", 0);
    }
} elseif (isset($_GET['delete'])) {
    $id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    $check = checkItem("id", 'notify', $id);
    if ($check > 0) {
        $stmt = $con->prepare("DELETE FROM notify WHERE id =?");
        $stmt->execute(array($id));
        redirectHome("success", "تم  الحذف بنجاح", "back", 0);
    } else {
        redirectHome("danger", "عذرا هناك خطأ ما", "back", 0);
    }
}
?>