<?php
/* <one line to give the program's name and a brief idea of what it does.>
 * Copyright (C) 2015 ATM Consulting <support@atm-consulting.fr>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * 	\file		admin/tasklist.php
 * 	\ingroup	tasklist
 * 	\brief		This file is an example module setup page
 * 				Put some comments here
 */
// Dolibarr environment
$res = @include("../../main.inc.php"); // From htdocs directory
if (! $res) {
    $res = @include("../../../main.inc.php"); // From "custom" directory
}

// Libraries
require_once DOL_DOCUMENT_ROOT . "/core/lib/admin.lib.php";
require_once '../lib/tasklist.lib.php';

$newToken = function_exists('newToken') ? newToken() : $_SESSION['newtoken'];
// Translations
$langs->load("tasklist@tasklist");

// Access control
if (! $user->admin) {
    accessforbidden();
}

// Parameters
$action = GETPOST('action', 'alphanohtml');

/*
 * Actions
 */
if (preg_match('/set_(.*)/',$action,$reg))
{
	$code=$reg[1];
	if (dolibarr_set_const($db, $code, GETPOST($code, 'aZ09'), 'chaine', 0, '', $conf->entity) > 0)
	{
		header("Location: ".$_SERVER["PHP_SELF"]);
		exit;
	}
	else
	{
		dol_print_error($db);
	}
}

if (preg_match('/del_(.*)/',$action,$reg))
{
	$code=$reg[1];
	if (dolibarr_del_const($db, $code, 0) > 0)
	{
		Header("Location: ".$_SERVER["PHP_SELF"]);
		exit;
	}
	else
	{
		dol_print_error($db);
	}
}

/*
 * View
 */
$page_name = "tasklistSetup";
llxHeader('', $langs->trans($page_name));

// Subheader
$linkback = '<a href="' . DOL_URL_ROOT . '/admin/modules.php">'
    . $langs->trans("BackToModuleList") . '</a>';
print_fiche_titre($langs->trans($page_name), $linkback);

// Configuration header
$head = tasklistAdminPrepareHead();
dol_fiche_head(
    $head,
    'settings',
    $langs->trans("Module104590Name"),
    0,
    "tasklist@tasklist"
);

// Setup page goes here
$form=new Form($db);
$var=false;
print '<table class="noborder" width="100%">';
print '<tr class="liste_titre">';
print '<td>'.$langs->trans("Parameters").'</td>'."\n";
print '<td align="center" width="20">&nbsp;</td>';
print '<td align="center" width="100">'.$langs->trans("Value").'</td>'."\n";


// Example with a yes / no select
$var=!$var;
print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("TASKLIST_SHOW_DOCPREVIEW").'</td>';
print '<td align="center" width="20">&nbsp;</td>';
print '<td align="right" width="300">';
print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
print '<input type="hidden" name="token" value="'.$newToken.'">';
print '<input type="hidden" name="action" value="set_TASKLIST_SHOW_DOCPREVIEW">';
print ajax_constantonoff('TASKLIST_SHOW_DOCPREVIEW');
print '</form>';
print '</td></tr>';

$var=!$var;
print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("TASKLIST_SHOW_EXTRAFIELDS").'</td>';
print '<td align="center" width="20">&nbsp;</td>';
print '<td align="right" width="300">';
print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
print '<input type="hidden" name="token" value="'.$newToken.'">';
print '<input type="hidden" name="action" value="set_TASKLIST_SHOW_EXTRAFIELDS">';
print $form->selectyesno("TASKLIST_SHOW_EXTRAFIELDS", getDolGlobalInt('TASKLIST_SHOW_EXTRAFIELDS'),1);
print '<input type="submit" class="button" value="'.$langs->trans("Modify").'">';
print '</form>';
print '</td></tr>';


if(getDolGlobalInt('TASKLIST_SHOW_EXTRAFIELDS')) {

    $var=!$var;
    print '<tr '.$bc[$var].'>';
    print '<td>'.$langs->trans("TASKLIST_SHOW_LINE_ORDER_EXTRAFIELD_JUST_THEM").'</td>';
    print '<td align="center" width="20">&nbsp;</td>';
    print '<td align="right" width="300" style="white-space:nowrap;">';
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
    print '<input type="hidden" name="token" value="'.$newToken.'">';
    print '<input type="hidden" name="action" value="set_TASKLIST_SHOW_LINE_ORDER_EXTRAFIELD_JUST_THEM">';
    print '<input name="TASKLIST_SHOW_LINE_ORDER_EXTRAFIELD_JUST_THEM" value="'. getDolGlobalString('TASKLIST_SHOW_LINE_ORDER_EXTRAFIELD_JUST_THEM') .'" />';
    print '<input type="submit" class="button" value="'.$langs->trans("Modify").'">';
    print '</form>';
    print '</td></tr>';

}

$var=!$var;
print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("TASKLIST_SHOW_DESCRIPTION_TASK").'</td>';
print '<td align="center" width="20">&nbsp;</td>';
print '<td align="right" width="300">';
print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
print '<input type="hidden" name="token" value="'.$newToken.'">';
print '<input type="hidden" name="action" value="set_TASKLIST_SHOW_DESCRIPTION_TASK">';
print ajax_constantonoff('TASKLIST_SHOW_DESCRIPTION_TASK');
print '</form>';
print '</td></tr>';

$var=!$var;
print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("TASKLIST_ONLY_ADMIN_CAN_CHANGE_USER").'</td>';
print '<td align="center" width="20">&nbsp;</td>';
print '<td align="right" width="300">';
print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
print '<input type="hidden" name="token" value="'.$newToken.'">';
print '<input type="hidden" name="action" value="set_TASKLIST_ONLY_ADMIN_CAN_CHANGE_USER">';
print ajax_constantonoff('TASKLIST_ONLY_ADMIN_CAN_CHANGE_USER');
print '</form>';
print '</td></tr>';

/*$var=!$var;
print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("TASKLIST_OF_LINK_TO_DOLIBARR").'</td>';
print '<td align="center" width="20">&nbsp;</td>';
print '<td align="right" width="300">';
print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
print '<input type="hidden" name="token" value="'.$newToken.'">';
print '<input type="hidden" name="action" value="set_TASKLIST_OF_LINK_TO_DOLIBARR">';
print ajax_constantonoff('TASKLIST_OF_LINK_TO_DOLIBARR');
print '</form>';
print '</td></tr>';
*/

print '</table>';

llxFooter();

$db->close();
