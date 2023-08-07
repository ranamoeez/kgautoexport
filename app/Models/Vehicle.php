<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VehicleImage;
use App\Models\Auction;
use App\Models\Terminal;
use App\Models\Status;
use App\Models\User;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_id', 'auction_location_id', 'draft', 'status_id', 'buyer_id', 'description', 'lotnumber', 'notes', 'car_price', 'transport_price', 'auction_price', 'service_fee', 'draft_expenses', 'destination_port_id', 'purchase_date', 'terminal_id', 'dispatch_date', 'delivery_date', 'delivered_on_date', 'vin', 'operable', 'keys', 'title', 'engine', 'usetype_id', 'bodytrim_id', 'class_id', 'weight', 'owner_id', 'container_buyer_id', 'paid_price', 'all_paid', 'pdate', 'delivered_on_date_ym', 'pickup_date', 'search_body', 'auction_buyer', 'destination_manual', 'client_name', 'carrier', 'position', 'has_photo', 'ref', 'notes_user', 'notes_document'
    ];

    public function vehicle_images(){
    	return $this->hasMany(VehicleImage::class, 'vehicle_id');
    }

    public function auction(){
    	return $this->belongsTo(Auction::class, 'auction_id');
    }

    public function terminal(){
    	return $this->belongsTo(Terminal::class, 'terminal_id');
    }

    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function buyer(){
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
