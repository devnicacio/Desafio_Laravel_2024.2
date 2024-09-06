@props(['route', 'id'])
<a href="{{route($route, $id)}}">
    <div class="bg-[#0571d3] hover:bg-orange-400 transition-colors text-white text-[18px] overflow-hidden shadow-sm rounded-lg flex justify-between items-center px-2 py-1">
        {{$slot}}
    </div>
</a>