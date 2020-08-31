@extends('layouts.pharmacy')
@section('content')


<div class="wrapper wrapper-content animated fadeInRight">

<div class="row">
<div class="col-lg-12">
 <div class="ibox float-e-margins">
 <div class="ibox-title">
     <h5>Inventory Report</h5>

     <div class="ibox-tools">

   </div>

 </div>

 <div class="ibox-content">

 <div class="table-responsive">
   <table class="table table-striped table-bordered table-hover dataTables-example" >
   <thead>
     <tr>
         <th>No</th>
         <th>Drug</th>
         <th>Inventory Stock</th>
         <th>Stock Update</th>
         <th>Sales</th>
         <th>Variance</th>
     </tr>
     </thead>
     <tbody>
       <?php
       $i = 1;
       foreach($reports as $report)
       {
         $inventory_qty = $report->inv_qty;
         $update_qty = $report->inv_qty2;
         $quantity = $report->quantity;
        //  $sale_qty = $report->qty3;
        //  $variance = $sale_qty - $update_qty;
         $drug = $report->drugname;
         $id = $report->id;

        ?>
        <tr>
        <td>{{$i}}</td>
        <td>{{$drug}}</td>
        <td>{{$inventory_qty}}</td>
        <td>{{$update_qty}}</td>
        <?php
        if($report->available == 'No')
        {
          $qq = DB::table('prescription_filled_status')
               ->join('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
               ->select('prescription_filled_status.quantity')
               ->where('prescription_filled_status.id', '=', $id)
               ->first();

         ?>
        <td>{{$qq->quantity}}</td>
        <?php
        $variance = $qq->quantity - $update_qty;
         ?>
        <td>{{$variance}}</td>
        <?php
         }
        else
        {
          ?>
          <td>{{$quantity}}</td>
          <?php
          $variance = $quantity - $update_qty;
           ?>
          <td>{{$variance}}</td>
        <?php
        }
         ?>

        </tr>
        <?php
        $i++;
      }
         ?>
   </tbody>
  <tfoot>
    <tr>
      <th>No</th>
      <th>Drug</th>
      <th>Inventory Stock</th>
      <th>Stock Update</th>
      <th>Sales</th>
      <th>Variance</th>
    </tr>
    </tfoot>
    </table>
        </div>

    </div>

   </div>
   </div>

    </div><!--content-->
</div><!--content page-->


@endsection
