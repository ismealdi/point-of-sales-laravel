<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'barcodes';

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
        'toko' ,'produk', 'barcode'
    ];

    public function getToko() {
        if($this->toko > 0) {
            return $this->getInfo->nama;
        }else{
            return "Semua Toko";
        }
    }

    public function getInfo() {
        return $this->hasOne("App\Toko", "id", "toko");
    }

    public function getProduk() {
        return $this->hasOne("App\Produk", "id", "produk");
    }

    public function formatedDate($date) {
        $date = Date("d M, Y", date_timestamp_get($date));

        return $date;
    }

}
