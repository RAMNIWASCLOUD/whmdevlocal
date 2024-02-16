
<table width="780px" border="0" cellspacing="0" cellpadding="0" style="font-size:8px; font-family:Arial, Helvetica, sans-serif; margin:0 auto; border:1px solid #000">
  <tr>
    <td style="border-bottom:1px solid #000"><table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td style="font-size:14px"><strong>Material Request Note (MRN)</strong></td>
        <td align="right"><img style="width: 70px" src="{{url('/')}}/css_and_js/logo.png" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td colspan="4" align="center" style="border:1px solid #000; border-width:0 1px 1px 0"><strong>Section A</strong></td>
        <td colspan="2" align="center" style="border:1px solid #000; border-width:0 0 1px 0"><strong>Section B</strong></td>
        </tr>
      <tr>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">Kind Attn</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['kind_attn']}}</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">Location</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['location']}}</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">MRN Process Date</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">{{$data['mrn_processing_date']}}</td>
      </tr>
      <tr>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">Mobile </td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['mobile_no']}}</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">Telephone 1</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['telephone_1']}}</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">MRN Process Time</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">{{$data['mrn_processing_time']}}</td>
      </tr>
      <tr>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">Telephone 2</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['telephone_2']}}</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">Date of Delivery</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">{{$data['delivery_date']}}</td>
      </tr>
      <tr>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">Time of delivery</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">{{$data['delivery_time']}}</td>
      </tr>
      <tr>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">MRN Ref</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['vmwh_mrn_ref']}}</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
      </tr>
      <tr>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">Date</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
      </tr>
      <tr>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">Site Address</td>
        <td height="25" style="border:1px solid #000; border-width:0 0 1px 0" colspan="5">{{$data['site_address']}}</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <th height="35" align="center" style="border:1px solid #000; border-width:1px 1px 1px 0; color: white;background-color:black;" scope="col">S.No</th>
        <th align="center" scope="col" style="border:1px solid #000; border-width:1px 1px 1px 0; color: white;background-color:black;">Description of Material</th>
        <th align="center" scope="col" style="border:1px solid #000; border-width:1px 1px 1px 0; color: white;background-color:black;">UOM</th>
        <th align="center" scope="col" style="border:1px solid #000; border-width:1px 1px 1px 0; color: white;background-color:black;">Requested Qty.</th>
        <th align="center" scope="col" style="border:1px solid #000; border-width:1px 1px 1px 0; color: white;background-color:black;">Issued from warehouse</th>
        <th align="center" scope="col" style="border:1px solid #000; border-width:1px 1px 1px 0; color: white;background-color:black;">Balance to be Issued</th>
        <th align="center" scope="col" style="border:1px solid #000; border-width:1px 0 1px 0; color: white;background-color:black;">Comment</th>
      </tr>
      <?php $count = 1;?>
      @if(!empty($data['single_phase_meter_qty']))
      <tr>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">{{$count}}</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">Single Phase Meter</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">Nos</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['single_phase_meter_qty']}}</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['single_phase_meter_qty_issued']}}</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['single_balance_to_issued']}}</td>
        <td align="center" style="border:1px solid #000; border-width:0 0 1px 0">{{$data['single_comment']}}</td>
      </tr>
      <?php $count++; ?>
      @endif
      @if(!empty($data['three_phase_meter_qty']))
      <tr>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">{{$count}}</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">Three Phase Meter</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">Nos</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['three_phase_meter_qty']}}</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['three_phase_meter_qty_issued']}}</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['three_balance_to_issued']}}</td>
        <td align="center" style="border:1px solid #000; border-width:0 0 1px 0">{{$data['three_comment']}}</td>
      </tr>
      @endif
      @if(!empty($data['sim_qty']))
      <tr>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">3</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">Sim</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">Nos</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['sim_qty']}}</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['sim_qty_issued']}}</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['sim_balance_to_issued']}}</td>
        <td align="center" style="border:1px solid #000; border-width:0 0 1px 0">{{$data['sim_comment']}}</td>
      </tr>
      @endif
      @if(!empty($data['modem_qty']))
      <tr>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">4</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">Modem</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">Nos</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['modem_qty']}}</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['modem_phase_meter_qty_issued']}}</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['modem_balance_to_issued']}}</td>
        <td align="center" style="border:1px solid #000; border-width:0 0 1px 0">{{$data['modem_comment']}}</td>
      </tr>
      @endif
      @if(!empty($data['seal_qty']))
      <tr>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">5</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">Antenna </td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">Nos</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['seal_qty']}}</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['seal_phase_meter_qty_issued']}}</td>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">{{$data['seal_balance_to_issued']}}</td>
        <td align="center" style="border:1px solid #000; border-width:0 0 1px 0">{{$data['seal_comment']}}</td>
      </tr>
      @endif
      <tr>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 1px 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" align="left" cellpadding="5" cellspacing="0">
      <tr>
        <th colspan="2" align="left" scope="col" style="border:1px solid #000; border-width:1px 0">Section -B Warehouse Team</th>
      </tr>
      <tr>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="30" style="border:1px solid #000; border-width:1px 0; padding-left:10px"><strong>Note for field Engr:</strong> Please confirm back the delivery of the quipment on site Location</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <th align="left" scope="col">Initiated by</th>
        <th align="left" scope="col">Approved By</th>
      </tr>
      <tr>
        <th height="25" align="left" scope="col">&nbsp;</th>
        <th align="left" scope="col">&nbsp;</th>
      </tr>
    </table></td>
  </tr>
</table>