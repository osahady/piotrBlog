<div class="my-3">
  @auth    
  <form action="{{ $route }} " method="POST" class="my-2">
    @csrf
    <div class="form-group mt-3">    
      <textarea class="form-control" name="content" cols="30" rows="4" ></textarea>
    </div> 
    <button class="btn btn-primary btn-block" type="submit">Add comment!</button>
          
  </form>
  @errors @enderrors
@else
  <a href="{{ route('login') }} ">Sing-in</a> to post comments
@endauth

</div>
<hr>