<!DOCTYPE html>
<html>
<head>
	<title>Letter</title>
</head>
<body>
	<div class="main">
		<div class="header" style="text-align: center; margin-top: 50px;">
			<p>LETTER OF INTENT FOR VEHICLE EXPORTS</p>
			<p>PORT OF SAVANNAH, GEORGIA</p>
		</div>
		<div class="first-section" style="width: 100%; min-height: 180px;">
			<div class="part-one" style="width: 33%; float: left;">
				<p style="margin-bottom: 5px; font-size: 14px;">TO:</p>
				<p style="margin-bottom: 5px; margin-top: 5px; font-size: 14px;">ATTN:EXODUS TEAM</p>
				<p style="margin-bottom: 5px; margin-top: 5px; font-size: 14px;">U.S.Customs and Border Protection</p>
				<p style="margin-bottom: 5px; margin-top: 5px; font-size: 14px;">139 Southern Boulevard</p>
				<p style="margin-bottom: 5px; margin-top: 5px; font-size: 14px;">Savannah, GA 31405</p>
			</div>
			<div class="part-two" style="width: 33%; float: left; text-align: center;">
				<img src="{{ asset("assets/logo.png") }}" style="width: 170px; height: 150px;">
			</div>
			<div class="part-three" style="width: 33%; float: left; text-align: right;">
				<p style="margin-bottom: 5px;">Ph: (912) 721-4840</p>
				<p style="margin-bottom: 5px; margin-top: 5px;">Fax: (912) 721-4847</p>
			</div>
		</div>
		<div class="second-section" style="width: 100%; min-height: 140px;">
			<table style="width: 100%;">
				<thead>
					<tr style="text-align: center;">
						<td colspan="6" style="border: 1px solid #000;">***US Customs and Border Protection Personnel Only***</td>
					</tr>
				</thead>
				<tbody>
					<tr style="text-align: center;">
						<td style="border: 1px solid #000;"></td>
						<td style="border: 1px solid #000;">INITIALS</td>
						<td style="border: 1px solid #000;">DATE</td>
						<td style="border: 1px solid #000;"></td>
						<td style="border: 1px solid #000;">INITIALS</td>
						<td style="border: 1px solid #000;">DATE</td>
					</tr>
					<tr>
						<td style="border: 1px solid #000;">DOCUMENT EXAMINED</td>
						<td style="border: 1px solid #000;"></td>
						<td style="border: 1px solid #000;"></td>
						<td style="border: 1px solid #000;">AES/SED CHECKED</td>
						<td style="border: 1px solid #000;"></td>
						<td style="border: 1px solid #000;"></td>
					</tr>
					<tr>
						<td style="border: 1px solid #000;">VIN Checked in NCCI And NICB</td>
						<td style="border: 1px solid #000;"></td>
						<td style="border: 1px solid #000;"></td>
						<td style="border: 1px solid #000;">AES/SED EXAM</td>
						<td style="border: 1px solid #000;"></td>
						<td style="border: 1px solid #000;"></td>
					</tr>
					<tr>
						<td style="border: 1px solid #000;">FAXED TO NICB</td>
						<td style="border: 1px solid #000;"></td>
						<td style="border: 1px solid #000;"></td>
						<td style="border: 1px solid #000;"></td>
						<td style="border: 1px solid #000;"></td>
						<td style="border: 1px solid #000;"></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="third-section" style="width: 100%; min-height: 130px;">
			<p style="margin-bottom: 5px; font-size: 12px;">***Note: Additional Containers and/or Vehicles Maybe Listed on Additional Pages Following Format***</p>
			<p style="margin-bottom: 5px; margin-top: 5px; font-size: 12px;">Date: 08/25/2023</p>
			<p style="margin-bottom: 5px; margin-top: 5px; font-size: 12px;">The following are documents for the vehicles we have booked with our lines. The sailing and vontainer information,</p>
			<p style="margin-bottom: 5px; margin-top: 5px; font-size: 12px;">Including the locations of the cardo has been listed below. If you need any further information please contact:</p>
		</div>
		<div class="fourth-section" style="width: 100%; min-height: 50px;">
			<div class="part-one" style="width: 19%; float: left;">
				<p style="margin-bottom: 5px; margin-top: 0px;">Container Number:</p>
			</div>
			<div class="part-two" style="width: 30%; float: left;">
				<input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;" value="{{ @$container->container_no }}">
			</div>
			<div class="part-one" style="width: 19%; float: left; margin-left: 20px;">
				<p style="margin-bottom: 5px; margin-top: 0px;">Booking Number:</p>
			</div>
			<div class="part-two" style="width: 30%; float: left;">
				<input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;" value="{{ @$container->booking_no }}">
			</div>
		</div>
		<div class="fourth-section" style="width: 100%; min-height: 50px;">
			<div class="part-one" style="width: 19%; float: left;">
				<p style="margin-bottom: 5px; margin-top: 0px;">POC Name:</p>
			</div>
			<div class="part-two" style="width: 30%; float: left;">
				<input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;" value="TOMAS ICKOVIC">
			</div>
			<div class="part-one" style="width: 19%; float: left; margin-left: 20px;">
				<p style="margin-bottom: 5px; margin-top: 0px;">POC Company:</p>
			</div>
			<div class="part-two" style="width: 30%; float: left;">
				<input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;" value="JAX AUTO SHIPPING">
			</div>
		</div>
		<div class="fourth-section" style="width: 100%; min-height: 50px;">
			<div class="part-one" style="width: 19%; float: left;">
				<p style="margin-bottom: 5px; margin-top: 0px;">POC Phone#:</p>
			</div>
			<div class="part-two" style="width: 30%; float: left;">
				<input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;" value="912-234-8984">
			</div>
			<div class="part-one" style="width: 19%; float: left; margin-left: 20px;">
				<p style="margin-bottom: 5px; margin-top: 0px;">POC Fax#:</p>
			</div>
			<div class="part-two" style="width: 30%; float: left;">
				<input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;" value="912-234-8985">
			</div>
		</div>
		<div class="fourth-section" style="width: 100%; min-height: 50px;">
			<div class="part-one" style="width: 19%; float: left;">
				<p style="margin-bottom: 5px; margin-top: 0px;">AES Number XTN:</p>
			</div>
			<div class="part-two" style="width: 30%; float: left;">
				<input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;" value="{{ @$container->export_reference }}">
			</div>
			<div class="part-one" style="width: 19%; float: left; margin-left: 20px;">
				<p style="margin-bottom: 5px; margin-top: 0px;">AES Number ITN:</p>
			</div>
			<div class="part-two" style="width: 30%; float: left;">
				<input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;" value="{{ @$container->aes_nr_itn }}">
			</div>
		</div>
		<div class="fourth-section" style="width: 100%; min-height: 50px;">
			<div class="part-one" style="width: 19%; float: left;">
				<p style="margin-bottom: 5px; margin-top: 0px;">Shipping Line:</p>
			</div>
			<div class="part-two" style="width: 30%; float: left;">
				<input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;" value="{{ @$container->shipping_line->name }}">
			</div>
			<div class="part-one" style="width: 19%; float: left; margin-left: 20px;">
				<p style="margin-bottom: 5px; margin-top: 0px;">SCAC Code:</p>
			</div>
			<div class="part-two" style="width: 30%; float: left;">
				<input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;">
			</div>
		</div>
		<div class="fourth-section" style="width: 100%; min-height: 50px;">
			<div class="part-one" style="width: 19%; float: left;">
				<p style="margin-bottom: 5px; margin-top: 0px;">Country of Final Destination:</p>
			</div>
			<div class="part-two" style="width: 30%; float: left;">
				<input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;" value="{{ @$container->destination_port->name }}">
			</div>
			<div class="part-one" style="width: 19%; float: left; margin-left: 20px;">
				<p style="margin-bottom: 5px; margin-top: 0px;">Vessel Name:</p>
			</div>
			<div class="part-two" style="width: 30%; float: left;">
				<input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;" value="{{ @$container->vessel_name }}">
			</div>
		</div>
		<div class="fourth-section" style="width: 100%; min-height: 50px;">
			<div class="part-one" style="width: 19%; float: left;">
				<p style="margin-bottom: 5px; margin-top: 0px;">Arrival Date:</p>
			</div>
			<div class="part-two" style="width: 30%; float: left;">
				<input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;" value="{{ @$container->arrival }}">
			</div>
			<div class="part-one" style="width: 19%; float: left; margin-left: 20px;">
				<p style="margin-bottom: 5px; margin-top: 0px;">Departure Date:</p>
			</div>
			<div class="part-two" style="width: 30%; float: left;">
				<input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;" value="{{ @$container->departure }}">
			</div>
		</div>
		<div class="fourth-section" style="width: 100%; min-height: 100px;">
			<div class="part-one" style="width: 19%; float: left;">
				<p style="margin-bottom: 5px; margin-top: 0px;">Location of Cargo:</p>
			</div>
			<div class="part-two" style="width: 80%; float: left;">
				<input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;" value="PORT">
			</div>
		</div>
		@if(count(@$vehicle) > 0)
		@foreach(@$vehicle as $key => $value)
		<div class="fourth-section" style="width: 100%; min-height: 50px;">
			<div class="part-one" style="width: 9%; float: left;">
				<p style="margin-bottom: 5px; margin-top: 0px;">{{ $key+1 }}. VIN#</p>
			</div>
			<div class="part-two" style="width: 35%; float: left;">
				<input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;" value="{{ @$value->vehicle->vin }}">
			</div>
			<div class="part-one" style="width: 19%; float: left; margin-left: 20px;">
				<p style="margin-bottom: 5px; margin-top: 0px;">Year/Make/Model:</p>
			</div>
			<div class="part-two" style="width: 35%; float: left;">
				<input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%;" value="{{ @$value->vehicle->modal.' '.@$value->vehicle->company_name.' '.@$value->vehicle->name }}">
			</div>
		</div>
		@endforeach
		@endif
		<div class="fourth-section" style="width: 100%; min-height: 50px; margin-top: 50px;">
			<div class="part-one" style="width: 11%; float: left;">
				<p style="margin-bottom: 5px; margin-top: 0px;">Authorized Signature:</p>
			</div>
			<div class="part-two" style="width: 38%; float: left;">
				<input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%; margin-top: 30px;">
			</div>
			<div class="part-one" style="width: 11%; float: left; margin-left: 20px;">
				<p style="margin-bottom: 5px; margin-top: 0px;">Date Signed:</p>
			</div>
			<div class="part-two" style="width: 38%; float: left;">
				<input type="text" style="border-top: none; border-left: none; border-right: none; width: 100%; margin-top: 30px;"  value="{{ @$container->date_for_letter }}">
			</div>
		</div>
	</div>
</body>
</html>