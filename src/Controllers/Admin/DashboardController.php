<?php

namespace Asus\Project\Controllers\Admin;

use Asus\Project\Commons\Controller;

class DashboardController extends Controller
{
 public function dashboard(){
    
    $this->renderViewAdmin(__FUNCTION__);
 }
}