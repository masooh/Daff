<?php
require_once("File.php");
require_once ('MysqliDb.php');

new MysqliDb ('localhost', 'root', '', 'moviedb');

function find_movie($file)
{
    $db = MysqliDb::getInstance();

    $db->where('filename', $file->filename);
    $movies = $db->get('movies');
    print_r($movies);
    return $movies;
}

function insert_movie($file)
{
    $db = MysqliDb::getInstance();

    $data = Array ("source_path" => $file->source_path,
        "filename" => $file->filename,
        "bytes" => $file->bytes
    );
    $id = $db->insert ('movies', $data);
    if($id) {
        echo "new movie " . $file->filename . "\n";
    } else {
        echo 'insert failed: ' . $db->getLastError();
    }
}

function update_store_meta($file)
{
    echo "Update meta data for " . $file->source_path . "\n";

    $db = MysqliDb::getInstance();
    $db->where('filename', $file->filename);
    $db->where('bytes', $file->bytes);
    $movies = $db->get('movies');
    if (empty($movies)) {
        echo "found file has no metadata in DB\n";

        $data = Array ("local_path" => $file->local_path,
            "filename" => $file->filename,
            "bytes" => $file->bytes,
            "stored" => true
        );
        $id = $db->insert ('movies', $data);
        if($id) {
            echo "new movie " . $file->filename . "\n";
        } else {
            echo 'insert failed: ' . $db->getLastError();
        }
    } else if (sizeof($movies) > 1) {
        echo "more than one matching file\n";
    } else {
        $movie = $movies[0];
        $movie['stored'] = true;
        $movie['local_path'] = $file->local_path;
        $db->where('id', $movie["id"]);
        $db->update('movies', $movie);
    }
}
?>
