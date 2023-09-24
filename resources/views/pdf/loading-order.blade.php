<!DOCTYPE html>
<html>
<head>
	<title>Letter</title>
</head>
<body>
	<div class="main">
		<div class="header" style="text-align: center; min-height: 150px;">
			<div class="part-one" style="width: 20%; float: left; text-align: left;">
				<img src="{{ asset("assets/logo.png") }}" style="width: 150px; height: 130px;">
			</div>
			<div class="part-two" style="width: 60%; float: left; margin-top: 40px;">
				<b>LOADING NOTICE</b>
			</div>
		</div>
		<div class="first-section" style="width: 100%;">
			<table style="width: 100%;">
				<tbody>
					<tr>
						<td style="border: 1px solid #000; padding: 10px;" rowspan="2" colspan="2">
							<p style="margin-bottom: 5px; font-size: 14px;">SHIPPER/EXPORTER</p>
							<p style="margin-bottom: 5px; margin-top: 5px; font-size: 14px;">{{ @$container->shipper->company_name }}</p>
							<p style="margin-bottom: 5px; margin-top: 5px; font-size: 14px;">{{ @$container->shipper->address }}</p>
							<p style="margin-bottom: 5px; margin-top: 5px; font-size: 14px;">TEL:{{ @$container->shipper->phone_number }}, FAX:{{ @$container->shipper->fax }}</p>
							<p style="margin-top: 5px; font-size: 14px;">{{ @$container->shipper->contact_person }}, {{ @$container->shipper->email }}</p>
						</td>
						<td style="border: 1px solid #000; font-size: 10px; padding: 10px;">DOCUMENT NO <span style="font-size: 16px; margin-left: 20px;">BOOKING #{{ @$container->booking_no }}</span></td>
					</tr>
					<tr>
						<td style="border: 1px solid #000; padding: 10px;">
							<p style="font-size: 10px;">EXPORT REFERENCE</p>
							<p style="text-align: center;">REF#{{ @$container->export_referrence }}</p>
						</td>
					</tr>
					<tr>
						<td style="border: 1px solid #000; padding: 10px;" colspan="2">
							<p style="margin-bottom: 5px; font-size: 14px;">CONSIGNEE</p>
							<p style="margin-bottom: 5px; margin-top: 5px; font-size: 14px;">{{ @$container->consignee->company_name }}</p>
							<p style="margin-bottom: 5px; margin-top: 5px; font-size: 14px;">{{ @$container->consignee->address }}</p>
							<p style="margin-bottom: 5px; margin-top: 5px; font-size: 14px;">TEL:{{ @$container->consignee->phone_number }}</p>
							<p style="margin-top: 5px; font-size: 14px;">{{ @$container->consignee->email }}</p>
						</td>
						<td style="border: 1px solid #000; padding: 10px;">
							<p style="font-size: 10px;">FORWARDING AGENT</p>
							<p style="text-align: center;"></p>
						</td>
					</tr>
					<tr>
						<td style="border: 1px solid #000; padding: 10px;" colspan="2">
							<p style="font-size: 10px;">NOTIFY PART</p>
							<p>{{ @$container->notify_party->name }}</p>
						</td>
						<td style="border: 1px solid #000; padding: 10px;">
							<p style="font-size: 10px;">DOMESTIC ROUTING/EXPORT INSTRUCTIONS</p>
							<b>AES ITN: {{ @$container->aes_nr_itn }}</b>
						</td>
					</tr>
					<tr>
						<td style="border: 1px solid #000; padding: 10px;" rowspan="2">
							<p style="font-size: 10px;">OCEAN/VESSEL</p>
							<p>{{ @$container->vessel_name }}</p>
							<p style="font-size: 10px; margin-top: 20px;">DATE OF SAIL</p>
							<b>09/03/2023</b>
						</td>
						<td style="border: 1px solid #000; padding: 10px;">
							<p style="font-size: 10px;">PORT OF LOADING</p>
							<b>{{ @$container->loading_port->name }}</b>
						</td>
						<td style="border: 1px solid #000; padding: 10px;" rowspan="2">
							<p style="font-size: 10px;">ONWARD INLAND ROUTING</p>
							<b style="color: red;">DDF, DHC, PSI-COLLECT</b>
						</td>
					</tr>
					<tr>
						<td style="border: 1px solid #000; padding: 10px;">
							<p style="font-size: 10px;">PORT OF DISCHARGE</p>
							<b>{{ @$container->discharge_port->name }}</b>
						</td>
					</tr>
				</tbody>
			</table>
			<table style="width: 100%;">
				<tbody>
					<tr>
						<td style="border: 1px solid #000; padding: 10px; text-align: center;" colspan="2">
							<b style="font-size: 12px;">CARRIER'S RECEIPT</b>
						</td>
						<td style="border: 1px solid #000; padding: 10px; text-align: center;" colspan="3">
							<b style="font-size: 12px;">PARTICULARS FURNISHED BY SHIPPER</b>
						</td>
					</tr>
					<tr>
						<td style="border: 1px solid #000; padding: 10px; text-align: center;">
							<b style="font-size: 12px;">MARKS AND NUMBERS</b>
						</td>
						<td style="border: 1px solid #000; padding: 10px; text-align: center;">
							<b style="font-size: 12px;">NUMBER OF CARGO UNITS OR OTHER PACKAGES</b>
						</td>
						<td style="border: 1px solid #000; padding: 10px; text-align: center;">
							<b style="font-size: 12px;">DESCRIPTION OF GOODS</b>
						</td>
						<td style="border: 1px solid #000; padding: 10px; text-align: center;">
							<b style="font-size: 12px;">GROSS WEIGHT</b>
						</td>
						<td style="border: 1px solid #000; padding: 10px; text-align: center;">
							<b style="font-size: 12px;">MEASUREMENT</b>
						</td>
					</tr>
					<tr>
						<td style="border: 1px solid #000; padding: 10px;">
							<p><b style="font-size: 10px;">SEAL#</b></p>
							<p><b style="font-size: 10px;">CONTAINER #</b></p>
						</td>
						<td style="border: 1px solid #000; padding: 10px; text-align: center;">
							<p style="font-size: 14px;">{{ count(@$vehicle) }}</p>
						</td>
						<td style="border: 1px solid #000; padding: 10px;">
							<p style="margin-bottom: 15px; font-size: 14px;">S.T.C.{{ count(@$vehicle) }} UNITS:</p>
							@if(count(@$vehicle) > 0)
							@foreach(@$vehicle as $key => $value)
							<p style="margin-bottom: 5px; margin-top: 5px; font-size: 12px;">{{ @$value->vehicle->modal.' '.@$value->vehicle->company_name.' '.@$value->vehicle->name }}</p>
							<p style="margin-bottom: 5px; margin-top: 5px; font-size: 12px;">VIN:{{ @$value->vehicle->vin }}</p>
							@endforeach
							@endif
							<p style="margin-bottom: 5px; margin-top: 15px; font-size: 12px;">SIGNATURE <input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;"></p>
							<p style="margin-top: 5px; margin-bottom: 5px; font-size: 12px;">GAS HAS BEEN DRAINED, BATTERIES DISCONNECTED</p>
							<p style="margin-top: 5px; margin-bottom: 5px; font-size: 12px;">FREIGHT PREPAID. DDF, DHC, PSI COLLECT</p>
							<b style="margin-top: 5px; font-size: 14px; color: red;">EXPRESS RELEASE</b>
						</td>
						<td style="border: 1px solid #000; padding: 10px;">
							@if(count(@$vehicle) > 0)
							@foreach(@$vehicle as $key => $value)
							<p style="margin-bottom: 5px; margin-top: 10px; font-size: 12px;">{{ @$value->vehicle->weight }} KG</p>
							@endforeach
							@endif
						</td>
						<td style="border: 1px solid #000; padding: 10px;">
							<p style="margin-bottom: 5px; margin-top: 10px; font-size: 12px;">{{ @$container->measurement->name }}</p>
						</td>
					</tr>
				</tbody>
			</table>
			<table style="width: 100%;">
				<tbody>
					<tr>
						<td style="border: 1px solid #000; padding: 10px; width: 40%;">
							<p style="margin-bottom: 5px; font-size: 14px; text-align: center;">DELIVERED BY:</p>
							<p style="margin-bottom: 5px; margin-top: 15px; font-size: 12px;">LIGHTER TRUCK <input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;"></p>
							<p style="margin-bottom: 5px; margin-top: 5px; font-size: 12px;">ARRIVED <input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;"> TIME <input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;"></p>
							<p style="margin-bottom: 5px; margin-top: 5px; font-size: 12px;">DATE UNLOADED <input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;"> TIME <input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;"></p>
							<p style="margin-bottom: 5px; margin-top: 5px; font-size: 12px;">DATE CHECKED BY <input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;"></p>
							<p style="margin-top: 5px; font-size: 12px;">IN SHIP PLACED ON DOCK LOCATION <input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;"></p>
						</td>
						<td style="border: 1px solid #000; padding: 10px; width: 60%;">
							<p style="margin-bottom: 5px; font-size: 12px;">RECEIVED THE ABOVE DESCRIBED GOOD OR PACKAGES SUBJECT TO ALL THE TERMS OF THE UNDESIGNED'S REGULAR FORM OF DOCK RECEIPT AND BILL OF LADING WICH SHELL CONSTITUTE THE CON-TRACT UNDER WHICH THE GOODS ARE RECEIVED, COPIES OF WHICH ARE AVAILABLE FROM THE CARRIER ON REQUEST AND MAY BE INSPECTED AT ANY OF ITS OFFICES</p>
							<p style="margin-bottom: 5px; margin-top: 5px; font-size: 12px;"><input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;"></p>
							<p style="margin-bottom: 5px; margin-top: 5px; font-size: 12px;">FOR THE MASTER</p>
							<p style="margin-bottom: 5px; margin-top: 5px; font-size: 12px;">BY <input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;"></p>
							<p style="margin-bottom: 5px; margin-top: 5px; font-size: 12px;">RECEIVING CLERK</p>
							<p style="margin-top: 5px; font-size: 14px;">DATE <input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;"></p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>