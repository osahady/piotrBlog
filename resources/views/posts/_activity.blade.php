{{-- most active posts (having most comments) --}}

@card(['title' => 'Most Commented'])
    @slot('subtitle')
        What People are currently talking about?                
    @endslot
    @slot('items')
        @foreach ($mostCommented as $topPost)
            <li class="list-group-item">
                <a href="{{ route('posts.show', $topPost->id) }}" >

                    {{ $topPost->title }}
                </a>
            </li>                    
        @endforeach
    @endslot
@endcard


{{-- most active users  --}}
@card(['title' => 'Most Active Users'])
    @slot('subtitle')
        Writters are currently talking about?
    @endslot
    @slot('items', collect($mostActive)->pluck('name'))

@endcard

{{-- most active users last month --}}
@card(['title' => 'Most Active Users Last Month'])
    @slot('subtitle')
    Active users last month
    @endslot
    @slot('items', collect($mostActiveLastMonth)->pluck('name'))

@endcard


        