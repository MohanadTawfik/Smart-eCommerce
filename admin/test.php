 <!DOCTYPE html>
 <html lang="en">

 <head>
   <meta charset="UTF-8">
   <link rel="stylesheet" href="layout/css/font-awesome.min.css" />
   <link rel="stylesheet" href="layout/css/all.min.css" />
   <link rel="stylesheet" href="layout/css/bootstrap.min.css" />
   <link rel="stylesheet" href="layout/css/dataTables.bootstrap5.min.css" />
   <link rel="stylesheet" href="layout/css/swiper-bundle.min.css" />
   <link rel="stylesheet" href="layout/css/style.css" />

 </head>

 <body>

   <?php


    include 'includes/template/connect.php';
    $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 ORDER BY UserID ASC  LIMIT 4 ");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    if (!empty($rows)) {
    ?>

     <div class="row mb-2">
       <h2 class=" d-flex align-items-center"> آخر 4 مستخدمين</h2>
     </div>
     <table >
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
                 <div class="image"><img src="<?php echo $avatars . $info["Avatar"]; ?>"></div>
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
   <?php } ?>
   <script src="layout/js/jquery-3.6.4.min.js"></script>
   <script src="layout/js/jquery.dataTables.min.js"></script>
   <script src="layout/js/dataTables.bootstrap5.min.js"></script>
   <script src="layout/js/bootstrap.bundle.min.js"></script>
   <script src="layout/js/swiper-bundle.min.js"></script>
   <script src="layout/js/main.js"></script>
 </body>

 </html>