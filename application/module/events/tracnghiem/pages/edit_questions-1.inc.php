<?php
$html = '';
$g_vars['page']['location'] = array('test_manager', 'test_manager', 'test_questions');

$this->_tpl_vars['g_vars'] = $g_vars;
$this->_tpl_vars['lngstr'] = $lngstr;
$$html.= $this->CI->load->view('events/tracnghiem/_header.tpl.html', $this->_tpl_vars, true);

$f_testid = (int)$func->readGetVar('testid');
$g_vars['page']['selected_section'] = 'testmanager';
$g_vars['page']['selected_tab'] = 'editquestions';
$g_vars['page']['menu_2_items'] = $func->getMenu2Items($g_vars['page']['selected_section'],$lngstr);
$html.= $func->writePanel2($g_vars,$g_vars['page']['menu_2_items']);
$html.= '<h2>' . $lngstr['page_header_test_questions'] . '</h2>';
$html.= $func->writeErrorsWarningsBar();
//$func->writeInfoBar($lngstr['tooltip_tests_questions']);
$i_pagewide_id = 0;

$i_subjectid_addon = '';
$i_sql_where_addon = '';
if (isset($_GET['subjectid']) && $_GET['subjectid'] != '') {
    $i_subjectid_addon .= '&subjectid=' . (int)$_GET['subjectid'];
    $i_sql_where_addon .= $srv_settings['table_prefix'] . 'questions.subjectid=' . (int)$_GET['subjectid'] . ' AND ';
}

$i_direction = '';
$i_order_addon = '';
$i_sql_order_addon = '';
$i_tablefields = array(
    array($lngstr['label_editquestions_hdr_test_questionid'], $lngstr['label_editquestions_hdr_test_questionid_hint'], $srv_settings['table_prefix'] . 'tests_questions.test_questionid'),
    array($lngstr['label_editquestions_hdr_questionid'], $lngstr['label_editquestions_hdr_questionid_hint'], $srv_settings['table_prefix'] . 'questions.questionid'),
    array($lngstr['label_editquestions_hdr_subjectid'], $lngstr['label_editquestions_hdr_subjectid_hint'], $srv_settings['table_prefix'] . 'questions.subjectid'),
    array($lngstr['label_editquestions_hdr_question_text'], $lngstr['label_editquestions_hdr_question_text_hint'], ''),
    array($lngstr['label_editquestions_hdr_question_type'], $lngstr['label_editquestions_hdr_question_type_hint'], $srv_settings['table_prefix'] . 'questions.question_type'),
    array($lngstr['label_editquestions_hdr_question_points'], $lngstr['label_editquestions_hdr_question_points_hint'], $srv_settings['table_prefix'] . 'questions.question_points'),

);
$i_order_no = isset($_GET['order']) ? (int)$_GET['order'] : 0;
if ($i_order_no >= count($i_tablefields))
    $i_order_no = -1;
if ($i_order_no >= 0) {
    $i_direction = (isset($_GET['direction']) && $_GET['direction']) ? 'DESC' : '';
    $i_order_addon = '&order=' . $i_order_no . '&direction=' . $i_direction;
    $i_sql_order_addon = ' ORDER BY ' . $i_tablefields[$i_order_no][2] . ' ' . $i_direction;
}

$i_url_limitto_addon = '';
$i_url_pageno_addon = '';
$i_url_limit_addon = '';
$i_pageno = 0;
$i_limitcount = isset($_GET['limitto']) ? (int)$_GET['limitto'] : $G_SESSION['config_itemsperpage'];
if ($i_limitcount > 0) {
    $i_recordcount = $func->getRecordCount($srv_settings['table_prefix'] . 'tests_questions, ' . $srv_settings['table_prefix'] . 'questions', $i_sql_where_addon . "" . $srv_settings['table_prefix'] . "tests_questions.testid=" . $f_testid . " AND " . $srv_settings['table_prefix'] . "tests_questions.questionid=" . $srv_settings['table_prefix'] . "questions.questionid");
    $i_pageno = isset($_GET['pageno']) ? (int)$_GET['pageno'] : 1;
    if ($i_pageno < 1)
        $i_pageno = 1;
    $i_limitfrom = ($i_pageno - 1) * $i_limitcount;
    $i_pageno_count = floor(($i_recordcount - 1) / $i_limitcount) + 1;
    if ($i_limitfrom > $i_recordcount) {
        $i_pageno = $i_pageno_count;
        $i_limitfrom = ($i_pageno - 1) * $i_limitcount;
    }
    $i_url_limitto_addon .= '&limitto=' . $i_limitcount;
    $i_url_pageno_addon .= '&pageno=' . $i_pageno;
    $i_url_limit_addon .= $i_url_limitto_addon . $i_url_pageno_addon;
} else {
    $i_url_limitto_addon = '&limitto=';
    $i_url_limit_addon .= $i_url_limitto_addon;
    $i_limitfrom = -1;
    $i_limitcount = -1;
}

$i_2_subjectid_addon = '';
$i_2_sql_where_addon = '';
if (isset($_GET['subjectid2']) && $_GET['subjectid2'] != '') {
    $i_2_subjectid_addon .= '&subjectid2=' . (int)$_GET['subjectid2'];
    $i_2_sql_where_addon .= $srv_settings['table_prefix'] . 'questions.subjectid=' . (int)$_GET['subjectid2'] . ' AND ';
}

$i_2_direction = '';
$i_2_order_addon = '';
$i_2_sql_order_addon = '';
$i_2_tablefields = array(
    array($lngstr['label_editquestions_hdr_questionid'], $lngstr['label_editquestions_hdr_questionid_hint'], $srv_settings['table_prefix'] . 'questions.questionid'),
    array($lngstr['label_editquestions_hdr_subjectid'], $lngstr['label_editquestions_hdr_subjectid_hint'], $srv_settings['table_prefix'] . 'questions.subjectid'),
    array($lngstr['label_editquestions_hdr_question_text'], $lngstr['label_editquestions_hdr_question_text_hint'], ''),
    array($lngstr['label_editquestions_hdr_question_type'], $lngstr['label_editquestions_hdr_question_type_hint'], $srv_settings['table_prefix'] . 'questions.question_type'),
    array($lngstr['label_editquestions_hdr_question_points'], $lngstr['label_editquestions_hdr_question_points_hint'], $srv_settings['table_prefix'] . 'questions.question_points'),
);
$i_2_order_no = isset($_GET['order2']) ? (int)$_GET['order2'] : 0;
if ($i_2_order_no >= count($i_2_tablefields))
    $i_2_order_no = -1;
if ($i_2_order_no >= 0) {
    $i_2_direction = (isset($_GET['direction2']) && $_GET['direction2']) ? 'DESC' : '';
    $i_2_order_addon = '&order2=' . $i_2_order_no . '&direction2=' . $i_2_direction;
    $i_2_sql_order_addon = ' ORDER BY ' . $i_2_tablefields[$i_2_order_no][2] . ' ' . $i_2_direction;
}

$i_2_url_limitto_addon = '';
$i_2_url_pageno_addon = '';
$i_2_url_limit_addon = '';
$i_2_pageno = 0;
$i_2_limitcount = isset($_GET['limitto2']) ? (int)$_GET['limitto2'] : $G_SESSION['config_itemsperpage'];
if ($i_2_limitcount > 0) {
    $i_2_recordcount = 0;
    $i_2_recordcount = $func->getRecordCount($srv_settings['table_prefix'] . 'questions', $i_2_sql_where_addon . '1=1');
    $i_2_pageno = isset($_GET['pageno2']) ? (int)$_GET['pageno2'] : 1;
    if ($i_2_pageno < 1)
        $i_2_pageno = 1;
    $i_2_limitfrom = ($i_2_pageno - 1) * $i_2_limitcount;
    $i_2_pageno_count = floor(($i_2_recordcount - 1) / $i_2_limitcount) + 1;
    if ($i_2_limitfrom > $i_2_recordcount) {
        $i_2_pageno = $i_2_pageno_count;
        $i_2_limitfrom = ($i_2_pageno - 1) * $i_2_limitcount;
    }
    $i_2_url_limitto_addon .= '&limitto2=' . $i_2_limitcount;
    $i_2_url_pageno_addon .= '&pageno2=' . $i_2_pageno;
    $i_2_url_limit_addon .= $i_2_url_limitto_addon . $i_2_url_pageno_addon;
} else {
    $i_2_url_limitto_addon = '&limitto2=';
    $i_2_url_limit_addon .= $i_2_url_limitto_addon;
    $i_2_limitfrom = -1;
    $i_2_limitcount = -1;
}
$html.= '<p><form name=qlinksForm class=iactive method="post"><table cellpadding=0 cellspacing=0 border=0 width="100%"><tr><td>';
$html.= '<table cellpadding=0 cellspacing=0 border=0 width="100%" style="background: url(/events/p_tracnghiem/images/toolbar-background.gif) repeat-x"><tr vAlign=center><td width=2><img src="/events/p_tracnghiem/images/toolbar-left.gif" width=2 height=32></td><td width=32>
<a href="/?control=mobo_event_tracnghiem&module=all&func=question_bank&testid=' . $f_testid . '&action=createq"><img src="/events/p_tracnghiem/images/button-add-big.gif" width=32 height=32 border=0 title="' . $lngstr['label_action_create_and_add_question'] . '"></a></td><td width=3><img src="/events/p_tracnghiem/images/toolbar-separator.gif" width=3 height=32 border=0></td><td width=32><a href="/?control=mobo_event_tracnghiem&func=test_manager&action=import&testid=' . $f_testid . '"><img src="/events/p_tracnghiem/images/button-import-big.gif" width=32 height=32 border=0 title="' . $lngstr['label_action_import_questions'] . '"></a></td><td width=3><img src="/events/p_tracnghiem/images/toolbar-separator.gif" width=3 height=32 border=0></td><td width=32>
<img src="/events/p_tracnghiem/images/button-cross-big.gif" width=32 height=32 border=0 title="' . $lngstr['label_action_question_links_delete'] . '" style="cursor: hand;" onclick="f=document.qlinksForm;if (confirm(\'' . $lngstr['qst_delete_question_links'] . '\')) { f.action=\'/?control=mobo_event_tracnghiem&func=test_manager&testid=' . $f_testid . $i_subjectid_addon . $i_order_addon . $i_url_limit_addon . $i_2_subjectid_addon . $i_2_order_addon . $i_2_url_limit_addon . '&action=deleteq&confirmed=1&module=all\';f.submit();}"></td><td width=3><img src="/events/p_tracnghiem/images/toolbar-separator.gif" width=3 height=32 border=0></td><td width=3><img src="/events/p_tracnghiem/images/1x1.gif" width=3 height=1></td><td width=32>';
$html.= '<select name=subjectid onchange="document.location.href=\'/?control=mobo_event_tracnghiem&module=all&func=test_manager&testid=' . $f_testid . '&subjectid=\'+this.value+\'' . $i_order_addon . $i_url_limit_addon . $i_2_subjectid_addon . $i_2_order_addon . $i_2_url_limit_addon . '&action=editt\';">';
$html.= '<option value=""></option>';
$i_rSet2 = $func->m_bd->Execute("SELECT * FROM " . $srv_settings['table_prefix'] . "subjects");
if ($i_rSet2) {
    foreach($i_rSet2 as $key2=>$value2) {
        $html.= '<option value=' . $value2['subjectid'];
        if (isset($_GET['subjectid']) && ($_GET['subjectid'] == $value2['subjectid']))
            $html.= ' selected=selected';
        $html.= '>' . $func->convertTextValue($value2['subject_name']) . '</option>' . "\n";
    }
}
$html.= '</select></td>';
$html.= '<td width="100%">&nbsp;</td>';
if ($i_limitcount > 0) {
    if ($i_pageno > 1) {
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=test_manager&action=editt&pageno=1&testid=' . $f_testid . $i_subjectid_addon . $i_order_addon . $i_url_limitto_addon . $i_2_subjectid_addon . $i_2_order_addon . $i_2_url_limit_addon . '"><img src="/events/p_tracnghiem/images/button-first-big.gif" width=32 height=32 border=0 title="' . $lngstr['button_first_page'] . '"></a></td>';
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=test_manager&action=editt&pageno=' . max(($i_pageno - 1), 1) . '&testid=' . $f_testid . $i_subjectid_addon . $i_order_addon . $i_url_limitto_addon . $i_2_subjectid_addon . $i_2_order_addon . $i_2_url_limit_addon . '"><img src="/events/p_tracnghiem/images/button-prev-big.gif" width=32 height=32 border=0 title="' . $lngstr['button_prev_page'] . '"></a></td>';
    } else {
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-first-big-inactive.gif" width=32 height=32 border=0 title="' . $lngstr['button_first_page'] . '"></td>';
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-prev-big-inactive.gif" width=32 height=32 border=0 title="' . $lngstr['button_prev_page'] . '"></td>';
    }
    if ($i_pageno < $i_pageno_count) {
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=test_manager&action=editt&pageno=' . min(($i_pageno + 1), $i_pageno_count) . '&testid=' . $f_testid . $i_subjectid_addon . $i_order_addon . $i_url_limitto_addon . $i_2_subjectid_addon . $i_2_order_addon . $i_2_url_limit_addon . '"><img src="/events/p_tracnghiem/images/button-next-big.gif" width=32 height=32 border=0 title="' . $lngstr['button_next_page'] . '"></a></td>';
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=test_manager&action=editt&pageno=' . $i_pageno_count . '&testid=' . $f_testid . $i_subjectid_addon . $i_order_addon . $i_url_limitto_addon . $i_2_subjectid_addon . $i_2_order_addon . $i_2_url_limit_addon . '"><img src="/events/p_tracnghiem/images/button-last-big.gif" width=32 height=32 border=0 title="' . $lngstr['button_last_page'] . '"></a></td>';
    } else {
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-next-big-inactive.gif" width=32 height=32 border=0 title="' . $lngstr['button_next_page'] . '"></td>';
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-last-big-inactive.gif" width=32 height=32 border=0 title="' . $lngstr['button_last_page'] . '"></td>';
    }
}
$html.= '<td width=2><img src="/events/p_tracnghiem/images/toolbar-right.gif" width=2 height=32></td></tr></table>';
$html.= '</td></tr><tr><td>';
$html.= '<table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">';
$html.= '<tr vAlign=top><td class=rowhdr1 title="' . $lngstr['label_hdr_select_hint'] . '" width=22><input type=checkbox name=toggleAll onclick="toggleCBs(this);"></td>';
$html.= $func->writeQryTableHeaders('/?control=mobo_event_tracnghiem&func=test_manager&action=editt&testid=' . $f_testid . $i_subjectid_addon . $i_url_limit_addon . $i_2_subjectid_addon . $i_2_order_addon . $i_2_url_limit_addon, $i_tablefields, $i_order_no, $i_direction);
$html.= '<td class=rowhdr1 colspan=3>' . $lngstr['label_hdr_action'] . '</td></tr>';
$i_questionids_in_the_test = array();
$i_rSet1 = $func->m_bd->SelectLimit("SELECT " . $srv_settings['table_prefix'] . "tests_questions.test_questionid, " . $srv_settings['table_prefix'] . "tests_questions.questionid, " . $srv_settings['table_prefix'] . "tests_questions.test_sectionid, " . $srv_settings['table_prefix'] . "questions.subjectid, " . $srv_settings['table_prefix'] . "questions.question_text, " . $srv_settings['table_prefix'] . "questions.question_time, " . $srv_settings['table_prefix'] . "questions.question_type, " . $srv_settings['table_prefix'] . "questions.question_points, tbl_listevents.name FROM " . $srv_settings['table_prefix'] . "tests_questions, " . $srv_settings['table_prefix'] . "questions, tbl_listevents WHERE " . $i_sql_where_addon . "" . $srv_settings['table_prefix'] . "tests_questions.testid=" . $f_testid . " AND " . $srv_settings['table_prefix'] . "tests_questions.questionid=" . $srv_settings['table_prefix'] . "questions.questionid AND " . $srv_settings['table_prefix'] . "questions.subjectid=tbl_listevents.id" . $i_sql_order_addon, $i_limitcount, $i_limitfrom);
if ($i_rSet1) {
    $i_counter = 0;
    foreach($i_rSet1 as $key1=>$value1) {
        $rowname = ($i_counter % 2) ? 'rowone' : 'rowtwo';
        array_push($i_questionids_in_the_test, $value1['questionid']);
        $html.= '<tr id=tr_' . $i_pagewide_id . ' class=' . $rowname . '2 onmouseover="rollTR(' . $i_pagewide_id . ',1);" onmouseout="rollTR(' . $i_pagewide_id . ',0);"><td align=center width=22><input id=cb_' . $i_pagewide_id . ' type=checkbox name=box_qlinks[] value="' . $value1['test_questionid'] . '" onclick="toggleCB(this);"></td><td align=right>' . $value1['test_questionid'] . '</td><td align=right>' . $value1['questionid'] . '</td><td><a href="/?control=mobo_event_tracnghiem&func=test_manager&testid=' . $f_testid . (isset($_GET['subjectid']) && $_GET['subjectid'] != '' ? '' : '&subjectid=' . $value1['subjectid']) . $i_order_addon . $i_url_limit_addon . $i_2_subjectid_addon . $i_2_order_addon . $i_2_url_limit_addon . '&action=editt">' . $func->convertTextValue($value1['name']) . '</a></td><td>' . $func->getTruncatedHTML($value1['question_text']) . '</td><td>';
        switch ($value1['question_type']) {
            case QUESTION_TYPE_MULTIPLECHOICE:
                $html.= $lngstr['label_atype_multiple_choice'];
                break;
            case QUESTION_TYPE_TRUEFALSE:
                $html.= $lngstr['label_atype_truefalse'];
                break;
            case QUESTION_TYPE_MULTIPLEANSWER:
                $html.= $lngstr['label_atype_multiple_answer'];
                break;
            case QUESTION_TYPE_FILLINTHEBLANK:
                $html.= $lngstr['label_atype_fillintheblank'];
                break;
            case QUESTION_TYPE_ESSAY:
                $html.= $lngstr['label_atype_essay'];
                break;
            case QUESTION_TYPE_RANDOM:
                $html.= $lngstr['label_atype_random'];
                break;
        }
        $html.= '</td>';
        $html.= '<td align=right>' . (($value1['question_type'] <> QUESTION_TYPE_RANDOM) ? $value1['question_points'] : '') . '</td>';

        $html.= '<td align=center width=22><a href="/?control=mobo_event_tracnghiem&func=question_bank&testid=' . $f_testid . '&questionid=' . $value1['questionid'] . '&action=editq"><img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-edit.gif" title="' . $lngstr['label_action_question_edit'] . '"></a></td><td align=center width=22><a href="/?control=mobo_event_tracnghiem&func=test_manager&testid=' . $f_testid . '&test_questionid=' . $value1['test_questionid'] . $i_subjectid_addon . $i_url_limit_addon . $i_2_subjectid_addon . $i_2_order_addon . $i_2_url_limit_addon . '&action=moveup"><img width=20 height=10 border=0 src="/events/p_tracnghiem/images/button-up.gif" title="' . $lngstr['label_action_question_moveup'] . '"></a><br><a href="/?control=mobo_event_tracnghiem&func=test_manager&testid=' . $f_testid . '&test_questionid=' . $value1['test_questionid'] . $i_subjectid_addon . $i_url_limit_addon . $i_2_subjectid_addon . $i_2_order_addon . $i_2_url_limit_addon . '&action=movedown"><img width=20 height=10 border=0 src="/events/p_tracnghiem/images/button-down.gif" title="' . $lngstr['label_action_question_movedown'] . '"></a></td><td align=center width=22><a href="/?control=mobo_event_tracnghiem&func=test_manager&testid=' . $f_testid . '&test_questionid=' . $value1['test_questionid'] . $i_subjectid_addon . $i_order_addon . $i_url_limit_addon . $i_2_subjectid_addon . $i_2_order_addon . $i_2_url_limit_addon . '&action=deleteq" onclick="return confirmMessage(this, \'' . $lngstr['qst_delete_question_link'] . '\')"><img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-cross.gif" title="' . $lngstr['label_action_question_link_delete'] . '"></a></td></tr>';
        $i_counter++;
        $i_pagewide_id++;
    }
}
$html.= '</table>';
$html.= '</td></tr></table></form>';

$html.= '<h2>' . $lngstr['page_header_questionbank'] . '</h2>';
$html.= '<p><form name=qbankForm class=iactive method=post><table cellpadding=0 cellspacing=0 border=0 width="100%"><tr><td>';
$html.= '<table cellpadding=0 cellspacing=0 border=0 width="100%" style="background: url(/events/p_tracnghiem/images/toolbar-background.gif) repeat-x"><tr vAlign=center><td width=2><img src="/events/p_tracnghiem/images/toolbar-left.gif" width=2 height=32></td><td width=32><a href="/?control=mobo_event_tracnghiem&func=question_bank&action=createq"><img src="/events/p_tracnghiem/images/button-new-big.gif" width=32 height=32 border=0 title="' . $lngstr['label_action_create_question'] . '"></a></td><td width=3><img src="/events/p_tracnghiem/images/toolbar-separator.gif" width=3 height=32 border=0></td><td width=32><img src="/events/p_tracnghiem/images/button-plus-big.gif" width=32 height=32 border=0 title="' . $lngstr['label_action_questions_append'] . '" style="cursor: hand;" onclick="f=document.qbankForm;f.action=\'/?control=mobo_event_tracnghiem&func=test_manager&testid=' . $f_testid . $i_subjectid_addon . $i_order_addon . $i_url_limit_addon . $i_2_subjectid_addon . $i_2_order_addon . $i_2_url_limit_addon . '&action=append\';f.submit();"></td><td width=3><img src="/events/p_tracnghiem/images/toolbar-separator.gif" width=3 height=32 border=0></td><td width=32><img src="/events/p_tracnghiem/images/button-cross-big.gif" width=32 height=32 border=0 title="' . $lngstr['label_action_questions_delete'] . '" style="cursor: hand;" onclick="f=document.qbankForm;if (confirm(\'' . $lngstr['qst_delete_questions'] . '\')) { f.action=\'/?control=mobo_event_tracnghiem&func=question_bank&testid=' . $f_testid . $i_subjectid_addon . $i_order_addon . $i_url_limit_addon . $i_2_subjectid_addon . $i_2_order_addon . $i_2_url_limit_addon . '&action=deleteq&confirmed=1\';f.submit();}"></td><td width=3><img src="/events/p_tracnghiem/images/toolbar-separator.gif" width=3 height=32 border=0></td><td width=3><img src="/events/p_tracnghiem/images/1x1.gif" width=3 height=1></td><td width=32>';
$html.= '<select name=subjectid2 onchange="document.location.href=\'/?control=mobo_event_tracnghiem&func=test_manager&testid=' . $f_testid . '&subjectid2=\'+this.value+\'' . $i_subjectid_addon . $i_order_addon . $i_url_limit_addon . $i_2_order_addon . $i_2_url_limit_addon . '&action=editt\';">';
$html.= '<option value=""></option>';
$i_rSet2 = $func->m_bd->Execute("SELECT * FROM tbl_listevents WHERE typeevent = 1");
if ($i_rSet2) {
    foreach($i_rSet2 as $key2=>$value2) {
        $html.= '<option value=' . $value2['id'];
        if (isset($_GET['subjectid2']) && ($_GET['subjectid2'] == $value2['id']))
            $html.= ' selected=selected';
        $html.= '>' . $func->convertTextValue($value2['name']) . '</option>' . "\n";
    }
}
$html.= '</select></td>';
$html.= '<td width="100%">&nbsp;</td>';
if ($i_2_limitcount > 0) {
    if ($i_2_pageno > 1) {
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=test_manager&action=editt&pageno2=1&testid=' . $f_testid . $i_subjectid_addon . $i_order_addon . $i_url_limit_addon . $i_2_subjectid_addon . $i_2_order_addon . $i_2_url_limitto_addon . '"><img src="/events/p_tracnghiem/images/button-first-big.gif" width=32 height=32 border=0 title="' . $lngstr['button_first_page'] . '"></a></td>';
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=test_manager&action=editt&pageno2=' . max(($i_2_pageno - 1), 1) . '&testid=' . $f_testid . $i_subjectid_addon . $i_order_addon . $i_url_limit_addon . $i_2_subjectid_addon . $i_2_order_addon . $i_2_url_limitto_addon . '"><img src="/events/p_tracnghiem/images/button-prev-big.gif" width=32 height=32 border=0 title="' . $lngstr['button_prev_page'] . '"></a></td>';
    } else {
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-first-big-inactive.gif" width=32 height=32 border=0 title="' . $lngstr['button_first_page'] . '"></td>';
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-prev-big-inactive.gif" width=32 height=32 border=0 title="' . $lngstr['button_prev_page'] . '"></td>';
    }
    if ($i_2_pageno < $i_2_pageno_count) {
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=test_manager&action=editt&pageno2=' . min(($i_2_pageno + 1), $i_2_pageno_count) . '&testid=' . $f_testid . $i_subjectid_addon . $i_order_addon . $i_url_limit_addon . $i_2_subjectid_addon . $i_2_order_addon . $i_2_url_limitto_addon . '"><img src="/events/p_tracnghiem/images/button-next-big.gif" width=32 height=32 border=0 title="' . $lngstr['button_next_page'] . '"></a></td>';
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=test_manager&action=editt&pageno2=' . $i_2_pageno_count . '&testid=' . $f_testid . $i_subjectid_addon . $i_order_addon . $i_url_limit_addon . $i_2_subjectid_addon . $i_2_order_addon . $i_2_url_limitto_addon . '"><img src="/events/p_tracnghiem/images/button-last-big.gif" width=32 height=32 border=0 title="' . $lngstr['button_last_page'] . '"></a></td>';
    } else {
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-next-big-inactive.gif" width=32 height=32 border=0 title="' . $lngstr['button_next_page'] . '"></td>';
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-last-big-inactive.gif" width=32 height=32 border=0 title="' . $lngstr['button_last_page'] . '"></td>';
    }
}
$html.= '<td width=2><img src="/events/p_tracnghiem/images/toolbar-right.gif" width=2 height=32></td></tr></table>';
$html.= '</td></tr><tr><td>';
$html.= '<table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">';
$html.= '<tr vAlign=top><td class=rowhdr1 title="' . $lngstr['label_hdr_select_hint'] . '" width=22><input type=checkbox name=toggleAll onclick="toggleCBs(this);"></td>';
$html.=$func->writeQryTableHeaders('/?control=mobo_event_tracnghiem&func=test_manager&action=editt&testid=' . $f_testid . $i_subjectid_addon . $i_order_addon . $i_url_limit_addon . $i_2_subjectid_addon . $i_2_url_limit_addon, $i_2_tablefields, $i_2_order_no, $i_2_direction, '2');
$html.= '<td class=rowhdr1 colspan=3>' . $lngstr['label_hdr_action'] . '</td></tr>';
$i_rSet2 = $func->m_bd->SelectLimit("SELECT " . $srv_settings['table_prefix'] . "questions.questionid, " . $srv_settings['table_prefix'] . "questions.subjectid, " . $srv_settings['table_prefix'] . "questions.question_text, " . $srv_settings['table_prefix'] . "questions.question_time, " . $srv_settings['table_prefix'] . "questions.question_type, " . $srv_settings['table_prefix'] . "questions.question_points, tbl_listevents.name FROM " . $srv_settings['table_prefix'] . "questions, tbl_listevents WHERE " . $i_2_sql_where_addon . "" . $srv_settings['table_prefix'] . "questions.subjectid=tbl_listevents.id" . $i_2_sql_order_addon, $i_2_limitcount, $i_2_limitfrom);
if ($i_rSet2) {
    $i_counter = 0;
    foreach($i_rSet2 as $key2=>$value2) {
        $rowname = ($i_counter % 2) ? 'rowone' : 'rowtwo';
        $i_rowtitle = '';

        if (!in_array($value2['questionid'], $i_questionids_in_the_test) || ($value2['question_type'] == QUESTION_TYPE_RANDOM)) {
            $html.= '<tr id=tr_' . $i_pagewide_id . ' class=' . $rowname . ' title="' . $i_rowtitle . '" onmouseover="rollTR(' . $i_pagewide_id . ',1);" onmouseout="rollTR(' . $i_pagewide_id . ',0);"><td align=center width=22><input id=cb_' . $i_pagewide_id . ' type=checkbox name=box_questions[] value="' . $value2['questionid'] . '" onclick="toggleCB(this);"></td><td align=right>' . $value2['questionid'] . '</td><td><a href="/?control=mobo_event_tracnghiem&func=test_manager&testid=' . $f_testid . (isset($_GET['subjectid2']) && $_GET['subjectid2'] != '' ? '' : '&subjectid2=' . $value2['subjectid']) . $i_subjectid_addon . $i_order_addon . $i_url_limit_addon . $i_2_order_addon . $i_2_url_limit_addon . '&action=editt">' . $func->convertTextValue($value2['name']) . '</a></td><td>' . $func->getTruncatedHTML($value2['question_text']) . '</td><td>';
            switch ($value2['question_type']) {
                case QUESTION_TYPE_MULTIPLECHOICE:
                    $html.= $lngstr['label_atype_multiple_choice'];
                    break;
                case QUESTION_TYPE_TRUEFALSE:
                    $html.= $lngstr['label_atype_truefalse'];
                    break;
                case QUESTION_TYPE_MULTIPLEANSWER:
                    $html.= $lngstr['label_atype_multiple_answer'];
                    break;
                case QUESTION_TYPE_FILLINTHEBLANK:
                    $html.= $lngstr['label_atype_fillintheblank'];
                    break;
                case QUESTION_TYPE_ESSAY:
                    $html.= $lngstr['label_atype_essay'];
                    break;
                case QUESTION_TYPE_RANDOM:
                    $html.= $lngstr['label_atype_random'];
                    break;
            }
            $html.= '</td><td align=right>' . ($value2['question_type'] <> QUESTION_TYPE_RANDOM ? $value2['question_points'] : '') . '</td><td align=center width=22><a href="/?control=mobo_event_tracnghiem&func=test_manager&testid=' . $f_testid . '&questionid=' . $value2['questionid'] . $i_subjectid_addon . $i_order_addon . $i_url_limit_addon . $i_2_subjectid_addon . $i_2_order_addon . $i_2_url_limit_addon . '&action=append"><img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-plus.gif" title="' . $lngstr['label_action_question_append'] . '"></a></td><td align=center width=22><a href="/?control=mobo_event_tracnghiem&func=question_bank&testid=' . $f_testid . '&questionid=' . $value2['questionid'] . '&action=editq"><img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-edit.gif" title="' . $lngstr['label_action_question_edit'] . '"></a></td><td align=center width=22><a href="/?control=mobo_event_tracnghiem&func=question_bank&testid=' . $f_testid . '&questionid=' . $value2['questionid'] . $i_subjectid_addon . $i_order_addon . $i_url_limit_addon . $i_2_subjectid_addon . $i_2_order_addon . $i_2_url_limit_addon . '&action=deleteq" onclick="return confirmMessage(this, \'' . $lngstr['qst_delete_question'] . '\')"><img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-cross.gif" title="' . $lngstr['label_action_question_delete'] . '"></a></td></tr>';
            $i_counter++;
            $i_pagewide_id++;
        }
    }
}
$html.= '</table>';
$html.= '</td></tr></table></form>';


$html.= $this->CI->load->view('events/tracnghiem/_footer.tpl.html', $this->_tpl_vars, true);
//die;
//displayTemplate('_footer');
$this->data['content_view'] = $html;
//$this->CI->template->write_view('content', 'game/eden/Events/LoanDauVoDai/logxephang', $this->data);
$this->CI->template->write_view('content', 'events/tracnghiem/views.tpl.html', $this->data);
?>