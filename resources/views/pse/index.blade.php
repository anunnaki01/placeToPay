@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Pagos en Linea</div>

                    <div class="card-body">
                        @if (session('responseReasonText'))
                            <div class="alert alert-danger"> {{ session('responseReasonText') }}</div>
                        @endif
                        <form method="POST" action="{{url('pse/createTransaction')}}">

                            {!! csrf_field() !!}

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="paymentMethod">Medio de Pago* </label>

                                    <select name="paymentMethod" id="paymentMethod" class="form-control">
                                        @foreach ($paymentMethods as $paymentMethod)
                                            <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="bankInterface">Tipo de Cliente* </label>

                                    {{--<select name="customerTypes" id="customerTypes" class="form-control">--}}
                                    {{--@foreach ($customerTypes as $customerType)--}}
                                    {{--<option value="{{ $customerType->id }}">{{ $customerType->name }}</option>--}}
                                    {{--@endforeach--}}
                                    {{--</select>--}}

                                    <select name="bankInterface" id="bankInterface" class="form-control">
                                        <option value="0">Persona</option>
                                        <option value="1">Empresa</option>
                                    </select>
                                </div>
                            </div>


                            <br>
                            @if(is_string($bankList))
                                <b>{{$bankList}}</b>
                            @else
                                <label for="bankCode">Entidad Bancaria* </label>

                                <select name="bankCode" id="bankCode" class="form-control">
                                    @foreach ($bankList as $bank)
                                        @if($bank['bankCode']==0)
                                            {{$bank['bankCode']=""}}
                                        @endif
                                        @if (old('bankCode') == $bank['bankCode'])
                                            <option value="{{ $bank['bankCode'] }}"
                                                    selected>{{ $bank['bankName'] }}</option>
                                        @else
                                            <option value="{{ $bank['bankCode'] }}">{{ $bank['bankName'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            @endif
                            @if ($errors->has('bankCode'))
                                <span class="text-danger">{{ $errors->first('bankCode') }}</span>
                            @endif
                            <br><br>
                            <h3>Pagador</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name">Documento* </label>
                                    <input type="text" name="document" id="document" placeholder="Documento"
                                           class="form-control" value="{{old('document')}}">
                                    @if ($errors->has('document'))
                                        <span class="text-danger">{{ $errors->first('document') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="documentType">Tipo de Documento* </label>
                                    <select name="documentType" id="documentType" class="form-control">
                                        <option value="CC">Cédula de ciudadanía colombiana</option>
                                        <option value="CE">Cédula de extranjería</option>
                                        <option value="TI">Tarjeta de identidad</option>
                                        <option value="PPN">Pasaporte</option>
                                        <option value="NIT">Número de identificación tributaria</option>
                                        <option value="SSN">Social Security Number</option>
                                    </select>
                                    @if ($errors->has('documentType'))
                                        <span class="text-danger">{{ $errors->first('documentType') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="firstName">Nombre* </label>
                                    <input type="text" name="firstName" id="firstName" placeholder="Nombre"
                                           class="form-control" value="{{old('firstName')}}">
                                    @if ($errors->has('firstName'))
                                        <span class="text-danger">{{ $errors->first('firstName') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="lastName">Apellido* </label>
                                    <input type="text" name="lastName" id="lastName" placeholder="Apellido"
                                           class="form-control" value="{{old('lastName')}}">
                                    @if ($errors->has('lastName'))
                                        <span class="text-danger">{{ $errors->first('lastName') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="company">Compañía* </label>
                                    <input type="text" name="company" id="company" placeholder="Compañia"
                                           class="form-control" value="{{old('company')}}">
                                    @if ($errors->has('company'))
                                        <span class="text-danger">{{ $errors->first('company') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="emailAddress">Correo Electrónico* </label>
                                    <input type="email" name="emailAddress" id="emailAddress"
                                           placeholder="Correo Electrónico" class="form-control"
                                           value="{{old('emailAddress')}}">
                                    @if ($errors->has('emailAddress'))
                                        <span class="text-danger">{{ $errors->first('emailAddress') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="address">Dirección* </label>
                                    <input type="text" name="address" id="address" placeholder="Dirección"
                                           class="form-control" value="{{old('address')}}">
                                    @if ($errors->has('address'))
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="city">Ciudad* </label>
                                    <input type="text" name="city" id="city" placeholder="Ciudad" class="form-control"
                                           value="{{old('city')}}">
                                    @if ($errors->has('city'))
                                        <span class="text-danger">{{ $errors->first('city') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="province">Departamento* </label>
                                    <input type="text" name="province" id="province" placeholder="Departamento"
                                           class="form-control" value="{{old('province')}}">
                                    @if ($errors->has('province'))
                                        <span class="text-danger">{{ $errors->first('province') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="country">País* </label>

                                    <select name="country" id="country" class="form-control">
                                        <option value="CO" selected>Colombia</option>
                                    </select>
                                    @if ($errors->has('country'))
                                        <span class="text-danger">{{ $errors->first('country') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="phone">Telefono* </label>
                                    <input type="text" name="phone" id="phone" placeholder="Telefono"
                                           class="form-control" value="{{old('phone')}}">
                                    @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="mobile">Celular* </label>
                                    <input type="text" name="mobile" id="mobile" placeholder="Celular"
                                           class="form-control" value="{{old('mobile')}}">
                                    @if ($errors->has('mobile'))
                                        <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                    @endif
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-success">Continuar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
