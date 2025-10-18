<?php
use app\controllers\CommonController;

define('SUPER_ADMIN','admin_manager');
define('ADMIN_MEMBER','admin_member');

// Non authorization pages
$nonAuthorizPagesArray=[
'dashboard',
'logout',
'viewpassword',
'updatepassword',
'application',
'optin',
'storeoptin',
'proposals',
'ajaxaddfinancedetails'
];

$pageSpecificAuthorization=[
];

$optinYesNoArray['Yes'] = 1;
$optinYesNoArray['No'] = 2;

$propertyNameArray[1]= "33 Carl Street";
$propertyNameArray[2]= "39 Raffles";
$propertyNameArray[3]= "61 Regent";
$propertyNameArray[4]= "55 Regent";

$buyingTypeArray['Individual'] = 1;
$buyingTypeArray['Trust'] = 2;
$buyingTypeArray['SMSF'] = 3;

define('NON_AUTH_PAGES_ARRAY', $nonAuthorizPagesArray);
define('PAGE_SPECIFIC_AUTH_PAGES_ARRAY', $pageSpecificAuthorization);


define('OPTION_YES_NO_ARRAY', $optinYesNoArray);
define('PROPERTY_NAME_ARRAY', $propertyNameArray);
define('BUYING_TYPE_ARRAY', $buyingTypeArray);
?>