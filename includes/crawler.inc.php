<?php

function sayHi()
{
    return "Hi!";
}

function buildFileList($dir, $extensions)
{
    if (!is_dir($dir) || !is_readable($dir)) {
        return false;
    } else {
        if (is_array($extensions)) {
            $extensions = implode('|', $extensions);
        }
        $pattern = "/\.(?:{$extensions})$/i";
        $folder = new DirectoryIterator($dir);
        $files = new RegexIterator($folder, $pattern);
        // initialize an array and fill it with the filenames
        $filenames = array();
        foreach ($files as $file) {
            $filenames[] = $file->getFilename();
        }
        // sort the array and return it
        natcasesort($filenames);
        return $filenames;
    }
}

function buildFileList2($dir)
{
    if (!is_dir($dir) || !is_readable($dir)) {
        return false;
    } else {
        $folder = new DirectoryIterator($dir);

        // initialize an array and fill it with the filenames
        $filenames = array();
        $filenames[] = $dir;

        foreach (new DirectoryIterator($dir) as $fileInfo) {
            if ($fileInfo->isDot()) continue;
            $filename = $fileInfo->getFilename();
            if (strpos($filename, '.') === 0 || strpos($filename, '$') === 0) continue;
            $filenames[] = $filename;
        }

        // Ask users if they want files sorted and, if so, how?
        // sort the array and return it
        // natcasesort($filenames);
        return $filenames;
    }
}

function buildFileList3($path)
{
    if (!is_dir($path) || !is_readable($path)) {
        return false;
    } else {

        $filenames = array();

        $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
        foreach ($objects as $name => $object) {
            // echo "$name\n";
            // if ($object->isDot()) continue;
            if (is_dir($object)) {
                $name = $name . '/';
            }
            $filenames[] = $name;
        }
        return $filenames;
    }
}

function filterDotFiles()
{
    $names = array();

    $directory = new RecursiveDirectoryIterator('C:\\Users\\Joseph\\Documents\\');

    // Filter out ".Trash*" folders
    //$filter = new DirnameFilter($directory, '/^(?!\.Trash)/');
    $filter = new DirnameFilter($directory, '/!\.+$/m');
    //$filter = $directory;

    // Filter PHP/HTML files
    //$filter = new FilenameFilter($directory, '/!\.+$/m');

    $objects = new RecursiveIteratorIterator($filter, RecursiveIteratorIterator::SELF_FIRST);
    foreach ($objects as $name => $object) {
        // echo $file . PHP_EOL;
        if (is_dir($object)) {
            $name = $name . '/';
        }
        $names[] = $name;
    }

    return $names;
}

function getFileLinks($path)
{
    $directory = new RecursiveDirectoryIterator($path);
    $filter = new RecursiveCallbackFilterIterator($directory, function ($current, $key, $iterator) {
        // Skip hidden files and directories.
        if ($current->getFilename()[0] === '.') {
            return FALSE;
        }
//    if ($current->isDir()) {
//        // Only recurse into intended subdirectories.
//        return $current->getFilename() === 'wanted_dirname';
//    }
//    else {
//        // Only consume files of interest.
//        return strpos($current->getFilename(), 'wanted_filename') === 0;
//    }
        return true;
    });

    $files = new RecursiveIteratorIterator($filter, RecursiveIteratorIterator::SELF_FIRST);
    $links = array();

    foreach ($files as $file) {
        //$indent = str_repeat('    ', $files->getDepth());
        //echo $indent, "$file\n";
        $links[] = getLinkCode($file, $files->getDepth() + 1);
    }
    return $links;
}

function getLinkCode($file, $depth) {
    // set description to be the filename
    $description = substr(strrchr($file, DIRECTORY_SEPARATOR), 1);

    // generate class attribute for link
    $classes = '';

    if (is_dir($file)) {
        $classes = 'class="directory';
        $description = $file;
    } else {
        $file = "file:///" . $file;
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

    //$linkCode = '<a ' . $classes . ' href="' . $line . '">' . $description . '</a><br />';
    $linkCode = sprintf('<a %1$s href="%2$s">%3$s</a><br />', $classes, $file, $description);
    return $linkCode;
}

