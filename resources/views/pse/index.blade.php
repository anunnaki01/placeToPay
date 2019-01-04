@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Pago en Linea</div>

                    <div class="card-body">

                        <form method="POST" action="{{url('users/save')}}">

                            {!! csrf_field() !!}

                            <label for="paymentMethod">Medio de Pago: </label>

                            <select name="paymentMethod" id="paymentMethod" class="form-control">
                                @foreach ($paymentMethods as $paymentMethod)
                                    <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                                @endforeach
                            </select>

                            <label for="customerTypes">Tipo de Cliente: </label>

                            <select name="customerTypes" id="customerTypes" class="form-control">
                                @foreach ($customerTypes as $customerType)
                                    <option value="{{ $customerType->id }}">{{ $customerType->name }}</option>
                                @endforeach
                            </select>

                            @if(is_string($bankList))
                                <b>{{$bankList}}</b>

                            @else
                                <label for="name">Entidad Bancaria: </label>

                                <select name="bankList" id="bankList" class="form-control">
                                    @foreach ($bankList as $bank)
                                        <option value="{{ $bank['bankCode'] }}">{{ $bank['bankName'] }}</option>
                                    @endforeach
                                </select>
                            @endif
                            <br>
                            <button type="submit">Continuar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
