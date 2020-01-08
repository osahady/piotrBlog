
<p class="text-muted">
    {{-- check if it is null put added --}}
    {{ empty(trim($slot)) ? 'Added' : $slot}} {{ $date->diffForHumans() }}
    @if (isset($name))
    by {{ $name }}
        
    @endif
</p>