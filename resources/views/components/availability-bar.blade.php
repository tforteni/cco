@props(['availability', 'day'])

@php
$availability = $availability->where('day', $day);
$slots = [];  
foreach($availability as $slot)
{
    $time = $slot->start_time;
    while($time < $slot->end_time)
    {
        $slots[] = (int) $time;
        $time++;
    }
}  
@endphp

<div class="rounded-md flex flex-col w-full h-full border-tahini border-2">
    @for($x = 6; $x < 24; $x++)
        @if(in_array($x, $slots))
            <div id="{$x}" class="bg-navy border-b-2 border-tahini flex-1">&nbsp;</div>
        @else
            <div id="{$x}" class="border-b-2 border-tahini flex-1">&nbsp;</div>
        @endif
    @endfor
</div>