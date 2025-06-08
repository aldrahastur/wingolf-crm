<?php

namespace App\Exports;

use App\Models\Membership;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{

    protected $users;
    private mixed $table;
    private ?string $membershipId;

    public function __construct($users, $filter = null)
    {
        $this->users = $users;

        if($filter && array_key_exists('memberships', $filter)) {
            $this->membershipId = $filter['memberships']['value'];
        }

    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->users->map(function($user) {

            $mappedValues =[
                'Letter salutation' => $user->letter_salutation,
                'First name' => $user->first_name,
                'Last name' => $user->last_name,
                'Email' => $user->email,
                'Phone' => $user->phone,
                'Mobile' => $user->mobile,
                'Address' => $user->address,
                'ZIP Code' => $user->zip_code,
                'City' => $user->status,
                'Birthday' => ($user->birthday) ? $user->birthday->format('d.m.Y') : null,
                'Admission Date' => ($user->admission_date) ? $user->admission_date->format('d.m.Y') : null,
                'Status' => ($user->status == 1) ? 'Active' : 'Inactive',
            ];

            if ($this->membershipId) {
                $membership = $user->memberships()->find($this->membershipId);
                $mappedValues['Membership'] = $membership->name;
                $mappedValues['Membership Admission Date'] = $membership->pivot->membership_admission_date;
                $mappedValues['Membership Leave Date'] = $membership->pivot->membership_leave_date;
                $mappedValues['Membership fee required'] = $membership->pivot->fee_required;
                $mappedValues['Membership voluntary payer'] = $membership->pivot->voluntary_payer;
            }

            return $mappedValues;
        });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $headings = [
            'Letter salutation',
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'Mobile',
            'Address',
            'ZIP Code',
            'City',
            'Birthday',
            'Admission Date',
            'Status',
        ];

        if ($this->membershipId) {
            $headings[] = 'Membership';
            $headings[] = 'Membership Admission Date';
            $headings[] = 'Membership Leave Date';
            $headings[] = 'Membership fee required';
            $headings[] = 'Membership voluntary payer';
        }

        return $headings;
    }
}
