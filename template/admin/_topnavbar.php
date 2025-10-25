<?php
/* ======================================
  Filename: Top Nav bar
  Author: Ameen 
  Description: Top Nav bar
  =======================================
*/
?>

<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="navbar-brand-wrapper d-flex justify-content-center custom-navbar">
    <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
      <a class="navbar-brand brand-logo" href="<?php echo BASE_URL; ?><?php echo $_SESSION['auth']['user_redirect'] ?>">
        <img src="<?php echo ASSETS_DIR; ?>/images/zeon.png" alt="logo" />
        <?php
        if(!empty($_SESSION['auth']['user_department']) && $_SESSION['auth']['user_department'] != "Client"){
        ?>
          <span class="brand-text ms-0 me-3"
            style="font-size:16px; font-weight:600; color:#333; position: relative; top: 8px;">
            <?php echo $_SESSION['auth']['user_department']?>
          </span>
        <?
        }
        ?>
      </a>
    </div>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end" style="flex-direction: row-reverse!important;">
    <ul class="navbar-nav me-lg-2">
      <!--<li class="nav-item nav-user-status dropdown"><br>
              <p class="mb-0">Last login was 23 hours ago.</p>
          </li> -->
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link" href="<?php echo $_SESSION['auth']['user_redirect'] ?>" data-bs-toggle="dropdown" id="profileDropdown">
          <img src="<?php echo ASSETS_DIR; ?>/images/user.png" alt="profile" class="profile-pic" />
          <span class="nav-profile-name">

            <?php echo isset($_SESSION['auth']['usr_fname']) ? trim($_SESSION['auth']['usr_fname']) : '' ?>
            <?php echo isset($_SESSION['auth']['usr_lname']) ?  trim($_SESSION['auth']['usr_lname']) : '' ?>
          </span>
        </a>
        <div class="dropdown-menu navbar-dropdown shadow rounded-3 border-0 mt-2 p-2 profile-dropdown" aria-labelledby="profileDropdown">
          <!--
          <a class="dropdown-item d-flex align-items-center gap-2 rounded-2 py-2 px-3"
            href="<?php echo BASE_URL; ?>viewpassword/<?php echo $_SESSION['auth']['user_id'] ?? '' ?>">
            <i class="typcn typcn-lock-closed-outline text-custom fs-5"></i>
            <span>Change Password</span>
          </a>
          -->
          <div class="dropdown-divider my-2"></div>
          <a class="dropdown-item d-flex align-items-center gap-2 rounded-2 py-2 px-3 text-danger fw-semibold"
            href="<?php echo BASE_URL ?>logout">
            <i class="typcn typcn-eject fs-5"></i>
            <span>Logout</span>
          </a>
        </div>
      </li>

    </ul>
    <ul class="navbar-nav navbar-nav-right">
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="typcn typcn-th-menu"></span>
    </button>
  </div>
</nav>