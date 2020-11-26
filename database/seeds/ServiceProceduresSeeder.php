<?php

use Illuminate\Database\Seeder;
use App\ServiceProcedure;

class ServiceProceduresSeeder extends Seeder
{
    
    public function run()
    {
        $laboratory_procedures = [
            [
             'serviceid' => 4,
             'code' => 'Hemoglobin A1c (HBa1c/Glycosylated/Glycated Hemoglobin)', 
             'procedure' => 'Hemoglobin A1c (HBa1c/Glycosylated/Glycated Hemoglobin)', 
             'price' => 850.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Fasting Blood Sugar (FBS)', 
             'procedure' => 'Fasting Blood Sugar (FBS)', 
             'price' => 150.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Total Cholesterol', 
             'procedure' => 'Total Cholesterol', 
             'price' => 200.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Triglycerides', 
             'procedure' => 'Triglycerides', 
             'price' => 250.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'HDL/LDL', 
             'procedure' => 'HDL/LDL', 
             'price' => 350.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Blood Uric Acid (BUA)', 
             'procedure' => 'Blood Uric Acid (BUA)', 
             'price' => 150.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Creatinine', 
             'procedure' => 'Creatinine', 
             'price' => 180.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Blood Urea Nitrogen (BUN)', 
             'procedure' => 'Blood Urea Nitrogen (BUN)', 
             'price' => 150.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'SGOT/AST', 
             'procedure' => 'SGOT/AST', 
             'price' => 250.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'SGPT/ALT', 
             'procedure' => 'SGPT/ALT', 
             'price' => 250.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Potassium', 
             'procedure' => 'Potassium', 
             'price' => 350.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Sodium', 
             'procedure' => 'Sodium', 
             'price' => 350.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Sodium', 
             'procedure' => 'Sodium', 
             'price' => 350.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Sodium', 
             'procedure' => 'Sodium', 
             'price' => 350.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Prostate Specific Antigen (PSA)', 
             'procedure' => 'Prostate Specific Antigen (PSA)', 
             'price' => 950.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Thyroid Stimulating Hormone (TSH)', 
             'procedure' => 'Thyroid Stimulating Hormone (TSH)', 
             'price' => 800.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'FT3 (Free Triiodothyronine)', 
             'procedure' => 'FT3 (Free Triiodothyronine)', 
             'price' => 700.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'FT4 (Free Thyroxine)', 
             'procedure' => 'FT4 (Free Thyroxine)', 
             'price' => 700.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'T3 (Triiodothyronine)', 
             'procedure' => 'T3 (Triiodothyronine)', 
             'price' => 600.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'T4 (Thyroxine)', 
             'procedure' => 'T4 (Thyroxine)', 
             'price' => 600.00,
             'to_diagnose' => 'Y',
            ],

         ];
 
 
         foreach ($laboratory_procedures as $procedure) {
            ServiceProcedure::create([
                'serviceid' => $procedure['serviceid'],
                'code' => $procedure['code'], 
                'procedure' => $procedure['procedure'], 
                'price' => $procedure['price'], 
                'to_diagnose' => $procedure['to_diagnose'], 
                ]);
         }
    }
}
