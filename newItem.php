<?php
ob_start();
session_start();
$pageTitle = "منتج جديد ";
$dir = 'rtl';
// error_reporting(0);

if (!isset($_SESSION["user_name"])) {
    header("location:index.php");
    exit(0);
} else {

    include 'init.php';
?>

    <section class="home">

        <main>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $id = $_POST['userid'];
                $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
                $desc = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
                $price =  filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT);
                $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
                $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
                $cat = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);
                $tags = filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_STRING);

                $form_errors = [];
                if (empty($name)) {
                    $formErrors[] = 'إسم المنتج لايجب أن يكون  <b>فارغاً</b>';
                }
                if (strlen($desc) < 10) {
                    $form_errors[] = "وصف المنتج ينبغي أن يكون على الأقل 10 أحرف";
                }
                if (empty($country)) {
                    $formErrors[] = 'إسم البلد لايجب أن يكون  <b>فارغاً</b>';
                }
                if (empty($price)) {
                    $formErrors[] = 'سعر المنتج لايجب أن يكون  <b>فهرغاً</b>';
                }
                if (empty($status)) {
                    $formErrors[] = 'يجب عليك إختيار الحالة';
                }
                if (empty($cat)) {
                    $formErrors[] = 'يجب عليك إختيار القسم';
                }

                // check if no error 
                if (empty($formError)) {
                    // insert Item info to database 
                    $stmt = $con->prepare("INSERT INTO items(`Name` , `Description` , Price , Country_Made, `Status` , Cat_ID , `User_ID` ,tags, Add_Date) VALUES(?, ?, ?, ?, ?, ?, ?, ? ,now())");
                    $stmt->execute(array($name, $desc, "$" . $price, $country, $status, $cat, $id, $tags));
                    if ($stmt) {
                        $successMsg = " تم اضافة المنتج";
                    }
                }
            }
            ?>
            <h1 class="text-center"><?php echo $pageTitle; ?></h1>
            <div class="row live-review">
                <!-- live review -->
                <div>
                    <div class="product-card live-preview">
                        <div class="logo-cart">
                            <img class="live-image" src=" <?php echo $itemImg . "img.png"; ?>" alt="logo">
                            <i class="fa fa-heart" aria-hidden="true"></i>
                        </div>
                        <div class="main-images">
                            <img class="live-image" src=" <?php echo $itemImg . "img.png"; ?>" alt="logo">">
                        </div>
                        <div class="shoe-details">
                            <div class="details">
                                <span class="shoe_name live-title"> اسم المنتج</span>
                                <span class="price_num ">$<span class="live-price">0</span></span>
                            </div>
                            <div class="price">
                                <div class="stars">
                                    <div class="star-inner"></div>
                                </div>
                                <p class="live-desc">الوصف</p>
                            </div>
                        </div>
                        <div class="button">
                            <div class="button-layer"></div>
                            <button type="submit"> إضافة للسلة <i class="fas fa-shopping-cart"></i> </button>
                        </div>
                    </div>
                </div>

                <div>
                    <form class="from-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <input type="hidden" name="userid" value="<?php echo $_SESSION['ID']; ?>">
                        <div class="mb-3 row ">
                            <label for="Name">اسم المنتج</label>
                            <div class=" input-container ">
                                <input type="text" name="name" class="form-control live" pattern=".{4,}" title="This Field Require At Least 4 Characters" data-class=".live-title" id="Name" autocomplete="off" required placeholder="اسم المنتج">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="description">وصف المنتج</label>
                            <div class=" input-container ">
                                <input type="text" name="description" class=" form-control live" pattern=".{10,}" title="This Field Require At Least 10 Characters" data-class=".live-desc" id="description" required placeholder="وصف المنتج ">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="price">سعر المنتج</label>
                            <div class=" input-container ">
                                <input type="text" name="price" class="form-control live" data-class=".live-price" id="price" required placeholder="سعر المنتج   ">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="country">دولة الصنع</label>
                            <div class=" input-container ">
                                <input type="text" name="country" class="form-control" id="country" required placeholder="دولة الصنع">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="status">حالة المنتج</label>
                            <div class=" input-container ">
                                <select class="form-select" name="status" id="status" required aria-label="Default select example">
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
                                <select class="form-select" name="category" id="category" required aria-label="Default select example">
                                    <option selected>إختر القسم </option>
                                    <?php
                                    $stmt_cat = $con->prepare("SELECT * FROM categories WHERE Visibility = 0");
                                    $stmt_cat->execute();
                                    $cats = $stmt_cat->fetchAll();
                                    foreach ($cats as $cat) { ?>
                                        <option value=" <?php echo $cat['ID']; ?>">
                                            <?php echo $cat['Name']; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="tags">هاشتاج</label>
                            <div class=" input-container ">
                                <input type="text" name="tags" class="form-control" id="tags" placeholder="افصل بين الهشتاجات بالفاصلة  (,)">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="image">الصورة</label>
                            <div class="input-container ">
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
            <!-- start looping throw errors  -->
            <?php
            if (!empty($form_errors)) {
                echo '<div class="container">';
                foreach ($form_errors as $error) {
                    echo  "<div class ='alert alert-danger' role='alert'>$error</div>";
                }
                echo '</div>';
            }
            if (isset($successMsg)) {
                echo '<div class="container">';
                echo "<div class='alert alert-success'>" . $successMsg . "</div>";
                echo '</div>';
            }
            ?>

            <!-- end looping throw errors  -->
        </main>
    </section>

<?php
}
include $tpl . 'footer.php';


ob_end_flush();
?>