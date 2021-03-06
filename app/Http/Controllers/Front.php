<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Product;
use App\User;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Cart;


class Front extends Controller
{
    public $brands;
    public $categories;
    public $products;
    public $title;
    public $description;
    
    public function __construct() {
        $this->brands = Brand::all(array('id', 'name'));
        $this->categories = Category::all(array('id', 'name'));
        $this->products = Product::all(array('id','name','price'));
    }
    
    public function index() {
        return view('home', array('title' => 'Welcome','description' => '','page' => 'home', 'brands' => $this->brands, 'categories' => $this->categories, 'products' => $this->products));
    }

    public function products() {
        return view('products', array('title' => 'Products Listing','description' => '','page' => 'products', 'brands' => $this->brands, 'categories' => $this->categories, 'products' => $this->products));
    }

    public function product_details($id) {
        $product = Product::find($id);
        $brand = $this->categories->where('id', $product->id)->first()->name;
        return view('product_details', array('brand' => $brand, 'product' => $product, 'title' => $product->name,'description' => $product->description,'page' => 'products', 'brands' => $this->brands, 'categories' => $this->categories, 'products' => $this->products));
    }

    public function product_categories($id) {
        $products = Product::where('category_id', "=", $id)->get();
        return view('products', array('title' => 'Welcome','description' => '','page' => 'products', 'brands' => $this->brands, 'categories' => $this->categories, 'products' => $products, 'id' => $id));
    }

    public function product_brands($name, $category = null) {
        return view('products', array('title' => 'Welcome','description' => '','page' => 'products', 'brands' => $this->brands, 'categories' => $this->categories, 'products' => $this->products));
    }

    public function blog() {
        return view('blog', array('title' => 'Welcome','description' => '','page' => 'blog', 'brands' => $this->brands, 'categories' => $this->categories, 'products' => $this->products));
    }

    public function blog_post($id) {
        return view('blog_post', array('title' => 'Welcome','description' => '','page' => 'blog', 'brands' => $this->brands, 'categories' => $this->categories, 'products' => $this->products));
    }

    public function contact_us() {
        return view('contact_us', array('title' => 'Welcome','description' => '','page' => 'contact_us'));
    }

    public function login() {
        return view('login', array('title' => 'Welcome','description' => '','page' => 'home'));
    }

    public function logout() {
        Auth::logout();
        return Redirect::away('login');
    }

    public function cart() {
        
        if(Request::isMethod('post')){
            $product_id = Request::get('product_id');
            $product = Product::find($product_id);
            Cart::add(array('id' => $product_id, 'name' => $product->name, 'qty' => 1, 'price' => $product->price));
        }
        
        if(Request::get('product_id')){
            $rowId = Cart::search(array('id' => Request::get('product_id')));
            $item = Cart::get($rowId[0]);

            if(Request::get('increment') == 1){
                Cart::update($rowId[0], $item->qty + 1);    
            } 
            
            else if(Request::get('decrement') == 1){
                Cart::update($rowId[0], $item->qty - 1);    
            } 
            
            else if(Request::get('delete') == 1){
                Cart::remove($rowId[0]);
            }
        } else if(Request::get('clear_cart') == 1){
            Cart::destroy();
        }
        
        $cart = Cart::content();
        return view('cart', array('cart' => $cart, 'title' => 'Welcome', 'description' => '', 'page' => 'home'));
    }

    public function checkout() {
        $cart = Cart::content();
        return view('checkout', array('title' => 'Welcome','description' => '','page' => 'home', 'cart' => $cart));
    }

    public function search($query) {
        return view('products', array('title' => 'Welcome','description' => '','page' => 'products'));
    }
    
    public function register(){
        if(Request::isMethod('post')){
            User::create(array(
               'name' => Request::get('name'),
               'email' => Request::get('email'),
               'password' => bcrypt(Request::get('password'))
            ));
        }
        
        return Redirect::away('login');
    }
    
    public function authenticate(){
        if( Auth::attempt( array('email' => Request::get('email'), 'password' => Request::get('password'))) ){
            return redirect()->intended('checkout');
        } else {
             return view('login', array('title' => 'Welcome', 'description' => '', 'page' => 'home'));
        }
    }
}
