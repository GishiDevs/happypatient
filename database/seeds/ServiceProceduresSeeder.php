<?php

use Illuminate\Database\Seeder;
use App\ServiceProcedure;

class ServiceProceduresSeeder extends Seeder
{
    
    public function run()
    {   

        // Laboratory Service Procedures
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
            [
             'serviceid' => 4,
             'code' => 'CORONARY RISK PROFILE (FBS, Total Chole, Triglycerides, HDL/LDL)', 
             'procedure' => 'CORONARY RISK PROFILE (FBS, Total Chole, Triglycerides, HDL/LDL)', 
             'price' => 950.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'ROUTINE BLOOD CHEMISTRY (FBS, Total Chole, Triglycerides, Crea, BUA)', 
             'procedure' => 'ROUTINE BLOOD CHEMISTRY (FBS, Total Chole, Triglycerides, Crea, BUA)', 
             'price' => 930.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'LIPID PROFILE (Total Chole, Triglycerides, HDL/LDL)', 
             'procedure' => 'LIPID PROFILE (Total Chole, Triglycerides, HDL/LDL)', 
             'price' => 800.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'CBC', 
             'procedure' => 'CBC', 
             'price' => 150.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Platelet Count', 
             'procedure' => 'Platelet Count', 
             'price' => 100.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'ABO and RH Blood Typing', 
             'procedure' => 'ABO and RH Blood Typing', 
             'price' => 120.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Hemoglobin & Hematocrit (Hgb/Hct)', 
             'procedure' => 'Hemoglobin & Hematocrit (Hgb/Hct)', 
             'price' => 100.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Cell Differential', 
             'procedure' => 'Cell Differential', 
             'price' => 100.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Clotting Time', 
             'procedure' => 'Clotting Time', 
             'price' => 100.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Bleeding Time', 
             'procedure' => 'Bleeding Time', 
             'price' => 100.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Peripheral Blood Smear', 
             'procedure' => 'Peripheral Blood Smear', 
             'price' => 460.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'DENGUE PACKAGE (CBC w/ plt. Ct., Urine, Dengue duo)', 
             'procedure' => 'DENGUE PACKAGE (CBC w/ plt. Ct., Urine, Dengue duo)', 
             'price' => 1200.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Urine Analysis', 
             'procedure' => 'Urine Analysis', 
             'price' => 100.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Pregnancy Test (Urine/Serum)', 
             'procedure' => 'Pregnancy Test (Urine/Serum)', 
             'price' => 200.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Semen Analysis/ Sperm Analysis', 
             'procedure' => 'Semen Analysis/ Sperm Analysis', 
             'price' => 400.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Fecalysis (Direct Smear)', 
             'procedure' => 'Fecalysis (Direct Smear)', 
             'price' => 120.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Occult Blood Test', 
             'procedure' => 'Occult Blood Test', 
             'price' => 270.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'HBsAg Screening (Hepatitis B)', 
             'procedure' => 'HBsAg Screening (Hepatitis B)', 
             'price' => 320.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Anti HAV-IgM (Hepatitis A)', 
             'procedure' => 'Anti HAV-IgM (Hepatitis A)', 
             'price' => 400.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Typhidot', 
             'procedure' => 'Typhidot', 
             'price' => 450.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Dengue duo', 
             'procedure' => 'Dengue duo', 
             'price' => 900.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'RPR/VDRL (Syphilis screening)', 
             'procedure' => 'RPR/VDRL (Syphilis screening)', 
             'price' => 250.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Troponin I', 
             'procedure' => 'Troponin I', 
             'price' => 450.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'KOH', 
             'procedure' => 'KOH', 
             'price' => 150.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 4,
             'code' => 'Gram Stain', 
             'procedure' => 'Gram Stain', 
             'price' => 150.00,
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

        //  X-Ray Service Procedures
        $xray_procedures = [

            [
             'serviceid' => 6,
             'code' => 'Abdomen ( up & sup )', 
             'procedure' => 'Abdomen ( up & sup )', 
             'price' => 600.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 6,
             'code' => 'Abdomen Pedia', 
             'procedure' => 'Abdomen Pedia', 
             'price' => 400.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 6,
             'code' => 'Ankle jt. Unilateral', 
             'procedure' => 'Ankle jt. Unilateral', 
             'price' => 400.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 6,
             'code' => 'Ankle jt. Bilateral', 
             'procedure' => 'Ankle jt. Bilateral', 
             'price' => 600.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 6,
             'code' => 'Cervical APL', 
             'procedure' => 'Cervical APL', 
             'price' => 600.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 6,
             'code' => 'Cervical complete', 
             'procedure' => 'Cervical complete', 
             'price' => 1000.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 6,
             'code' => 'Chest PA', 
             'procedure' => 'Chest PA', 
             'price' => 280.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 6,
             'code' => 'Chest APL (adult)', 
             'procedure' => 'Chest APL (adult)', 
             'price' => 500.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 6,
             'code' => 'Chest APL (pedia)', 
             'procedure' => 'Chest APL (pedia)', 
             'price' => 400.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 6,
             'code' => 'Chest Bucky ', 
             'procedure' => 'Chest Bucky', 
             'price' => 300.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 6,
             'code' => 'Chest Apicogram', 
             'procedure' => 'Chest Apicogram', 
             'price' => 250.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 6,
             'code' => 'Clavicle unilateral', 
             'procedure' => 'Clavicle unilateral', 
             'price' => 300.00,
             'to_diagnose' => 'Y',
            ],
            [
             'serviceid' => 6,
             'code' => 'Clavicle bilateral', 
             'procedure' => 'Clavicle bilateral', 
             'price' => 300.00,
             'to_diagnose' => 'Y',
            ],

         ];
 
 
         foreach ($xray_procedures as $procedure) {
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
