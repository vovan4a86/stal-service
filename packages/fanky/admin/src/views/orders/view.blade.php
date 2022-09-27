@extends('admin::template')

@section('scripts')
    <script type="text/javascript" src="/adminlte/interface_orders.js"></script>
@stop

@section('page_name')
    <h1>Заказ № {{ $order->id }}</h1>
@stop

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="{{ route('admin.orders') }}">Заказы</a></li>
        <li class="active">Заказ № {{ $order->id }}</li>
    </ol>
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4 text-bold">Заказчик</div>
                        <div class="col-md-8">{{ $order->name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-bold">Тип</div>
                        <div class="col-md-8">{{ array_get(\Fanky\Admin\Models\Order::$user_type, $order->user)  }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-bold">Email</div>
                        <div class="col-md-8">{{ $order->email }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-bold">Телефон</div>
                        <div class="col-md-8">{{ $order->phone }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4 text-bold">Дата заказа</div>
                        <div class="col-md-8">{{ $order->dateFormat() }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-bold">Способ доставки</div>
                        <div class="col-md-8">{{ array_get(\Fanky\Admin\Models\Order::$delivery_method, $order->delivery_method)}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-bold">Сумма заказа</div>
                        <div class="col-md-8">{{ $order->summ }}</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="box box-solid">
        <div class="box-body">
            @if (count($items))
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Продукт</th>
                        <th>Количество</th>
                        <th>Цена</th>
                        <th>Сумма</th>
                        <th width="50"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td><a target="_blank" href="{{ route('admin.catalog.productEdit', [$item->id]) }}">{{ $item->name }}</a></td>
                            <td>{{ $item->pivot->count }}</td>
                            <td>{{ $item->pivot->price }}</td>
                            <td>{{ $item->pivot->count * $item->pivot->price }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Итого:</th>
                            <th>{{ $all_count }}</th>
                            <th></th>
                            <th>{{ $all_summ }}</th>
                        </tr>
                    </tfoot>
                </table>
            @else
                <p>Нет товаров в заказе!</p>
            @endif
        </div>
    </div>
{{--
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 text-bold">ID платежа</div>
                            <div class="col-md-8">
                                <a href="{{ route('admin.sberpay.view', [$payment_order->id]) }}">{{ $payment_order->payment_id }}</a>
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 text-bold">Статус платежа</div>
                            <div class="col-md-8 {{ array_get(\Fanky\Admin\Models\PaymentOrder::$status_colors, $payment_order->status_id) }}">{{ array_get(\Fanky\Admin\Models\PaymentOrder::$statuses, $payment_order->status_id) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
--}}
@stop
