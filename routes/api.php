<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\TicketTypeController;
use App\Http\Controllers\API\RegionController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\PackageController;
use App\Http\Controllers\API\EventCategoryController;
use App\Http\Controllers\API\PackageServiceController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\ClientCompanyEventController;
use App\Http\Controllers\API\PrivacyLevelController;
use App\Http\Controllers\API\MemberPrivacyController;
use App\Http\Controllers\API\SubscriptionController;
use App\Http\Controllers\API\TaxSettingController;
use App\Http\Controllers\API\SponsorController;
use App\Http\Controllers\API\RegistrationCodeController;
use App\Http\Controllers\API\MemberRegistrationCodeController;
use App\Http\Controllers\API\MemberCompanyController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\EventSponsorController;
use App\Http\Controllers\API\EventSponsorTypeController;
use App\Http\Controllers\API\EventTicketPriceController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\EventBookingInvoiceController;
use App\Http\Controllers\API\SubscriptionPaymentController;

Route::apiResource('subscription-payments', SubscriptionPaymentController::class);
Route::apiResource('event-booking-invoices', EventBookingInvoiceController::class);
Route::apiResource('bookings', BookingController::class);
Route::apiResource('event-ticket-prices', EventTicketPriceController::class);
Route::apiResource('event-sponsor-types', EventSponsorTypeController::class);
Route::apiResource('event-sponsors', EventSponsorController::class);
Route::apiResource('events', EventController::class);
Route::apiResource('member-companies',MemberCompanyController::class);
Route::apiResource('member-registration-codes',MemberRegistrationCodeController::class);
Route::apiResource('registration-codes', RegistrationCodeController::class);
Route::apiResource('sponsors', SponsorController::class);
Route::apiResource('tax-settings', TaxSettingController::class);
Route::apiResource('member-privacy', MemberPrivacyController::class);
Route::apiResource('privacy-levels', PrivacyLevelController::class);
Route::apiResource('client-company-events', ClientCompanyEventController::class);
Route::apiResource('companies', CompanyController::class);
Route::apiResource('package-services', PackageServiceController::class);
Route::apiResource('event-categories', EventCategoryController::class);
Route::apiResource('packages', PackageController::class);
Route::apiResource('services', ServiceController::class);
Route::apiResource('regions', RegionController::class);
Route::apiResource('members', MemberController::class);
Route::apiResource('ticket-types', TicketTypeController::class);



Route::apiResource('subscriptions', SubscriptionController::class);
// Additional custom routes
Route::post('/subscriptions/renew', [SubscriptionController::class, 'renew']);
Route::post('/subscriptions/{id}/mark-paid', [SubscriptionController::class, 'markAsPaid']);
