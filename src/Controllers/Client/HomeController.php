<?php
namespace Asus\Project\Controllers\Client;

use Asus\Project\Commons\Controller;
use Asus\Project\Commons\Helper;
use Asus\Project\Models\Product;
use Asus\Project\Models\User;



class HomeController extends Controller
{
    private Product $product;
    public function __construct()
    {
        $this->product =new Product();
    }
   public function index(){
    $name ='hiennvph46587';
    $products =$this->product->all();
    
        $this->renderViewClient('home',[
        'name'=> $name,
        'products' => $products
    ]);
   }
  
}