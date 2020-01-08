<div class="card my-3">
           
        <div class="card-body">
            <h5 class="card-title">{{ $title }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">
                {{ $subtitle }}
            </h6>
            <ul class="list-group">
                @if (is_a($items, 'Illuminate\Support\Collection'))
                    @foreach ($items as $item)
                        <li class="list-group-item">
                            {{ $item }}
                        </li>                    
                    @endforeach
                    
                @else
                    {{ $items }}
                @endif
            </ul>
            
        </div>
    </div> 