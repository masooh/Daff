<?php
require_once("includes/Lftp.php");
require_once("includes/dao.php");

$opts = getopt("d:s:");
$ftp_dir = $opts["d"];
$source = $opts["s"];

$files = Lftp::extract_cls($ftp_dir . "/" . Lftp::CLS_LOG);

$movies_to_fetch = array();

foreach ($files as $file) {
    $found_movies = find_movie($file);
    if (empty($found_movies)) {
        $file->source = $source;
        insert_movie($file);
        $movies_to_fetch[$file->source_path] = $file;
    } else {
        # fetch movie as only meta data is there
        if ($found_movies[0]["stored"] == false) {
            $movies_to_fetch[$file->source_path] = $file;
        }
        echo "movie already imported: " . $file->filename . "\n";
    }

}

$fetch_commands = Lftp::create_fetch_commands($movies_to_fetch, $ftp_dir .  "/.log/mirror.log");
file_put_contents($ftp_dir . "/.lftp/fetch-commands.lftp", implode("\n", $fetch_commands));
?>

