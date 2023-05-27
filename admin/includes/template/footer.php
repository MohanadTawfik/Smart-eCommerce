<?php if (!isset($no_head_and_nav)) {
  echo "</div>";
}
?>
<script src="<?php echo $js; ?>jquery-3.6.4.min.js"></script>
<script src="<?php echo $js; ?>jquery.dataTables.min.js"></script>
<script src="<?php echo $js; ?>dataTables.bootstrap5.min.js"></script>
<script src="<?php echo $js; ?>bootstrap.bundle.min.js"></script>
<script src="<?php echo $js; ?>swiper-bundle.min.js"></script>
<script src="<?php echo $js; ?>main.js"></script>

<script>
  <?php if (isset($_SESSION['state']) && isset($_SESSION['massage'])) { ?>
    notify("<?php echo $_SESSION['state'] ?>", "<?php echo $_SESSION['massage'] ?>");
  <?php
    unset($_SESSION['state']);
    unset($_SESSION['massage']);
  } ?>
</script>

</body>

</html>