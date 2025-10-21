<?php

use core\Route;
use app\controllers\ApplicationController;
use app\controllers\AdminController;
use app\controllers\admin\UserController;
use app\controllers\CommonController;
use app\controllers\LoanApplicationController;
use app\controllers\admin\ProposalController;
use app\controllers\LoanProgressController;
use app\controllers\TrustController;
use app\controllers\SmsfController;

//print_r(UserController::class);die;

// Public routes
Route::get("/", [AdminController::class, "home"]);
Route::post("/loginvalidate", [AdminController::class, "loginvalidate"]);
Route::get("/login", [AdminController::class, "login"]);
Route::get("/authorization", [AdminController::class, "authorizationerror"]);
Route::get("/pagenotfound", [AdminController::class, "pageNotFounderror"]);


// Protected admin home
//CommonController::authRoute("get", "/application", [LoanApplicationController::class, "home"]);
CommonController::authRoute("get", "/application", [LoanProgressController::class, "home"]);
CommonController::authRoute("get", "/optin", [LoanApplicationController::class, "optin"]);
CommonController::authRoute("post", "/storeoptin", [LoanApplicationController::class, "storeoptin"]);

//trust
CommonController::authRoute("get", "/trust/{*}", [TrustController::class, "home"]);
CommonController::authRoute("post", "/storetrust", [TrustController::class, "storetrust"]);

//smsf
CommonController::authRoute("get", "/smsf/{*}", [SmsfController::class, "home"]);
CommonController::authRoute("post", "/storesmsf", [SmsfController::class, "storesmsf"]);

CommonController::authRoute("post", "/ajaxaddfinancedetails", [LoanProgressController::class, "ajaxaddfinancedetails"]);

CommonController::authRoute("get", "/logout", [AdminController::class, "logout"]);

CommonController::authRoute("get", "/viewpassword/{*}", [UserController::class, "viewchangePassword"]);
CommonController::authRoute("post", "/updatepassword", [UserController::class, "updatePassword"]);


CommonController::authRoute("get", "/proposals", [ProposalController::class, "home"]);
CommonController::authRoute("post", "/ajaxproposals", [ProposalController::class, "ajaxproposals"]);


/* 404 Page - Not found route */

//echo "Page not found!";
Route::notFound($_SERVER['REQUEST_URI']);