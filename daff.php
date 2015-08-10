<?php
require_once("includes/lftp.php");
require_once("includes/dao.php");

$opts = getopt("d:");

var_dump($opts);

$ftp_dir = $opts["d"];

var_dump($ftp_dir);

$mirror_file = "/tmp/mirror.log";
$paths = extract_mirror_paths($mirror_file);
$cls_commands = generate_cls_commands($paths);

file_put_contents($ftp_dir . "/cls-command.lftp", implode("\n", $cls_commands));

//foreach ($paths as $path) {
//    insert_movie($path, basename($path), null);
//}
?>

