<h3>@lang('site.client.info'):</h3>
<ul style="list-style:none">
    <li><span class="fw-bold">@lang('site.client.name'):</span> {{ $order->client->name }}</li>
    <li><span class="fw-bold">@lang('site.phone'):</span> {{ $order->client->phone }}</li>
    <li><span class="fw-bold">@lang('site.address'):</span> {{ $order->client->address }}</li>
</ul>
<h3 class="mt-3">@lang('site.order.details'):</h3>
<ul style="list-style: none">
    @foreach ($order->products as $product)
        <li class="mb-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="me-2"><bdi>{{ $product->quantity }}</bdi>X</div>
                    <img src="{{ asset($product->item->image) }}" width="40">
                    <p class="fw-bold mb-0 ms-2">{{ $product->item->title }}</p>
                </div>
                <div class=" d-flex justify-content-end align-items-center">
                    [{{ $product->item->sell_price * $product->quantity}} @lang('site.currency')]
                </div>
            </div>
        </li>
    @endforeach
</ul>
<hr>
<div class="d-flex justify-content-between ps-5">
    <p class="fw-bold">@lang('site.total_price'):</p>
    <p>[{{ $order->total_price }} @lang('site.currency')]</p>
</div>