<?php

namespace App\Faker;

use Faker\Provider\Base;

class CategoryFields extends Base
{
    protected static $category_fields = [
        'Asking',
        'Bidding',
        'Buy',
        'Sell',
        'Auction',
        'Auctioneer',
        'Consulting',
        'Contract',
        'Deal',
        'Dealer',
        'Demand',
        'Demand Draft',
        'Coding',
        'Design',
        'Development',
        'Documentation',
        'Engineering',
        'Engineering Design',
        'Engineering Development',
        'Engineering Technology',
        'Social',
        'Social Media',
        'Social Networking',
        'PHP',
        'PHP Development',
        'PHP Programming',
        'PHP Programming Language',
        'PHP Programming Language Development',
        'Javascript',
        'Javascript Development',
        'Javascript Programming',
        'Javascript Programming Language',
        'Javascript Programming Language Development',
    ];

    public function categoryFields()
    {
        return static::randomElement(static::$category_fields);
    }
}
