<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ContainerImage;
use App\Models\ContStatus;
use App\Models\Shipper;
use App\Models\ShippingLine;
use App\Models\Consignee;
use App\Models\PreCarriage;
use App\Models\LoadingPort;
use App\Models\DischargePort;
use App\Models\DestinationPort;
use App\Models\NotifyParty;
use App\Models\Terminal;
use App\Models\Measurement;
use Illuminate\Database\Eloquent\SoftDeletes;

class Container extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'status_id', 'shipper_id', 'shipping_line_id', 'consignee_id', 'pre_carriage_id', 'vessel_name', 'location', 'loading_port_id', 'discharge_port_id', 'destination_port_id', 'notify_part_id', 'booking_no', 'container_no', 'cut_off', 'departure', 'arrival', 'pier_terminal_id', 'contract_no', 'voyage_no', 'seal_no', 'export_reference', 'domestic_routing', 'measurement_id', 'aes_nr_xtn', 'aes_nr_itn', 'invoice_date', 'invoice_term', 'date_for_letter', 'draft', 'owner_id', 'arrival_ym', 'request_type', 'date_created', 'search_body', 'aes_block_body', 'all_paid', 'fowarding_agent_id', 'vgm', 'notes_document'
    ];

    public function container_documents(){
    	return $this->hasMany(ContainerImage::class, 'container_id');
    }

    public function status(){
    	return $this->belongsTo(ContStatus::class, 'status_id');
    }

    public function shipper(){
    	return $this->belongsTo(Shipper::class, 'shipper_id');
    }

    public function shipping_line(){
    	return $this->belongsTo(ShippingLine::class, 'shipping_line_id');
    }

    public function consignee(){
    	return $this->belongsTo(Consignee::class, 'consignee_id');
    }

    public function pre_carriage(){
    	return $this->belongsTo(PreCarriage::class, 'pre_carriage_id');
    }

    public function loading_port(){
    	return $this->belongsTo(LoadingPort::class, 'loading_port_id');
    }

    public function discharge_port(){
    	return $this->belongsTo(DischargePort::class, 'discharge_port_id');
    }

    public function destination_port(){
    	return $this->belongsTo(DestinationPort::class, 'destination_port_id');
    }

    public function notify_party(){
    	return $this->belongsTo(NotifyParty::class, 'notify_part_id');
    }

    public function pier_terminal(){
    	return $this->belongsTo(Terminal::class, 'pier_terminal_id');
    }

    public function measurement(){
    	return $this->belongsTo(Measurement::class, 'measurement_id');
    }
}
