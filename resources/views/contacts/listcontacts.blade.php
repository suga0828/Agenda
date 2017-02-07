@if(session()->has('msj'))
  {{-- .alert.alert-success>{{session('msj')}} --}}
  <div class="alert alert-success">{{session('msj')}}</div>
@elseif(session()->has('nomsj'))
  <div class="alert alert-success">{{session('nomsj')}}</div>
@endif


<table class="table table-bordered">
  <thead>
      {{-- tr>th*3 --}}
      <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Acciones</th>
      </tr>
  </thead>
  <tbody>
      @if(!empty($contacts))
      @foreach($contacts as $cont)
          <tr>
              <td>{{$cont->name}}</td>
              <td>{{$cont->email}}</td>
              <td>
                  <a href="contacts/{{$cont->id}}/edit" class="btn btn-success btn-xs">Modificar</a>
                  <form action="{{route('contacts.destroy',$cont->id)}}" method="POST">
                  <input type="hidden" name="_method" value="DELETE">
                  {{csrf_field()}}
                  <button type="submit" class="btn btn-danger btn-xs">Eliminar</button>
                </form>    
              </td>
          </tr>
      @endforeach
      @else
        <tr><td colspan="3">No se encontraron registros</td></tr>
      @endif
  </tbody>
</table>