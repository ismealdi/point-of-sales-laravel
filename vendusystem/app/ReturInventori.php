<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturInventori extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'retur_inventoris';

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
        'inventori' ,'produk', 'satuan', 'harga', 'jumlah', 'total'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function getInventori() {
        return $this->hasOne("App\Inventori", "id", "inventori");
    }

    public function getProduk() {
        return $this->hasOne("App\Produk", "id", "produk");
    }

    public function getSatuan() {
        return $this->hasOne("App\Satuan", "id", "satuan");
    }


    public function formatedDate($date) {
        $date = Date("d M, Y", date_timestamp_get($date));

        return $date;
    }

}
