<?php
// Build a utility that will present a web page to the user.
// The page will have a filesystem explorer to select a folder,
// a checkbox to select recursive action, and a button to start
// the process.

// The user will select a folder and click the start button. The
// utility will create a link for the selected folder and for
// every object, folder or file, in the selected folder. If the
// recursive checkbox is selected, then links will be created for
// every object in any subfolders of the selected folder.

// First step: present a page with a file selector, a checkbox,
// and a start button. When the user clicks on the start button,
// check to see if the value of the file selector is set and if
// it is the path to a valid folder location. If not, return to
// the page and display an error message. If so, print the path
// to the folder and the status of the checkbox.

// Second step: print the path to the selected folder and all the
// paths to the first-level objects contained within the folder.

// Third step: convert the paths to hyperlinks that point to the
// objects.

// Fourth step: add recursion.

// Fifth step: save the generated collection of hyperlinks to a file.

// Issues: evidently HTML doesn't allow you to display a directory selector.

require_once('.\\classes\\DirnameFilter.php');
include('.\\includes\\crawler.inc.php');

if (!isset($path)) $path = 'C:\\Users\\Joseph\\Documents\\';
$recurse = false;
$errors = array();

if (isset($_POST['start'])) {
    $path = $_POST['folderPath'];
    if (!isset($path) || !is_dir($path)) {
        // TEMPORARY
        $path = 'C:\\Users\\Joseph\\Documents\\';
        // $errors['folderPath'] = 'Please enter a valid folder path';
    }
    $recurse = $_POST['recurse'];
    if (isset($recurse)) {
        $recurse = true;
    }
}

?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Directory Mapper</title>
    <link href="styles/closeout.css" rel="stylesheet" type="text/css" media="screen">
</head>

<body>
<div id="maincontent">
    <h2>Directory Mapper</h2>
    <?php if ($_POST && isset($errors['folderPath'])) { ?>
        <p class="warning"><?php echo $errors['folderPath'] ?></p>
    <?php } ?>

    <form id="form1" name="form1" method="post" action="">
        <p>
            <label for="folderPath">Enter the path of the folder to crawl:</label><br />
            <input type="text" name="folderPath" id="folderPath">
        </p>
        <p>
            <span id="interests">
                <input type="checkbox" name="recurse" id="recurse"><label for="recurse">Crawl subfolders</label><br />
                <input type="checkbox" name="fileout" id="fileout"><label for="fileout">Save to file?</label>
            </span>
        </p>
        <p>
            <input type="submit" name="start" id="start" value="Start">
        </p>
    </form>
    <?php
    if ($_POST && !isset($errors['folderPath'])) { ?>
        <p><?php echo "Entered path: " . $path . '<br />'?></p>
        <p><?php echo "Crawl subfolders: " . ($recurse ? 'Yes' : 'No') . '<br />'?></p>
    <?php } ?>
    <ul>
    <?php
        $fileLinks = getFileLinks($path);
        //$baseFolder = getLinkCode($path, 0);
        //echo '[' . $baseFolder . ']';
        echo getLinkCode($path, 0);
        foreach ($fileLinks as $fileLink) {
            echo $fileLink;
        }

    ?>
    </ul>
</div>
</body>
</html>
