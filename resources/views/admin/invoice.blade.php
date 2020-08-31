@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('content')
<?php

?>
<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>Invoice</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li>
                    Other Pages
                </li>
                <li class="active">
                    <strong>Invoice</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-4">
            <div class="title-action">
                <a input name="b_print" type="button" class="btn btn-primary ipt"   onClick="printdiv('div_print');" value=" Print Invoice"><i class="fa fa-print"></i>Print Invoice</a>

            </div>
        </div>
    </div>
    <div id="div_print">
<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content animated fadeInRight p-xl">
            <div class="ibox-content p-xl">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5>From:</h5>
                            <address>
                                <strong>Priority Health ltd.</strong><br>
                                P. O. BOX 16282-00100<br>
                                Nairobi, Kenya<br>
                                <abbr title="Website">Website:</abbr>www.afyapepe.com
                            </address>
                        </div>

                        <div class="col-sm-6 text-right">
                            <h4>Invoice No.</h4>
                            <h4 class="text-navy">INV-{{$subscription->invoice_no}}</h4>
                            <span>To:</span>
                            <address>
                                @if($subscription->name)<strong>{{$subscription->name}}</strong><br>@endif
                              @if($subscription->building)  {{$subscription->building}}<br>@endif
                              @if($subscription->floor_room)   {{$subscription->floor_room}}<br>@endif
                              @if($subscription->street) {{$subscription->street}}<br>@endif
                              @if($subscription->phone)<abbr title="Phone">P:{{$subscription->phone}}</abbr>@endif
                            </address>
                            <p>
                                <span><strong>Invoice Date:</strong> {{$subscription->invoice_date}} </span><br/>
                                <span><strong>Due Date:</strong> {{$subscription->due_date}} </span>
                            </p>
                        </div>
                    </div>

                    <div class="table-responsive m-t">
                        <table class="table invoice-table">
                            <thead>
                            <tr>
                                <th>Description of Service</th>
                                <th>Quantity</th>
                                <th>Unit Cost</th>
                                <th>Total Cost</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php  $Tmonth =0;
                                     $Totyearly =0;
                                     $Totsetup =0;

                                  if($addsum->adddsum) {$Totaddons=$addsum->adddsum;}else{$Totaddons =0;}
                                     ?>
                    @if($subscription->setup)        <tr>
                      <?php   $Totsetup =$subscription->setup; ?>
                                <td><div><strong>Setting Up Costs</strong></div>
                                    <p>One time set up fee : This covers deployment, account set up, training and some promotional materials.</p></td>
                                <td>1</td>
                                <td>{{$subscription->setup}}</td>
                                <td>{{$Totsetup}}</td>
                              </tr>
                      @endif
                      @if($subscription->amount)       <tr>
                                <td><div><strong>Monthly Subscription</strong></div>
                                    <strong> {{$subscription->package}}</strong><br>
                                    <p>Subscription : This covers software as a service fee, storage as well as maintenance.</p></td>
                                    </td>
                                <td>{{$subscription->quantity}}</td>
                                <td>{{$subscription->amount}}</td>
                                <?php $Tmonth =$subscription->amount*$subscription->quantity;
                                 ?>
                                <td>{{$Tmonth}}</td>
                         </tr>
                         @endif
                         @if($subscription->yearly)
                    <tr>
                        <?php   $Totyearly =$subscription->yearly *$subscription->quantity; ?>
                                   <td><div><strong>Annual Subscription</strong></div>
                                       <strong> {{$subscription->package}}</strong><br>
                                       <p>Subscription : This covers software as a service fee, storage as well as maintenance.</p></td>
                                       </td>
                                   <td>1</td>
                                   <td>{{$subscription->yearly}}</td>
                                   <td>{{$Totyearly}}</td>
                            </tr>
                            @endif

                            @foreach($addons as $addon)
                         <tr>
                        <td><div><strong>{{$addon->name}}</strong></div>
                        <p>{{$addon->desc}}</p></td>
                                          </td>
                                      <td></td>
                                      <td>{{$subscription->yearly}}</td>
                                      <td>{{$addon->addamounts}}</td>
                               </tr>
                               @endforeach


                            </tbody>
                        </table>
                    </div><!-- /table-responsive -->
<?php $sub1 = $Totyearly + $Tmonth +$Totsetup +$Totaddons;
$tax = (16/100)*$sub1;
$total = $tax + $sub1;
?>
                    <table class="table invoice-total">
                        <tbody>
                        <tr>
                            <td><strong>Sub Total :</strong></td>
                            <td>{{$sub1}}</td>
                        </tr>
                        <tr>
                            <td><strong>TAX :</strong></td>
                            <td>{{$tax}}</td>
                        </tr>
                        <tr>
                            <td><strong>TOTAL :</strong></td>
                            <td>{{$total}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <!-- <div class="text-right">
                        <button class="btn btn-primary"><i class="fa fa-dollar"></i> Make A Payment</button>
                    </div> -->
                    <table class="table">
                      <thead>
                        <tr><th>Make Payment</th></tr>
                      <tr>
                          <th>Direct Deposit</th>
                          <th>Cheques</th>
                          <th>Lipa Na Mpesa</th>

                      </tr>
                      </thead>
                        <tbody>


                        <tr class="well">
                            <td>
                            Priority Health Limited <br>
                            Standard Chartered Bank Limited<br>
                            Account Number: 0102445039800<br>
                            Branch Name: Junction<br>
                            SCBLKENX<br></td>
                            <td>Cheques payable to Priority Health Limited</td>
                            <td>
                                Paybill Number 134108 <br>
                                Account Name - Invoice number<br>
                              </td>
                        </tr>

                        </tbody>
                    </table>

          </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('script')
<script>
function printdiv(printpage)
{
var headstr = "<html><head><title></title></head><body>";
var footstr = "</body>";
var newstr = document.all.item(printpage).innerHTML;
var oldstr = document.body.innerHTML;
document.body.innerHTML = headstr+newstr+footstr;
window.print();
document.body.innerHTML = oldstr;
return false;
}
</script>
@endsection
