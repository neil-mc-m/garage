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

$app->get('/search/{q}', 'CMS\\Controllers\\SearchController::searchAction');
$app->get('/search-results/{contentId}', 'CMS\\Controllers\\SearchController::userAction');
//$app->get('/sales', 'CMS\\Controllers\\MainController::salesAction');




$app->get('/admin/logout', 'CMS\\Controllers\\SecurityController::logoutAction');

$app->get('/admin/dashboard', 'CMS\\Controllers\\AdminController::dashboardAction');

$app->get('/admin/pages', 'CMS\\Controllers\\PagesController::pagesAction');
$app->get('/admin/view-pages', 'CMS\\Controllers\\PagesController::viewPagesAction');

$app->get('/admin/create-page', 'CMS\\Controllers\\PagesController::createPageAction');
$app->post('/admin/new-page', 'CMS\\Controllers\\PagesController::newPageAction');

$app->get('/admin/delete-page', 'CMS\\Controllers\\PagesController::deletePageAction');
$app->post('/admin/process-delete-page', 'CMS\\Controllers\\PagesController::processDeletePageAction');

$app->get('/admin/view-cars', 'CMS\\Controllers\\ContentController::viewAllCarsAction');
$app->get('/admin/view-single-content/{contentId}', 'CMS\\Controllers\\ContentController::singleContentAction');

$app->match('/admin/create-content', 'CMS\\Controllers\\ContentController::createContentFormAction');
//$app->post('/admin/process-content', 'CMS\\Controllers\\ContentController::processContentAction');

$app->get('/admin/delete-content', 'CMS\\Controllers\\ContentController::deleteContentFormAction');
$app->get('/admin/process-delete-content/{id}', 'CMS\\Controllers\\ContentController::processDeleteCarAction');

$app->match('/admin/edit-car/{id}', 'CMS\\Controllers\\ContentController::editCarAction');
$app->post('/admin/process-edit-content', 'CMS\\Controllers\\ContentController::processEditContentAction');

$app->get('/admin/images', 'CMS\\Controllers\\ImageController::viewImagesAction');
$app->post('/admin/add-image/{carid}/{imageid}', 'CMS\\Controllers\\ImageController::addImageAction');
$app->get('/admin/delete-image/{id}', 'CMS\\Controllers\\ImageController::deleteImageAction');
$app->post('/admin/lead-image/{carid}/{imageid}', 'CMS\\Controllers\\ImageController::makeLeadImageAction');

$app->get('/admin/upload-image', 'CMS\\Controllers\\ImageController::uploadImageFormAction');

$app->post('/admin/process-imageUpload', 'CMS\\Controllers\\UploadController::processImageUploadAction');
$app->get('/{pageRoute}', 'CMS\\Controllers\\MainController::routeAction');
$app->get('/{pageRoute}/{id}', 'CMS\\Controllers\\MainController::singleCarAction');


$app->run();
