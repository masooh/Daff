<?php
require_once("includes/Lftp.php");
require_once("includes/dao.php");

$opts = getopt("d:");
$ftp_dir = $opts["d"];

$local_file_lines = explode("\n", file_get_contents($ftp_dir . "/.log/local_files.log"));

foreach ($local_file_lines as $line) {
    if (!empty(trim($line))) {
        $parts =  explode(" ", $line);
        print_r($parts);
        $file = new File();
        $file->source_path = $parts[1];
        $file->filename = basename($parts[1]);
        $file->bytes = $parts[0];
        $file->local_path = $ftp_dir . $parts[1];
        update_store_meta($file);
    }
}

?>

