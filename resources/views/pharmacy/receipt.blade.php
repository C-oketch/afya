@extends('layouts.receipt')
@section('content')

<div class="wrapper wrapper-content p-xl">
    <div class="ibox-content p-xl">
            <div class="row">
                <div class="col-sm-6">
                  <address>
                      <strong>{{$receipt->pname}}</strong><br>
                      {{$receipt->ptown}}<br>

                  </address>
                </div>

                <div class="col-sm-6 text-right">
                    <h4>Receipt No.</h4>
                    <h4 class="text-navy">{{$number}}</h4>


                    <p>

                        <span><strong>Date:</strong> {{$dys}}</span>
                    </p>
                </div>
            </div>

            <div class="table-responsive m-t">
                <table class="table invoice-table">
                    <thead>
                    <tr>
                        <th>Manufacturer</th>
                        <th>Drug</th>
                        <th>Dose</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      @if($receipt->available == 'Yes')
                        <td>{{$receipt->Manufacturer}}</td>
                        <td>{{$receipt->drugname}}</td>
                        <td>{{$receipt->dose}}</td>
                        <td>{{$receipt->quantity}}</td>
                        <td>{{$receipt->price}}</td>
                        <td>{{$receipt->total}}</td>
                      @elseif($receipt->available == 'No')
                      <?php
                      $manu = DB::table('druglists')
                                   ->select('Manufacturer')
                                   ->where('id', '=', $receipt->drug2)
                                   ->first();
                       ?>
                        <td>{{$manu->Manufacturer}}</td>
                        <td>{{$receipt->inv_drug}}</td>
                        <td>{{$receipt->dose}}</td>
                        <td>{{$receipt->quantity}}</td>
                        <td>{{$receipt->price}}</td>
                        <td>{{$receipt->total}}</td>
                      @endif
                    </tr>
                    </tbody>
                </table>
            </div><!-- /table-responsive -->

            <table class="table invoice-total">
                <tbody>

                <tr>
                    <td><strong>TOTAL :</strong></td>
                   <td>{{$receipt->total}}</td>
                </tr>
                </tbody>
            </table>

        </div>

</div>

<script type="text/javascript">
    window.print();
</script>

@endsection
