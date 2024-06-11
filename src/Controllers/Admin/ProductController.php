<?php

namespace Asus\Project\Controllers\Admin;

use Asus\Project\Commons\Controller;

use Asus\Project\Commons\Helper;
use Asus\Project\Models\Category;
use Asus\Project\Models\Product;
use Asus\Project\Models\User;

use Rakit\Validation\Validator;;

class ProductController extends Controller
{
    private Product $product;
    private Category $category;
    public function __construct()
    {
        $this->product = new Product();
        $this->category= new Category();
    }

    public function index()
    {

        [$products, $totalpage] =$this->product->paginate();

        

    //    $products=$this->product->all();
       $this->renderViewAdmin('products.index',[
        'products' =>$products
       ]);
    }
    public function create()
    {
        $categories =$this->category->all();
        
        $categoryPluck = array_column($categories,'name','id');
        $this->renderViewAdmin('products.create',[
            'categoryPluck' => $categoryPluck
        ]);
    }
    public function store()
    {
        

        $validator = new Validator;
        $validation = $validator->make($_POST + $_FILES, [
            'name'               =>  'required|max:100',
            'overview'           => 'max:500',
            'content'            => 'max:65000',
            'img_thumbnail'      => 'uploaded_file:0,2048K,png,jpeg,jpg',
            

        ]);

        $validation->validate();

        if ($validation->fails()) {
            
            
            $_SESSION['errors'] = $validation->errors()->firstOfAll();

            header('Location: ' . url('admin/products/create'));
            exit();
        } else {
            $data = [
                'category_id'       =>    $_POST['category_id'],
                'name'              =>    $_POST['name'],
                'overview'          =>    $_POST['overview'],
                'content'          =>    $_POST['content']
            ];


            if (isset($_FILES['img_thumbnail']) && $_FILES['img_thumbnail']['size'] > 0) {
                $from = $_FILES['img_thumbnail']['tmp_name'];
                $to = 'assets/uploads/' . time() . $_FILES['img_thumbnail']['name'];

                if (move_uploaded_file($from, PATH_ROOT . $to)) {
                    $data['img_thumbnail'] = $to;
                } else {
                    $_SESSION['errors']['img_thumbnail'] = 'Upload Khong thanh cong';

                    header('Location: ' . url('admin/products/create'));
                    exit();
                }
            }
            //   Helper::debug($data);
            $this->product->insert($data);

            $_SESSION['status'] = true;
            $_SESSION['msg'] = 'Thao tac thanh cong';

            header('Location: ' . url('admin/products'));
            exit();
        }
    }
    public function show($id)
    {
        $product = $this->product->findByID($id);

        $this->renderViewAdmin('products.show', [
            'product' => $product
        ]);
    }
    public function edit($id)
    {

        $product = $this->product->findByID($id);
        $categories= $this->category->all();
        $categoryPluck = array_column($categories,'name','id');

        $this->renderViewAdmin('products.edit', [
            'product' => $product,
            'categoryPluck' => $categoryPluck
        ]);
    }
    public function update($id)
    {
        $product = $this->product->findByID($id);
        $validator = new Validator;
        $validation = $validator->make($_POST + $_FILES, [
            
            'name'               =>  'required|max:100',
            'overview'           => 'max:500',
            'content'            => 'max:65000',
            'img_thumbnail'      => 'uploaded_file:0,2048K,png,jpeg,jpg',

        ]);

        $validation->validate();

        if ($validation->fails()) {
            $_SESSION['errors'] = $validation->errors()->firstOfAll();

            header('Location: ' . url("admin/products/{$product['id']}/edit"));
            exit();
        } else {
            $data = [
               'category_id'       =>    $_POST['category_id'],
                'name'              =>    $_POST['name'],
                'overview'          =>    $_POST['overview'],
                'content'          =>    $_POST['content'],
                'update_at'        =>    date('Y-m-d H:i:s')
            ];

            //$flagUpload = false;

            if (!empty($_FILES['img_thumbnail']) && $_FILES['img_thumbnail']['size'] > 0) {
               // $flagUpload = true;
                $from = $_FILES['img_thumbnail']['tmp_name'];
                $to = 'assets/uploads/' . time() . $_FILES['img_thumbnail']['name'];

                if (move_uploaded_file($from, PATH_ROOT . $to)) {
                    $data['img_thumbnail'] = $to;
                } else {
                    $_SESSION['errors']['img_thumbnail'] = 'Upload Khong thanh cong';

                    header('Location: ' . url("admin/products/{$product['id']}/edit"));
                    exit();
                }
            }
            //   Helper::debug($data);
            $this->product->update($id, $data);
            if (
               // $flagUpload
                 $product['img_thumbnail']
                && file_exists(PATH_ROOT . $product['img_thumbnail'])
            ) {
                unlink(PATH_ROOT . $product['img_thumbnail']);
            }


            $_SESSION['status'] = true;
            $_SESSION['msg'] = 'Thao tac thanh cong';
            //{$product['id']}
            header('Location: ' . url("admin/products/$id/edit"));
            exit();
        }
    }
    public function delete($id)
    {
        $product = $this->product->findByID($id);
        $this->product->delete($id);
        
        if (
            $product['avatar']
            && file_exists(PATH_ROOT . $product['avatar'])
        ) {
            unlink(PATH_ROOT . $product['avatar']);
        }
        header('Location:' . url('admin/products'));
        exit();
    }
}
