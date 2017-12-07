<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tokos';

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
        'nama', 'alamat', 'status'
    ];

    public function getStatus() {
        $status = ["Tidak Aktif", "Aktif"];

        return $status[$this->status];
    }

    public function formatedDate($date) {
        $date = Date("d M, Y", date_timestamp_get($date));

        return $date;
    }

}
