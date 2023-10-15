<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VehicleImage;
use App\Models\VehicleDocuments;
use App\Models\Auction;
use App\Models\AuctionLocation;
use App\Models\Terminal;
use App\Models\DestinationPort;
use App\Models\Status;
use App\Models\User;
use App\Models\Fine;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'auction_id', 'address', 'location', 'transportation_address', 'pickup_address', 'delivery_address', 'towing_price', 'us_towing_price', 'us_trans_fines', 'occean_freight', 'auction_location_id', 'draft', 'status_id', 'buyer_id', 'company_name', 'name', 'modal', 'lotnumber', 'notes', 'transportation_notes', 'car_price', 'transport_price', 'auction_price', 'service_fee', 'draft_expenses', 'destination_port_id', 'purchase_date', 'terminal_id', 'dispatch_date', 'due_date', 'delivery_date', 'delivered_on_date', 'vin', 'operable', 'keys', 'title', 'engine', 'usetype_id', 'bodytrim_id', 'class_id', 'weight', 'fuel_type', 'owner_id', 'container_buyer_id', 'paid_price', 'all_paid', 'paid_date', 'pdate', 'delivered_on_date_ym', 'pickup_date', 'search_body', 'auction_buyer', 'destination_manual', 'client_name', 'carrier', 'position', 'has_photo', 'ref', 'notes_user', 'notes_document', 'notes_financial', 'notes_user_financial', 'update_destination', 'at_terminal_date'
    ];

    public function vehicle_images(){
    	return $this->hasMany(VehicleImage::class, 'vehicle_id');
    }

    public function vehicle_documents(){
        return $this->hasMany(VehicleDocuments::class, 'vehicle_id');
    }

    public function fines(){
        return $this->hasMany(Fine::class, 'vehicle_id');
    }

    public function auction(){
    	return $this->belongsTo(Auction::class, 'auction_id');
    }

    public function auction_location(){
        return $this->belongsTo(AuctionLocation::class, 'auction_location_id');
    }

    public function terminal(){
    	return $this->belongsTo(Terminal::class, 'terminal_id');
    }

    public function destination_port(){
        return $this->belongsTo(DestinationPort::class, 'destination_port_id');
    }

    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function buyer(){
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
