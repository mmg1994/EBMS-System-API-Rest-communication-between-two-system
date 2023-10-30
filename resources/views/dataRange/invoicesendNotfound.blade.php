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
                  <th>INVOICE</th>
                
                  </thead>         
               </tr>
                  @if(array($invoice_number) > 0) 

                @foreach((array) $invoice_number as $invoice_number)        
               <tr>
                      <td>{{$invoice_number}}</td>    
                                   
               </tr>
                              
                      @endforeach
                 
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