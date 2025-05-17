<a href="javascript:void(0)" class="{{$attr['class']}} libraries-delete-btn" data-url="{{$attr['url']}}">
    @if(isset($attr['icon']))
    <i class="{{$attr['icon']}}"></i>
    @endif

    {{$attr['label']}}
</a>

<form action="{{$attr['url']}}" method="post">
@csrf
@method('DELETE')
</form>