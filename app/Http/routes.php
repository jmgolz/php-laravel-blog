<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/','Front@index');
Route::get('/products','Front@products');
Route::get('/products/details/{id}','Front@product_details');
Route::get('/products/categories/{category}','Front@product_categories');
Route::get('/products/brands','Front@product_brands');

Route::get('/blog','Front@blog');
Route::get('/blog/post/{id}','Front@blog_post');

Route::get('/contact-us','Front@contact_us');
Route::get('/login','Front@login');
Route::get('/logout','Front@logout');

Route::get('/cart','Front@cart');
Route::post('/cart', 'Front@cart');

Route::get('/checkout','Front@checkout');
Route::get('/search/{query}','Front@search');



// Route::get('hello', 'Hello@index');
// Route::get('/hello/{name}', 'Hello@show');

Route::get('blade', function () {
    $drinks = array('Vodka','Gin','Brandy');
    return view('page', array("name" => "The Raven",'day' => 'Friday', 'drinks' => $drinks)); 
});

Route::get('/insert', function(){
   App\Category::create(array('name' => 'music')) ;
   return 'Category Added';
});

Route::get('/read', function(){
   $category = new App\Category();
   $get_all_categories = $category->all(array('name', 'id'));
   
   foreach($get_all_categories as $category_item){
       echo $category_item->id . ' ' . $category_item->name . "<br />";
   }
});

Route::get('/update', function(){
    $category = App\Category::find(6);
    $category->name = "HEAVY METAL";
    $category->save();
});

Route::get('/delete', function(){
   $category = App\Category::find(5);
   $category->delete();
   
   $categories_list = $category->all(array('name', 'id'));
   foreach($categories_list as $categories_list_item){
       echo $categories_list_item->id . ' ' . $categories_list_item->name . '<br />';
   }
});