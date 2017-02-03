
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$contact['title']}}</div>
                <div class="panel-body">
                  {{-- informar al usuario de los errores de la clase request --}}
                    {{-- @if(!empty($errors))
                      <ul>
                        @foreach ($errors->all() as $error)
                          <li>{{$error}}</li>
                        @endforeach
                      </ul>
                    @endif --}}
                    <form role='form' action="{{url('contacts')}}" method="post" enctype='multipart/form-data'>
                      @if(session()->has('msj'))
                        {{-- .alert.alert-success>{{session('msj')}} --}}
                        <div class="alert alert-success">{{session('msj')}}</div>
                      @elseif(session()->has('nomsj'))
                        <div class="alert alert-success">{{session('nomsj')}}</div>
                      @endif

                       <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$contact['name']}}" >
                        
                        @if($errors->has('name'))
                          <span style="color:red">{{$errors->first('name')}}</span>
                        @endif

                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$contact['email']}}">
                        
                        @if($errors->has('email'))
                          <span style="color:red">{{$errors->first('email')}}</span>
                        @endif

                      </div>
                      <div class="form-group">
                        <label for="exampleInputFile">File input</label>
                        <input type="file" id="contactfile" name="contactfile">
                        <p class="help-block">Example block-level help text here.</p>
                        
                        {{-- @if($errors->has('contactfile'))
                          <span style="color:red">{{$errors->first('contactfile')}}</span>
                        @endif --}}

                        {{-- condicion para modificar --}}
                        @if(!empty($contact['file']))
                          <div class="text-center">
                            <img src="{{url('ImgContacts/'.$contact['file'])}}" alt="" class="img-responsive img-thumbnail">
                          </div>
                        @endif

                        @if(!empty($contact['id']))
                          <input type="hidden" name="_method" value="PUT">
                        @endif

                      </div>
                      <div class="text-center">
                        <a href="/home" class="btn btn-default">Atras</a>
                       <button type="submit" class="btn btn-default">Submit</button> 
                      </div>
                      
                      {{-- Token --}}
                      {{csrf_field()}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



