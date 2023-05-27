<?php
ob_start();
session_start();
$no_head_and_nav = "";
$pageTitle = "تسجيل الدخول";
$dir = 'rtl';
// error_reporting(0);



if (isset($_SESSION["user_name"])) {
    header('location: index.php');
    exit(0);
} else {
    include 'init.php';
?>
    <div class="container loginContainer">
        <div id="steps" class="steps row">
            <div class="button-login">
                <span id="form_button" data-class="login" class="col-sm-6 show-tittle selected" my_tittle="تسجيل الدخول">
                    تسحيل الدخول
                    <i class="fas fa-right-to-bracket"> </i>
                </span>
                <span id="form_button" data-class="signup" class="col-sm-6 show-tittle" my_tittle="انشاء حساب والتسجيل">
                    إنشاء حساب
                    <i class="fas fa-user-plus"></i>
                </span>
            </div>
        </div>

        <div class="login-page">
            <div class="box-form col-sm-12 col-md-8 col-lg-6">
                <div class="form-content">
                    <form id="login" class="content" name="login" action="login.php?login" autocomplete="off" method="POST">
                        <div class="input-group row col-12">
                            <input type="text" name="username" required>
                            <label>إسم المستخدم</label>
                        </div>
                        <div class="input-group row col-12 ">
                            <input type="password" name="password" required>
                            <label>كلمة المرور</label>
                        </div>
                        <div class="row col-12 ">
                            <button type="submit" class="btn">
                                <span class="text">دخول</span><i class="fas fa-check icon"></i>
                            </button>
                        </div>
                    </form>


                    <form id="signup" class="content" name="signup" action="login.php?signup" method="POST" autocomplete="off">
                        <div class="input-group">
                            <input type="text" required autocomplete='off' name="user" pattern=".{4,}">
                            <label>إسم المستخدم</label>
                        </div>
                        <div class="input-group">
                            <input type="email" required name="email">
                            <label>البريد الالكتروني</label>
                        </div>
                        <div class="input-group">
                            <input type="password" required name="pass" autocomplete='new-password'>
                            <label>كلمة المرور</label>
                        </div>
                        <div class="input-group">
                            <input type="password" required name="con-pass" autocomplete='new-password'>
                            <label> تأكيد كلمة المرور</label>
                        </div>
                        <div class="input-group">
                            <input type="text" required autocomplete='off' name="full" pattern=".{4,}">
                            <label> الاسم الكامل</label>
                        </div>
                        <button type="submit" class="btn">
                            <span class="text">تسجيل</span>
                            <i class="fas fa-check icon"></i>
                        </button>
                    </form>

                </div>
            </div>

        </div>

    </div>
    <?php

    /// check if user coming from HTTP request
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_GET['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $hashPass = sha1($password);


            // check if user exist in database
            $stmt = $con->prepare("SELECT UserID , Username, `password` FROM users WHERE Username = ? AND `password` = ?");
            $stmt->execute(array($username, $hashPass));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();

            // if count > 0 this mean the database contain the record about this username
            if ($count > 0) {
                $_SESSION["user_name"] = $username; // register session name
                $_SESSION['ID'] = $row['UserID']; // register session ID
                if ($row['Approve'] == 0) {
                    $_SESSION['state'] = "warning";
                    $_SESSION['massage'] = "لحساب غير نشط. الرجاء الاتصال بالمسؤول!";
                }
                header('location: index.php');
            }
        } elseif (isset($_GET['signup'])) {
            $user = $_POST['user'];
            $password = $_POST['pass'];
            $password2 = $_POST['con-pass'];
            $email = $_POST['email'];
            $full = $_POST['full'];

            $form_errors = [];
            // filter name
            if (isset($user)) {
                $filter_user = filter_var($user, FILTER_SANITIZE_STRING);
                if (strlen($filter_user) < 4) {
                    $form_errors[] = "إسم المستخدم  يجب أن يكون أكبر من 4 أحرف";
                }
            }

            // filter name
            if (isset($full)) {
                $filter_user = filter_var($user, FILTER_SANITIZE_STRING);
                if (strlen($filter_user) < 4) {
                    $form_errors[] = "الاسم الكامل يجب أن يكون أكبر من 4 أحرف";
                }
            }

            // filter password
            if (isset($password) && isset($password2)) {
                if (empty($password)) {
                    $form_errors[] = "عذراً كلمة المرور فارغة";
                }
                if (sha1($password) !== sha1($password2)) {
                    $form_errors[] = "عذراً كلمة المرور غير مطابقه";
                }
            }

            // filter email
            if (isset($email)) {
                $filter_email = filter_var($email, FILTER_SANITIZE_EMAIL);
                if (filter_var($filter_email, FILTER_VALIDATE_EMAIL) != true) {
                    $form_errors[]  = "الإيميل غير صحيح";
                }
            }


            // check if no error 
            if (empty($form_errors)) {
                //check if user exist in database
                $check = checkItem("Username", 'users', $filter_user);
                if ($check == 1) {
                    $form_errors[] =  "عذراً هذا المستخدم غير موجود";
                } else {
                    // insert user info to database 
                    $stmt = $con->prepare("INSERT INTO users(Username,`password`,UserEmail, FullName ,RegStatus,`Date`) VALUES(:userV, :passV ,:emailV,:fullV, 0,now())");
                    $stmt->execute(array('userV' => $filter_user, 'passV' => sha1($password), 'emailV' => $filter_email, 'fullV' => $full));
                    $successMsg = "تم إنشاء الحساب بنجاح .. بمكنك الان تسجيل الدخول";
                }
            }
        }
    }
    ?>

    <div class="the-errors text-center">
        <?php
        if (!empty($form_errors)) {
            foreach ($form_errors as $error) {
                echo "<div class='msg error'>" . $error . "</div>";
            }
        }
        if (isset($successMsg)) {
            echo "<div class='msg success'>" . $successMsg . "</div>";
        }
        ?>
    </div>

<?php
}
include $tpl . 'footer.php';
ob_end_flush();
