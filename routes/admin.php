<?php

// CRUD bao gom : danh sach,them,sua,xem,xoa
// User :
//       GET   -> USER/INDEX  ->INDEX   -> Danh sach
//       GET   -> USER/CREATE ->CREATE           -> HIỂN THỊ DANH SÁCH THÊM MỚI
//       POST  -> USER/STORE  ->STORE           -> LƯU DỮ LIỆU TỪ FORM THÊM MỚI VÀO DB
//       GET   -> USER/ID     ->SHOW    ($id)      -> XEM CHI TIẾT 
//       GET   -> USER/ID/EDIT ->EDIT    ($id)     -> HIỂN THỊ FORM CẬP NHẬT
//       PUT   -> USER/ID      ->UPDATE   ($id)      -> LƯU DỮ LIỆU TỪ FORM CẬP NHẬP VÀO DB   
//       DELETE -> USER/ID     ->DELETE  ($id)       -> XÓA BẢN GHI TRONG DB   

use Asus\Project\Controllers\Admin\DashboardController;
use Asus\Project\Controllers\Admin\ProductController;
use Asus\Project\Controllers\Admin\UserController;

$router->before('GET|POST', '/admin/*.*', function () {
      if (! isset($_SESSION['user'])) {
            header('location: ' . url('login'));
            exit();
      }
});



$router->mount('/admin', function () use ($router) {
      $router->get('/',     DashboardController::class . '@dashboard');

      // CRUD USER
      $router->mount('/users', function () use ($router) {
            $router->get('/',             UserController::class . '@index');
            $router->get('/create',       UserController::class . '@create');
            $router->post('/store',       UserController::class . '@store');
            $router->get('/{id}/show',    UserController::class . '@show');
            $router->get('/{id}/edit',    UserController::class . '@edit');
            $router->post('/{id}/update', UserController::class . '@update');
            $router->get('/{id}/delete',  UserController::class . '@delete');
      });


      // CRUD PRODUCTS
      $router->mount('/products', function () use ($router) {
            $router->get('/',                    ProductController::class . '@index');
            $router->get('/create',              ProductController::class . '@create');
            $router->post('/store',              ProductController::class . '@store');
            $router->get('/{id}/show',           ProductController::class . '@show');
            $router->get('/{id}/edit',           ProductController::class . '@edit');
            $router->post('/{id}/update',        ProductController::class . '@update');
            $router->get('/{id}/delete',         ProductController::class . '@delete');
      });
});
