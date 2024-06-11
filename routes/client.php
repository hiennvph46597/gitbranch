<?php 

// Website co cac trang la:
// Trang chu
// gioi thieu
// San pham
// chi tiet san pham
// lien he

// de dinh nghia duoc , dieu dau tien lam la phai tao Controller truoc
// tiep theo , khai function tuong ung de xu ly 
// Buoc cuoi , dinh nghia duong dan

// HTTP Method :get ,post,put {path}, path, delete, option, head

namespace Asus\Project\Controllers\Client\AboutController;

use Asus\Project\Controllers\Client\AboutController;
use Asus\Project\Controllers\Client\CartController;
use Asus\Project\Controllers\Client\ContactController;
use Asus\Project\Controllers\Client\HomeController;
use Asus\Project\Controllers\Client\LoginController;
use Asus\Project\Controllers\Client\OrderController;
use Asus\Project\Controllers\Client\ProductController;




$router->get('/',                        HomeController::class    . '@index');
$router->get('/about',                   AboutController::class   . '@index');

$router->get('/contact',                 ContactController::class . '@index');
$router->post('/contact/store',          ContactController::class . '@store');

$router->get('/products',                ProductController::class . '@index');
$router->get('/products/{id}',           ProductController::class . '@detail');



$router->get('/login',                   LoginController::class . '@showFormLogin');
$router->post('/handle-login',           LoginController::class . '@login');
$router->get('/logout',                  LoginController::class . '@logout');

$router->get('cart/add',                CartController:: class. '@add');
$router->get('cart/quantityInc',        CartController:: class. '@quantityInc');
$router->get('cart/quantityDec',        CartController:: class. '@quantityDec');
$router->get('cart/remove',             CartController:: class. '@remove');
$router->get('cart/detail',             CartController:: class. '@detail');

$router->post('order/checkout',          OrderController:: class. '@checkout');