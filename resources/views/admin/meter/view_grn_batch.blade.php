<?php 
use \MongoDB\BSON\ObjectID as MongoId;

        $phase1 = \DB::table('meter')->where(['batch_id'=>$id,'phase_type'=>'1 Phase'])->count();
       
        $phase3  = \DB::table('meter')->where(['batch_id'=>$id,'phase_type'=>'3 Phase'])->count();
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
        <td><strong>GRN No.:</strong>Admin-{{date('Y',strtotime($data['batch_grn_date']))}}-00{{$data['batch_grn_no']}}</td>
        <td><strong>Invoice No.:</strong>{{$data['batch_invoice_no']}}</td>
        <td><strong>GRN Date:</strong>{{$data['batch_grn_date']}}</td>
      </tr>
      <tr>
        <td><strong>Supplier: </strong>{{$data['batch_supplier']}}</td>
        <td><strong>Delivery Location: </strong>{{$data['batch_delivery_location']}}</td>
        <td><strong>Invoice Date: </strong>{{$data['batch_invoice_date']}}</td>
      </tr>
      <tr>
        <td><strong>Order No.:</strong>{{$data['batch_order_no']}}</td>
        <td>&nbsp;</td>
        <td><strong>Warranty Expiry Date: </strong>{{ date('Y-m-d', strtotime('+5 year', strtotime($data['batch_grn_date'])))}}</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td><strong>Transporter/Courier Name:</strong>{{$data['batch_transporter']}}</td>
        <td><strong>LR/Docket No.:</strong>{{$data['batch_lr_docket_no']}}</td>
      </tr>
      <tr>
        <td><strong>Waybill No.:</strong>{{$data['batch_lr_docket_no']}}</td>
        <td><strong>Waybill Date:</strong>{{$data['batch_waybill_date']}}</td>
      </tr>
      <tr>
        <td><strong>Vehicle No.:</strong>{{$data['batch_vehicle_no']}}</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="5" style="border:1px solid #000; border-width:1px 0">
      <tr>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;text-align: center;"><strong>Sr. No.</strong></td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;text-align: center;"><strong>Goods</strong></td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;text-align: center;"><strong>Order Qty.</strong></td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;text-align: center;"><strong>Delivered Qty.</strong></td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;text-align: center;"><strong>Rate</strong></td>
        <td style="border:1px solid #000;border-width:0 1px 1px 1px; text-align:right;"><strong>Total</strong></td>
      </tr>
      <?php $total = $srno = 0; ?>
       @if(!empty($phase1))  
      <?php $srno++; ?>
      <tr>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;text-align: center;">{{$srno}}</td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;text-align: center;"> 1 Phase smart Meter</td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;text-align: center;">{{$phase1}}</td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;text-align: center;">{{$phase1}}</td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;text-align: center;">3193.52</td>
        <?php $total += 3193.52*$phase1; ?>
        <td style="border:1px solid #000;border-width:0 1px 1px 1px; text-align:right;">{{ 3193.52*$phase1 }}</td>
      </tr>
      @endif
      @if(!empty($phase3))  
      <?php $srno++; ?>
      <tr>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;">{{$srno}}</td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;"> 3 Phase smart Meter</td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;">{{$phase3}}</td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;">{{$phase3}}</td>
        <td style="border:1px solid #000;border-width:0 0 1px 1px;">4632.68</td>
        <?php $total += 4632.68*$phase3; ?>
        <td style="border:1px solid #000;border-width:0 1px 1px 1px;">{{ 4632.68*$phase3 }}</td>
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
        
        <td>Received By<br>{{(!empty($batch_supplier))? $batch_supplier:''}}</td>
        <td style="text-align: right;">Checked By<br>EDF Warehouses</td>
      </tr>
    </table></td>
  </tr>
</table>
<script type="text/javascript">window.print();</script>
</body>
</html>
