<?php
function getFileContents($filepath) {
    $file = null;
    try {
        // open a file for reading
        if ($file = fopen($filepath, "r")) {

            // read the contents of the file
            $contents = fread($file, filesize($filepath));
            return $contents;
        }
    } catch (Exception $e) {
        echo "Exception occurred: " . $e->getMessage();
    } finally {
        if (isset($file)) {
            fclose($file);
        }
    }

}