@extends('frontend.layouts.app')

@section('content')
    <section class="pt-4 mb-4">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left">
                    <h1 class="fw-700 fs-20 fs-md-24 text-dark">{{ translate('Track Order') }}</h1>
                </div>
                <div class="col-lg-6">
                    <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                        <li class="breadcrumb-item has-transition opacity-50 hov-opacity-100">
                            <a class="text-reset" href="{{ route('home') }}">{{ translate('Home') }}</a>
                        </li>
                        <li class="text-dark fw-600 breadcrumb-item">
                            "{{ translate('Track Order') }}"
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-5">
        <div class="container">
            <div class="row">
                <div class="col-xxl-5 col-xl-6 col-lg-8 mx-auto">
                    <form action="{{ route('orders.track') }}" method="GET" enctype="multipart/form-data">
                        <div class="bg-white border rounded-0 mb-5">
                            <div class="fs-15 fw-600 p-3 border-bottom text-center">
                                {{ translate('Check Your Order Status')}}
                            </div>
                            <div class="form-box-content p-3">
                                <div class="form-group">
                                    <input type="text" class="form-control rounded-0 mb-3"
                                        placeholder="{{ translate('Order Code')}}" name="order_code"
                                        value="{{ $order->code ?? '' }}" required>
                                </div>
                                <div class="text-right">
                                    <button type="submit"
                                        class="btn btn-primary rounded-0 w-150px">{{ translate('Track Order')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @isset($order)
                @php
                    $status = $order->delivery_status;
                    $timelines = $order->timelines;

                    // Map statuses to timeline steps
                    // Statuses: pending, confirmed, in_production, ocean_transit, picked_up, on_the_way, delivered, cancelled

                    $steps = [
                        ['status' => 'confirmed', 'label' => translate('Order Placed'), 'icon' => 'las la-file-invoice'],
                        ['status' => 'packing', 'label' => translate('Packing'), 'icon' => 'las la-box'],
                        ['status' => 'dispatched', 'label' => translate('Dispatched'), 'icon' => 'las la-shipping-fast'],
                        ['status' => 'on_the_way', 'label' => translate('Final Mile Delivery'), 'icon' => 'las la-truck'],
                        ['status' => 'delivered', 'label' => translate('Delivered'), 'icon' => 'las la-check-circle']
                    ];

                    // Determine active index
                    // Logic: exact match is best, but we need progress.
                    // We assume linear progression: confirmed < packing < dispatched < on_the_way < delivered
                    $status_order = ['pending', 'confirmed', 'packing', 'dispatched', 'picked_up', 'on_the_way', 'delivered'];
                    $current_status_index = array_search($status == 'picked_up' ? 'on_the_way' : $status, $status_order);

                    // Helper to get date
                    function getStepDate($step_status, $timelines, $order)
                    {
                        // Check explicit timeline first
                        $timeline = $timelines->where('status', $step_status)->sortByDesc('created_at')->first();
                        if ($timeline)
                            return $timeline->created_at;

                        // Fallbacks for legacy/initial states
                        if ($step_status == 'confirmed' && $order->date)
                            return \Carbon\Carbon::createFromTimestamp($order->date);
                        if ($step_status == 'delivered' && $order->delivered_date)
                            return $order->delivered_date;

                        return null;
                    }
                @endphp

                <div class="row gutters-10">
                    <!-- Left Column: Timeline -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-none rounded-0">
                            <div class="card-header border-bottom-0">
                                <h5 class="mb-0 fs-18 fw-700">{{ translate('Tracking History') }}</h5>
                            </div>
                            <div class="card-body">
                                <ul class="timeline-with-icons">
                                    @foreach($steps as $index => $step)
                                        @php
                                            $step_index = -1;
                                            // Find index of this step in the master order list to compare with current status
                                            // Mapping step status to master list keys
                                            $mapping = [
                                                'confirmed' => 'confirmed',
                                                'packing' => 'packing',
                                                'dispatched' => 'dispatched',
                                                'on_the_way' => 'on_the_way', // covers picked_up too via logic above
                                                'delivered' => 'delivered'
                                            ];
                                            $mapped_status = $mapping[$step['status']];
                                            $step_numeric_index = array_search($mapped_status, $status_order);

                                            $is_completed = $step_numeric_index !== false && $current_status_index !== false && $current_status_index >= $step_numeric_index;
                                            $is_active = $step_numeric_index !== false && $current_status_index !== false && $current_status_index == $step_numeric_index;

                                            $date = getStepDate($step['status'], $timelines, $order);
                                        @endphp
                                        <li class="timeline-item {{ $is_completed ? 'completed' : '' }}">
                                            <span
                                                class="timeline-icon {{ $is_completed ? 'bg-success text-white' : 'bg-soft-secondary text-secondary' }}">
                                                <i class="{{ $step['icon'] }}"></i>
                                            </span>
                                            <div class="timeline-content">
                                                <h6
                                                    class="fs-15 mb-1 {{ $is_completed ? 'fw-700 text-dark' : 'fw-400 text-muted' }}">
                                                    {{ $step['label'] }}</h6>
                                                @if($date)
                                                    <p class="text-muted fs-12 mb-0">
                                                        {{ \Carbon\Carbon::parse($date)->setTimezone('Asia/Kolkata')->format('d M, Y - h:i A') }}</p>
                                                @elseif($is_completed)
                                                    <p class="text-muted fs-12 mb-0">{{ translate('Verified') }}</p>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Map & Details -->
                    <div class="col-lg-6">
                        <!-- Map Section -->
                        <div class="card border-0 shadow-none rounded-0 mb-4">
                            <div class="card-header border-bottom-0">
                                <h5 class="mb-0 fs-18 fw-700">{{ translate('Delivery Location') }}</h5>
                            </div>
                            <div class="card-body p-0">
                                @php
                                    $shipping_address = json_decode($order->shipping_address);
                                    $address_string = $shipping_address->address . ', ' . $shipping_address->city . ', ' . $shipping_address->country;
                                @endphp
                                <div class="map-container"
                                    style="height: 300px; width: 100%; position: relative; overflow: hidden;">
                                    <iframe width="100%" height="100%" frameborder="0" style="border:0"
                                        src="https://maps.google.com/maps?q={{ urlencode($address_string) }}&t=&z=13&ie=UTF8&iwloc=&output=embed"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        </div>

                        <!-- Order Details -->
                        <div class="card border-0 shadow-sm rounded-0">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <span class="text-muted d-block fs-12">{{ translate('Shipped To') }}</span>
                                        <span class="fw-600 d-block text-dark">{{ $shipping_address->name }}</span>
                                        <span class="fs-12 text-muted">{{ $address_string }}</span>
                                    </div>
                                    <div class="col-6 text-right">
                                        <span class="text-muted d-block fs-12">{{ translate('Order #') }}</span>
                                        <span class="fw-600 d-block text-dark">{{ $order->code }}</span>
                                    </div>
                                </div>
                                <hr class="dashed">
                                <div class="row">
                                    <div class="col-6">
                                        <span class="fw-700 text-dark">{{ translate('Total') }}</span>
                                    </div>
                                    <div class="col-6 text-right">
                                        <span class="fw-700 text-primary fs-16">{{ single_price($order->grand_total) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endisset
        </div>
    </section>

    <style>
        .timeline-with-icons {
            list-style: none;
            padding: 0;
            position: relative;
            margin-left: 20px;
        }

        .timeline-with-icons .timeline-item {
            position: relative;
            padding-left: 40px;
            /* Space for icon */
            padding-bottom: 30px;
        }

        .timeline-with-icons .timeline-item::before {
            content: '';
            position: absolute;
            left: 19px;
            /* Center of icon (40px width -> center 20px, icon width 38px -> center 19px) */
            top: 40px;
            /* Below icon */
            bottom: 0px;
            width: 2px;
            background-color: #e9ecef;
        }

        .timeline-with-icons .timeline-item:last-child::before {
            display: none;
        }

        /* Icon styling */
        .timeline-icon {
            position: absolute;
            left: 0;
            top: 0;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
            font-size: 18px;
        }

        /* Active state for line - difficult to do purely CSS without JS determining exact height, 
               so we usually just color the icons. 
               Optional: Color the line of *completed* items. 
               We can do this by coloring the ::before of the *previous* item.
            */
        .timeline-item.completed .timeline-icon {
            /* Active color set in HTML classes usually */
        }

        .timeline-item.completed::before {
            background-color: #28a745;
            /* Green line connecting completed items */
        }

        /* Fix for last item line behavior if we want lines between nodes */
        .timeline-item.completed+.timeline-item.completed::before {
            /* Only color the line if the NEXT item is also completed? 
                   Actually, the line belongs to the current item pointing to the next.
                   So if THIS item is completed, its line downwards should be green IF the next one is reached?
                   Or just simple gray lines. Let's stick to gray lines to avoid complexity with partial states.
                */
            background-color: #e9ecef;
        }

        /* Override line color for cleaner look - stick to gray, focus on icons */
        .timeline-with-icons .timeline-item::before {
            background-color: #dee2e6;
        }
    </style>
@endsection