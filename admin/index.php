<?php

// -------------------------------------------------------------------------
//           Quote for Xoops v1.00
//        Module for
//      XOOPS V2 - PHP Content Management System
//       <https://www.xoops.org>
// -------------------------------------------------------------------------
// Author: Eric Houze
// Purpose: Module to display the quote of the day into Xoops V2.
// email: eric.houze@free.fr
// Site: http://eric.houze.free.fr
// -------------------------------------------------------------------------
//  This program is free software; you can redistribute it and/or modify
//  it under the terms of the GNU General Public License as published by
//  the Free Software Foundation; either version 2 of the License, or
//  (at your option) any later version.
//
//  This program is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//  GNU General Public License for more details.
// -------------------------------------------------------------------------

require_once 'admin_header.php';

/*********************************************************/
/*                           FreeContent - Admin                                  */
/*********************************************************/

xoops_cp_header();
$myts = MyTextSanitizer::getInstance();
echo '<br>';

switch ($op) {
    case 'edit':
    q4x_admin_edit($id);
      break;
    case 'editdb':
    $form_author = $myts->addSlashes($form_author);
        $form_quote = $myts->addSlashes($form_quote);
      $q = 'UPDATE ' . $xoopsDB->prefix() . "_quote4xoops SET author='" . $form_author . "', quote='" . $form_quote . "' WHERE id='" . $form_id . "'";
      if ($xoopsDB->query($q)) {
          redirect_header('index.php', 1, _AM_Q4X_EDIT_DONE);
      } else {
          redirect_header('index.php', 1, _AM_Q4X_EDIT_DBERROR);
      }
    q4x_admin_add();
        q4x_admin_browse(-1, '');
      break;
    case 'del':
    if ($xoopsDB->query('DELETE FROM ' . $xoopsDB->prefix() . '_quote4xoops WHERE id=' . $id . '')) {
        redirect_header('index.php', 1, _AM_Q4X_DEL_OK);
    } else {
        redirect_header('index.php', 1, _AM_Q4X_EDIT_DBERROR);
    }
    q4x_admin_add();
        q4x_admin_browse(-1, '');
      break;
   case 'delconfirm':
    OpenTable();
      $result = $xoopsDB->queryF('SELECT id, author, quote FROM ' . $xoopsDB->prefix() . "_quote4xoops WHERE id='" . $id . "'", 1);
      $q4x_item = $xoopsDB->fetchArray($result);
      echo '<center><h4>' . _AM_Q4X_DEL_REALLY . '</h4></center>
			  <br>' . _AM_Q4X_ID . ' : ' . $q4x_item['id'] . '
			  <br>' . _AM_Q4X_AUTHOR . ' : ' . htmlspecialchars($q4x_item['author'], ENT_QUOTES | ENT_HTML5) . '
			  <br>' . _AM_Q4X_QUOTE . ' : ' . htmlspecialchars($q4x_item['quote'], ENT_QUOTES | ENT_HTML5) . "
			  <br><form action='index.php' method='post'>
			  <input type='hidden' name='id' value='" . $id . "'>
			  <input type='hidden' name='op' value='del'>
			  <input type='submit' value='" . _AM_Q4X_DELETE . "'>&nbsp;
			  <input type='button' value='" . _CANCEL . "' onclick='javascript:history.go(-1);'></form>";
      CloseTable();
      break;
    case 'add':
    $form_author = $myts->addSlashes($form_author);
      $form_quote = $myts->addSlashes($form_quote);
      $q = 'INSERT INTO ' . $xoopsDB->prefix() . "_quote4xoops (author, quote) VALUES ('" . $form_author . "', '" . $form_quote . "')";
      if ($xoopsDB->query($q)) {
          redirect_header('index.php', 1, _AM_Q4X_EDIT_DONE);
      } else {
          redirect_header('index.php', 1, _AM_Q4X_EDIT_DBERROR);
      }
      break;
    case 'browse':
    $form_browsein = $browse_in;
      $form_browsetext = $myts->addSlashes($browse_text);
    q4x_admin_add();
        q4x_admin_browse($form_browsein, $form_browsetext);
        break;
    default:
    q4x_admin_add();
        q4x_admin_browse(-1, '');
      break;
}

xoops_cp_footer();

//*****************************************************************************************
//*** Functions-declaration ***************************************************************
//*****************************************************************************************

function q4x_admin_add()
{
    global $xoopsConfig;

    OpenTable();

    echo '<form name="Add Quote" action="./index.php" method="post"><div align="center">
   	<h4>' . _AM_Q4X_ADD_HEADER . '</h4>
	   </div><table border="0" cellpadding="2" cellspacing="2" width="95%">
      <tr>
      	<td align="right">' . _AM_Q4X_AUTHOR . ':</td>
         <td><input type="text" name="form_author" size="30" maxlength="50" tabindex="1"><br></td>
      </tr>
      <tr>
      	<td align="right">' . _AM_Q4X_QUOTE . ':</td>
         <td><input type="text" name="form_quote" size="100" maxlength="255" value="" tabindex="2"></td>
      </tr>
      <tr height="10">
      	<td align="right" height="10"></td>
      	<td height="10"><input type="hidden" value="add" name="op"></td>
       </tr>
       <tr>
       	<td align="right"></td>
         <td><input type="submit" name="add" tabindex="3" value="' . _AM_Q4X_ADD_SUBMIT_ADD . '"> <input type="reset" tabindex="4" value="' . _AM_Q4X_ADD_SUBMIT_RESET . '"></td>
       </tr></table></form>';

    CloseTable();
}

function q4x_admin_browse($in, $text)
{
    global $xoopsDB, $xoopsConfig;

    $defopt0 = 'selected';

    $defopt1 = '';

    if (1 == $in) {
        $defopt1 = 'selected';

        $defopt0 = '';
    }

    $myts = MyTextSanitizer::getInstance();

    OpenTable();

    echo '<form name="Browse Quote" action="./index.php" method="post"><div align="center">
   	<h4>' . _AM_Q4X_EDIT_HEADER . '</h4>
	   </div><table border="0" cellpadding="2" cellspacing="2" width="95%">
		<tr>
			<td>' . _AM_Q4X_EDIT_BROWSE . " 
    			<SELECT name='browse_in'>
					<OPTION value='0' $defopt0>" . _AM_Q4X_QUOTE . "</option>
					<OPTION value='1' $defopt1>" . _AM_Q4X_AUTHOR . '</option>
				</SELECT>			
			' . _AM_Q4X_EDIT_CONTAIN . " <input type=\"text\" name=\"browse_text\" value=\"$text\" size=\"30\" tabindex=\"2\"><br></td>
		</tr>
		<tr>
			<td align=\"center\">" . _AM_Q4X_EDIT_LEAVEBLANK . '
			<input type="hidden" value="browse" name="op"></td>
		</tr>
      <tr>
         <td align="center"><input type="submit" name="browse" tabindex="3" value="' . _AM_Q4X_EDIT_FIND . '"</td>
      </tr></table></form>';

    // Make query if $in contains a valide value

    if (0 == $in || 1 == $in) {
        echo '<table border=2 cellpadding=2 cellspacing=2 width="95%">
  			 <tr>
			    <th>' . _AM_Q4X_ID . '</th>
				 <th>' . _AM_Q4X_AUTHOR . '</th>
				 <th>' . _AM_Q4X_QUOTE . '</th>
				 <th>' . _AM_Q4X_SHOWED . '</th>
				 <th>' . _AM_Q4X_ACTION . '</th>
			</tr>';

        // make selection for query

        $where = '';

        if ('0' == $in) {
            $where = 'where quote ';
        } else {
            $where = 'where author ';
        }

        $where .= "LIKE '%$text%'";

        // get all selected rows from db

        $result = $xoopsDB->query('SELECT id, author, quote, showed FROM ' . $xoopsDB->prefix() . "_quote4xoops $where");

        while ($q4x_item = $xoopsDB->fetchArray($result)) {
            $showed = '&nbsp;';

            if (0 != $q4x_item['showed']) {
                $showed = formatTimestamp($q4x_item['showed'], 's');
            }

            echo '<tr><td>' . $q4x_item['id'] . '</td>
		   <td>' . htmlspecialchars($q4x_item['author'], ENT_QUOTES | ENT_HTML5) . '</td>
		   <td>' . htmlspecialchars($q4x_item['quote'], ENT_QUOTES | ENT_HTML5) . '</td>
		   <td>' . $showed . '</td>
		   <td><a href="./index.php?op=edit&id=' . $q4x_item['id'] . '">' . _AM_Q4X_EDIT . '</a><br>
		       <a href="./index.php?op=delconfirm&id=' . $q4x_item['id'] . '">' . _AM_Q4X_DELETE . '</a></td></tr>';
        }

        echo '</table>';
    }

    CloseTable();
}

function q4x_admin_edit($id)
{
    global $xoopsConfig, $xoopsDB;

    $myts = MyTextSanitizer::getInstance();

    $result = $xoopsDB->query('SELECT id, author, quote FROM ' . $xoopsDB->prefix() . "_quote4xoops WHERE id='" . $id . "'");

    $q4x_item = $xoopsDB->fetchArray($result);

    OpenTable();

    echo '<form name="Edit Content" action="./index.php" method="post">
		<div align="center"><h4>' . _AM_Q4X_EDIT_THISQUOTE . '</h4></div>
		<table border="0" cellpadding="2" cellspacing="2" width="95%">
      <tr>
	      <td align="right">' . _AM_Q4X_ID . ':</td>
         <td><input type="text" value="' . $id . '" name="form_id" size="5" readonly> </td>
      </tr>
      	<td align="right">' . _AM_Q4X_AUTHOR . ':</td>
         <td><input type="text" value="' . htmlspecialchars($q4x_item['author'], ENT_QUOTES | ENT_HTML5) . '" name="form_author" size="30" maxlength="50" tabindex="1"><br></td>
      </tr>
      <tr>
      	<td align="right">' . _AM_Q4X_QUOTE . ':</td>
         <td><input type="text" value="' . htmlspecialchars($q4x_item['quote'], ENT_QUOTES | ENT_HTML5) . '" name="form_quote" size="100" maxlength="255" value="" tabindex="2"></td>
		</tr>		
      <tr height="10">
      	<td align="right" height="10"></td>
         <td height="10"><input type="hidden" value="editdb" name="op"></td>
      </tr>
      <tr>
      	<td align="right"></td>
         <td><input type="submit" name="editdb" tabindex="3" value="' . _AM_Q4X_SUBMIT_UPD . "\">
			  <input type='button' value='" . _CANCEL . "' onclick='javascript:history.go(-1);'></form>
				
      </tr></table></form>";

    CloseTable();
}
