<div class="item-container d-flex align-items-center">
    <div class="item-label"><b>{!! is_array($label) ? $label['label'] : $label !!}</b></div>
    <div class="item-value">: {!! is_array($label) && isset($label['content']) ? $label['content'](\Arr::get($data, $value, '')) : \Arr::get($data, $value, '') !!}</div>
</div>