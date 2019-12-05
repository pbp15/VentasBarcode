@extends('auth.contenido')

@section('login')
<div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group mb-0">
          <div class="card p-4">
          <form class="form-horizontal was-validated" method="POST" action="{{ route('login')}}">
          {{ csrf_field() }}
              <div class="card-body">
              <h1 class="text-center">Acceder</h1>
              <p class="text-center ">Control de acceso al sistema</p>
              <div class="form-group mb-3{{$errors->has('usuario' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="icon-user"></i></span>
                <input type="text" value="{{old('usuario')}}" name="usuario" id="usuario" class="form-control" placeholder="Usuario">
                {!!$errors->first('usuario','<span class="invalid-feedback">:message</span>')!!}
              </div>
              <div class="form-group mb-4{{$errors->has('password' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                {!!$errors->first('password','<span class="invalid-feedback">:message</span>')!!}
              </div>
              <div class="row">
                <div class="col-6 ">
                  <button type="submit" class="btn btn-outline-primary px-4">Ingresar</button>
                </div>
              </div>
            </div>
          </form>
          </div>
          <div class="card text-white bg-info py-5 d-md-down-none" style="width:44%">
            <div class="card-body text-center">
              <div>
              
                <h2 class=" ">Sistema de Inventario - Ventas  </h2>
   
                <img src="img/user1.png"  width="40%" height ="30%" >
     
                <h2 class=" ">Inversiones "Roque" </h2>
                <hr>
                <p> Calidad y Confianza</p>
                
              
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
