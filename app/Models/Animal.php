<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Excludable;

class Animal extends Model
{   
    use Excludable;

    public $timestamps = true;
    protected $table = 'animals';
    protected $primaryKey = 'id';
    protected $hidden = [];
    protected $appends = [
        'breed',
        'gender',
        'selected'
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
