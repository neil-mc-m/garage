<?php
require_once 'bootstrap.php';
# ________________________________________________________________
#                      ROUTES
# ________________________________________________________________
#
$app->get('/', 'CMS\\Controllers\\MainController::indexAction');
$app->get('/home', 'CMS\\Controllers\\MainController::indexAction');

$app->get('/login', 'CMS\\Controllers\\SecurityController::logInAction');
$app->get('/admin', 'CMS\\Controllers\\SecurityController::logInAction');

$app->match('/contact', 'CMS\\Controllers\\MainController::contactFormAction');

$app->get('/search/{q}', 'CMS\\Controllers\\SearchController::searchAction');
$app->get('/search-results/{contentId}', 'CMS\\Controllers\\SearchController::userAction');

$app->get('/admin/logout', 'CMS\\Controllers\\SecurityController::logoutAction');

$app->get('/admin/dashboard', 'CMS\\Controllers\\AdminController::dashboardAction');
$app->get('/admin/analytics', 'CMS\\Controllers\\AdminController::analyticsAction');

$app->get('/admin/pages', 'CMS\\Controllers\\PagesController::pagesAction');
$app->get('/admin/view-pages', 'CMS\\Controllers\\PagesController::viewPagesAction');
$app->get('/admin/create-page', 'CMS\\Controllers\\PagesController::createPageAction');
$app->post('/admin/new-page', 'CMS\\Controllers\\PagesController::newPageAction');
$app->get('/admin/delete-page', 'CMS\\Controllers\\PagesController::deletePageAction');
$app->post('/admin/process-delete-page', 'CMS\\Controllers\\PagesController::processDeletePageAction');

$app->get('/admin/view-cars', 'CMS\\Controllers\\CarController::viewAllCarsAction');
$app->get('/admin/view-single-content/{contentId}', 'CMS\\Controllers\\CarController::singleCarAction');
$app->match('/admin/create-content', 'CMS\\Controllers\\CarController::createCarFormAction');
$app->get('/admin/delete-content', 'CMS\\Controllers\\CarController::deleteCarFormAction');
$app->get('/admin/process-delete-content/{id}', 'CMS\\Controllers\\CarController::processDeleteCarAction');
$app->match('/admin/edit-car/{id}', 'CMS\\Controllers\\CarController::editCarAction');
//$app->post('/admin/process-edit-content', 'CMS\\Controllers\\CarController::processEditCarAction');

$app->get('/admin/images', 'CMS\\Controllers\\ImageController::viewImagesAction');
$app->post('/admin/add-image/{carid}/{imageid}', 'CMS\\Controllers\\ImageController::addImageAction');
$app->get('/admin/delete-image/{id}', 'CMS\\Controllers\\ImageController::deleteImageAction');
$app->post('/admin/lead-image/{carid}/{imageid}', 'CMS\\Controllers\\ImageController::makeLeadImageAction');
$app->get('/admin/upload-image', 'CMS\\Controllers\\ImageController::uploadImageFormAction');

$app->post('/admin/process-imageUpload', 'CMS\\Controllers\\UploadController::processImageUploadAction');

$app->get('/{pageRoute}', 'CMS\\Controllers\\MainController::routeAction');
$app->get('/{pageRoute}/details/{make}/{model}/{id}', 'CMS\\Controllers\\MainController::singleCarAction');



$app->run();
