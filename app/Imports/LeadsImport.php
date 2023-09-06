<?php

namespace App\Imports;

use App\Models\Lead;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;

class LeadsImport implements ToCollection
{
    protected $leads = [];

    public function collection(Collection $rows)
    {
        $validator = Validator::make($rows->toArray(), [
            '*.0' => 'regex:/^([0-9\+]*)$/' // Assuming the phone number is in the first column of each row
        ]);

        if ($validator->fails()) {
            // Handle validation errors
            // You can throw an exception or log the errors and stop the import process
            // For simplicity, let's just return here
            return;
        }

        foreach ($rows as $row) {
            $phoneNumber = '+' . $row[0]; // Assuming the phone number is in the first column of each row
            if (isset($row[1])) {
                $username = $row[1];
                $existNumber = Lead::where('phone', $phoneNumber)
                    ->orWhere('username', $username)
                    ->first();
            } else {
                $existNumber = Lead::where('phone', $phoneNumber)
                    ->first();
            }

            if ($existNumber) {
                continue;
            }

            // Create a new lead and assign the phone number
            $lead = new Lead();
            $lead->phone = $phoneNumber;
            if (isset($row[1])) {
                $lead->username = $username;
            }
            $lead->status = 5;
            $lead->save();

            $this->leads[] = $lead;
        }
        
        
    }

    public function getLeads()
    {
        return $this->leads;
        
    }
}

