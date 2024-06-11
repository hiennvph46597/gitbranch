<?php

namespace Asus\Project\Controllers\Client;

use Asus\Project\Commons\Controller;
use Asus\Project\Commons\Helper;
use Asus\Project\Models\Cart;
use Asus\Project\Models\CartDetail;
use Asus\Project\Models\Product;

class CartController extends Controller
{
    private Product $product;
    private Cart $cart;
    private CartDetail $cartDetail;
    public function __construct()
    {
        $this->cart         = new Cart();
        $this->cartDetail   = new CartDetail();
        $this->product      = new Product();
    }
    public function add()
    {    // Thêm

        $product = $this->product->findByID($_GET['productID']);
        $key = 'cart';
        if (isset($_SESSION['user'])) {
            $key = '-' . $_SESSION['user']['id'];
        }

        if (!isset($_SESSION[$key][$product['id']])) {
            $_SESSION[$key][$product['id']] = $product + ['quantity' => $_GET['quantity'] ?? 1];
        } else {
            $_SESSION[$key][$product['id']]['quantity'] += $_GET['quantity'];
        }
        if (isset($_SESSION['user'])) {
            $conn = $this->cart->getConnection();
           // $conn->beginTransaction();

            try {
                $cart = $this->cart->findByUserID($_SESSION['user']['id']);
                if (empty($cart)) {

                    $this->cart->insert([
                        'user_id'  => $_SESSION['user']['id']
                    ]);
                }

                
                $cartID = $cart['id'] ?? $conn->lastInsertId();

                $_SESSION['cart_id']= $cartID;

                $this->cartDetail->deleteByCartID($cartID);
                foreach ($_SESSION[$key] as $productID => $item) {
                    
                    if(empty($cartItem)) {

                        $this->cartDetail->insert([
                            'cart_id' => $cartID,
                            'product_id' => $productID,
                            'quantity' => $item['quantity']
                        ]);
                    }
                    

                 //  $conn->commit();
                }
            } catch (\Throwable $th) {
               // $conn->rollBack();
            }
        }
         header('Location: ' . url('cart/detail'));
         exit;

    }
    public function detail()
    {         // chi tiet gio hang
        $this->renderViewClient('cart');


    }
    public function quantityInc()
    {    // Tăng số lượng 

        $key = 'cart';
        if (isset($_SESSION['user'])) {
            $key .= ' - ' . $_SESSION['user']['id'];
        }

        $_SESSION[$key][$_GET['productID']]['quantity'] +=1;

        if(isset($_SESSION['user'])) {

            $this->cartDetail->updateByCartIDAndProductID(
                $_GET['cartID'],
                $_GET['productID'],
                $_SESSION[$key][$_GET['productID']]['quantity'] 
            );
        }
        header('Location: ' . url('cart/detail'));
        exit;

    }
    public function quantityDec()
    {    // giảm số lượng

        $key = 'cart';
        if (isset($_SESSION['user'])) {
            $key .= ' - ' . $_SESSION['user']['id'];
        }

       

        if($_SESSION[$key][$_GET['productID']]['quantity'] > 1){
            $_SESSION[$key][$_GET['productID']]['quantity'] -=1;
        }
        if(isset($_SESSION['user'])) {

            $this->cartDetail->updateByCartIDAndProductID(
                $_GET['cartID'],
                $_GET['productID'],
                $_SESSION[$key][$_GET['productID']]['quantity'] 
            );
        }
        header('Location: ' . url('cart/detail'));
        exit;
       
    }
    public function remove()
    {  
       // Xóa item ỏ xóa trắng

        $key = 'cart';
        if (isset($_SESSION['user'])) {
            $key .= ' - ' . $_SESSION['user']['id'];
        }

        unset($_SESSION[$key][ $_GET['productID']]);
        if(isset($_SESSION['user'])) {

            $this->cartDetail->deleteByCartIDAndProductID($_GET['cart'], $_GET['productID']);
        }

        header('Location: ' . url('cart/detail'));
        exit;

    }
}
