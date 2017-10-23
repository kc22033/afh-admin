<?php namespace App\Models;

use App\Models\Animal;

class AnimalList extends Animal
{   
    protected $hidden = [
        'is_va_releasing_agency',
        'created_at',
        'updated_at',
        'color',
        'origin_id',
        'origin',
        'narrative',
        'pri_breed',
        'sec_breed',
        'sex',
        'status_date'
    ];
    protected $appends = [
        'selected',
        'breed',
        'gender'
    ];

    public function getSelectedAttribute()
    {
        return 0;
    }


    public function getBreedAttribute()
    {
        $sec_breed = (strlen($this->sec_breed)==0 ? '' : ' / ' . $this->sec_breed);
        $mix = ($this->mix ? ' Mix' : ''); 
        return $this->pri_breed . $sec_breed . $mix;
    }

    public function getGenderAttribute()
    {
        switch ($this->sex) {
            case "Female":
                $gender = "F" . ($this->altered ? " / S" : "");
                break;
            case "Male":
                $gender = "M" . ($this->altered ? " / N" : "");
                break;
            default:
                $gender = "Unk";
        }
        return $gender;
    }

}
