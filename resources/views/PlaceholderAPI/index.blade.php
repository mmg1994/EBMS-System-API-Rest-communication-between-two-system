<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTTP CLIENT</title>

    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>

<table class="table">
@csrf
  <thead>

  
    <tr>
      <th scope="col">#</th>
   <!--   <th scope="col">title</th>
      <th scope="col">body</th>  -->

    </tr>
  </thead>

  <tbody>

  @if (is_array($nif))

  @foreach ($nif as $nif)
  var_dump($nif)
      <tr>
    
     
   
     <!--   <td>{{$data['body']}}</td> 
      <td>     <a href="{{route('post.edit', $data['id'] )}}">edit</a>  </td> -->
    </tr>
    @endforeach
    @endif


  </tbody>
</table>


</body>
</html> 