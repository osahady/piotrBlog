<div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $post->title ?? null) }}">
</div>

<div class="form-group mt-3">    
    <label for="title">Content</label>
    <textarea class="form-control" name="content" cols="30" rows="4" >{{ Request::old('content', $post->content ?? null) }}</textarea>
</div> 
<div class="form-group custom-file">
    <input type="file" name="thumbnail" class="custom-file-input">
    <label for="title" class="custom-file-label">Thumbnail</label>

</div>

@errors @enderrors 