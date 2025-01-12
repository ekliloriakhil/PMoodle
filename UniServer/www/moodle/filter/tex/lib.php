<?php  //$Id$

function tex_filter_get_executable($debug=false) {
    global $CFG;

    $error_message1 = "Your system is not configured to run mimeTeX. You need to download the appropriate<br />"
                     ."executable for you ".PHP_OS." platform from <a href=\"http://moodle.org/download/mimetex/\">"
                     ."http://moodle.org/download/mimetex/</a>, or obtain the C source<br /> "
                     ."from <a href=\"http://www.forkosh.com/mimetex.zip\">"
                     ."http://www.forkosh.com/mimetex.zip</a>, compile it and "
                     ."put the executable into your<br /> moodle/filter/tex/ directory.";

    $error_message2 = "Custom mimetex is not executable!<br /><br />";

    if ((PHP_OS == "WINNT") || (PHP_OS == "WIN32") || (PHP_OS == "Windows")) {
        return "$CFG->dirroot/filter/tex/mimetex.exe";
    }

    $custom_commandpath = "$CFG->dirroot/filter/tex/mimetex";
    if (file_exists($custom_commandpath)) {
        if (is_executable($custom_commandpath)) {
            return $custom_commandpath;
        } else {
            error($error_message2.$error_message1);
        }
    }

    switch (PHP_OS) {
        case "Linux":   return "$CFG->dirroot/filter/tex/mimetex.linux";
        case "Darwin":  return "$CFG->dirroot/filter/tex/mimetex.darwin";
        case "FreeBSD": return "$CFG->dirroot/filter/tex/mimetex.freebsd";
    }

    error($error_message1);
}


function tex_filter_get_cmd($pathname, $texexp) {
    $texexp = escapeshellarg($texexp);
    $executable = tex_filter_get_executable(false);

    if ((PHP_OS == "WINNT") || (PHP_OS == "WIN32") || (PHP_OS == "Windows")) {
        $executable = str_replace(' ', '^ ', $executable);
        return "$executable ++ -e  \"$pathname\" -- $texexp";

    } else {
        return "\"$executable\" -e \"$pathname\" -- $texexp";
    }
}

/**
 * Purge all caches when settings changed.
 */
function filter_tex_updatedcallback($name) {
    global $CFG;
    reset_text_filters_cache();

    if (file_exists("$CFG->dataroot/filter/tex")) {
        remove_dir("$CFG->dataroot/filter/tex");
    }
    if (file_exists("$CFG->dataroot/filter/algebra")) {
        remove_dir("$CFG->dataroot/filter/algebra");
    }
    if (file_exists("$CFG->dataroot/temp/latex")) {
        remove_dir("$CFG->dataroot/temp/latex");
    }

    delete_records('cache_filters', 'filter', 'tex');
    delete_records('cache_filters', 'filter', 'algebra');
}

?>
