@php
    $products = get_auction_products(8, null);
@endphp
@if(count($products) > 0)
<section class="mb-4 mt-4 pt-4 pb-4" style="background-color: {{ get_setting('auction_product_bg_color', '#f5f5f5') }}">
    <div class="container">
        <!-- Top Section -->
        <div class="d-flex mb-3 align-items-baseline justify-content-between px-2">
            <!-- Title -->
            <div>
                <h3 class="fs-20 fw-700 mb-0">{{ translate('Auction Products') }}</h3>
                <p class="fs-12 text-secondary mb-0">{{ translate('Products') }} ({{ count($products) }})</p>
            </div>
            <!-- View All Link -->
            <a type="button" class="arrow-next text-white view-more-slide-btn d-flex align-items-center" href="{{ route('auction_products.all') }}" style="background-color: {{ get_setting('auction_product_btn_color', '#000000') }}">
                <span><i class="las la-angle-right fs-20 fw-600"></i></span>
                <span class="fs-12 mr-2 text">{{ translate('View All') }}</span>
            </a>
        </div>
        
        <!-- Products Grid -->
        <div class="row gutters-16">
            <!-- Auction Banner -->
            <div class="col-lg-4 col-md-12 mb-3 mb-lg-0">
                <div class="h-100 w-100 overflow-hidden rounded-2">
                    <a href="{{ route('auction_products.all') }}" class="d-block h-100">
                        <img class="img-fit lazyload mx-auto h-100 w-100 has-transition"
                            style="min-height: 400px; object-fit: cover;"
                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                            data-src="{{ uploaded_asset(get_setting('auction_banner_image', null, $lang)) }}"
                            alt="{{ env('APP_NAME') }} auction"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                    </a>
                </div>
            </div>
            
            <!-- Auction Products Grid -->
            <div class="col-lg-8 col-md-12">
                <div class="row gutters-16">
                    @foreach ($products->take(4) as $key => $product)
                        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                            <div class="bg-white rounded-2 p-3 h-100 border has-transition hov-shadow-md">
                                <div class="row no-gutters align-items-center">
                                    <!-- Product Image -->
                                    <div class="col-5">
                                        <a href="{{ route('auction-product', $product->slug) }}" class="d-block text-center">
                                            <img class="img-fluid lazyload mx-auto has-transition" 
                                                style="height: 100px; object-fit: contain;"
                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                alt="{{ $product->getTranslation('name') }}"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                        </a>
                                    </div>
                                    
                                    <!-- Product Details -->
                                    <div class="col-7 pl-3">
                                        <h3 class="fw-400 fs-13 text-truncate-2 lh-1-3 mb-2" style="height: 35px;">
                                            <a href="{{ route('auction-product', $product->slug) }}" class="text-reset hov-text-primary">{{ $product->getTranslation('name') }}</a>
                                        </h3>
                                        <div class="mb-2">
                                            <span class="fs-11 text-secondary d-block">{{ translate('Starting Bid') }}</span>
                                            <span class="fw-700 fs-16 text-dark">{{ single_price($product->starting_bid) }}</span>
                                        </div>
                                        @php 
                                            $highest_bid = $product->bids->max('amount');
                                            $min_bid_amount = $highest_bid != null ? $highest_bid+1 : $product->starting_bid; 
                                        @endphp
                                        <button class="btn btn-sm px-3 py-1 rounded-1 fs-12 fw-500 w-100" 
                                            style="background-color: {{ get_setting('auction_product_btn_color', '#c7a17a') }}; color: #fff;" 
                                            onclick="bid_single_modal({{ $product->id }}, {{ $min_bid_amount }})">
                                            {{ translate('Place Bid') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
