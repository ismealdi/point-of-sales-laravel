<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pemilik extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pemiliks';

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
        'toko', 'nama', 'alamat', 'telepon', 'user'
    ];

    public function getToko() {
        return $this->hasOne("App\Toko", "id", "toko");
    }

    public function getUser() {
        return $this->hasOne("App\User", "id", "user");
    }

    public function getStatus() {
        $status = ["Tidak Aktif", "Aktif"];

        return $status[$this->status];
    }

    public function formatedDate($date) {
        $date = Date("d M, Y", date_timestamp_get($date));

        return $date;
    }

}
