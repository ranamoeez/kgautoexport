<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendVehicle extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->subject("Vehicle | K&G Auto Export")->view('email.send-vehicle');
        if (!empty($this->data->vehicle_documents)) {
            foreach ($this->data->vehicle_documents as $key => $value) {
                $data = $data->attach("http://kgautoexport.s3-website.eu-north-1.amazonaws.com/".$value->filename);
            }
        } else if (!empty($this->data->vehicle->vehicle_documents)) {
            foreach ($this->data->vehicle->vehicle_documents as $key => $value) {
                $data = $data->attach("http://kgautoexport.s3-website.eu-north-1.amazonaws.com/".$value->filename);
            }
        }
        if (!empty($this->data->vehicle_images)) {
            foreach ($this->data->vehicle_images as $key => $value) {
                $data = $data->attach("http://kgautoexport.s3-website.eu-north-1.amazonaws.com/".$value->filename);
            }
        } else if (!empty($this->data->vehicle->vehicle_images)) {
            foreach ($this->data->vehicle->vehicle_images as $key => $value) {
                $data = $data->attach("http://kgautoexport.s3-website.eu-north-1.amazonaws.com/".$value->filename);
            }
        }
        return $data;
    }
}