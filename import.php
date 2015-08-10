<?php
require_once("includes/lftp.php");
require_once("includes/dao.php");

$opts = getopt("d:");
$ftp_dir = $opts["d"];

$files = extract_cls($ftp_dir . "/lftp.log");

var_dump($files);

foreach ($files as $file) {
    insert_movie($file);
}
?>

