<?php // $Id$

require_once($CFG->libdir.'/pagelib.php');

define('PAGE_ADMIN', 'admin');

// Bounds for block widths
// more flexible for theme designers taken from theme config.php
$lmin = (empty($THEME->block_l_min_width)) ? 0 :   $THEME->block_l_min_width;
$lmax = (empty($THEME->block_l_max_width)) ? 210 : $THEME->block_l_max_width;
$rmin = (empty($THEME->block_r_min_width)) ? 0 :   $THEME->block_r_min_width;
$rmax = (empty($THEME->block_r_max_width)) ? 210 : $THEME->block_r_max_width;

define('BLOCK_L_MIN_WIDTH', $lmin);
define('BLOCK_L_MAX_WIDTH', $lmax);
define('BLOCK_R_MIN_WIDTH', $rmin);
define('BLOCK_R_MAX_WIDTH', $rmax);

page_map_class(PAGE_ADMIN, 'page_admin');

class page_admin extends page_base {

    var $section;
    var $visiblepathtosection;

    // hack alert!
    // this function works around the inability to store the section name
    // in default block, maybe we should "improve" the blocks a bit?
    function init_extra($section) {
        global $CFG;

        if($this->full_init_done) {
            return;
        }

        $adminroot =& admin_get_root(false, false); //settings not required - only pages

        // fetch the path parameter
        $this->section = $section;
        $current =& $adminroot->locate($section, true);
        $this->visiblepathtosection = array_reverse($current->visiblepath);

        // all done
        $this->full_init_done = true;
    }

    function blocks_get_default() {
        return 'admin_tree,admin_bookmarks';
    }

    // seems reasonable that the only people that can edit blocks on the admin pages
    // are the admins... but maybe we want a role for this?
    function user_allowed_editing() {
        return has_capability('moodle/site:manageblocks', get_context_instance(CONTEXT_SYSTEM));
    }

    // has to be fixed. i know there's a "proper" way to do this
    function user_is_editing() {
        global $USER;
        return $USER->adminediting;
    }

    function url_get_path() {
        global $CFG;

        $adminroot =& admin_get_root(false, false); //settings not required - only pages

        $root =& $adminroot->locate($this->section);
        if (is_a($root, 'admin_externalpage')) {
            return $root->url;
        } else {
            return ($CFG->wwwroot . '/' . $CFG->admin . '/settings.php');
        }
    }

    function url_get_parameters() {  // only handles parameters relevant to the admin pagetype
        return array('section' => (isset($this->section) ? $this->section : ''));
    }

    function blocks_get_positions() {
        return array(BLOCK_POS_LEFT, BLOCK_POS_RIGHT);
    }

    function blocks_default_position() {
        return BLOCK_POS_LEFT;
    }

    function blocks_move_position(&$instance, $move) {
        if($instance->position == BLOCK_POS_LEFT && $move == BLOCK_MOVE_RIGHT) {
            return BLOCK_POS_RIGHT;
        } else if ($instance->position == BLOCK_POS_RIGHT && $move == BLOCK_MOVE_LEFT) {
            return BLOCK_POS_LEFT;
        }
        return $instance->position;
    }

    // does anything need to be done here?
    function init_quick($data) {
        parent::init_quick($data);
    }

    function print_header($section = '', $focus='') {
        global $USER, $CFG, $SITE;

        $this->init_full($section); // we're trusting that init_full() has already been called by now; it should have.
                                    // if not, print_header() has to be called with a $section parameter

        // The search page currently doesn't handle block editing
        if ($this->section != 'search' and $this->user_allowed_editing()) {
            $buttons = '<div><form '.$CFG->frametarget.' method="get" action="' . $this->url_get_path() . '">'.
                '<div><input type="hidden" name="adminedit" value="'.($this->user_is_editing()?'off':'on').'" />'.
                '<input type="hidden" name="section" value="'.$this->section.'" />'.
                '<input type="submit" value="'.get_string($this->user_is_editing()?'blockseditoff':'blocksediton').'" /></div></form></div>';
        } else {
            $buttons = '&nbsp;';
        }

        $navlinks = array();
        foreach ($this->visiblepathtosection as $element) {
            $navlinks[] = array('name' => $element, 'link' => null, 'type' => 'misc');
        }
        $navigation = build_navigation($navlinks);

        print_header("$SITE->shortname: " . implode(": ",$this->visiblepathtosection), $SITE->fullname, $navigation, $focus, '', true, $buttons, '');
    }

    function get_type() {
        return PAGE_ADMIN;
    }
}

?>
