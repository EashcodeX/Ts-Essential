@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{translate('Customer Details')}}</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="{{ route('customers.index') }}" class="btn btn-circle btn-info">
                    <span>{{translate('Back to List')}}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">
                {{translate('Customer Information')}}
                @if($customer->banned == 1)
                    <span class="badge badge-inline badge-danger ml-2">{{translate('Banned')}}</span>
                @endif
                @if($customer->is_suspicious == 1)
                    <span class="badge badge-inline badge-warning ml-2">{{translate('Suspicious')}}</span>
                @endif
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Personal Information -->
                <div class="col-lg-6">
                    <div class="card shadow-sm mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">{{translate('Personal Information')}}</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="text-muted" width="40%">{{translate('Full Name')}}</td>
                                    <td class="fw-600">{{$customer->name}}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{translate('Email')}}</td>
                                    <td class="fw-600">
                                        {{$customer->email ?? translate('N/A')}}
                                        @if($customer->email_verified_at != null)
                                            <span class="badge badge-inline badge-success ml-1">{{translate('Verified')}}</span>
                                        @else
                                            <span
                                                class="badge badge-inline badge-warning ml-1">{{translate('Unverified')}}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{translate('Phone')}}</td>
                                    <td class="fw-600">{{$customer->phone ?? translate('N/A')}}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{translate('Gender')}}</td>
                                    <td class="fw-600">{{$customer->gender ? ucfirst($customer->gender) : translate('N/A')}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{translate('Date of Birth')}}</td>
                                    <td class="fw-600">
                                        {{$customer->date_of_birth ? date('d M, Y', strtotime($customer->date_of_birth)) : translate('N/A')}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="col-lg-6">
                    <div class="card shadow-sm mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">{{translate('Address Information')}}</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="text-muted" width="40%">{{translate('Address')}}</td>
                                    <td class="fw-600">{{$customer->address ?? translate('N/A')}}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{translate('City')}}</td>
                                    <td class="fw-600">{{$customer->city ?? translate('N/A')}}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{translate('Postal Code')}}</td>
                                    <td class="fw-600">{{$customer->postal_code ?? translate('N/A')}}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{translate('Country')}}</td>
                                    <td class="fw-600">{{$customer->country ?? translate('N/A')}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="col-lg-6">
                    <div class="card shadow-sm mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">{{translate('Account Information')}}</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="text-muted" width="40%">{{translate('Customer Package')}}</td>
                                    <td class="fw-600">
                                        @if ($customer->customer_package != null)
                                            {{$customer->customer_package->getTranslation('name')}}
                                        @else
                                            {{translate('N/A')}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{translate('Wallet Balance')}}</td>
                                    <td class="fw-600">{{single_price($customer->balance)}}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{translate('Remaining Uploads')}}</td>
                                    <td class="fw-600">
                                        @if ($customer->customer_package != null)
                                            {{$customer->remaining_uploads}}
                                        @else
                                            {{translate('N/A')}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{translate('Member Since')}}</td>
                                    <td class="fw-600">{{date('d M, Y', strtotime($customer->created_at))}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Additional Contact -->
                <div class="col-lg-6">
                    <div class="card shadow-sm mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">{{translate('Additional Contact')}}</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="text-muted" width="40%">{{translate('Primary Phone')}}</td>
                                    <td class="fw-600">{{$customer->primary_phone ?? translate('N/A')}}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{translate('Secondary Phone')}}</td>
                                    <td class="fw-600">{{$customer->secondary_phone ?? translate('N/A')}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Account Status -->
                <div class="col-lg-12">
                    <div class="card shadow-sm mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">{{translate('Account Status')}}</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="text-center p-3 border rounded">
                                        <div class="text-muted mb-2">{{translate('Email Verification')}}</div>
                                        @if($customer->email_verified_at != null)
                                            <span class="badge badge-success">{{translate('Verified')}}</span>
                                        @else
                                            <span class="badge badge-warning">{{translate('Unverified')}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center p-3 border rounded">
                                        <div class="text-muted mb-2">{{translate('Ban Status')}}</div>
                                        @if($customer->banned == 1)
                                            <span class="badge badge-danger">{{translate('Banned')}}</span>
                                        @else
                                            <span class="badge badge-success">{{translate('Active')}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center p-3 border rounded">
                                        <div class="text-muted mb-2">{{translate('Suspicious Status')}}</div>
                                        @if($customer->is_suspicious == 1)
                                            <span class="badge badge-warning">{{translate('Suspicious')}}</span>
                                        @else
                                            <span class="badge badge-success">{{translate('Normal')}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center p-3 border rounded">
                                        <div class="text-muted mb-2">{{translate('User Type')}}</div>
                                        <span class="badge badge-info">{{ucfirst($customer->user_type)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection