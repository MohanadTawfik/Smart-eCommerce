<?php
ob_start();
session_start();
$no_head_and_nav = '';
$pageTitle = "تسجيل الدخول";
$dir = 'ltr';
// error_reporting(0);

if ((isset($_SESSION["admin_name"])) && (isset($_SESSION['role'])) && ($_SESSION['role'] == 1)) {
    header('location: dashboard.php');
}

include 'init.php';
/// check if user coming from HTTP request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = $_POST['remember'];
    $hashPass = sha1($password);


    // check if user exist in database
    $stmt = $con->prepare("SELECT UserID , Username, `password` FROM users WHERE Username = ? AND `password` = ? AND GroupID = 1 LIMIT 1");
    $stmt->execute(array($username, $hashPass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    // if count > 0 this mean the database contain the record about this username
    if ($count > 0) {

        if ($remember  === 'on') {
            $_SESSION['admin_name'] = $username; // register session name
            $_SESSION['admin_id'] = $row['UserID']; // register session ID
            $_SESSION['role'] = $row['GroupID']; // register session ID
        }
        // if ($status == 0) {
        //     $msg = "حساب غير نشط. الرجاء الاتصال بالمسؤول!";
        // }

        header('location: dashboard.php');
        exit();
    }
}
?>

<style>
    /*-------------------- 23. Login ------------------- */

    .login-area {
        background: #f3f8fb;
    }

    .login-box {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        min-height: 100vh;
    }

    .login-box form {
        margin: auto;
        width: 450px;
        max-width: 100%;
        background: #fff;
        border-radius: 3px;
    }

    .login-form-head {
        text-align: center;
        background: #8655fc;
        padding: 50px;
    }

    .login-form-head h4 {
        letter-spacing: 0;
        text-transform: uppercase;
        font-size: calc(1.275rem + 0.3vw);
        font-weight: 600;
        margin-bottom: 7px;
        color: #fff;
    }

    .login-form-head p {
        color: #fff;
        font-size: 14px;
        line-height: 22px;
    }

    .login-form-body {
        padding: 50px;
    }

    .form-gp {
        margin-bottom: 25px;
        position: relative;
    }

    .login-form-body a {
        color: #007bff;
        text-align: right;
    }

    .login-form-body label {
        color: #b3b2b2;
        font-weight: 500;
    }

    .form-gp label {
        position: absolute;
        left: 0;
        top: 0;
        transition: all 0.3s ease 0s;
        display: inline-block;
        margin-bottom: 8px;
        margin-bottom: 0.5rem;
    }

    .form-gp.focused label {
        top: -20px;
        color: #7e74ff;
    }

    .form-gp input {
        width: 100%;
        height: 30px;
        color: #4070f4;
        border: none;
        border-bottom: 2px solid #e6e6e6;
        font-weight: bold;
    }

    .form-gp input:focus {
        outline: none;
    }


    .form-gp input::-webkit-input-placeholder {
        color: #dad7d7;
    }

    .form-gp input::-moz-placeholder {
        color: #dad7d7;
    }

    .form-gp input:-ms-input-placeholder {
        color: #dad7d7;
    }

    .form-gp input:-moz-placeholder {
        color: #dad7d7;
    }

    .form-gp i {
        position: absolute;
        right: 5px;
        color: #7e74ff;
        font-size: 16px;
    }

    .rmber-area {
        font-size: 13px;
    }

    .submit-btn-area {
        text-align: center;
    }

    .submit-btn-area button {
        width: 100%;
        height: 50px;
        border: none;
        background: #fff;
        color: #585b5f;
        border-radius: 40px;
        text-transform: uppercase;
        letter-spacing: 0;
        font-weight: 600;
        font-size: 12px;
        box-shadow: 0 0 22px rgba(0, 0, 0, 0.07);
        -webkit-transition: all 0.3s ease 0s;
        transition: all 0.3s ease 0s;
    }

    .submit-btn-area button:hover {
        background: #2c71da;
        color: #ffffff;
    }

    .submit-btn-area button i {
        margin-left: 15px;
        transition: margin-right 0.3s ease 0s;
    }

    .submit-btn-area button:hover i {
        margin-right: 20px;
    }

    /* login-s2 */

    .login-s2 {
        background: #fff;
        position: relative;
        z-index: 1;
        overflow: hidden;
    }

    .login-s2:before {
        content: "";
        position: absolute;
        height: 206%;
        width: 97%;
        background: #fcfcff;
        border-radius: 50%;
        left: -42%;
        z-index: -1;
        top: -47%;
        box-shadow: inset 0 0 51px rgba(0, 0, 0, 0.1);
    }

    .login-s2 .login-form-head,
    .login-s2 .login-box form,
    .login-s2 .login-box form .form-gp input {
        background: transparent;
    }

    .login-s2 .login-form-head h4,
    .login-s2 .login-form-head p {
        color: #444;
    }

    /*-------------------- END Login ------------------- */
</style>

<!-- login area start -->
<div class="login-area login-s2">
    <div class="container">
        <div class="login-box ptb--100">
            <form method="POST" name="signin">
                <div class="login-form-head">
                    <h4>لوحة تسجيل دخول الادمن</h4>
                    <p>نظام التعليم الذكي</p>
                    <?php if (isset($msg)) { ?><div class="alert alert-info "> <?php echo htmlentities($msg); ?> </div><?php } ?>
                </div>

                <div class="login-form-body">
                    <div class="form-gp">
                        <input type="text" id="username" name="username" autocomplete="off" required>
                        <label for="exampleInputEmail1">إسم المستخدم</label>
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <div class="text-danger"></div>
                    </div>
                    <div class="form-gp">
                        <input type="password" id="password" name="password" autocomplete="off" required>
                        <label for="exampleInputPassword1">كلمة المرور</label>
                        <i class="fa fa-lock" aria-hidden="true"></i>
                        <div class="text-danger"></div>
                    </div>
                    <div class="row mb-4 rmber-area">
                        <div class="col-6">
                            <div class="form-check mr-sm-2">
                                <input type="checkbox" name="remember" checked class="form-check-input" id="customControlAutosizing">
                                <label class="form-check-label" for="customControlAutosizing">تذكير</label>
                            </div>
                        </div>
                        <div class="col-6" style="text-align:right ;">
                            <a href="#">هل نسيت كلمة المرور؟</a>
                        </div>
                    </div>
                    <div class="submit-btn-area">
                        <button id="form_submit" type="submit" name="signin"><i class="fa fa-arrow-left" aria-hidden="true"></i> تسجيل الدخول</button>
                    </div>
                    <!-- <div class="form-footer text-center mt-5">
                            <p class="text-muted"><a href="admin/index.php">الذهاب الى لوحة تحكم المسؤول</a></p>
                        </div> -->
                </div>
            </form>
        </div>
    </div>
</div>
<!-- login area end -->

<?php

include $tpl . 'footer.php';
ob_end_flush();
?>