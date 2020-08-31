@extends('layouts.pharmacy')
@section('content')


<div class="wrapper wrapper-content animated fadeInRight">

<div class="row">
<div class="col-lg-12">
 <div class="ibox float-e-margins">
 <div class="ibox-title">
     <h5>Drugs Stock</h5>

     <div class="ibox-tools">
@role(['Pharmacyadmin','Pharmacymanager'])
     <a class="btn btn-primary " type="button" href="{{ URL::to('new_stock') }}"><i class="fa fa-paste"></i> Add Stock</a>
     @endrole

   </div>

 </div>

 <div class="ibox-content">

 <div class="table-responsive">
   {!! Form::open(array('route' => 'edit_inventory','method'=>'POST','class'=>'form-horizontal','role'=>'form')) !!}
   <table class="table table-striped table-bordered table-hover dataTables-pharmacy" >
   <thead>
     <tr>
         <th>No</th>
         <th>Drug</th>
         <th>Manufacturer</th>
         <th>Supplier</th>
         @role(['Pharmacyadmin','Pharmacymanager'])
         <th>Number in stock</th>
         <th>Date</th>
         @endrole
         @role(['Pharmacyadmin','Pharmacymanager','Pharmacystorekeeper'])
         <th>Updated Quantity</th>
         @endrole
         <th>Action</th>
         <th></th>
     </tr>
     </thead>
     <tbody>
       <?php
       $i = 1;
       foreach($inventory as $inv)
       {

         $inv_id = $inv->inv_id;

         $entry_date = $inv->entry_date;
         $drug_id = $inv->drug_id;
         $inventory_id = $inv->inventory_id;
         $counter = DB::table('prescription_filled_status')
                ->join('prescription_details', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
                ->select(DB::raw('SUM(prescription_filled_status.quantity) AS count1'))
                ->where('prescription_details.drug_id', '=', $drug_id)
                ->first();
        $sold= $counter->count1;

        $stock = DB::table('inventory')
                    ->join('druglists','druglists.id','=','inventory.drug_id')
                    ->join('strength','strength.strength','=','inventory.strength')
                    ->where([
                      ['inventory.quantity', '>', 0],
                      ['is_active', '=', 'yes'],
                      ['inventory.drug_id' , '=', $drug_id],
                    ])
                    ->sum('inventory.quantity');

          $bought = $stock;

          $stock_level = $bought - $sold;

          /**
          *Get supplier
          */
          $supplier = DB::table('inventory')
                    ->join('drug_suppliers', 'drug_suppliers.id', '=', 'inventory.supplier')
                    ->select('drug_suppliers.name')
                    ->where('inventory.id', '=', $inventory_id)
                    ->first();
        ?>
        <tr>
        <td>{{$i}}</td>
        <td>{{$inv->drugname}}</td>
        <td>{{$inv->Manufacturer}}</td>
        <td>{{$supplier->name}}</td>
        @role(['Pharmacyadmin','Pharmacymanager'])
        <td>{{$stock_level}}</td>
        <td>{{$entry_date}}</td>
        @endrole
        @role(['Pharmacyadmin','Pharmacymanager','Pharmacystorekeeper'])
        <td>
          <?php
          $amount = array();
          $amount = DB::table('inventory_updates')
                  ->where([
                    ['status', '=', 1],
                    ['drug_id', '=', $drug_id],
                  ])
                  ->sum('quantity');

                  if(empty($amount))
                  {
                  echo '';
                  }
                  else
                  {
                    echo $amount;
                  }
           ?>
        </td>
        @endrole

        <td>
          <input name="selector[]" type="checkbox" value="{{$drug_id}}">
          <!-- <input name="selector2[]" type="hidden" value="{{$inventory_id}}">--> <!-- used for single edit,update or delete -->
        </td>

        <td>
          @role(['Pharmacyadmin','Pharmacymanager'])
          <button class="btn btn-primary" name="submit_edit" value="Edit" type="submit">Edit.</button>
          @endrole

          @role(['Pharmacyadmin','Pharmacymanager','Pharmacystorekeeper'])
          <button class="btn btn-primary" name="submit_update" value="Update" type="submit">Update.</button>
          @endrole

          @role(['Pharmacyadmin','Pharmacymanager'])
          <button class="btn btn-primary" name="submit_delete" value="Delete" type="submit">Delete.</button>
          @endrole

          <input type="hidden" name="inventory_id" value="{{$inv->inventory_id}}" />

          <!-- <a href="{{ route('update_inv',$inventory_id) }}">Update</a> &nbsp;&nbsp; -->
          @role(['Pharmacyadmin','Pharmacymanager'])
          <!-- <a data-toggle="modal" class="btn btn-primary" href="#modal-form" data-manufacturer="{{$inv->Manufacturer}}"
            data-drug="{{$inv->drugname}}" data-stock="{{$stock_level}}" data-id="{{$inv->inventory_id}}">Delete</a> -->
            @endrole

        </td>
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
      <th>Manufacturer</th>
      <th>Supplier</th>
      @role(['Pharmacyadmin','Pharmacymanager'])
      <th>Number in stock</th>
      <th>Date</th>
      @endrole
      @role(['Pharmacyadmin','Pharmacymanager','Pharmacystorekeeper'])
      <th>Updated Quantity</th>
      @endrole
      <th>Action</th>
      <th></th>
    </tr>
    </tfoot>
    </table>

      {{ Form::close() }}
        </div>

    </div>


   </div>
   </div>

    </div><!--content-->
</div><!--content page-->


@endsection
