@extends('auth.layouts.authentication')

@section('content')
    <div class="aiz-main-wrapper d-flex flex-column justify-content-md-center bg-white">
        <section class="bg-white overflow-hidden">
            <div class="row">
                <div class="col-xxl-6 col-xl-9 col-lg-10 col-md-7 mx-auto py-lg-4">
                    <div class="card shadow-none rounded-0 border-0">
                        <div class="row no-gutters">
                            <!-- Left Side Image-->
                            <div class="col-lg-6">
                                <img src="{{ uploaded_asset(get_setting('customer_register_page_image')) }}"
                                    alt="{{ translate('Customer Register Page Image') }}" class="img-fit h-100">
                            </div>

                            <!-- Right Side -->
                            <div class="col-lg-6 p-4 p-lg-5 d-flex flex-column justify-content-center border right-content"
                                style="height: auto;">
                                <!-- Site Icon -->
                                <div class="size-48px mb-3 mx-auto mx-lg-0">
                                    <img src="{{ uploaded_asset(get_setting('site_icon')) }}"
                                        alt="{{ translate('Site Icon')}}" class="img-fit h-100">
                                </div>

                                <!-- Titles -->
                                <div class="text-center text-lg-left">
                                    <h1 class="fs-20 fs-md-24 fw-700 text-primary" style="text-transform: uppercase;">
                                        {{ translate('Complete Your Profile')}}
                                    </h1>
                                </div>

                                <!-- Register form -->
                                <div class="pt-3">
                                    <div class="">
                                        <form class="form-default" role="form"
                                            action="{{ route('registration.step2.store') }}" method="POST">
                                            @csrf

                                            <!-- Address -->
                                            <div class="form-group">
                                                <label
                                                    class="fs-12 fw-700 text-soft-dark">{{  translate('Address') }}</label>
                                                <input type="text"
                                                    class="form-control rounded-0{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                                    value="{{ old('address') }}" placeholder="{{  translate('Address') }}"
                                                    name="address" required>
                                                @if ($errors->has('address'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('address') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Country -->
                                            <div class="form-group">
                                                <label
                                                    class="fs-12 fw-700 text-soft-dark">{{  translate('Country') }}</label>
                                                <select
                                                    class="form-control rounded-0{{ $errors->has('country_id') ? ' is-invalid' : '' }}"
                                                    name="country_id" id="country_id" required>
                                                    <option value="">{{ translate('Select Country') }}</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('country_id'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('country_id') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- State -->
                                            <div class="form-group">
                                                <label class="fs-12 fw-700 text-soft-dark">{{  translate('State') }}</label>
                                                <select
                                                    class="form-control rounded-0{{ $errors->has('state_id') ? ' is-invalid' : '' }}"
                                                    name="state_id" id="state_id" required>
                                                    <option value="">{{ translate('Select State') }}</option>
                                                </select>
                                                @if ($errors->has('state_id'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('state_id') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- City -->
                                            <div class="form-group">
                                                <label class="fs-12 fw-700 text-soft-dark">{{  translate('City') }}</label>
                                                <select
                                                    class="form-control rounded-0{{ $errors->has('city_id') ? ' is-invalid' : '' }}"
                                                    name="city_id" id="city_id" required>
                                                    <option value="">{{ translate('Select City') }}</option>
                                                </select>
                                                @if ($errors->has('city_id'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('city_id') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Area -->
                                            <div class="form-group">
                                                <label class="fs-12 fw-700 text-soft-dark">{{  translate('Area') }}</label>
                                                <!-- Editable text area -->
                                                <input type="text"
                                                    class="form-control rounded-0{{ $errors->has('area') ? ' is-invalid' : '' }}"
                                                    name="area" id="area" placeholder="{{ translate('Enter Area') }}">

                                                <!-- Hidden Select for fetching areas if available -->
                                                <div class="mt-2 d-none" id="area_select_div">
                                                    <select class="form-control rounded-0" name="area_id" id="area_id">
                                                        <option value="">{{ translate('Select Area') }}</option>
                                                    </select>
                                                </div>

                                                @if ($errors->has('area_id') || $errors->has('area'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('area') ?: $errors->first('area_id') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Postal Code -->
                                            <div class="form-group">
                                                <label
                                                    class="fs-12 fw-700 text-soft-dark">{{  translate('Postal Code') }}</label>
                                                <input type="text"
                                                    class="form-control rounded-0{{ $errors->has('postal_code') ? ' is-invalid' : '' }}"
                                                    value="{{ old('postal_code') }}"
                                                    placeholder="{{  translate('Postal Code') }}" name="postal_code"
                                                    required>
                                                @if ($errors->has('postal_code'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('postal_code') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Gender -->
                                            <div class="form-group">
                                                <label
                                                    class="fs-12 fw-700 text-soft-dark">{{  translate('Gender') }}</label>
                                                <select
                                                    class="form-control rounded-0{{ $errors->has('gender') ? ' is-invalid' : '' }}"
                                                    name="gender" required>
                                                    <option value="">{{ translate('Select Gender') }}</option>
                                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                                        {{ translate('Male') }}
                                                    </option>
                                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                                        {{ translate('Female') }}
                                                    </option>
                                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>
                                                        {{ translate('Other') }}
                                                    </option>
                                                </select>
                                                @if ($errors->has('gender'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('gender') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Primary Phone -->
                                            <div class="form-group">
                                                <label
                                                    class="fs-12 fw-700 text-soft-dark">{{  translate('Primary Phone') }}</label>
                                                <input type="tel"
                                                    class="form-control rounded-0{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                                    value="{{ $user->phone ?? old('phone') }}"
                                                    placeholder="{{ translate('Primary Phone') }}" name="phone" id="phone"
                                                    {{ !empty($user->phone) ? 'readonly' : '' }} required>
                                                @if ($errors->has('phone'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('phone') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Secondary Phone -->
                                            <div class="form-group">
                                                <label
                                                    class="fs-12 fw-700 text-soft-dark">{{  translate('Secondary Phone (Optional)') }}</label>
                                                <input type="tel"
                                                    class="form-control rounded-0{{ $errors->has('secondary_phone') ? ' is-invalid' : '' }}"
                                                    value="{{ old('secondary_phone') }}"
                                                    placeholder="{{  translate('Secondary Phone') }}" name="secondary_phone"
                                                    id="secondary_phone">
                                                @if ($errors->has('secondary_phone'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('secondary_phone') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="mb-4 mt-4">
                                                <button type="submit"
                                                    class="btn btn-primary btn-block fw-600 rounded-0">{{  translate('Complete Registration') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        (function ($) {
            "use strict";

            // Init Intl Tel Input
            var phoneInput = document.querySelector("#phone");
            var secondaryPhoneInput = document.querySelector("#secondary_phone");

            var iti = window.intlTelInput(phoneInput, {
                separateDialCode: true,
                utilsScript: "{{ static_asset('assets/js/vendors.js') }}?v=1" // usually included in vendors.js but standard path is utils.js. Assuming vendors has it.
            });

            var iti2 = window.intlTelInput(secondaryPhoneInput, {
                separateDialCode: true,
                utilsScript: "{{ static_asset('assets/js/vendors.js') }}?v=1"
            });

            // On submit, update the input with full number with country code
            $('.form-default').on('submit', function (e) {
                if (iti) {
                    if (iti.isValidNumber()) {
                        $('#phone').val(iti.getNumber());
                    } else {
                        var countryData = iti.getSelectedCountryData();
                        var currentVal = $('#phone').val();
                        if (currentVal.trim() !== "") {
                            $('#phone').val('+' + countryData.dialCode + currentVal);
                        }
                    }
                }
                if (iti2) {
                    if (iti2.isValidNumber()) {
                        $('#secondary_phone').val(iti2.getNumber());
                    } else {
                        var countryData2 = iti2.getSelectedCountryData();
                        var currentVal2 = $('#secondary_phone').val();
                        if (currentVal2.trim() !== "") {
                            $('#secondary_phone').val('+' + countryData2.dialCode + currentVal2);
                        }
                    }
                }
            });


            $(document).on('change', '#country_id', function () {
                var country_id = this.value;
                $.post('{{ route('get-state') }}', {
                    _token: '{{ csrf_token() }}',
                    country_id: country_id
                }, function (data) {
                    $('#state_id').html(JSON.parse(data));
                    $('#city_id').html('<option value="">{{ translate('Select City') }}</option>');
                    $('#area_id').html('<option value="">{{ translate('Select Area') }}</option>');
                    $('#area_select_div').addClass('d-none');
                });
            });

            $(document).on('change', '#state_id', function () {
                var state_id = this.value;
                $.post('{{ route('get-city') }}', {
                    _token: '{{ csrf_token() }}',
                    state_id: state_id
                }, function (data) {
                    $('#city_id').html(JSON.parse(data));
                    $('#area_id').html('<option value="">{{ translate('Select Area') }}</option>');
                    $('#area_select_div').addClass('d-none');
                });
            });

            $(document).on('change', '#city_id', function () {
                var city_id = this.value;
                $.post('{{ route('get-area') }}', {
                    _token: '{{ csrf_token() }}',
                    city_id: city_id
                }, function (data) {
                    var areas = JSON.parse(data);
                    // Check if areas has options other than placeholder
                    // The get-area route returns HTML options string
                    // We can put it in the select and check children
                    $('#area_id').html(areas);
                    if ($('#area_id option').length > 1) {
                        $('#area_select_div').removeClass('d-none');
                    } else {
                        $('#area_select_div').addClass('d-none');
                    }
                });
            });

            // When area dropdown changes, fill the text input
            $(document).on('change', '#area_id', function () {
                var selectedText = $("#area_id option:selected").text();
                if (this.value !== "") {
                    $('#area').val(selectedText);
                }
            });

        })(jQuery);
    </script>
@endsection