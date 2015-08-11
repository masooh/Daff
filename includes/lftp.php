<?php

require_once("File.php");

class Lftp {
    const CLS_LOG = ".log/cls.log";

    public static function extract_mirror_paths($mirror_file)
    {
        $mirror_lines = explode("\n", file_get_contents($mirror_file));

        $paths = array();
        foreach ($mirror_lines as $line) {
            // no deletions
            if (strpos($line, "get") !== false && strpos($line, " -e ") == false ) {
                $url_string = explode(" ", $line)[3];
                $path = parse_url($url_string)["path"];
                $paths[$path] = $line;
            }
        }
        return $paths;
    }

    public static function generate_cls_commands($paths){
        $commands = array();
        foreach ($paths as $path) {
            $commands[] = "cls -s --block-size=1 -1 $path >> " . self::CLS_LOG;
        }

        return $commands;
    }

    public static function extract_cls($cls_log)
    {
        if (!file_exists($cls_log)) {
            throw new Exception("CLS Log is missing: " . $cls_log);
        }
        $cls_lines = explode("\n", file_get_contents($cls_log));

        $files = array();

        foreach ($cls_lines as $line) {
            if (!empty(trim($line))) {
                $file = self::cls_line_to_file($line);
                $files[] = $file;
            }
        }
        return $files;
    }

    public static function create_fetch_commands($movies_to_fetch, $mirror_file)
    {
        $paths = self::extract_mirror_paths($mirror_file);

        $fetch_commands = array();

        foreach ($paths as $path => $command) {
            if (!empty(trim($path)) && array_key_exists($path, $movies_to_fetch)) {
                $fetch_commands[] = $command;
            }
        }

        return $fetch_commands;
    }

    private static function cls_line_to_file($line)
    {
        $file = new File();
        $cls_array = explode(" ", $line);
        $file->bytes = $cls_array[0];
        $file->source_path = $cls_array[1];
        $file->filename = basename($cls_array[1]);
        return $file;
    }
}