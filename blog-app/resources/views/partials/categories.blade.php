<div class="nav-scroller py-1 mb-2">
    <nav class="nav d-flex justify-content-around">
    	@foreach($categories as $c)
      	<a class="p-2 link-secondary" href="{{ route('category', $c->id) }}">{{ $c->title }}</a>
    	@endforeach
    </nav>
  </div>