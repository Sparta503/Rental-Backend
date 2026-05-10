// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public data routes (accessible to all authenticated users)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/items', [ItemController::class, 'index']);
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::get('/reviews', [ReviewController::class, 'index']);
});

// User-only routes
Route::middleware(['auth:sanctum', 'user.only'])->group(function () {
    Route::post('/items', [ItemController::class, 'store']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::post('/reviews', [ReviewController::class, 'store']);
});

// Admin-only routes
Route::middleware(['auth:sanctum', 'admin.only'])->group(function () {
    Route::put('/items/{id}', [ItemController::class, 'update']);
    Route::delete('/items/{id}', [ItemController::class, 'destroy']);
    Route::put('/bookings/{id}', [BookingController::class, 'update']);
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);
    Route::put('/reviews/{id}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);
    Route::get('/admin/users', [AdminController::class, 'index']);
    Route::post('/admin/users/{id}/role', [AdminController::class, 'updateRole']);
});