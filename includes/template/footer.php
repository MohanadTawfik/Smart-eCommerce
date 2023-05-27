<?php if (!isset($no_head_and_nav)) {
  echo "</div>";
}
?>

<script src="<?php echo $js; ?>jquery-3.6.4.min.js"></script>
<script src="<?php echo $js; ?>bootstrap.bundle.min.js"></script>
<script src="<?php echo $js; ?>swiper-bundle.min.js"></script>
<script src="<?php echo $js; ?>main.js"></script>

<script>
  <?php if (isset($_SESSION['user_state']) && isset($_SESSION['user_message'])) { ?>
    notify("<?php echo $_SESSION['user_state'] ?>", "<?php echo $_SESSION['user_message'] ?>");
  <?php
    unset($_SESSION['user_state']);
    unset($_SESSION['user_message']);
  } ?>
</script>

</body>

</html>