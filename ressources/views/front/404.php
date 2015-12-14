<?php ob_start(); ?>
    <h1>Page 404 !</h1>
    <P><?php echo $message; ?></P>
<?php
$content = ob_get_clean();
include __DIR__.'/../layouts/master.php';