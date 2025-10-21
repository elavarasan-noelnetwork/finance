<?php

use app\controllers\CommonController;

$_OcommonCtrl = new CommonController();
//$_AbackEndMenu = $_OcommonCtrl->getRoleBasedBackendMenu($_SESSION['auth']['user_role']);

$_AbackEndMenu[1]['men_name'] = 'Applications';
$_AbackEndMenu[1]['men_page'] = 'proposals';
$_AbackEndMenu[1]['men_icon'] = 'home-outline';


// Resolve current page to highlight active link
$currentPage=$_OcommonCtrl->getCurrentPageName();



if (!empty($currentPage)) {
  $routeAliases = [
    
    'admin' => 'dashboard',

    'adduser' => 'users',
    'viewuser' => 'users',
    'edituser' => 'users',
    'storeuser' => 'users',

    'adddepartment' => 'departments',
    'editdepartment' => 'departments',
    'viewdepartment' => 'departments',
    'storedepartment' => 'departments',

    'addrole' => 'roles',
    'editrole' => 'roles',
    'viewrole' => 'roles',  
    'storerole' => 'roles',   
    'viewrolemenu' => 'roles',   
    'storerolemenu' => 'roles',   
    'viewpageacess' => 'roles',

    'addmenu' => 'menus',
    'editmenu' => 'menus',
    'viewmenu' => 'menus',  
    'storemenu' => 'menus',

    'addpage' => 'pages',
    'editpage' => 'pages',
    'viewpage' => 'pages',  
    'storepage' => 'pages',   
    

    'editcompany' => 'companies',
    'viewcompany' => 'companies',  
    'storecompany' => 'companies',    

  ];
  $resolvedPage = $routeAliases[$currentPage] ?? $currentPage;
}

//echo "<pre>";
//print_r($_AbackEndMenu);
//exit;

?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <?php
    if (!empty($_AbackEndMenu)) {
      foreach ($_AbackEndMenu as $menu_id => $menu) {

        $menuActive = "";
        $collapseShow = "";
        $ariaExpanded = "false";

        $hasActiveSubmenu = false;


        if (!empty($menu['sub_menu']) && is_array($menu['sub_menu'])) {
          foreach ($menu['sub_menu'] as $sub_menu) {
            if ($resolvedPage === $sub_menu['men_page']) {
              $hasActiveSubmenu = true;
              break; // 💡 This ensures only the matching menu gets activated
            }
          }

          if ($hasActiveSubmenu) {
            $menuActive = " active";
            $collapseShow = " show";
            $ariaExpanded = "true";
          } else {
            $menuActive = "";
            $collapseShow = "";
            $ariaExpanded = "false";
          }
        } else {
          if ($resolvedPage === $menu['men_page']) {
            $menuActive = " active";
          }
        }

        // Main Menu Item
        if (!empty($menu['sub_menu'])) {
    ?>
          <li class="nav-item<?= $menuActive ?>">
            <a class="nav-link" data-bs-toggle="collapse" href="#menu_<?= $menu_id ?>" aria-expanded="<?= $ariaExpanded ?>" aria-controls="menu_<?= $menu_id ?>">
              <i class="typcn typcn-<?= $menu['men_icon'] ?> menu-icon"></i>
              <span class="menu-title"><?= $menu['men_name'] ?></span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse<?= $collapseShow?>" id="menu_<?= $menu_id ?>">
              <ul class="nav flex-column sub-menu">
                <?php foreach ($menu['sub_menu'] as $sub_menu) {
                  $subActive = ($resolvedPage === $sub_menu['men_page']) ? " active" : "";
                ?>
                  <li class="nav-item">
                    <a class="nav-link<?= $subActive ?>" href="<?= BASE_URL ?><?= $sub_menu['men_page'] ?>">
                      <?= $sub_menu['men_name'] ?>
                    </a>
                  </li>
                <?php } ?>
              </ul>
            </div>
          </li>
        <?php
        } else {
        ?>
          <li class="nav-item<?= $menuActive ?>">
            <a class="nav-link" href="<?= BASE_URL ?><?= $menu['men_page'] ?>">
              <i class="typcn typcn-<?= $menu['men_icon'] ?> menu-icon"></i>
              <span class="menu-title"><?= $menu['men_name'] ?></span>
            </a>
          </li>
    <?php
        }
      }
    }
    ?>
  </ul>
</nav>