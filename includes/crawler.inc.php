<?php

// Called from dir_mapper.php
function getFileLinks($path)
{
    $directory = new RecursiveDirectoryIterator($path);
    // Whoa, am I really defining a function inline and passing it as an argument to the filter class constructor?
    $filter = new RecursiveCallbackFilterIterator($directory, function ($current, $key, $iterator) {
        // Skip hidden files and directories.
        if ($current->getFilename()[0] === '.') {
            return FALSE;
        }
        return true;
    });

    $files = new RecursiveIteratorIterator($filter, RecursiveIteratorIterator::SELF_FIRST);
    $links = array();

    foreach ($files as $file) {
        $links[] = getLinkCode($file, $path, $files->getDepth() + 1);
    }
    return $links;
}

// Called from this->getFileLinks($path)
function getLinkCode($file, $basedir, $depth) {
    // set description to be the filename
    $description = substr(strrchr($file, DIRECTORY_SEPARATOR), 1);

    // generate class attribute for link
    $classes = '';

    if (is_dir($file)) {
        $classes = 'class="directory';
        // TO DO: fix the $dirpath assignment so that there is no leading slash on subdirectory names
        $dirpath = substr($file, strlen($basedir));
        $description = $dirpath;
        $file = "file:///" . $file;
    } else {
        $file = "file:///" . $file;
    }

    if ($depth === 0) {
        $classes = $classes . '"';
    }

    if ($depth > 0) {
        $indent = 'indent' . $depth;
        if (!empty($classes)) {
            $classes = $classes . ' ' . $indent . '"';
        } else {
            $classes = 'class="' . $indent . '"';
        }
    } else {

    }

    $linkCode = sprintf('<a %1$s href="%2$s">%3$s</a><br />', $classes, $file, $description);
    return $linkCode;
}

