@extends('layouts.master')
@include('navbar.header')
@section('content')
@include('sidebar.dashboard')
<link rel="stylesheet" href="{{URL::to('assets/css/profile.css')}}">
<main class="col bg-faded py-3 flex-grow-1">
   

<body>
    <div  class="col-lg-8 mx-auto">
       <div class="row">
          <div class="col-md-6" style="margin-top:40px">
             <h2>Search NIF</h2><hr>
             <form action="{{ route('web.find') }}" method="POST">
        @csrf
                <div class="form-group">
                   <label for="">Enter NIF</label>
                   <input type="text" class="form-control" name="query" placeholder="Search here....." value="{{ request()->input('query') }}">
                   <span class="text-danger">@error('query'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                 <button type="submit" class="btn btn-primary">Search</button>
                </div>
             </form>
             <br>
             <br>
             <hr>
             <br>
             @if(isset($nif))

               <table class="table table-hover">
               <thead> 
                       <tr>
                           <th >NIF NAME</th>
                          
                       </tr>
               </thead>
                       @if(array($nif) > 0)
                      @foreach((array) $nif as $nif)
                              <tr>
                                  <td>{{$nif}}</td>
                    
                              </tr>
                           @endforeach
                           @else

                        <tr><td>No result found!</td></tr>
                        @endif
               </table>

 

             @endif
          </div>
       </div>
    </div>
</body>

</main>
@endsection