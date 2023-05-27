<?php

function lang($phrase)
{
  static $lang = array(
    // Navbar Links 
    'HOME_ADMIN' => 'الرئيسية',
    'CATAGORIES' => 'الأقسام',
    'ITEMS'      => 'المنتجات',
    'MEMBERS'    => 'الأعضاء',
    'STATISTICS' => 'الإحصائيات',
    'COMMENTS' => 'التفاعلات',
    'LOGS'       => 'السجلات',
    ''           => '',
    ''           => '',
  );
  return $lang[$phrase];
}
