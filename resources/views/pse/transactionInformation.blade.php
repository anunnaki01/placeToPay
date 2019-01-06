@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @if(!empty($errorMessage))
                        <div class="alert alert-danger">
                            <strong>{{utf8_encode($errorMessage)}}</strong>
                        </div>

                    @else
                        <div class="card-header">Informacion de la Transaccion</div>

                        <div class="card-body">

                            <div class="row">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">Transaccion ID</th>
                                        <th scope="col">{{$transactionInformation['transactionID']}}</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Sesion ID</th>
                                        <th scope="col">{{$transactionInformation['sessionID']}}</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Referencia</th>
                                        <th scope="col">{{$transactionInformation['reference']}}</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Fecha de Solicitud</th>
                                        <th scope="col">{{$transactionInformation['requestDate']}}</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Fecha de proceso</th>
                                        <th scope="col">{{$transactionInformation['bankProcessDate']}}</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Código de trazabilidad</th>
                                        <th scope="col">{{$transactionInformation['trazabilityCode']}}</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Estado de la transaccion</th>
                                        <th scope="col">{{$transactionInformation['transactionState']}}</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Descripcion</th>
                                        <th scope="col">{{utf8_encode($transactionInformation['responseReasonText'])}}</th>
                                    </tr>
                                    </thead>
                                </table>
                                <a href="{{ url('pse') }}" class="btn btn-success">Inicio</a>
                            </div>

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
