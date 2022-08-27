<?php

namespace App\Faker;

use Faker\Provider\Base;

class CompanyFields extends Base{

    protected static $field_name = [
        'Accounting',
        'Airlines',
        'Alternative Dispatch',
        'Artificial Intelligence',
        'Automotive',
        'Banking',
        'Biotechnology',
        'Broadcast Media',
        'Business Services',
        'Chemical',
        'Civic Engagement',
        'Communications',
        'Computer',
        'Computer Hardware',
        'Computer Software',
        'Construction',
        'Consulting',
        'Consumer Electronics',
        'Consumer Goods',
        'Consumer Services',
        'Data Analytics',
        'Food and Beverage',
        'Government',
        'Healthcare',
        'Hospitality',
        'Insurance',
        'Internet',
        'Investment',
        'Legal',
        'Manufacturing',
        'Media',
        'Non-Profit',
        'Operations',
        'Packaging',
        'Pharmaceutical',
        'Printing',
        'Publishing',
        'Real Estate',
        'Retail',
        'Rental',
        'Security',
        'Semiconductor',
        'Service',
        'Shipping',
        'Repair Shop',
        'Sports',
        'Tobacco',
        'Parfumerals',
        'Telecommunications',
        'Electronic Repair',
        'Phone Service',
        'Computer Customization',
    ];

    public function companyField()
    {
        return static::randomElement(static::$field_name);
    }

}
