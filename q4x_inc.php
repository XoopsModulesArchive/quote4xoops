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

function q4x_getToDayID()
{
    // Return the ID of the quote of the day

    global $xoopsDB;

    $todayID = 0; // Init

    // Get the actual time stamp

    $tsnow = strtotime('now');

    // Compute the time stamp of today for 0 hours 0 minutes 0 seconds

    $today = getdate($tsnow);

    $m = $today['mon'];

    $d = $today['mday'];

    $y = $today['year'];

    $tsday = mktime(0, 0, 0, $m, $d, $y);

    //query Database (returns an array)

    $result = $xoopsDB->queryF('SELECT id FROM ' . $xoopsDB->prefix() . '_quote4xoops WHERE showed=' . $tsday . '', 1);

    $q4x_item = $xoopsDB->fetchArray($result);

    //$id found?

    if (isset($q4x_item['id']) && '0' != $q4x_item['id']) {
        $todayID = $q4x_item['id'];
    } else {
        // All quotes are already been showed ?

        $max = 0;

        $result = $xoopsDB->queryF('SELECT count(id) as tot FROM ' . $xoopsDB->prefix() . '_quote4xoops WHERE showed=0', 1);

        $q4x_item = $xoopsDB->fetchArray($result);

        if (isset($q4x_item['tot']) && '0' != $q4x_item['tot']) {
            $max = $q4x_item['tot'];
        } else {
            // if all quotes have been showed, reinit

            $q = 'UPDATE ' . $xoopsDB->prefix() . '_quote4xoops SET showed=0';

            $res = $xoopsDB->queryF($q);

            $result = $xoopsDB->queryF('SELECT count(id) as tot FROM ' . $xoopsDB->prefix() . '_quote4xoops WHERE showed=0', 1);

            $q4x_item = $xoopsDB->fetchArray($result);

            if (isset($q4x_item['tot']) && '0' != $q4x_item['tot']) {
                $max = $q4x_item['tot'];
            }
        }

        // Take à random unshowedquote

        // get à random number into all unshowed quote

        mt_srand((float) microtime() * 1000000);

        $randval = random_int(0, $max);

        // Get the corresponding ID

        $result = $xoopsDB->queryF('SELECT id FROM ' . $xoopsDB->prefix() . '_quote4xoops WHERE showed=0', 1, $randval);

        $q4x_item = $xoopsDB->fetchArray($result);

        if (isset($q4x_item['id']) && '0' != $q4x_item['id']) {
            $todayID = $q4x_item['id'];

            // update the selected quote

            // set showed at todays timestamp;

            $q = 'UPDATE ' . $xoopsDB->prefix() . '_quote4xoops SET showed=' . $tsday . ' WHERE id=' . $todayID . '';

            $res = $xoopsDB->queryF($q);
        }
    }

    return $todayID;
}

function q4x_getRandomID()
{
    // Return a random ID of a quote

    global $xoopsDB;

    $randomID = 0;

    $max = 0;

    $result = $xoopsDB->queryF('SELECT count(id) as tot FROM ' . $xoopsDB->prefix() . '_quote4xoops WHERE showed=0', 1);

    $q4x_item = $xoopsDB->fetchArray($result);

    if (isset($q4x_item['tot']) && '0' != $q4x_item['tot']) {
        $max = $q4x_item['tot'];
    }

    // Take random

    // get à random number into quote

    mt_srand((float) microtime() * 1000000);

    $randval = random_int(0, $max);

    // Get the corresponding ID

    $result = $xoopsDB->queryF('SELECT id FROM ' . $xoopsDB->prefix() . '_quote4xoops WHERE showed=0', 1, $randval);

    $q4x_item = $xoopsDB->fetchArray($result);

    if (isset($q4x_item['id']) && '0' != $q4x_item['id']) {
        $randomID = $q4x_item['id'];
    }

    return $randomID;
}

function q4x_getQuoteByID($id)
{
    // Return the quote of the day corresponding of $id

    // When return $author conains the author of the quote

    // and $quote contains the quote

    // return an array

    global $xoopsDB;

    // init var

    $quotearr = [];

    $quotearr['quote'] = _MD_Q4X_QUOTENOTFOUND;

    $quotearr['author'] = '';

    $result = $xoopsDB->queryF('SELECT author,quote FROM ' . $xoopsDB->prefix() . '_quote4xoops WHERE id=' . $id . '', 1);

    $q4x_quote = $xoopsDB->fetchArray($result);

    if (isset($q4x_quote['author']) && '' != $q4x_quote['author']) {
        $myts = MyTextSanitizer::getInstance();

        $quotearr['author'] = htmlspecialchars($q4x_quote['author'], ENT_QUOTES | ENT_HTML5);

        $quotearr['quote'] = htmlspecialchars($q4x_quote['quote'], ENT_QUOTES | ENT_HTML5);
    }

    return $quotearr;
}
