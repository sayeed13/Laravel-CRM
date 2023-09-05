<?php

namespace App\Exports;

use App\Models\Lead;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NotesExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    protected $startDate;
    protected $endDate;


    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Lead::with(['notes' => function ($query) {
            return $query->select('lead_id', 'text')->latest();
        }, 'agent'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->has('notes')
            ->latest()
            ->get();
    }


    public function map($lead): array
    {

        $statusLabels = [
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
            18 => 'Follow Up',
        ];

        $status = isset($statusLabels[$lead->status]) ? $statusLabels[$lead->status] : '';
        $noteText = $lead->notes->isNotEmpty() ? $lead->notes->last()->text : '';


        return [
            $lead->phone,
            $noteText,
            $status,
            $lead->agent->name,
            Date::dateTimeToExcel($lead->created_at),
        ];
    }

    public function headings(): array
    {
        return [
            'Phone Number',
            'Note',
            'Status',
            'Agent',
            'Created At'
        ];
    }
}
