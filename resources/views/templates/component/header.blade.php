<div class="header">
  <div class="container">
    <div class="w3layouts_logo">
      <a href="{{ route('home') }}"><h1>One<span>Movies</span></h1></a>
    </div>
    <div class="w3_search">
      <form action="{{ route('movies') }}" method="get">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search" required="">
        <input type="submit" value="Go">
      </form>
    </div>
    <div class="w3l_sign_in_register">
      <ul>
        @auth
          <li><a href="{{ route('profile.show') }}">Halo, {{ auth()->user()->name }}</a></li>
          <li>
            <form action="{{ route('logout') }}" method="post" style="display:inline;">
              @csrf
              <button type="submit" style="background:none; border:0; padding:0; color:inherit; font:inherit; cursor:pointer; text-transform:uppercase;">Logout</button>
            </form>
          </li>
        @else
          <li><a href="#" data-toggle="modal" data-target="#myModal">Login</a></li>
        @endauth
      </ul>
    </div>
    <div class="clearfix"> </div>
  </div>
</div>