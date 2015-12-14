<?php namespace Controllers;

use Middleware\Request;
use Models\Product;
use Models\Image;
use Models\Tag;
use Cart\Cart;
use Models\Category;
use Cart\SessionStorage;
use Models\History;
use Models\Customer;

class FrontController {

    private $cart;

    public function __construct(){

        $this->cart = new Cart(new SessionStorage('starwars'));
    }

    public function index() {

        $product = new Product;
        $image = New Image;
        $tag = New Tag;
        $products = $product->all();
        $category = new Category;
        $categories = $category->all();

        // var_dump($_SESSION);

        view('front.index', compact('products', 'image', 'tag', 'categories'));

    }

    public function show($id){
        $image = New Image;
        $tag = New Tag;
        $products = new Product;
        $product = $products->productId($id);
        $category = new Category;
        $categories = $category->all();

        view('front.sin
        gle', compact('product', 'image', 'tag', 'categories'));
    }

    public function showCategory($id){
        $category = new Category;
        $products = $category->products($id);
        $categories = $category->all();
        $image = new Image;
        $tag = new Tag;

        view('front.index', compact('products', 'image', 'tag', 'categories'));
    }

    public function command(){

        $rules =  [
            'name' => FILTER_VALIDATE_INT,
            'quantity' => FILTER_VALIDATE_INT,
            'price' => FILTER_VALIDATE_FLOAT
        ];

        $sanitize = filter_input_array(INPUT_POST, $rules);
        //var_dump($sanitize);

        $productCart = new \Cart\Product($sanitize['name'], $sanitize['price']);

        $this->cart->buy($productCart, $sanitize['quantity']);

        $this->redirect(url());
    }

    public function showCart(){

        $storage = $this->cart->all();

        $products = [];
        $category = new Category;
        $categories = $category->all();

        foreach($storage as $id => $total){

            $p = new Product; // product du Model pas du Cart
            $stmt = $p->find($id);

            $products[$stmt->title]['price'] = (float) $stmt->price;
            $products[$stmt->title]['total'] = $total;
            $products[$stmt->title]['quantity'] = $total/$stmt->price;
            $products[$stmt->title]['product_id'] = $id;
        }

        $image = new Image;

        view('front.cart', compact('products', 'image', 'categories'));
    }

    public function store(){

        if(!checked_token($_POST['_token'])){
            $this->redirect(url('cart'));
        }
        //if(empty($_SESSION)) session_start();

        if(!empty($_SESSION['old'])) $_SESSION['old']=[];

        if(!empty($_SESSION['error'])) $_SESSION['error']=[];

        $rules = [
            'email'  => FILTER_VALIDATE_EMAIL,
            'number' => [
                'filter' => FILTER_CALLBACK,
                'options' => function($nb){
                    if(preg_match('/[0-9]{16}/', $nb)) return $nb;
                    return false;
                }
            ],
            'adresse' => FILTER_SANITIZE_STRING
        ];

        $sanitize = filter_input_array(INPUT_POST, $rules);

        //var_dump($sanitize);

        $error = false;

        if(!$sanitize['email']){
            $error = true;
            $_SESSION['error']['email'] = 'your email is invalid';
        }

        if(!$sanitize['number']){
            $error = true;
            $_SESSION['error']['number'] = 'your blue card number is invalid';
        }

        if(!empty($sanitize['adresse'])){
            $error = true;
            $_SESSION['error']['adresse'] = 'you must give your address';
        }

        if($error){
            $_SESSION['old']['email'] = $sanitize['email'];
            $_SESSION['old']['adresse'] = $sanitize['adresse'];

            $this->redirect(url('cart'));
        }

        //transactionnelle PDO

        try{

            \Connect::$pdo->beginTransaction();

            $history = new History;
            $customer = new Customer;

            $customer->create(['email' => $sanitize['email'], 'number' => $sanitize['number'], 'adresse' => $sanitize['adresse'] ]);

            $customer_id = \Connect::$pdo->lastInsertId();

            $storage = $this->cart->all();

            foreach($storage as $id => $total){

                $p = new Product; // product du Model pas du Cart
                $stmt = $p->find($id);

                $history->create([
                    'product_id' => $id,
                    'customer_id' =>$customer_id,
                    'price' => (float) $stmt->price,
                    'total' => $total,
                    'quantity' => $total/$stmt->price,
                    'commanded_at' => date('Y-m-d h:i:s'),
                ]);
            }

            \Connect::$pdo->commit();

            $this->cart->reset();
            $this->redirect(url());

        }catch (\PDOException $e){

            \Connect::$pdo->rollBack();

        }
    }

    private function redirect($path, $status='200 Ok'){

        header("HTTP/1.1 $status");
        header('Content-Type: html/text charset=UTF-8');
        header("Location: $path");
        exit; // alias de die

    }
}
