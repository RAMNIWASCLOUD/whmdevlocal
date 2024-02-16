<?php 
use \MongoDB\BSON\ObjectID as MongoId;
    

        $Received_by= \DB::table('login_users')->where(['_id'=>new MongoId($data['vmwh'])])->first();
       
        $Supplier = \DB::table('login_users')->where(['_id'=>new MongoId($data['swh'])])->first();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Good Received Note</title>
</head>

<body>
<table width="700px" border="0" cellspacing="0" cellpadding="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; margin:0 auto; border:1px solid #000">
  <tr>
    <td align="center" style="font-size:16px; border-bottom:1px solid #000"><strong>Good Received Note</strong></td>
  </tr>
  <tr>
    <td style="border-bottom:1px solid #000"><table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td><strong>GRN No.:</strong>{{$data['utility']}}-{{date('Y',$data['vmwh_dispatch_created_time'])}}-00{{$data['grn_no']}}</td>
        <td><strong>Invoice No.:</strong>{{$data['mrn_ref']}}</td>
        <td><strong>GRN Date:</strong>{{date('d-m-Y',$data['vmwh_dispatch_created_time'])}}</td>
      </tr>
      <tr>
        <td><strong>Supplier: </strong>{{$Supplier['warehouse_name']}}</td>
        <td><strong>Delivery Location: </strong>{{$Received_by['city']}}</td>
        <td><strong>Invoice Date: </strong>{{date('')}}</td>
      </tr>
      <tr>
        <td><strong>Order No.:</strong>{{$data['vmwh_dl_ch_ref']}}</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td><strong>Transporter/Courier Name:</strong>{{$data['transport_name']}}</td>
        <td><p><strong>LR/Docket No.:</strong></p>{{$data['lr_no']}}</td>
      </tr>
      <tr>
        <td><strong>Waybill No.:</strong></td>
        <td><strong>Waybill Date:</strong></td>
      </tr>
      <tr>
        <td><p><strong>Vehicle No.:</strong>{{$data['driver_name']}}</p></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="5" style="border:1px solid #000; border-width:1px 0">
      <tr>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;"><strong>Sl. NO.</strong></td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;"><strong>Goods</strong></td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;"><strong>Order Qty.</strong></td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;"><strong>Delivered Qty.</strong></td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;"><strong>Rate</strong></td>
        <td style="border:1px solid #000;border-width:0 1px 1px 1px;"><strong>Total</strong></td>
      </tr>
      <?php $total = $srno = 0; ?>
       @if(!empty($data['single_phase_meter_qty']))  
      <?php $srno++; ?>
      <tr>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;">{{$srno}}</td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;"> 1 Phase smart Meter</td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;">{{$data['single_phase_meter_qty']}}</td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;">{{$data['single_phase_meter_qty_issued']}}</td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;">3193.52</td>
        <?php $total += 3193.52*$data['single_phase_meter_qty_issued']; ?>
        <td style="border:1px solid #000;border-width:0 1px 1px 1px;">{{ 3193.52*$data['single_phase_meter_qty_issued'] }}</td>
      </tr>
      @endif
      @if(!empty($data['three_phase_meter_qty']))  
      <?php $srno++; ?>
      <tr>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;">{{$srno}}</td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;"> 3 Phase smart Meter</td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;">{{$data['three_phase_meter_qty']}}</td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;">{{$data['three_phase_meter_qty_issued']}}</td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;">4632.68</td>
        <?php $total += 4632.68*$data['three_phase_meter_qty_issued']; ?>
        <td style="border:1px solid #000;border-width:0 1px 1px 1px;">{{ 4632.68*$data['three_phase_meter_qty_issued'] }}</td>
      </tr>
      @endif
      <tr>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;">&nbsp;</td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;">&nbsp;</td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;">&nbsp;</td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;">&nbsp;</td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;">&nbsp;</td>
        <td style="border:1px solid #000;border-width:0 1px 1px 1px;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border:1px solid #000;border-width:0 0 0 1px;">&nbsp;</td>
        <td style="border:1px solid #000;border-width:0 0 0 1px;">&nbsp;</td>
        <td style="border:1px solid #000;border-width:0 0 0 1px;">&nbsp;</td>
        <td style="border:1px solid #000;border-width:0 0 0 1px;">&nbsp;</td>
        <td style="border:1px solid #000;border-width:0 0 0 1px;">&nbsp;</td>
        <td style="border:1px solid #000;border-width:0 1px 0 1px;">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="75" align="left" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        
        <td>Received By<br>{{(!empty($Received_by))? $Received_by['warehouse_name']:''}}</td>
        <td>Checked By<br>{{(!empty($Received_by))? $Received_by['warehouse_name']:''}}</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
