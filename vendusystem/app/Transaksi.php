<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transaksis';

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
        'toko' ,'user', 'pelanggan', 'tanggal', 'catatan', 'transaksi'
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

    public function getNamaPelanggan() {
        if($this->pelanggan > 0) {
            return $this->getPelanggan->nama;
        }else{
            return "-";
        }
    }

    public function getPelanggan() {
        return $this->hasOne("App\Pelanggan", "id", "pelanggan");
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
            return $this->hasMany("App\MasukTransaksi", "transaksi", "id");
        }else if($this->transaksi == "keluar") {
            return $this->hasMany("App\KeluarTransaksi", "transaksi", "id");
        }else if($this->transaksi == "retur") {
            return $this->hasMany("App\ReturTransaksi", "transaksi", "id");
        }else{
            return null;
        }
    }

    public function formatedDate($date) {
        $date = Date("d M, Y", strtotime($date));

        return $date;
    }

}
