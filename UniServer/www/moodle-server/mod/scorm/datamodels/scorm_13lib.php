<?php // $Id$

function scorm_get_toc($user,$scorm,$liststyle,$currentorg='',$scoid='',$mode='normal',$attempt='',$play=false) {
    global $CFG;

    $strexpand = get_string('expcoll','scorm');
    $modestr = '';
    if ($mode == 'browse') {
        $modestr = '&amp;mode='.$mode;
    } 
    $scormpixdir = $CFG->modpixpath.'/scorm/pix';
    
    $result = new stdClass();
    $result->toc = "<ul id='s0' class='$liststyle'>\n";
    $tocmenus = array();
    $result->prerequisites = true;
    $incomplete = false;
    
    //
    // Get the current organization infos
    //
    $organizationsql = '';
    if (!empty($currentorg)) {
        if (($organizationtitle = get_field('scorm_scoes','title','scorm',$scorm->id,'identifier',$currentorg)) != '') {
            $result->toc .= "\t<li>$organizationtitle</li>\n";
            $tocmenus[] = $organizationtitle;
        }
        $organizationsql = "AND organization='$currentorg'";
    }
    //
    // If not specified retrieve the last attempt number
    //
    if (empty($attempt)) {
        $attempt = scorm_get_last_attempt($scorm->id, $user->id);
    }
    $result->attemptleft = $scorm->maxattempt - $attempt;
    if ($scoes = get_records_select('scorm_scoes',"scorm='$scorm->id' $organizationsql order by id ASC")){
        // drop keys so that we can access array sequentially
        $scoes = array_values($scoes); 
        //
        // Retrieve user tracking data for each learning object
        // 
    
        $usertracks = array();
        $optionaldatas = array();
        foreach ($scoes as $sco) {
            if (!empty($sco->launch)) {
                if ($usertrack=scorm_get_tracks($sco->id,$user->id,$attempt)) {
                    if ($usertrack->status == '') {
                        $usertrack->status = 'notattempted';
                    }
                    $usertracks[$sco->identifier] = $usertrack;
                }
                if ($optionaldata = scorm_get_sco($sco->id, SCO_DATA)) {
                    $optionaldatas[$sco->identifier] = $optionaldata;
                }
            }
        }

        $level=0;
        $sublist=1;
        $previd = 0;
        $nextid = 0;
        $findnext = false;
        $parents[$level]='/';
        foreach ($scoes as $pos=>$sco) {
            $isvisible = false;
            $sco->title = stripslashes($sco->title);
            if (isset($optionaldatas[$sco->identifier])) {
                if (!isset($optionaldatas[$sco->identifier]->isvisible) || 
                   (isset($optionaldatas[$sco->identifier]->isvisible) && ($optionaldatas[$sco->identifier]->isvisible == 'true'))) {
                    $isvisible = true;
                }
            }
            if ($parents[$level]!=$sco->parent) {
                if ($newlevel = array_search($sco->parent,$parents)) {
                    for ($i=0; $i<($level-$newlevel); $i++) {
                        $result->toc .= "\t\t</ul></li>\n";
                    }
                    $level = $newlevel;
                } else {
                    $i = $level;
                    $closelist = '';
                    while (($i > 0) && ($parents[$level] != $sco->parent)) {
                        $closelist .= "\t\t</ul></li>\n";
                        $i--;
                    }
                    if (($i == 0) && ($sco->parent != $currentorg)) {
                        $style = '';
                        if (isset($_COOKIE['hide:SCORMitem'.$sco->id])) {
                            $style = ' style="display: none;"';
                        }
                        $result->toc .= "\t\t<li><ul id='s$sublist' class='$liststyle'$style>\n";
                        $level++;
                    } else {
                        $result->toc .= $closelist;
                        $level = $i;
                    }
                    $parents[$level]=$sco->parent;
                }
            }
            if (isset($scoes[$pos+1])) {
                $nextsco = $scoes[$pos+1];
            } else {
                $nextsco = false;
            }
            $nextisvisible = false;
            if (($nextsco !== false) && (isset($optionaldatas[$nextsco->identifier]))) {
                if (!isset($optionaldatas[$nextsco->identifier]->isvisible) || 
                   (isset($optionaldatas[$nextsco->identifier]->isvisible) && ($optionaldatas[$nextsco->identifier]->isvisible == 'true'))) {
                    $nextisvisible = true;
                }
            }
            if ($nextisvisible && ($nextsco !== false) && ($sco->parent != $nextsco->parent) && 
               (($level==0) || (($level>0) && ($nextsco->parent == $sco->identifier)))) {
                $sublist++;
                $icon = 'minus';
                if (isset($_COOKIE['hide:SCORMitem'.$nextsco->id])) {
                    $icon = 'plus';
                }
                $result->toc .= "\t\t".'<li><a href="javascript:expandCollide(\'img'.$sublist.'\',\'s'.$sublist.'\','.$nextsco->id.');">'.
                                '<img id="img'.$sublist.'" src="'.$scormpixdir.'/'.$icon.'.gif" alt="'.$strexpand.'" title="'.$strexpand.'"/></a>';
            } else if ($isvisible) {
                $result->toc .= "\t\t".'<li><img src="'.$scormpixdir.'/spacer.gif" />';
            }
            if (empty($sco->title)) {
                $sco->title = $sco->identifier;
            }
            if (!empty($sco->launch)) {
                if ($isvisible) {
                    $startbold = '';
                    $endbold = '';
                    $score = '';
                    if (empty($scoid) && ($mode != 'normal')) {
                        $scoid = $sco->id;
                    }
                    if (isset($usertracks[$sco->identifier])) {
                        $usertrack = $usertracks[$sco->identifier];
                        $strstatus = get_string($usertrack->status,'scorm');
                        if ($sco->scormtype == 'sco') {
                            $statusicon = '<img src="'.$scormpixdir.'/'.$usertrack->status.'.gif" alt="'.$strstatus.'" title="'.$strstatus.'" />';
                        } else {
                            $statusicon = '<img src="'.$scormpixdir.'/assetc.gif" alt="'.get_string('assetlaunched','scorm').'" title="'.get_string('assetlaunched','scorm').'" />';
                        }
                        
                        if (($usertrack->status == 'notattempted') || ($usertrack->status == 'incomplete') || ($usertrack->status == 'browsed')) {
                            $incomplete = true;
                            if ($play && empty($scoid)) {
                                $scoid = $sco->id;
                            }
                        }
                        if ($usertrack->score_raw != '') {
                            $score = '('.get_string('score','scorm').':&nbsp;'.$usertrack->score_raw.')';
                        }
                        $strsuspended = get_string('suspended','scorm');
                        if (isset($usertrack->{'cmi.core.exit'}) && ($usertrack->{'cmi.core.exit'} == 'suspend')) {
                            $statusicon = '<img src="'.$scormpixdir.'/suspend.gif" alt="'.$strstatus.' - '.$strsuspended.'" title="'.$strstatus.' - '.$strsuspended.'" />';
                        }
                    } else {
                        if ($play && empty($scoid)) {
                            $scoid = $sco->id;
                        }
                        if ($sco->scormtype == 'sco') {
                            $statusicon = '<img src="'.$scormpixdir.'/notattempted.gif" alt="'.get_string('notattempted','scorm').'" title="'.get_string('notattempted','scorm').'" />';
                            $incomplete = true;
                        } else {
                            $statusicon = '<img src="'.$scormpixdir.'/asset.gif" alt="'.get_string('asset','scorm').'" title="'.get_string('asset','scorm').'" />';
                        }
                    }

                    if ($sco->id == $scoid) {
                        $startbold = '<b>';
                        $endbold = '</b>';
                        $findnext = true;
                        $shownext = isset($optionaldatas[$sco->identifier]->next) ? $optionaldatas[$sco->identifier]->next : 0;
                        $showprev = isset($optionaldatas[$sco->identifier]->prev) ? $optionaldatas[$sco->identifier]->prev : 0;
                    }
                
                    if (($nextid == 0) && (scorm_count_launchable($scorm->id,$currentorg) > 1) && ($nextsco!==false) && (!$findnext)) {
                        if (!empty($sco->launch)) {
                            $previd = $sco->id;
                        }
                    }
                    require_once('sequencinglib.php');
                    if (scorm_seq_evaluate($sco->id,$usertracks)) {
                        if ($sco->id == $scoid) {
                            $result->prerequisites = true;
                        }
                            $url = $CFG->wwwroot.'/mod/scorm/player.php?a='.$scorm->id.'&amp;currentorg='.$currentorg.$modestr.'&amp;scoid='.$sco->id;
                            $result->toc .= $statusicon.'&nbsp;'.$startbold.'<a href="'.$url.'">'.format_string($sco->title).'</a>'.$score.$endbold."</li>\n";
                            $tocmenus[$sco->id] = scorm_repeater('&minus;',$level) . '&gt;' . format_string($sco->title);
                    } else {
                        if ($sco->id == $scoid) {
                            $result->prerequisites = false;
                        }
                        $result->toc .= '&nbsp;'.format_string($sco->title)."</li>\n";
                    }
                }
            } else {
                $result->toc .= '&nbsp;'.format_string($sco->title)."</li>\n";
            }
            if (($nextsco !== false) && ($nextid == 0) && ($findnext)) {
                if (!empty($nextsco->launch)) {
                    $nextid = $nextsco->id;
                }
            }
        }
        for ($i=0;$i<$level;$i++) {
            $result->toc .= "\t\t</ul></li>\n";
        }
        
        if ($play) {
            $sco = get_record('scorm_scoes','id',$scoid);
            $sco->previd = $previd;
            $sco->nextid = $nextid;
            $result->sco = $sco;
            $result->incomplete = $incomplete;
        } else {
            $result->incomplete = $incomplete;
        }
    }
    $result->toc .= "\t</ul>\n";
    if ($scorm->hidetoc == 0) {
        $result->toc .= '
          <script type="text/javascript">
          //<![CDATA[
              function expandCollide(which,list,item) {
                  var el = document.ids ? document.ids[list] : document.getElementById ? document.getElementById(list) : document.all[list];
                  which = which.substring(0,(which.length));
                  var el2 = document.ids ? document.ids[which] : document.getElementById ? document.getElementById(which) : document.all[which];
                  if (el.style.display != "none") {
                      el2.src = "'.$scormpixdir.'/plus.gif";
                      el.style.display=\'none\';
                      new cookie("hide:SCORMitem" + item, 1, 356, "/").set();
                  } else {
                      el2.src = "'.$scormpixdir.'/minus.gif";
                      el.style.display=\'block\';
                      new cookie("hide:SCORMitem" + item, 1, -1, "/").set();
                  }
              }
          //]]>
          </script>'."\n";
    }
    
    $url = $CFG->wwwroot.'/mod/scorm/player.php?a='.$scorm->id.'&amp;currentorg='.$currentorg.$modestr.'&amp;scoid=';
    $result->tocmenu = popup_form($url,$tocmenus, "tocmenu", $sco->id, '', '', '', true);

    return $result;
}

?>
