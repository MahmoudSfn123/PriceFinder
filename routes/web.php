<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\DiscussionController as AdminDiscussionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\ReplyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\VerificationController as AdminVerificationController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\SignupController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use illuminate\Support\Facades\Mail;
use App\Mail\HelloMail;
use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;
use App\Http\Controllers\InvoiceProcessorController;

Route::get('/welcome',function(){ return view('welcome');})->name('welcome');

Route::get('/', [HomeController::class,'index'])->name('home.index');

Route::get('/about', [AboutController::class,'index'])->name('about.index');

Route::get('/contact',[ContactController::class,'index'])->name('contact.index');


Route::get('/products/create',[ProductController::class,'create'])->name('products.create')->middleware('auth');

Route::post('/products',[ProductController::class,'store'])->name('products.store')->middleware('auth');

Route::get('/products/details/{id}', [ProductController::class, 'showDetails'])->name('products.details');

Route::get('/products/{catid?}', [ProductController::class,'show'])->name('products.show');

Route::get('/signup',[AuthController::class,'showSignup'])->name('signup.show');

Route::get('/login',[AuthController::class,'showLogin'])->name('login.show');

Route::post('/signup',[AuthController::class,'signup'])->name('signup');

Route::post('/login',[AuthController::class,'login'])->name('login');

Route::post('/logout',[AuthController::class,'logout'])->name('logout');

// Route::post('/invoices/temp-upload', [ProductController::class, 'tempUpload'])->name('invoices.temp-upload');

Route::post('/products/{product}/rate', [ProductController::class, 'rate'])
    ->name('products.rate');


Route::get('/discussions',[DiscussionController::class,'index'])->name('discussions.index')->middleware('auth');

Route::get('discussions/{discussion}',[DiscussionController::class,'show'])->name('discussions.show')->middleware('auth');

Route::get('/start-discussion', [DiscussionController::class, 'create'])->name('discussions.create')->middleware('auth');

Route::post('/start-discussion', [DiscussionController::class, 'store'])->name('discussions.store')->middleware('auth');

Route::post('discussions/{id}/reply',[DiscussionController::class,'storeReply'])->name('replies.store')->middleware('auth');

Route::post('discussions/{discussion}/like',[DiscussionController::class,'toggleDiscussionLike'])->name('discussions.like')->middleware('auth');

Route::post('/replies/{reply}/like', [DiscussionController::class, 'toggleReplyLike'])->name('replies.like')->middleware('auth');

Route::post('/api/process-invoice', [InvoiceProcessorController::class, 'processInvoice'])
        ->name('api.process-invoice')->middleware('web');

// Route::get('/debug-ollama', function () {
//     try {
//         // Test 1: Check if Ollama is accessible
//         $ch = curl_init();
//         curl_setopt($ch, CURLOPT_URL, 'http://localhost:11434/api/tags');
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($ch, CURLOPT_TIMEOUT, 10);
//         $response = curl_exec($ch);
//         $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//         curl_close($ch);

//         echo "<h3>1. Ollama Connection Test:</h3>";
//         echo "HTTP Code: " . $httpCode . "<br>";
//         echo "Response: " . $response . "<br><br>";

//         // Test 2: Check if Prism is installed
//         echo "<h3>2. Prism Installation Check:</h3>";
//         if (class_exists('Prism\Prism\Prism')) {
//             echo "✅ Prism is installed (correct namespace)<br>";
//         } else {
//             echo "❌ Prism is NOT installed<br>";
//         }

//         // Test 3: Test simple Prism call
//         echo "<h3>3. Prism Test:</h3>";

//         $response = Prism::text()
//             ->using(Provider::Ollama, 'llama3')
//             ->withPrompt('Say hello in JSON format like {"message": "hello"}')
//             ->withClientOptions(['timeout' => 30])
//             ->asText(); // Changed from ->generate() to ->asText()

//         echo "Response: " . $response->text . "<br><br>";

//         // Test 4: Test with your actual OCR text
//         echo "<h3>4. Invoice Processing Test:</h3>";
//         $service = app(\App\Services\InvoiceAIService::class);
//         $sampleText = "Krispy Tender Main Road 5818 70834814 MOF#400247 1 Dine In 08-06-2025 1657 CHECK # 111117 Order Nb. 196 1 Family Meal 3000000 1 Honey $0000 TOTAL LL: 3,050,000 TOTAL $: 34.08 Cash $: 40.00 Change 530000";

//         $result = $service->processInvoiceText($sampleText);

//         if ($result) {
//             echo "✅ Success: " . json_encode($result, JSON_PRETTY_PRINT);
//         } else {
//             echo "❌ Failed to process";
//         }

//     } catch (Exception $e) {
//         echo "Error: " . $e->getMessage() . "<br>";
//         echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "<br>";
//         echo "Trace: " . $e->getTraceAsString();
//     }
// });

// // Debug route for controller testing
// Route::post('/debug-invoice', function (Request $request) {
//     try {
//         $controller = new \App\Http\Controllers\InvoiceProcessorController(
//             new \App\Services\InvoiceAIService()
//         );

//         $testRequest = new Request([
//             'extracted_text' => 'Krispy Tender Main Road 5818 70834814 MOF#400247 1 Dine In 08-06-2025 1657 CHECK # 111117 Order Nb. 196 1 Family Meal 3000000 1 Honey $0000 TOTAL LL: 3,050,000 TOTAL $: 34.08 Cash $: 40.00 Change 530000'
//         ]);

//         $response = $controller->processInvoice($testRequest);

//         return $response;

//     } catch (Exception $e) {
//         return response()->json([
//             'error' => $e->getMessage(),
//             'file' => $e->getFile(),
//             'line' => $e->getLine(),
//             'trace' => $e->getTraceAsString()
//         ], 500);
//     }
// });

// Simple test route to check Prism basics
// Route::get('/test-prism', function () {
//     try {
//         $response = Prism::text()
//             ->using(Provider::Ollama, 'llama3')
//             ->withPrompt('Return just the word "working"')
//             ->asText();

//         return response()->json([
//             'status' => 'success',
//             'response' => $response->text
//         ]);
//     } catch (Exception $e) {
//         return response()->json([
//             'status' => 'error',
//             'message' => $e->getMessage()
//         ], 500);
//     }
// });



Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::ResetLinkSent
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PasswordReset
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');




////////////////////Admin/////////////////////



Route::prefix('admin')->group(function () {
    // Protected admin routes
    Route::middleware(['auth', 'isadmin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
        Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
        Route::post('/products/store', [AdminProductController::class, 'store'])->name('admin.products.store');
        Route::get('/products/{name}', [AdminProductController::class, 'show'])->name('admin.products.show');
        Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');

        Route::get('/categories',[AdminCategoryController::class,'index'])->name('admin.categories.index');
        Route::get('/categories/create',[AdminCategoryController::class,'create'])->name('admin.categories.create');
        Route::post('/categories/store',[AdminCategoryController::class,'store'])->name('admin.categories.store');
        Route::get('categories/{id}',[AdminCategoryController::class,'show'])->name('admin.categories.show');
        Route::get('categories/{id}/edit',[AdminCategoryController::class,'edit'])->name('admin.categories.edit');
        Route::put('categories/{id}',[AdminCategoryController::class,'update'])->name('admin.categories.update');
        Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');

        Route::get('/verifications',[AdminVerificationController::class,'index'])->name('admin.verifications.index');
        Route::post('/verifications/{id}/verify', [AdminVerificationController::class, 'verify'])->name('admin.verifications.verify');

        Route::get('discussions',[AdminDiscussionController::class,'index'])->name('admin.discussions.index');
        Route::get('discussions/{id}',[AdminDiscussionController::class,'show'])->name('admin.discussions.show');
        Route::post('discussions/{id}/lock', [AdminDiscussionController::class, 'lock'])->name('admin.discussions.lock');
        Route::post('discussions/{id}/unlock', [AdminDiscussionController::class, 'unlock'])->name('admin.discussions.unlock');
        Route::delete('discussions/{id}',[AdminDiscussionController::class,'destroy'])->name('admin.discussions.destroy');

        Route::delete('replies/{reply}', [ReplyController::class, 'destroy'])->name('admin.replies.destroy');

        Route::get('users',[UserController::class,'index'])->name('admin.users.index');
        Route::delete('users/{id}',[UserController::class,'destroy'])->name('admin.users.destroy');
        Route::get('users/create',[UserController::class,'create'])->name('admin.users.create');
        Route::post('users/store',[UserController::class,'store'])->name('admin.users.store');
        Route::get('users/{id}/edit',[UserController::class,'edit'])->name('admin.users.edit');
        Route::put('users/{id}/update',[UserController::class,'update'])->name('admin.users.update');

        Route::get('/reviews',[AdminReviewController::class,'index'])->name('admin.reviews.index');
        Route::get('reviews/show/{id}',[AdminReviewController::class,'show'])->name('admin.reviews.show');
        Route::delete('reviews/{id}',[AdminReviewController::class,'destroy'])->name('admin.reviews.destroy');





    });
});








