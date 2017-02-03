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
              </td>
          </tr>
      @endforeach
      @else
        <tr><td colspan="3">No se encontraron registros</td></tr>
      @endif
  </tbody>
</table>