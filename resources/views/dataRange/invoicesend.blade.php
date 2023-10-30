@extends('layouts.master')
@include('navbar.header')
@section('content')
@include('sidebar.dashboard')
<link rel="stylesheet" href="{{URL::to('assets/css/profile.css')}}">

<main class="col bg-faded py-3 flex-grow-1">
   

<body>
    <div  class="col-lg-10 mx-auto">
       <div>
          <div class="col-md-10" >
             <h2>Search INVOICE</h2><hr>
             <form action="{{ route('web.finder') }}" method="POST">
               @csrf
                <div class="form-group">
                   <label for="">Enter SIGNATURE</label>
                   <input type="text" class="form-control" name="query" placeholder="singature....." value="{{ request()->input('query') }}">
                   <span class="text-danger">@error('query'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                 <button type="submit" class="btn btn-primary" style="position: absolute;">Search</button>
                </div>
             </form>
             </div>
             <br>
             <br>
             <hr>
             <br>
          
             @if(isset($invoice_number))
             <table  style="padding:30px;">
             <thead>          
                  <tr>
                  <th>NUMBER</th>
                  <th style=" width:800px">CUSTOMER NAME</th>
                  <th style=" width:1000px">ARTICLE</th>
                  <th style=" width:600px">PRICE</th>
                  <th style=" width:600px">QUANTITY</th>
                  <th style=" width:600px">CANCEL STATUS</th>  
                  <th style=" width:1200px">INVOICE DATE</th>
                  <th style=" width:600px">SIGNATURE DATE</th>
                  </thead>         
               </tr>
                  @if(array($invoice_number) > 0) 

                        
               <tr>
                  @foreach($invoice_number as $invoice_number)    <td>{{$invoice_number}}</td>     @endforeach
                  @foreach($customer_name as $customer_name)      <td>{{$customer_name}}</td>          @endforeach
                  @foreach($item_designation as $item_designation)      <td>{{$item_designation}}</td>          @endforeach
                  @foreach($item_price as $item_price)      <td>{{$item_price}}</td>          @endforeach
                  @foreach($item_quantity as $item_quantity)      <td>{{$item_quantity}}</td>          @endforeach
                  @foreach($cancelled_invoice as $cancelled_invoice)      <td>{{$cancelled_invoice}}</td>          @endforeach       
                  @foreach($invoice_date as $invoice_date)      <td>{{$invoice_date}}</td>          @endforeach
                  @foreach($invoice_signature_date as $invoice_signature_date)      <td>{{$invoice_signature_date}}</td>          @endforeach 
                                 
               </tr>
                              
                     @else

               <tr><td>No result found!</td></tr>
                     @endif
                        </table>

         

                        @endif
          
       </div>
    </div>
</body>

</main>
@endsection