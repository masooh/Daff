<?php
require_once("includes/Lftp.php");
require_once("includes/dao.php");

$opts = getopt("d:");
$ftp_dir = $opts["d"];

$mirror_file = ".log/mirror.log";
$paths = Lftp::extract_mirror_paths($ftp_dir . "/" . $mirror_file);

echo '$paths' . "\n";
print_r($paths);

$cls_commands = Lftp::generate_cls_commands(array_keys($paths));

file_put_contents($ftp_dir . "/.lftp/cls-command.lftp", implode("\n", $cls_commands));
?>