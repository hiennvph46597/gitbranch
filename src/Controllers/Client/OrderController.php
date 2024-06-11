<?php

namespace Asus\Project\Controllers\Client;

use Asus\Project\Commons\Controller;
use Asus\Project\Models\Cart;
use Asus\Project\Models\CartDetail;
use Asus\Project\Models\Order;
use Asus\Project\Models\OrderDetail;
use Asus\Project\Models\User;

class OrderController extends Controller
{
    public User $user;
    public Order $order;
    public OrderDetail $orderDetail;
    private Cart $cart;
    private CartDetail $cartDetail;
    
    
    public function __construct()
    {
        $this->user            =new User();
        $this->order            =new Order();
        $this->orderDetail      =new OrderDetail();
        $this->cart=             new Cart();
        $this->cartDetail=       new CartDetail();
        
    }
    public function checkout(){
        // Chua dang nhap thi phai tao tai khoan
        $userID = $_SESSION['user']['id'] ?? null;

        if (! $userID) {
            $conn= $this->user->getConnection();
            $this->user->insert([
                'name' => $_POST['user_name'],
                'email' => $_POST['user_email'],
                'password' => password_hash($_POST['user_email'], PASSWORD_DEFAULT),

                //type

                'is_active' => 0,
                
            ]);

            $userID= $conn->lastInsertId();
        }

        //Them du lieu vao orderDetail
        $conn= $this->user->getConnection();

        $this->order->insert([
            'user_id' => $userID,
            'user_name' => $_POST['user_email'],
            'user_email' => $_POST['user_email'],
            'user_phone' => $_POST['user_phone'],
            'user_address' => $_POST['user_address'],
            
        ]);
        $orderID =$conn->lastInsertId();

        $key = 'cart';
        if (isset($_SESSION['user'])) {
            $key .= ' - ' . $_SESSION['user']['id'];
        }

        foreach ($_SESSION[$key] as $productID => $item) {
                    
            if(empty($cartItem)) {

                $this->orderDetail->insert([
                    'order_id' => $orderID,
                    'product_id' => $productID,
                    'quantity' => $item['quantity'],
                    'price_regular' => $item['price_regular'],
                    'price_sale' => $item['price_sale']
                ]);
            }
            unset($_SESSION[$key]);
            if(isset($_SESSION['user'])){
                unset($_SESSION['cart_id']);
            }

            // Xoa du lieu Trong cart+ cartdDetail

       
         header('Location: ' . url());
         exit;
    }
}
}