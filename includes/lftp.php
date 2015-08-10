<?php
require_once("File.php");

function extract_mirror_paths($mirror_file)
{
    $mirror_lines = explode("\n", file_get_contents($mirror_file));

    $paths = array();

    foreach ($mirror_lines as $line) {
        if (strpos($line, "get") !== FALSE) {
            $url_string = explode(" ", $line)[3];
            $path = parse_url($url_string)["path"];
            $paths[] = $path;
        }
    }
    return $paths;
}

function generate_cls_commands($paths){
    $commands = array();
    foreach ($paths as $path) {
        $commands[] = "cls -s --block-size=1 -1 $path";
    }

    return $commands;
}

function extract_cls($cls_log)
{
    if (!file_exists($cls_log)) {
        throw new Exception("CLS Log is missing: " . $cls_log);
    }
    $cls_lines = explode("\n", file_get_contents($cls_log));

    echo "cls_lines";
    var_dump($cls_lines);

    $files = array();
    $between_marker = false;

    foreach ($cls_lines as $line) {
        if (strpos($line, "marker-start")) {
            $between_marker = true;
            continue;
        } elseif (strpos($line, "marker-end")) {
            $between_marker = false;
            break;
        }

        if ($between_marker) {
            $file = new File();
            $cls_array = explode(" ", $line);

            echo "cls_array";
            var_dump($cls_array);
            $file->bytes = $cls_array[0];
            $file->source_path = $cls_array[1];
            $file->filename = basename($cls_array[1]);
            $files[] = $file;
        }

    }
    return $files;
}
?>