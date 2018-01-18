<?php
$html = '';
$g_vars['page']['location'] = array('test_manager', 'test_manager', 'assign');
$this->_tpl_vars['g_vars'] = $g_vars;
$this->_tpl_vars['lngstr'] = $lngstr;
$html.= $this->CI->load->view('events/tracnghiem/_header.tpl.html', $this->_tpl_vars, true);

$g_vars['page']['selected_section'] = 'testmanager';
$g_vars['page']['selected_tab'] = 'testmanager-8';
$g_vars['page']['menu_2_items'] = $func->getMenu2Items($g_vars['page']['selected_section'], $lngstr);
$html.=$func->writePanel2($g_vars, $g_vars['page']['menu_2_items']);
$html.= '<h2>' . $lngstr['page_header_test_assignto_tests'] . '</h2>';
$html.=$func->writeErrorsWarningsBar();
//$func->writeInfoBar($lngstr['tooltip_tests_groups']);
$i_pagewide_id = 0;

$f_testids = array();
$i_testids_addon = "";
$i_sql_where_addon = "";
if (isset($_POST["box_tests"]) && is_array($_POST["box_tests"])) {
    foreach ($_POST["box_tests"] as $f_testid) {
        array_push($f_testids, $f_testid);
    }
} else if (isset($_GET["testids"]) && $_GET["testids"] != "") {
    $f_testids = explode(SYSTEM_ARRAY_ITEM_SEPARATOR, $func->readGetVar('testids'));
} else {
    array_push($f_testids, $func->readGetVar('testid'));
}
$i_testids_addon .= "&testids=" . implode(SYSTEM_ARRAY_ITEM_SEPARATOR, $f_testids);
//reset($f_testids);
if (list(, $val) = each($f_testids))
    $i_sql_where_addon .= "testid=" . (int)$val;
while (list(, $val) = each($f_testids)) {
    $i_sql_where_addon .= " OR testid=" . (int)$val;
}
if ($i_sql_where_addon != "")
    $i_sql_where_addon = '(' . $i_sql_where_addon . ') AND ';

$i_direction = "";
$i_order_addon = "";
$i_sql_order_addon = "";
$i_tablefields = array(
    array($lngstr["label_edittests_hdr_testid"], $lngstr["label_edittests_hdr_testid_hint"], $srv_settings['table_prefix'] . "tests.testid"),
    array($lngstr["label_edittests_hdr_test_notes"], $lngstr["label_edittests_hdr_test_notes_hint"], ""),
    array($lngstr["label_edittests_hdr_test_name"], $lngstr["label_edittests_hdr_test_name_hint"], $srv_settings['table_prefix'] . "tests.test_name"),
    array($lngstr["label_edittests_hdr_subjectid"], $lngstr["label_edittests_hdr_subjectid_hint"], $srv_settings['table_prefix'] . "tests.subjectid"),
    array($lngstr["label_edittests_hdr_test_datestart"], $lngstr["label_edittests_hdr_test_datestart_hint"], $srv_settings['table_prefix'] . "tests.test_datestart"),
    array($lngstr["label_edittests_hdr_test_dateend"], $lngstr["label_edittests_hdr_test_dateend_hint"], $srv_settings['table_prefix'] . "tests.test_dateend"),
    array($lngstr["label_edittests_hdr_test_enabled"], $lngstr["label_edittests_hdr_test_enabled_hint"], $srv_settings['table_prefix'] . "tests.test_enabled"),
);
$i_order_no = isset($_GET["order"]) ? (int)$_GET["order"] : 0;
if ($i_order_no >= count($i_tablefields))
    $i_order_no = -1;
if ($i_order_no >= 0) {
    $i_direction = (isset($_GET["direction"]) && $_GET["direction"]) ? "DESC" : "";
    $i_order_addon = "&order=" . $i_order_no . "&direction=" . $i_direction;
    $i_sql_order_addon = " ORDER BY " . $i_tablefields[$i_order_no][2] . " " . $i_direction;
}

$i_2_direction = "";
$i_2_order_addon = "";
$i_2_sql_order_addon = "";
$i_2_tablefields = array(
    array($lngstr["label_managegroups_hdr_groupid"], $lngstr["label_managegroups_hdr_groupid_hint"], $srv_settings['table_prefix'] . "groups.groupid"),
    array($lngstr["label_managegroups_hdr_group_name"], $lngstr["label_managegroups_hdr_group_name_hint"], $srv_settings['table_prefix'] . "groups.group_name"),
    array($lngstr["label_managegroups_hdr_group_description"], $lngstr["label_managegroups_hdr_group_description_hint"], $srv_settings['table_prefix'] . "groups.group_description"),
);
$i_2_order_no = isset($_GET["order2"]) ? (int)$_GET["order2"] : 0;
if ($i_2_order_no >= count($i_2_tablefields))
    $i_2_order_no = -1;
if ($i_2_order_no >= 0) {
    $i_2_direction = (isset($_GET["direction2"]) && $_GET["direction2"]) ? "DESC" : "";
    $i_2_order_addon = "&order2=" . $i_2_order_no . "&direction2=" . $i_2_direction;
    $i_2_sql_order_addon = " ORDER BY " . $i_2_tablefields[$i_2_order_no][2] . " " . $i_2_direction;
}

$i_2_url_limitto_addon = "";
$i_2_url_pageno_addon = "";
$i_2_url_limit_addon = "";
$i_2_pageno = 0;
$i_2_limitcount = isset($_GET["limitto2"]) ? (int)$_GET["limitto2"] : $G_SESSION['config_itemsperpage'];
if ($i_2_limitcount > 0) {
    $i_2_recordcount = $func->getRecordCount($srv_settings['table_prefix'] . 'groups');
    $i_2_pageno = isset($_GET["pageno2"]) ? (int)$_GET["pageno2"] : 1;
    if ($i_2_pageno < 1)
        $i_2_pageno = 1;
    $i_2_limitfrom = ($i_2_pageno - 1) * $i_2_limitcount;
    $i_2_pageno_count = floor(($i_2_recordcount - 1) / $i_2_limitcount) + 1;
    if ($i_2_limitfrom > $i_2_recordcount) {
        $i_2_pageno = $i_2_pageno_count;
        $i_2_limitfrom = ($i_2_pageno - 1) * $i_2_limitcount;
    }
    $i_2_url_limitto_addon .= "&limitto2=" . $i_2_limitcount;
    $i_2_url_pageno_addon .= "&pageno2=" . $i_2_pageno;
    $i_2_url_limit_addon .= $i_2_url_limitto_addon . $i_2_url_pageno_addon;
} else {
    $i_2_url_limitto_addon = "&limitto2=";
    $i_2_url_limit_addon .= $i_2_url_limitto_addon;
    $i_2_limitfrom = -1;
    $i_2_limitcount = -1;
}

$html.= '<p><form name=testsForm class=iactive method=post><table cellpadding=0 cellspacing=0 border=0 width="100%"><tr><td>';
$html.= '<table cellpadding=0 cellspacing=0 border=0 width="100%" style="background: url(/events/p_tracnghiem/images/toolbar-background.gif) repeat-x"><tr vAlign=center><td width=2><img src="/events/p_tracnghiem/images/toolbar-left.gif" width=2 height=32></td><td width=32><a href="/?control=mobo_event_tracnghiem&func=test_manager&action=create"><img src="/events/p_tracnghiem/images/button-new-big.gif" width=32 height=32 border=0 title="' . $lngstr['label_action_create_test'] . '"></a></td><td width=3><img src="/events/p_tracnghiem/images/toolbar-separator.gif" width=3 height=32 border=0></td><td width=32><img src="/events/p_tracnghiem/images/button-groups-big.gif" border=0 title="' . $lngstr['label_action_groups'] . '" style="cursor: hand;" onclick="f=document.testsForm;f.action=\'/?control=mobo_event_tracnghiem&func=test_manager&action=groups\';f.submit();"></td><td width=3><img src="/events/p_tracnghiem/images/toolbar-separator.gif" width=3 height=32 border=0></td><td width=32><img src="/events/p_tracnghiem/images/button-cross-big.gif" border=0 title="' . $lngstr['label_action_tests_delete'] . '" style="cursor: hand;" onclick="f=document.testsForm;if (confirm(\'' . $lngstr['qst_delete_tests'] . '\')) { f.action=\'/?control=mobo_event_tracnghiem&func=test_manager&action=delete&confirmed=1\';f.submit();}"></td>';
$html.= '<td width="100%">&nbsp;</td><td width=2><img src="/events/p_tracnghiem/images/toolbar-right.gif" width=2 height=32></td></tr></table>';
$html.= '</td></tr><tr><td>';
$html.= '<table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">';
$html.= '<tr vAlign=top><td class=rowhdr1 title="' . $lngstr['label_hdr_select_hint'] . '" width=22><input type=checkbox name=toggleAll onclick="toggleCBs(this);"></td>';
$html.=$func->writeQryTableHeaders('/?control=mobo_event_tracnghiem&func=test_manager&action=groups' . $i_testids_addon . $i_2_order_addon . $i_2_url_limit_addon, $i_tablefields, $i_order_no, $i_direction);
$html.= '<td class=rowhdr1 colspan=4>' . $lngstr['label_hdr_action'] . '</td></tr>';
$i_rSet1 = $func->m_bd->Execute("SELECT " . $srv_settings['table_prefix'] . "tests.testid, " . $srv_settings['table_prefix'] . "tests.test_name, " . $srv_settings['table_prefix'] . "tests.subjectid, " . $srv_settings['table_prefix'] . "tests.test_datestart, " . $srv_settings['table_prefix'] . "tests.test_dateend, " . $srv_settings['table_prefix'] . "tests.test_notes, " . $srv_settings['table_prefix'] . "tests.test_enabled, " . $srv_settings['table_prefix'] . "subjects.subject_name FROM " . $srv_settings['table_prefix'] . "tests, " . $srv_settings['table_prefix'] . "subjects WHERE " . $i_sql_where_addon . "" . $srv_settings['table_prefix'] . "tests.subjectid=" . $srv_settings['table_prefix'] . "subjects.subjectid" . $i_sql_order_addon);
if ($i_rSet1) {
    $i_counter = 0;
    foreach($i_rSet1 as $key1=>$value1) {
        $rowname = ($i_counter % 2) ? "rowone" : "rowtwo";
        $html.= '<tr id=tr_' . $i_pagewide_id . ' class=' . $rowname . ' onmouseover="rollTR(' . $i_pagewide_id . ',1);" onmouseout="rollTR(' . $i_pagewide_id . ',0);"><td align=center width=22><input id=cb_' . $i_pagewide_id . ' type=checkbox name=box_tests[] value="' . $value1["testid"] . '" onclick="toggleCB(this);"></td><td align=right>' . $value1["testid"] . '</td><td align=center width=16 style="padding: 1px;"><a href="javascript:void(0)" onClick="showDialog(\'/?control=mobo_event_tracnghiem&func=test_manager&testid=' . $value1["testid"] . '&action=notes\', 300, 200)"><img src="/events/p_tracnghiem/images/button-notes.gif" width=16 height=20 title="' . $func->convertTextValue($value1["test_notes"]) . '" border=0></a></td><td>' . $func->convertTextValue($value1["test_name"]) . '</td><td><a href="/?control=mobo_event_tracnghiem&func=test_manager&subjectid=' . (isset($_GET["subjectid"]) && $_GET["subjectid"] != "" ? "" : $value1["subjectid"]) . $i_order_addon . '">' . $func->convertTextValue($value1["subject_name"]) . '</a></td><td>' . $func->getDateLocal($lngstr['language']['date_format'], $value1["test_datestart"]) . '</td><td>' . $func->getDateLocal($lngstr['language']['date_format'], $value1["test_dateend"]) . '</td><td align=center><a href="/?control=mobo_event_tracnghiem&func=test_manager&testid=' . $value1["testid"] . $i_order_addon . '&action=enable&set=' . ($value1["test_enabled"] ? '0"><img src="/events/p_tracnghiem/images/button-checkbox-2.gif" width=13 height=13 border=0 title="' . $lngstr['label_yes'] . '">' : '1"><img src="/events/p_tracnghiem/images/button-checkbox-0.gif" width=13 height=13 border=0 title="' . $lngstr['label_no'] . '">') . '</a></td>';
        $html.= '<td align=center width=22><a href="/?control=mobo_event_tracnghiem&func=test_manager&testid=' . $value1["testid"] . '&action=settings"><img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-gear.gif" title="' . $lngstr['label_action_test_settings'] . '"></a></td><td align=center width=22><a href="/?control=mobo_event_tracnghiem&func=test_manager&testids=' . $value1["testid"] . '&action=groups"><img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-groups.gif" title="' . $lngstr['label_action_test_groups_select'] . '"></a></td><td align=center width=22><a href="/?control=mobo_event_tracnghiem&func=test_manager&testid=' . $value1["testid"] . '&action=editt"><img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-edit.gif" title="' . $lngstr['label_action_questions_edit'] . '"></a></td><td align=center width=22><a href="/?control=mobo_event_tracnghiem&func=test_manager&testid=' . $value1["testid"] . '&action=delete" onclick="return confirmMessage(this, \'' . $lngstr['qst_delete_test'] . '\')"><img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-cross.gif" title="' . $lngstr['label_action_test_delete'] . '"></a></td></tr>';
        $i_counter++;
        $i_pagewide_id++;
    }
}
$html.= '</table>';
$html.= '</td></tr></table></form>';

$html.= '<h2>' . $lngstr['page_header_test_assignto_groups'] . '</h2>';
$html.= '<p><form name=groupsForm class=iactive method=post><table cellpadding=0 cellspacing=0 border=0 width="100%"><tr><td>';
$html.= '<table cellpadding=0 cellspacing=0 border=0 width="100%" style="background: url(/events/p_tracnghiem/images/toolbar-background.gif) repeat-x"><tr vAlign=center><td width=2><img src="/events/p_tracnghiem/images/toolbar-left.gif" width=2 height=32></td><td width=32><a href="/?control=mobo_event_tracnghiem&func=groups&action=create"><img src="/events/p_tracnghiem/images/button-new-big.gif" border=0 title="' . $lngstr['label_action_create_group'] . '"></a></td><td width=3><img src="/events/p_tracnghiem/images/toolbar-separator.gif" width=3 height=32 border=0></td><td width=32><img src="/events/p_tracnghiem/images/button-cross-big.gif" border=0 title="' . $lngstr['label_action_groups_delete'] . '" style="cursor: hand;" onclick="f=document.groupsForm;if (confirm(\'' . $lngstr['qst_delete_groups'] . '\')) { f.action=\'/?control=mobo_event_tracnghiem&func=groups&action=delete&confirmed=1\';f.submit();}"></td><td width="100%">&nbsp;</td>';
if ($i_2_limitcount > 0) {
    if ($i_2_pageno > 1) {
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=test_manager&action=groups&pageno2=1' . $i_testids_addon . $i_order_addon . $i_2_order_addon . $i_2_url_limitto_addon . '"><img src="/events/p_tracnghiem/images/button-first-big.gif" border=0 title="' . $lngstr['button_first_page'] . '"></a></td>';
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=test_manager&action=groups&pageno2=' . max(($i_2_pageno - 1), 1) . $i_testids_addon . $i_order_addon . $i_2_order_addon . $i_2_url_limitto_addon . '"><img src="/events/p_tracnghiem/images/button-prev-big.gif" border=0 title="' . $lngstr['button_prev_page'] . '"></a></td>';
    } else {
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-first-big-inactive.gif" border=0 title="' . $lngstr['button_first_page'] . '"></td>';
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-prev-big-inactive.gif" border=0 title="' . $lngstr['button_prev_page'] . '"></td>';
    }
    if ($i_2_pageno < $i_2_pageno_count) {
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=test_manager&action=groups&pageno2=' . min(($i_2_pageno + 1), $i_2_pageno_count) . $i_testids_addon . $i_order_addon . $i_2_order_addon . $i_2_url_limitto_addon . '"><img src="/events/p_tracnghiem/images/button-next-big.gif" border=0 title="' . $lngstr['button_next_page'] . '"></a></td>';
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=test_manager&action=groups&pageno2=' . $i_2_pageno_count . $i_testids_addon . $i_order_addon . $i_2_order_addon . $i_2_url_limitto_addon . '"><img src="/events/p_tracnghiem/images/button-last-big.gif" border=0 title="' . $lngstr['button_last_page'] . '"></a></td>';
    } else {
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-next-big-inactive.gif" border=0 title="' . $lngstr['button_next_page'] . '"></td>';
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-last-big-inactive.gif" border=0 title="' . $lngstr['button_last_page'] . '"></td>';
    }
}
$html.= '<td width=2><img src="/events/p_tracnghiem/images/toolbar-right.gif" width=2 height=32></td></tr></table>';
$html.= '</td></tr><tr><td>';
$html.= '<table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">';
$html.= '<tr vAlign=top><td class=rowhdr1 title="' . $lngstr['label_hdr_select_hint'] . '" width=22><input type=checkbox name=toggleAll onclick="toggleCBs(this);"></td>';
$html.=$func->writeQryTableHeaders('/?control=mobo_event_tracnghiem&func=test_manager&action=groups' . $i_testids_addon . $i_order_addon . $i_2_url_limit_addon, $i_2_tablefields, $i_2_order_no, $i_2_direction, '2');
$html.= '<td class=rowhdr1 title="' . $lngstr['page_assignto_hdr_assignto_hint'] . '" vAlign=top>' . $lngstr['page_assignto_hdr_assignto'] . '</td>';
$html.= '<td class=rowhdr1 colspan=2>' . $lngstr['label_hdr_action'] . '</td></tr>';
$i_rSet3 = $func->m_bd->SelectLimit("SELECT * FROM " . $srv_settings['table_prefix'] . "groups" . $i_2_sql_order_addon, $i_2_limitcount, $i_2_limitfrom);
if ($i_rSet3) {
    $i_counter = 0;
    foreach($i_rSet3 as $key3=>$value3) {

        $i_member_count = $func->getRecordCount($srv_settings['table_prefix'] . 'groups_tests', $i_sql_where_addon . "groupid=" . $value3["groupid"]);
        $rowname = ($i_counter % 2) ? "rowone" : "rowtwo";
        $html.= '<tr id=tr_' . $i_pagewide_id . ' class=' . $rowname . ' onmouseover="rollTR(' . $i_pagewide_id . ',1);" onmouseout="rollTR(' . $i_pagewide_id . ',0);"><td align=center width=22' . ($value3["groupid"] > SYSTEM_GROUP_MAX_INDEX ? '' : ' class=system') . '><input id=cb_' . $i_pagewide_id . ' type=checkbox name=box_groups[] value="' . $value3["groupid"] . '" onclick="toggleCB(this);"></td><td align=right>' . $value3["groupid"] . '</td><td>' . $func->getTruncatedHTML($value3["group_name"]) . '</td><td>' . $value3["group_description"] . '</td><td align=center><a href="/?control=mobo_event_tracnghiem&func=test_manager&action=assignto&groupid=' . $value3["groupid"] . $i_order_addon . $i_testids_addon . $i_2_url_limit_addon . '&set=' . ($i_member_count >= sizeof($f_testids) ? '0"><img src="/events/p_tracnghiem/images/button-checkbox-2.gif" width=13 height=13 border=0 title="' . $lngstr['label_yes'] . '">' : ($i_member_count > 0 ? '1"><img src="/events/p_tracnghiem/images/button-checkbox-1.gif" width=13 height=13 border=0 title="' . $lngstr['label_partially'] . '">' : '1"><img src="/events/p_tracnghiem/images/button-checkbox-0.gif" width=13 height=13 border=0 title="' . $lngstr['label_no'] . '">')) . '</a></td>';
        $html.= '<td align=center width=22><a href="/?control=mobo_event_tracnghiem&func=groups&groupid=' . $value3["groupid"] . '&action=edit"><img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-edit.gif" title="' . $lngstr['label_action_group_edit'] . '"></a></td><td align=center width=22>' . ($value3["groupid"] > SYSTEM_GROUP_MAX_INDEX ? '<a href="/?control=mobo_event_tracnghiem&func=groups&groupid=' . $value3["groupid"] . '&action=delete" onclick="return confirmMessage(this, \'' . $lngstr['qst_delete_group'] . '\')"><img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-cross.gif" title="' . $lngstr['label_action_group_delete'] . '"></a>' : '<img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-cross-inactive.gif">') . '</td></tr>';
        $i_counter++;
        $i_pagewide_id++;
    }
}
$html.= '</table>';
$html.= '</td></tr></table></form>';

//displayTemplate('_footer');
$html.= $this->CI->load->view('events/tracnghiem/_footer.tpl.html', $this->_tpl_vars, true);
//die;
//displayTemplate('_footer');
$this->data['content_view'] = $html;
//$this->CI->template->write_view('content', 'game/eden/Events/LoanDauVoDai/logxephang', $this->data);
$this->CI->template->write_view('content', 'events/tracnghiem/views.tpl.html', $this->data);
//displayTemplate('_footer');
?>
