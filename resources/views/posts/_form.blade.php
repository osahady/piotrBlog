<div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $post->title ?? null) }}"
</div>

<div class="form-group mt-3">
    
    <label for="title">Content</label>
    <textarea class="form-control" name="content" cols="30" rows="4" >{{ Request::old('content', $post->content ?? null) }}</textarea>
</div> 

@if ($errors->any())
    <div class="form-group alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>     
            @endforeach
        </ul>
    </div>
@endif   