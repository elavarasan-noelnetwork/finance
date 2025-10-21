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
'ajaxproposals',
'ajaxaddfinancedetails',
'trust',
'storetrust',
'smsf',
'storesmsf',
];

$pageSpecificAuthorization=[
];


$departmentArray[1] = 'Client';
$departmentArray[2] = 'Admin';
$departmentArray[3] = 'Accounts';
$departmentArray[4] = 'Legal';
$departmentArray[5] = 'Finance';

$optinYesNoArray['Yes'] = 1;
$optinYesNoArray['No'] = 2;

$propertyNameArray[1]= "33 Carl Street";
$propertyNameArray[2]= "39 Raffles";
$propertyNameArray[3]= "61 Regent";
$propertyNameArray[4]= "55 Regent";

$buyingTypeArray['Individual'] = 1;
$buyingTypeArray['Trust'] = 2;
$buyingTypeArray['SMSF'] = 3;

$buyingTypeNameArray[1] = 'Individual';
$buyingTypeNameArray[2] = 'Trust';
$buyingTypeNameArray[3] = 'SMSF';

$loanStatusArray[10] = "Application in Progress";
$loanStatusArray[20] = "Trust Setup";
$loanStatusArray[30] = "SMSF Setup";
$loanStatusArray[40] = "Finance Review";
$loanStatusArray[50] = "Finance Rejected";
$loanStatusArray[60] = "Legal Review";
$loanStatusArray[70] = "Closed";

$loanProgressPercentageArray[10] = 10;
$loanProgressPercentageArray[20] = 20;  
$loanProgressPercentageArray[30] = 20;  
$loanProgressPercentageArray[40] = 40;  
$loanProgressPercentageArray[50] = 60;  
$loanProgressPercentageArray[60] = 80;  
$loanProgressPercentageArray[70] = 100; 

define('NON_AUTH_PAGES_ARRAY', $nonAuthorizPagesArray);
define('PAGE_SPECIFIC_AUTH_PAGES_ARRAY', $pageSpecificAuthorization);


define('OPTION_YES_NO_ARRAY', $optinYesNoArray);
define('PROPERTY_NAME_ARRAY', $propertyNameArray);
define('BUYING_TYPE_ARRAY', $buyingTypeArray);
define('BUYING_TYPE_NAME_ARRAY', $buyingTypeNameArray);
define('LOAN_STATUS_ARRAY', $loanStatusArray);
define('DEPARTMENT_ARRAY', $departmentArray);
define('LOAN_PROGRESS_PERCNTAGE_ARRAY', $loanProgressPercentageArray);
?>