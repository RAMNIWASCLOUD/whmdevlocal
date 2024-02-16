<table width="535px" border="0" cellspacing="0" cellpadding="0" style="margin:0 auto; font-family:Arial, Helvetica, sans-serif; font-size:8px; border:1px solid #000">
  <tr>
    <td align="center" style="border-bottom:1px solid #000"><h2>Energy Efficency Services Ltd</h2>
    <h4>1st Floor Consumer Faciliation Center Vidyut Bhawan Bailey Road Patna - 800001</h4>
    </td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" style="border-bottom:1px solid #000; padding:10px 0; font-size:16px;"><strong><u>DN/CHALLAN</u></strong></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td width="58%" style="border:1px solid #000; border-width:0 1px 1px 0"><strong>DN/Challan No: {{$data['vmwh_dl_ch_ref']}}</strong></td>
            <td width="15%" style="border:1px solid #000; border-width:0 1px 1px 0"><strong>MRN NO:</strong></td>
            <td width="27%" style="border-bottom:1px solid #000"> {{$data['vmwh_mrn_ref']}}</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td width="16%" style="border:1px solid #000; border-width:0 1px 1px 0"><strong>DN/Challan Date :</strong></td>
            <td width="42%" style="border:1px solid #000; border-width:0 1px 1px 0"><strong>{{$data['vmwh_dispatch_processing_date']}}</strong></td>
            <td width="15%" style="border:1px solid #000; border-width:0 1px 1px 0"><strong>Location</strong></td>
            <td width="27%" style="border:1px solid #000; border-width:0 0 1px 0"><strong>{{$data['location']}}</strong></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td width="178" style="border:1px solid #000; border-width:0 1px 1px 0"><strong>From (Address of Consigner/Sender)</strong></td>
            <td width="178" style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
            <td style="border:1px solid #000; border-width:0 0 1px 0"><strong>To (Address of Consignee/Receiver)</strong></td>
          </tr>
          <tr>
            <td style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['from_address']}}</td>
            <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
            <td style="border:1px solid #000; border-width:0 0 1px 0">{{$data['to_address']}}</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <?php 
      $i = 0;
      $total = 0; 
    ?>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0"><strong>Sr. No. </strong></td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0"><strong>Material Description</strong></td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0"><strong>UOM</strong></td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0"><strong>Price(Rs.)</strong></td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0"><strong>Qty</strong></td>
        <td style="border:1px solid #000; border-width:0 0 1px 0"><strong>Value(Rs.)</strong></td>
        </tr>
      @if(!empty($data['single_phase_meter_qty_issued']))  
        <tr>
          <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0"><strong>{{ $i=$i+1 }}</strong></td>
          <td style="border:1px solid #000; border-width:0 1px 1px 0"> 1 Phase smart Meter</td>
          <td style="border:1px solid #000; border-width:0 1px 1px 0">Nos</td>
          <td style="border:1px solid #000; border-width:0 1px 1px 0">3193.52</td>
          <td style="border:1px solid #000; border-width:0 1px 1px 0">{{ $data['single_phase_meter_qty_issued'] }}</td>
          <?php $total += 3193.52*$data['single_phase_meter_qty_issued']; ?>
          <td style="border:1px solid #000; border-width:0 0 1px 0"><strong>{{ 3193.52*$data['single_phase_meter_qty_issued'] }}</strong></td>
        </tr>
      @endif
      @if(!empty($data['three_phase_meter_qty_issued']))  
        <tr>
          <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0"><strong>{{ $i=$i+1 }}</strong></td>
          <td style="border:1px solid #000; border-width:0 1px 1px 0"> 3 Phase smart Meter</td>
          <td style="border:1px solid #000; border-width:0 1px 1px 0">Nos</td>
          <td style="border:1px solid #000; border-width:0 1px 1px 0">4632.68</td>
          <td style="border:1px solid #000; border-width:0 1px 1px 0">{{ $data['three_phase_meter_qty_issued'] }}</td>
          <?php $total += 4632.68*$data['three_phase_meter_qty_issued']; ?>
          <td style="border:1px solid #000; border-width:0 0 1px 0"><strong>{{ 4632.68*$data['three_phase_meter_qty_issued'] }}</strong></td>
        </tr>
      @endif
      <tr>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0"><strong>{{ $i=$i+1 }}</strong></td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        </tr>
      <tr>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0"><strong>{{ $i=$i+1 }}</strong></td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        </tr>
      <tr>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0"><strong>{{ $i=$i+1 }}</strong></td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        </tr>
      <tr>
        <td style="border:1px solid #000; border-width:0 1px 1px 0" align="center"><strong>{{ $i=$i+1 }}</strong></td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        </tr>
      <tr>
        <td style="border:1px solid #000; border-width:0 1px 1px 0" align="center"><strong>{{ $i=$i+1 }}</strong></td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        </tr>
      <tr>
        <td style="border:1px solid #000; border-width:0 1px 1px 0" align="center"><strong>{{ $i=$i+1 }}</strong></td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        </tr>
      <tr>
        <td style="border:1px solid #000; border-width:0 1px 1px 0" align="center"><strong>{{ $i=$i+1 }}</strong></td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        </tr>
      <tr>
        <td style="border:1px solid #000; border-width:0 1px 1px 0" align="center">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0" colspan="2">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">Total</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0"><strong>{{$total}}</strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="25" style="padding:0 10px"><strong>In Words:</strong> <?php $number = $total;
                $no = floor($number);
                $point = round($number - $no, 2) * 100;
                $hundred = null;
                $digits_1 = strlen($no);
                $i = 0;
                $str = array();
                $words = array('0' => '', '1' => 'One', '2' => 'Two',
                '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
                '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
                '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
                '13' => 'Thirteen', '14' => 'Fourteen',
                '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
                '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
                '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
                '60' => 'Sixty', '70' => 'Seventy',
                '80' => 'Eighty', '90' => 'Ninety');
                $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
                while ($i < $digits_1) {
                $divider = ($i == 2) ? 10 : 100;
                $number = floor($no % $divider);
                $no = floor($no / $divider);
                $i += ($divider == 10) ? 1 : 2;
                if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] .
                " " . $digits[$counter] . $plural . " " . $hundred
                :
                $words[floor($number / 10) * 10]
                . " " . $words[$number % 10] . " "
                . $digits[$counter] . $plural . " " . $hundred;
                } else $str[] = null;
                }
                $str = array_reverse($str);
                $result = implode('', $str);
                $points = ($point) ?
                "." . $words[$point / 10] . " " . 
                $words[$point = $point % 10] : '';
                $amount_in_word = $result . "Rupees  " ;//. $points . " Paise";\

                if(!empty($result))
                {
                  echo $amount_in_word;
                }
                ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td style="border:1px solid #000; border-width:1px 0">The materials are being sent for implementation of smart meter project as per the attached documents.<br />
          <p style="text-transform:uppercase"><strong>Not for sale or Any other commmercial Purpose (for Electricity Department Use Only) Value Declared for Insurance Purpose Only</strong></p></td>
      </tr>
      <tr>
        <td style="border:1px solid #000; border-width:0 0 1px 0"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="33%">Despatch Details</td>
            <td width="33%">Box:</td>
            <td width="33%">Dispatch Mode: {{$data['dispatch_mode']}}</td>
          </tr>
          @if($data['dispatch_mode']=='Self Pickup')
            <tr>
            <td><strong>Pickup Person Name:</strong>{{$data['name_of_pickup_person']}}</td>
            <td>&nbsp;</td>
            <td><strong>Person Mobile No.:</strong>{{$data['mobile_no_pickup_person']}}</td>
          </tr>
          @else
            <tr>
              <td><strong>Carrier Name:</strong>{{$data['transport_name']}}</td>
              <td>&nbsp;</td>
              <td><strong>Docket/ LR no. :</strong>{{$data['lr_no']}}</td>
            </tr>
          @endif
        </table></td>
      </tr>
      <tr>
        <td style="border:1px solid #000; border-width:0 0 1px 0"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><strong>GST No.10AACCE4248H1Z3</strong></td>
            <td style="padding:20px 0"><strong><u>Declaration:</u></strong> Above mentioned Meters are being dispatched for govt project. these are not for sale and hence, have no commercial value</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td>Material Received by</td>
        <td>For EESL</td>
      </tr>
      <tr>
        <td height="75">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Seal &amp; Signature</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>