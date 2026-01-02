<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithMapping, WithHeadings
{
    protected $ids;

    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        return User::whereIn('id', $this->ids)->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
            'Data of Birth',
            'Address',
            'City',
            'Postal Code',
            'Country',
            'Package',
            'Wallet Balance',
            'Member Since',
        ];
    }

    public function map($user): array
    {
        return [
            $user->name,
            $user->email,
            $user->phone,
            $user->date_of_birth,
            $user->address,
            $user->city,
            $user->postal_code,
            $user->country,
            $user->customer_package ? $user->customer_package->getTranslation('name') : '',
            $user->balance,
            $user->created_at->format('Y-m-d'),
        ];
    }
}
