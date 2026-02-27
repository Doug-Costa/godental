@php($items = $items ?? [])
@foreach($items as $item)
  @include('partials.result_item', ['item' => $item])
@endforeach