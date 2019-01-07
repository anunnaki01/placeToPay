@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Mis transacciones</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-right">

                                <a href="{{url('/pse')}}" class="btn btn-success">Nueva
                                    Transacción</a>
                                <a href="{{url('/reviewTransactions')}}" class="btn btn-primary">Revisar Transacciones pendientes</a>

                            </div>

                        </div>
                        <br>
                        @if($transactions->count() == 0)
                            <b>No se encontraron transacciones...</b>
                        @else
                            <table class="table table-bordered">

                                <thead>
                                <tr>
                                    <th> Transaccion ID</th>
                                    <th> Referencia</th>
                                    <th> Estado</th>
                                    <th> Descripcion</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>
                                            <a href="{{url('pse/transaction/'.$transaction->transaction_id)}}">{{$transaction->transaction_id}}</a>
                                        </td>
                                        <td> {{$transaction->reference}} </td>
                                        <td> {{$transaction->transaction_state}} </td>
                                        <td> {{$transaction->description}} </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
