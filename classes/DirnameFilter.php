<?php

require_once('FilesystemRegexFilter.php');

class DirnameFilter extends FilesystemRegexFilter {
    // Filter directories against the regex
    public function accept() {
        return ( ! $this->isDir() || preg_match($this->regex, $this->getFilename()));
    }
}
