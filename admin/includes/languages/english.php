<?php

function lang($phrase)
{
  static $lang = array(

    // Navbar Links 
    'HOME_ADMIN' => 'Home',
    'CATAGORIES' => 'Catagories',
    'ITEMS'      => 'Items',
    'MEMBERS'    => 'Members',
    'STATISTICS' => 'Statistics',
    'COMMENTS' => 'Comments',
    'LOGS'       => 'Logs',
    ''           => '',
    ''           => '',


    //

  );
  return $lang[$phrase];
}
