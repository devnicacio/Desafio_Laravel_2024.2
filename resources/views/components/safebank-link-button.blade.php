@props(['route'])
<a href="{{route($route)}}">
    <div class="bg-[#0571d3] hover:bg-orange-400 transition-colors text-white text-[18px] overflow-hidden shadow-sm rounded-lg flex justify-between items-center px-4 py-2">
        {{$slot}}
    </div>
</a>