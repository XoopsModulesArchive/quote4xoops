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
// **************************************************************************//
// * Function: b_q4x_show
// * Output  : Return a block array containing the quote of the day
// **************************************************************************//
require_once XOOPS_ROOT_PATH . '/modules/quote4xoops/language/' . $xoopsConfig['language'] . '/main.php';
require_once XOOPS_ROOT_PATH . '/modules/quote4xoops/q4x_inc.php';

function b_q4x_show($option)
{
    $block = [];

    $q4xID = q4x_getToDayID();

    $block = q4x_getQuoteByID($q4xID);

    return $block;
}

function b_q4x_random($option)
{
    $block = [];

    $q4xID = q4x_getRandomID();

    $block = q4x_getQuoteByID($q4xID);

    return $block;
}
