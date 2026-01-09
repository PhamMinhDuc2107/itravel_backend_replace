<?php

return [
    App\Providers\AppServiceProvider::class,

    
    Modules\Shared\Providers\SharedServiceProvider::class,   
    Modules\Identity\Providers\IdentityServiceProvider::class,

   
    Modules\Tour\Providers\TourServiceProvider::class,
    Modules\Hotel\Providers\HotelServiceProvider::class,   
    Modules\Visa\Providers\VisaServiceProvider::class,       

    
    Modules\Booking\Providers\BookingServiceProvider::class,
    Modules\Partner\Providers\PartnerServiceProvider::class,
    Modules\Payment\Providers\PaymentServiceProvider::class,
];