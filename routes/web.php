<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PerfilController;

/**
 * Define the routes for the web application.
 */

Route::get('/', HomeController::class)->name('home')->middleware('auth');

// The order of the routes is important. The first route that matches the request will be used to handle the request.

/**
 * Display the registration form.
 */
Route::get('/register', [RegisterController::class, 'index'])->name('register');

/**
 * Store the user registration data.
 */
Route::post('/register', [RegisterController::class, 'store']);

/**
 * Display the login form.
 */
Route::get('/login', [LoginController::class, 'index'])->name('login');

/**
 * Store the user login data.
 */
Route::post('/login', [LoginController::class, 'store']);

/**
 * Log the user out of the application.
 */
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

/**
 * Route to display the profile editing page.
 *
 * @return \Illuminate\Contracts\View\View
 */
Route::get('/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index')->middleware('auth');

/**
 * Route to handle the profile editing form submission.
 *
 * @return \Illuminate\Http\RedirectResponse
 */
Route::post('/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');

/**
 * Route for displaying the post creation form.
 *
 * This route maps to the 'create' method of the 'PostController'
 * The route name is set to 'posts.create'.
 */
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create')->middleware('auth');

/**
 * Route for storing the post data.
 *
 * This route maps to the 'store' method of the 'PostController'
 * The route name is set to 'posts.store'.
 */
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');


/**
 * Display the specified post.
 *
 * @param  \App\Models\User  $user
 * @param  \App\Models\Post  $post
 * @return \Illuminate\Contracts\View\View
 */
Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show');

/**
 * Store a new comment for a post.
 *
 * @param  \App\Http\Controllers\ComentarioController  $controller
 * @param  string  $user  The username of the user who owns the post.
 * @param  int  $post  The ID of the post.
 * @return \Illuminate\Http\Response
 */
Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');

/**
 * Delete a post.
 *
 * @param  \App\Models\Post  $post
 * @return \Illuminate\Http\Response
 */
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

/**
 * Store a new image.
 *
 * This route is responsible for storing a new image using the ImagenController's store method.
 * The route name is 'imagenes.store'.
 *
 * @param  \App\Http\Controllers\ImagenController  $controller
 * @param  string  $method
 * @return \Illuminate\Routing\Route
 */
Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

/**
 * Store a new like for a post.
 *
 * @param  int  $post  The ID of the post.
 * @return \Illuminate\Http\Response
 */
Route::post('/posts/{post}/likes', [LikeController::class, 'store'])->name('posts.likes.store');

/**
 * Remove a like from a post.
 *
 * @param  int  $post  The ID of the post.
 * @return \Illuminate\Http\Response
 */
Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy'])->name('posts.likes.destroy');

// Leave the dynamic routes at the bottom of the file to prevent them from overriding other routes.

/**
 * Display the posts for a specific user.
 *
 * @param  \App\Models\User  $user
 * @return \Illuminate\Contracts\View\View
 */
Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');

/**
 * Route to follow a user.
 *
 * This route is used to follow a user by their username.
 *
 * @param  string  $user:username  The username of the user to follow.
 * @param  string  $FollowerController@index  The controller method to handle the follow action.
 * @return \Illuminate\Routing\Route  The route instance.
 */
Route::post('/{user:username}', [FollowerController::class, 'store'])->name('users.follow');

/**
 * Route to unfollow a user.
 *
 * This route is used to unfollow a user by their username.
 *
 * @param  string  $user:username  The username of the user to unfollow.
 * @param  string  $FollowerController@destroy  The controller method to handle the unfollow action.
 * @return \Illuminate\Routing\Route  The route instance.
 */
Route::delete('/{user:username}', [FollowerController::class, 'destroy'])->name('users.unfollow');
