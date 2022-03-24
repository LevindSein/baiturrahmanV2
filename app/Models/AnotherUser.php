<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnotherUser extends Model
{
    use HasFactory;
    private $type;
    protected $table = 'another_user';
    protected $fillable = [
        'name',
        'hp',
        'address',
        'family',
        'muzakki',
        'stt_muzakki',
        'mustahik',
        'stt_mustahik',
        'type_mustahik'
    ];

    public static function kategori($type = 7){
        switch ($type) {
            case 1 :
                return 'Fakir';
                break;
            case 2 :
                return 'Miskin';
                break;
            case 3 :
                return 'Fi Sabilillah';
                break;
            case 4 :
                return 'Mualaf';
                break;
            case 5 :
                return 'Gharim';
                break;
            case 6 :
                return 'Ibnu Sabil';
                break;
            case 7 :
                return 'Amil Zakat';
                break;
            case 8 :
                return 'Riqab';
                break;
            default:
                return null;
                break;
        }
    }
}
