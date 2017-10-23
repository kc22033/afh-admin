<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Species;

class Breed extends Model
{   
    public $timestamps = false;
    protected $table = 'breeds';
    protected $primaryKey = 'id';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function species()
    {
        return $this->belongsTo(Species::class, 'species_id');
    }
}