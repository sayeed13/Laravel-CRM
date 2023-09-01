<?php

namespace App\Exports;



use App\Models\Lead;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LeadsExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Lead::with('agent', 'team')->get();
    }

    public function map($lead): array
    {
        $ftdValue = $lead->ftd == 1 ? 'Yes' : 'No';

        $statusLabels = [
            18 => 'Follow Up',
            1 => 'Interested',
            2 => 'Not Interested',
            3 => 'Existing Customer',
            4 => 'Invalid Number',
            5 => 'New',
            6 => 'Switched Off',
            7 => 'Call Busy',
            8 => 'Message Sent',
            9 => 'No Response',
            10 => 'ID Created',
            11 => 'Demo ID Sent',
            12 => 'Call After',
            13 => 'Waiting Response',
            14 => 'Play Later',
            15 => 'No Payment Option',
            16 => 'Blocked Number',
            17 => 'Declined',
        ];
    
        $status = isset($statusLabels[$lead->status]) ? $statusLabels[$lead->status] : '';

        return [
            $lead->agent->name,
            $lead->phone,
            $lead->username,
            $ftdValue,
            $lead->amount,
            $lead->source,
            $status,
            $lead->country,
            $lead->team->team_name,
            Date::dateTimeToExcel($lead->created_at),
        ];
    }

    public function headings(): array
    {
        return [
            'Agent',
            'Phone Number',
            'Username',
            'FTD',
            'FTD Amount',
            'Source',
            'Status',
            'Country',
            'Team',
            'Created At'
        ];
    }
}

