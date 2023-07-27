<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_id', 'shipper_id', 'shipping_line_id', 'consignee_id', 'pre_carriage_id', 'vessel_name', 'loading_port_id', 'discharge_port_id', 'destination_port_id', 'notify_part_id', 'booking_no', 'container_no', 'cut_off', 'departure', 'arrival', 'pier_terminal_id', 'contract_no', 'voyage_no', 'seal_no', 'export_reference', 'domestic_routing', 'measurement_id', 'aes_nr_xtn', 'aes_nr_itn', 'invoice_date', 'invoice_term', 'date_for_letter', 'draft', 'owner_id', 'arrival_ym', 'request_type', 'date_created', 'search_body', 'aes_block_body', 'all_paid', 'fowarding_agent_id', 'vgm', 'notes_document'
    ];
}
