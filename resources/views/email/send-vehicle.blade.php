<div style="height: 100%; display: table; margin:auto; background-color: #d5d5d5">
  <table style="width: 700px; min-width: 700px; max-width: 700px;" border="0" cellspacing="0" cellpadding="0">
    <thead style="background-color: #4c6b9b;">
      <tr>
        <td style="text-align: left; padding: 20px;">
          <img src="http://kgautoexport.co/public/assets/symble_logo.png" style="height: 70px;">
        </td>
        <td style="text-align: right; color:#000000; font-family: Halvetica, sans-serif; padding: 20px;">
          <h2 style="font-size:14px;margin:0px;">K&G Auto Export</h2>
          <div style="font-size: 12px;">Leading Importers</div>
          <div style="font-size: 12px;">10,000+ Beautiful Clients</div>
        </td>
      </tr>
    </thead>
    <tbody style="background-color: #ffffff;">
      <tr>
        <td style="padding: 20px">
          <div style="margin-top: 20px;"></div>
          <div style="border-left: solid 6px #4c6b9b; font-size:14px; color:rgb(23,58,60); font-family: Halvetica, sans-serif; padding-left: 10px;">
            <div style="font-size: 14px;">Hello!</div>
            <h2 style="font-size: 18px;font-weight:normal;margin:0px;">Following vehicle data is sended to you.</h2>
            <div>
              <p style="font-size: 14px; color:rgb(23,58,60); text-decoration:none">Below are the details of the vehicle</p>
            </div>
          </div>
        </td>
        <td></td>
      </tr>
    </tbody>
  </table>
  <div style="width: 700px; min-width: 700px; max-width: 700px; display: block; margin: auto; background-color: #ffffff; padding-top: 30px; font-family: Halvetica, sans-serif; color:rgb(23,58,60);">
    <table align="center" style="width: 650px;" border="0" cellpadding="0" cellspacing="0">
      <thead>
        <tr style="font-size: 14px;">
          <td style="padding: 15px; background-color: #b3c0df; text-align: center; font-size: 16px; border-bottom: 2px solid #ffffff;">VIN</td>
          <td style="padding: 15px; background-color: #c6d0e9; text-align: center; border-bottom: 2px solid #ffffff;">DELIVERY DATE</td>
          <td style="padding: 15px; background-color: #b3c0df; text-align: center; border-bottom: 2px solid #ffffff;">DESCRIPTION</td>
          <td style="padding: 15px; background-color: #c6d0e9; text-align: center; border-bottom: 2px solid #ffffff;">CLIENT NAME</td>
          <td style="padding: 15px; background-color: #b3c0df; text-align: center; border-bottom: 2px solid #ffffff;">DESTINATION</td>
        </tr>
      </thead>
      <tbody>
        <tr style="font-size: 14px;">
          <td style="padding: 15px; background-color: #b3c0df; text-align: center; font-size: 16px;">{{ $data->vin }}</td>
          <td style="padding: 15px; background-color: #c6d0e9; text-align: center;">{{ $data->delivery_date }}</td>
          <td style="padding: 15px; background-color: #b3c0df; text-align: center;">{{ $data->company_name.' '.$data->name.' '.$data->modal }}</td>
          <td style="padding: 15px; background-color: #c6d0e9; text-align: center;">{{ $data->client_name }}</td>
          <td style="padding: 15px; background-color: #b3c0df; text-align: center;">{{ $data->destination_port->name }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>