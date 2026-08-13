<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ShippingMethodController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\ProductPropertyController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductUnitController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\PageSectionController;
use App\Http\Controllers\ProductSliderController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProductRolePriceController;
use App\Http\Controllers\ProductRelatedController;
use App\Http\Controllers\SocialNetworkController;
use App\Http\Controllers\MenuController;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'verified', 'is_admin']], function () {

    require __DIR__.'/admin/products.php';
    require __DIR__.'/admin/settings.php';
    require __DIR__.'/admin/invoices.php';
    require __DIR__.'/admin/command.php';

    Route::post('/store-product-related', [ProductRelatedController::class, 'store'])
        ->name('store_product_related');
    Route::delete('/remove-product-related/{id}', [ProductRelatedController::class, 'destroy'])
        ->name('remove_product_related');

    Route::get('/chart', [ChartController::class, 'index'])->name('charts');
    Route::get('/media-list', [MediaController::class, 'list'])->name('media_list');

    Route::get('/users-search', [UserController::class, 'search'])->name('users_search');


    Route::put('/product-slider-status/{productSlider}', [ProductSliderController::class, 'toggle_status'])
        ->name('toggle_status_product_slider');

    Route::put('/banner-status/{banner}', [BannerController::class, 'toggle_status'])
        ->name('toggle_status_banner');


    Route::resources([
        'menu' => MenuController::class,
        'social' => SocialNetworkController::class,
        'role' => RoleController::class,
        'ticket' => TicketController::class,
        'cart' => CartController::class,
        'page' => PageController::class,
        'page-section' => PageSectionController::class,
        'product-slider' => ProductSliderController::class,
        'media' => MediaController::class,
        'banner' => BannerController::class,
        'slider' => SliderController::class,
        'coupon' => CouponController::class,
        'unit' => ProductUnitController::class,
        'inventory' => InventoryController::class,
        'brand' => BrandController::class,
        'category' => CategoryController::class,
        'product' => ProductController::class,
        'user' => UserController::class,
        'invoice' => InvoiceController::class,
        'shipping' => ShippingMethodController::class,
        'payment' => PaymentMethodController::class,
        'variant' => ProductVariantController::class,
        'property' => ProductPropertyController::class,
        'blog/category' => BlogCategoryController::class,
        'post' => PostController::class,
        'comment' => CommentController::class,
        'gallery' => ProductGalleryController::class,
        'course' => CourseController::class,
        'lesson' => LessonController::class,
        'role-price' => ProductRolePriceController::class,
    ]);

    Route::patch('/ticket-status/{ticket}', [TicketController::class, 'toggle_status'])
        ->name('ticket_status');
    Route::put('/user-status/{user}', [UserController::class, 'toggle_status'])
        ->name('user_status');
    Route::put('/comment-status/{comment}', [CommentController::class, 'toggle_status'])
        ->name('comment_status');
    Route::put('/post-status/{post}', [PostController::class, 'toggle_status'])
        ->name('post_status');
    Route::put('/page-status/{page}', [PageController::class, 'toggle_status'])
        ->name('page_status');
    Route::put('/brand-status/{brand}', [BrandController::class, 'toggle_status'])
        ->name('brand_status');
    Route::put('/category-status/{category}', [CategoryController::class, 'toggle_status'])
        ->name('category_status');
    Route::put('/blog-category-status/{category}', [BlogCategoryController::class, 'toggle_status'])
        ->name('blog_category_status');

    Route::put('/coupon-status/{coupon}', [CouponController::class, 'toggle_status'])
        ->name('coupon_status');

    Route::put('/slider-status/{slider}', [SliderController::class, 'toggle_status'])
        ->name('slider_status');

    Route::put('/social-status/{social}', [SocialNetworkController::class, 'toggle_status'])
        ->name('social_status');

    Route::put('/menu-status/{menu}', [MenuController::class, 'toggle_status'])
        ->name('menu_status');

    Route::put('/payment-status/{payment}', [PaymentMethodController::class, 'toggle_status'])
        ->name('payment_status');
    Route::put('/payment-default/{payment}', [PaymentMethodController::class, 'toggle_default'])
        ->name('payment_default');

    Route::put('/shipping-status/{shipping}', [ShippingMethodController::class, 'toggle_status'])
        ->name('shipping_status');
    Route::put('/shipping-default/{shipping}', [ShippingMethodController::class, 'toggle_default'])
        ->name('shipping_default');


    Route::delete('/restore-slider/{slider}', [SliderController::class, 'restore'])
        ->name('slider.restore')->withTrashed();

    Route::delete('/restore-coupon/{coupon}', [CouponController::class, 'restore'])
        ->name('coupon.restore')->withTrashed();


    Route::delete('/restore-inventory/{inventory}', [InventoryController::class, 'restore'])
        ->name('inventory.restore')->withTrashed();
    Route::delete('/restore-unit/{unit}', [ProductUnitController::class, 'restore'])
        ->name('inventory.restore')->withTrashed();
    Route::delete('/restore-brand/{brand}', [BrandController::class, 'restore'])
        ->name('brand.restore')->withTrashed();
    Route::delete('/restore-category/{category}', [CategoryController::class, 'restore'])
        ->name('category.restore')->withTrashed();

    Route::delete('/restore-menu/{menu}', [MenuController::class, 'restore'])
        ->name('menu.restore')->withTrashed();

    Route::delete('/restore-user/{user}', [UserController::class, 'restore'])
        ->name('user.restore')->withTrashed();

    Route::delete('/restore-page-section/{pageSection}', [PageSectionController::class, 'restore'])
        ->name('page_section.restore')->withTrashed();

    Route::delete('/restore-shipping/{shipping}', [ShippingMethodController::class, 'restore'])
        ->name('shipping.restore')->withTrashed();

    Route::delete('/restore-payment/{payment}', [PaymentMethodController::class, 'restore'])
        ->name('payment.restore')->withTrashed();

    Route::delete('/restore-variant/{variant}', [ProductVariantController::class, 'restore'])
        ->name('variant.restore')->withTrashed();

    Route::delete('/restore-post/{post}', [PostController::class, 'restore'])
        ->name('post.restore')->withTrashed();

    Route::delete('/restore-page/{page}', [PageController::class, 'restore'])
        ->name('page.restore')->withTrashed();

    Route::delete('/restore-blog-category/{category}', [BlogCategoryController::class, 'restore'])
        ->name('blog_category.restore')->withTrashed();

    Route::delete('/restore-comment/{comment}', [CommentController::class, 'restore'])
        ->name('comment.restore')->withTrashed();


});
