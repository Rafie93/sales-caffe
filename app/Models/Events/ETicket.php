<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ETicket extends Model
{
    use HasFactory;
    protected $table = "e_tickets";
    protected $fillable = ["sales_event_id","event_id","participant_name","phone","status"];
    
    public function events()
    {
        return $this->belongsTo("App\Models\Events\Event","event_id");

    }
    function isStatus()
    {
        $st = $this->status;
        if ($st==1) {
           return "E-Tiket";
        }else if ($st==2) {
              return "Digunakan";
        }else{
            return "Expired";
        }
    }
}
