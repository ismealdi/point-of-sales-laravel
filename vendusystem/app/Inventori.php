<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventori extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'inventoris';

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
        'toko' ,'user', 'pemasok', 'tanggal', 'catatan', 'transaksi', 'po'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function getNamaUser() {
        if($this->user > 0) {
            return $this->getUser->nama;
        }else{
            return "-";
        }
    }

    public function getUser() {
        return $this->hasOne("App\User", "id", "user");
    }

    public function getNamaPemasok() {
        if($this->pemasok > 0) {
            return $this->getPemasok->nama;
        }else{
            return "-";
        }
    }

    public function getPemasok() {
        return $this->hasOne("App\Pemasok", "id", "pemasok");
    }

    public function getNamaToko() {
        if($this->toko > 0) {
            return $this->getToko->nama;
        }else{
            return "-";
        }
    }

    public function getToko() {
        return $this->hasOne("App\Toko", "id", "toko");
    }

    public function getDaftar() {
        if($this->transaksi == "masuk") {
            return $this->hasMany("App\MasukInventori", "inventori", "id");
        }else if($this->transaksi == "keluar") {
            return $this->hasMany("App\KeluarInventori", "inventori", "id");
        }else if($this->transaksi == "retur") {
            return $this->hasMany("App\ReturInventori", "inventori", "id");
        }else{
            return null;
        }
    }

    public function formatedDate($date) {
        $date = Date("d M, Y", strtotime($date));

        return $date;
    }

}
