<div class="header_bottom sticky-top " style="background-color: #162312;">
    <div class="container">
      <nav class="navbar navbar-expand-lg">
        <button class="navbar-toggler bg-light " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            @foreach ($genres as $genre)
              <a class="nav-link text-capitalize pe-2" href="{{ route('home.movieByGenre', ['g_Slug'=>$genre->g_Slug, 'genreId'=>$genre->id]) }}">{{ $genre->g_Name }}</a>
            @endforeach
            
          </div>
        </div>
        
      </nav>
    </div>
  </div>