<button class="{{$attr['class']}}">
    @if(isset($attr['icon']))
    <i class="{{$attr['icon']}}"></i>
    @endif
    
    {{$attr['label']}}
</button>