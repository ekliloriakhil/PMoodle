<?php  //$Id$

///////////////////////////////////////////////////////////////////////////
//                                                                       //
// NOTICE OF COPYRIGHT                                                   //
//                                                                       //
// Moodle - Modular Object-Oriented Dynamic Learning Environment         //
//          http://moodle.com                                            //
//                                                                       //
// Copyright (C) 1999 onwards  Martin Dougiamas  http://moodle.com       //
//                                                                       //
// This program is free software; you can redistribute it and/or modify  //
// it under the terms of the GNU General Public License as published by  //
// the Free Software Foundation; either version 2 of the License, or     //
// (at your option) any later version.                                   //
//                                                                       //
// This program is distributed in the hope that it will be useful,       //
// but WITHOUT ANY WARRANTY; without even the implied warranty of        //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         //
// GNU General Public License for more details:                          //
//                                                                       //
//          http://www.gnu.org/copyleft/gpl.html                         //
//                                                                       //
///////////////////////////////////////////////////////////////////////////

require_once $CFG->libdir.'/formslib.php';

class edit_item_form extends moodleform {
    var $displayoptions;

    function definition() {
        global $COURSE, $CFG;

        $mform =& $this->_form;

/// visible elements
        $mform->addElement('header', 'general', get_string('gradeitem', 'grades'));

        $mform->addElement('text', 'itemname', get_string('itemname', 'grades'));
        $mform->addElement('text', 'iteminfo', get_string('iteminfo', 'grades'));
        $mform->setHelpButton('iteminfo', array('iteminfo', get_string('iteminfo', 'grades'), 'grade'), true);

        $mform->addElement('text', 'idnumber', get_string('idnumbermod'));
        $mform->setHelpButton('idnumber', array('idnumber', get_string('idnumber', 'grades'), 'grade'), true);

        $options = array(GRADE_TYPE_NONE=>get_string('typenone', 'grades'),
                         GRADE_TYPE_VALUE=>get_string('typevalue', 'grades'),
                         GRADE_TYPE_SCALE=>get_string('typescale', 'grades'),
                         GRADE_TYPE_TEXT=>get_string('typetext', 'grades'));

        $mform->addElement('select', 'gradetype', get_string('gradetype', 'grades'), $options);
        $mform->setHelpButton('gradetype', array('gradetype', get_string('gradetype', 'grades'), 'grade'), true);
        $mform->setDefault('gradetype', GRADE_TYPE_VALUE);

        //$mform->addElement('text', 'calculation', get_string('calculation', 'grades'));
        //$mform->disabledIf('calculation', 'gradetype', 'eq', GRADE_TYPE_TEXT);
        //$mform->disabledIf('calculation', 'gradetype', 'eq', GRADE_TYPE_NONE);

        $options = array(0=>get_string('usenoscale', 'grades'));
        if ($scales = get_records('scale')) {
            foreach ($scales as $scale) {
                $options[$scale->id] = format_string($scale->name);
            }
        }
        $mform->addElement('select', 'scaleid', get_string('scale'), $options);
        $mform->setHelpButton('scaleid', array('scaleid', get_string('scaleid', 'grades'), 'grade'), true);
        $mform->disabledIf('scaleid', 'gradetype', 'noteq', GRADE_TYPE_SCALE);

        $mform->addElement('text', 'grademax', get_string('grademax', 'grades'));
        $mform->setHelpButton('grademax', array('grademax', get_string('grademax', 'grades'), 'grade'), true);
        $mform->disabledIf('grademax', 'gradetype', 'noteq', GRADE_TYPE_VALUE);

        $mform->addElement('text', 'grademin', get_string('grademin', 'grades'));
        $mform->setHelpButton('grademin', array('grademin', get_string('grademin', 'grades'), 'grade'), true);
        $mform->disabledIf('grademin', 'gradetype', 'noteq', GRADE_TYPE_VALUE);

        $mform->addElement('text', 'gradepass', get_string('gradepass', 'grades'));
        $mform->setHelpButton('gradepass', array('gradepass', get_string('gradepass', 'grades'), 'grade'), true);
        $mform->disabledIf('gradepass', 'gradetype', 'eq', GRADE_TYPE_NONE);
        $mform->disabledIf('gradepass', 'gradetype', 'eq', GRADE_TYPE_TEXT);

        $mform->addElement('text', 'multfactor', get_string('multfactor', 'grades'));
        $mform->setHelpButton('multfactor', array('multfactor', get_string('multfactor', 'grades'), 'grade'), true);
        $mform->setAdvanced('multfactor');
        $mform->disabledIf('multfactor', 'gradetype', 'eq', GRADE_TYPE_NONE);
        $mform->disabledIf('multfactor', 'gradetype', 'eq', GRADE_TYPE_TEXT);

        $mform->addElement('text', 'plusfactor', get_string('plusfactor', 'grades'));
        $mform->setHelpButton('plusfactor', array('plusfactor', get_string('plusfactor', 'grades'), 'grade'), true);
        $mform->setAdvanced('plusfactor');
        $mform->disabledIf('plusfactor', 'gradetype', 'eq', GRADE_TYPE_NONE);
        $mform->disabledIf('plusfactor', 'gradetype', 'eq', GRADE_TYPE_TEXT);

        /// grade display prefs
        $default_gradedisplaytype = grade_get_setting($COURSE->id, 'displaytype', $CFG->grade_displaytype);
        $options = array(GRADE_DISPLAY_TYPE_DEFAULT    => get_string('default', 'grades'),
                         GRADE_DISPLAY_TYPE_REAL       => get_string('real', 'grades'),
                         GRADE_DISPLAY_TYPE_PERCENTAGE => get_string('percentage', 'grades'),
                         GRADE_DISPLAY_TYPE_LETTER     => get_string('letter', 'grades'));
        foreach ($options as $key=>$option) {
            if ($key == $default_gradedisplaytype) {
                $options[GRADE_DISPLAY_TYPE_DEFAULT] = get_string('defaultprev', 'grades', $option);
                break;
            }
        }
        $mform->addElement('select', 'display', get_string('gradedisplaytype', 'grades'), $options);
        $mform->setHelpButton('display', array('gradedisplaytype', get_string('gradedisplaytype', 'grades'), 'grade'), true);

        $default_gradedecimals = grade_get_setting($COURSE->id, 'decimalpoints', $CFG->grade_decimalpoints);
        $options = array(-1=>get_string('defaultprev', 'grades', $default_gradedecimals), 0=>0, 1=>1, 2=>2, 3=>3, 4=>4, 5=>5);
        $mform->addElement('select', 'decimals', get_string('decimalpoints', 'grades'), $options);
        $mform->setHelpButton('decimals', array('decimalpoints', get_string('decimalpoints', 'grades'), 'grade'), true);
        $mform->setDefault('decimals', -1);
        $mform->disabledIf('decimals', 'display', 'eq', GRADE_DISPLAY_TYPE_LETTER);
        if ($default_gradedisplaytype == GRADE_DISPLAY_TYPE_LETTER) {
            $mform->disabledIf('decimals', 'display', "eq", GRADE_DISPLAY_TYPE_DEFAULT);
        }

        /// hiding
        // advcheckbox is not compatible with disabledIf!
        $mform->addElement('checkbox', 'hidden', get_string('hidden', 'grades'));
        $mform->setHelpButton('hidden', array('hidden', get_string('hidden', 'grades'), 'grade'));
        $mform->addElement('date_time_selector', 'hiddenuntil', get_string('hiddenuntil', 'grades'), array('optional'=>true));
        $mform->setHelpButton('hiddenuntil', array('hiddenuntil', get_string('hiddenuntil', 'grades'), 'grade'));
        $mform->disabledIf('hidden', 'hiddenuntil[off]', 'notchecked');

        /// locking
        $mform->addElement('advcheckbox', 'locked', get_string('locked', 'grades'));
        $mform->setHelpButton('locked', array('locked', get_string('locked', 'grades'), 'grade'));

        $mform->addElement('date_time_selector', 'locktime', get_string('locktime', 'grades'), array('optional'=>true));
        $mform->setHelpButton('locktime', array('lockedafter', get_string('locktime', 'grades'), 'grade'));
        $mform->disabledIf('locktime', 'gradetype', 'eq', GRADE_TYPE_NONE);

/// parent category related settings
        $mform->addElement('header', 'headerparent', get_string('parentcategory', 'grades'));

        $options = array();
        $default = '';
        $coefstring = '';
        $categories = grade_category::fetch_all(array('courseid'=>$COURSE->id));
        foreach ($categories as $cat) {
            $cat->apply_forced_settings();
            $options[$cat->id] = $cat->get_name();
            if ($cat->is_course_category()) {
                $default = $cat->id;
            }
            if ($cat->is_aggregationcoef_used()) {
                if ($cat->aggregation == GRADE_AGGREGATE_WEIGHTED_MEAN) {
                    $coefstring = ($coefstring=='' or $coefstring=='aggregationcoefweight') ? 'aggregationcoefweight' : 'aggregationcoef';

                } else if ($cat->aggregation == GRADE_AGGREGATE_EXTRACREDIT_MEAN) {
                    $coefstring = ($coefstring=='' or $coefstring=='aggregationcoefextra') ? 'aggregationcoefextra' : 'aggregationcoef';

                } else if ($cat->aggregation == GRADE_AGGREGATE_SUM) {
                    $coefstring = ($coefstring=='' or $coefstring=='aggregationcoefextrasum') ? 'aggregationcoefextrasum' : 'aggregationcoef';

                } else {
                    $coefstring = 'aggregationcoef';
                }
            } else {
                $mform->disabledIf('aggregationcoef', 'parentcategory', 'eq', $cat->id);
            }
        }

        if (count($categories) > 1) {
            $mform->addElement('select', 'parentcategory', get_string('gradecategory', 'grades'), $options);
        }

        if ($coefstring !== '') {
            if ($coefstring == 'aggregationcoefextrasum') {
                // advcheckbox is not compatible with disabledIf!
                $mform->addElement('checkbox', 'aggregationcoef', get_string($coefstring, 'grades'));
            } else {
                $mform->addElement('text', 'aggregationcoef', get_string($coefstring, 'grades'));
            }
            $mform->setHelpButton('aggregationcoef', array($coefstring, get_string($coefstring, 'grades'), 'grade'), true);
        }

/// hidden params
        $mform->addElement('hidden', 'id', 0);
        $mform->setType('id', PARAM_INT);

        $mform->addElement('hidden', 'courseid', $COURSE->id);
        $mform->setType('courseid', PARAM_INT);

        $mform->addElement('hidden', 'itemtype', 'manual'); // all new items are manual only
        $mform->setType('itemtype', PARAM_ALPHA);

/// add return tracking info
        $gpr = $this->_customdata['gpr'];
        $gpr->add_mform_elements($mform);

/// mark advanced according to site settings
        if (isset($CFG->grade_item_advanced)) {
            $advanced = explode(',', $CFG->grade_item_advanced);
            foreach ($advanced as $el) {
                if ($mform->elementExists($el)) {
                    $mform->setAdvanced($el);
                }
            }
        }
//-------------------------------------------------------------------------------
        // buttons
        $this->add_action_buttons();
    }


/// tweak the form - depending on existing data
    function definition_after_data() {
        global $CFG, $COURSE;

        $mform =& $this->_form;

        if ($id = $mform->getElementValue('id')) {
            $grade_item = grade_item::fetch(array('id'=>$id));

            if (!$grade_item->is_raw_used()) {
                $mform->removeElement('plusfactor');
                $mform->removeElement('multfactor');
            }

            if ($grade_item->is_outcome_item()) {
                // we have to prevent incompatible modifications of outcomes if outcomes disabled
                $mform->removeElement('grademax');
                $mform->removeElement('grademin');
                $mform->removeElement('gradetype');
                $mform->removeElement('display');
                $mform->removeElement('decimals');
                $mform->hardFreeze('scaleid');

            } else {
                if ($grade_item->is_external_item()) {
                    // following items are set up from modules and should not be overrided by user
                    $mform->hardFreeze('itemname,idnumber,gradetype,grademax,grademin,scaleid');
                    //$mform->removeElement('calculation');
                }
            }

            //remove the aggregation coef element if not needed
            if ($grade_item->is_course_item()) {
                if ($mform->elementExists('parentcategory')) {
                    $mform->removeElement('parentcategory');
                }
                if ($mform->elementExists('aggregationcoef')) {
                    $mform->removeElement('aggregationcoef');
                }

            } else {
                // if we wanted to change parent of existing item - we would have to verify there are no circular references in parents!!!
                if ($mform->elementExists('parentcategory')) {
                    $mform->hardFreeze('parentcategory');
                }

                if ($grade_item->is_category_item()) {
                    $category = $grade_item->get_item_category();
                    $parent_category = $category->get_parent_category();
                } else {
                    $parent_category = $grade_item->get_parent_category();
                }

                $parent_category->apply_forced_settings();

                if (!$parent_category->is_aggregationcoef_used()) {
                    if ($mform->elementExists('aggregationcoef')) {
                        $mform->removeElement('aggregationcoef');
                    }
                } else {
                    //fix label if needed
                    $agg_el =& $mform->getElement('aggregationcoef');
                    $aggcoef = '';
                    if ($parent_category->aggregation == GRADE_AGGREGATE_WEIGHTED_MEAN) {
                        $aggcoef = 'aggregationcoefweight';

                    } else if ($parent_category->aggregation == GRADE_AGGREGATE_EXTRACREDIT_MEAN) {
                        $aggcoef = 'aggregationcoefextra';

                    } else if ($parent_category->aggregation == GRADE_AGGREGATE_SUM) {
                        $aggcoef = 'aggregationcoefextrasum';
                    }

                    if ($aggcoef !== '') {
                        $agg_el->setLabel(get_string($aggcoef, 'grades'));
                        $mform->setHelpButton('aggregationcoef', array($aggcoef, get_string($aggcoef, 'grades'), 'grade'), true);
                    }
                }
            }

            if ($category = $grade_item->get_item_category()) {
                if ($category->aggregation == GRADE_AGGREGATE_SUM) {
                    if ($mform->elementExists('gradetype')) {
                        $mform->hardFreeze('gradetype');
                    }
                    if ($mform->elementExists('grademin')) {
                        $mform->hardFreeze('grademin');
                    }
                    if ($mform->elementExists('grademax')) {
                        $mform->hardFreeze('grademax');
                    }
                    if ($mform->elementExists('scaleid')) {
                        $mform->removeElement('scaleid');
                    }
                }
            }

        } else {
            // all new items are manual, children of course category
            $mform->removeElement('plusfactor');
            $mform->removeElement('multfactor');
        }

        // no parent header for course category
        if (!$mform->elementExists('aggregationcoef') and !$mform->elementExists('parentcategory')) {
            $mform->removeElement('headerparent');
        }
    }


/// perform extra validation before submission
    function validation($data, $files) {
        global $COURSE;

        $errors = parent::validation($data, $files);

        if (array_key_exists('idnumber', $data)) {
            if ($data['id']) {
                $grade_item = new grade_item(array('id'=>$data['id'], 'courseid'=>$data['courseid']));
                if ($grade_item->itemtype == 'mod') {
                    $cm = get_coursemodule_from_instance($grade_item->itemmodule, $grade_item->iteminstance, $grade_item->courseid);
                } else {
                    $cm = null;
                }
            } else {
                $grade_item = null;
                $cm = null;
            }
            if (!grade_verify_idnumber($data['idnumber'], $COURSE->id, $grade_item, $cm)) {
                $errors['idnumber'] = get_string('idnumbertaken');
            }
        }

        if (array_key_exists('gradetype', $data) and $data['gradetype'] == GRADE_TYPE_SCALE) {
            if (empty($data['scaleid'])) {
                $errors['scaleid'] = get_string('missingscale', 'grades');
            }
        }

        if (array_key_exists('grademin', $data) and array_key_exists('grademax', $data)) {
            if ($data['grademax'] == $data['grademin'] or $data['grademax'] < $data['grademin']) {
                $errors['grademin'] = get_string('incorrectminmax', 'grades');
                $errors['grademax'] = get_string('incorrectminmax', 'grades');
            }
        }

        return $errors;
    }

}
?>
