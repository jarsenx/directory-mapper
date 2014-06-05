<?php

define("SRCHBL_IDX_BEGIN_PATH", $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . 'directory-mapper' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'srchbl_idx_begin.txt');
define("SRCHBL_IDX_END_PATH", "'..' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'srchbl_idx_end.txt'");
include('fileutil.inc.php');

function buildAndSaveFile($links) {
    // read the contents of srchbl_idx_begin.txt
    // close the file
    // open a new file in append mode and push the beginning HTML to it
    // iterate through the links array and append them to the open file
    // read the contents of srchbl_idx_end.txt
    // push the ending HTML to the new file
    // close the file
    // close the new file

    $fileBegin = getFileContents(SRCHBL_IDX_BEGIN_PATH);
    echo $fileBegin;
}
