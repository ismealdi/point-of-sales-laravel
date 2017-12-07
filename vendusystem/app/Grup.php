<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grup extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'grups';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jenis', 'nama'
    ];

    public function getJenis() {
        return $this->hasOne("App\Jenis", "id", "jenis");
    }

    public function formatedDate($date) {
        $date = Date("d M, Y", date_timestamp_get($date));

        return $date;
    }

}
