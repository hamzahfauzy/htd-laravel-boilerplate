<a href="{{$attr['url']}}" target="{{isset($attr['target']) ? $attr['target'] : '_self'}}" class="{{$attr['class']}}">
    @if(isset($attr['icon']))
    <i class="{{$attr['icon']}}"></i>
    @endif

    {{$attr['label']}}
</a>