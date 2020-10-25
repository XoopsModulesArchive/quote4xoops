<?php

// -------------------------------------------------------------------------
//           Quote for Xoops v1.20
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

require 'header.php';
include 'q4x_inc.php';

$q4xID = q4x_getToDayID();
$quote = [];
$quote = q4x_getQuoteByID($q4xID);

// We must always set our main template before including the header
$GLOBALS['xoopsOption']['template_main'] = 'q4x_index.html';

// Include the page header
require XOOPS_ROOT_PATH . '/header.php';

$xoopsTpl->assign('title', _MD_Q4X_TITLE);
$xoopsTpl->assign('quote', $quote['quote']);
$xoopsTpl->assign('author', $quote['author']);

// Include the page footer
include(XOOPS_ROOT_PATH . '/footer.php');

// echo "<p><i>$quote</i></p><p align=\"right\">$author</p>";
