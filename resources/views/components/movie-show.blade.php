@extends('templates.index')

@push('style')
  <link rel="stylesheet" type="text/css" href="{{ asset('template/list-css/table-style.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('template/list-css/basictable.css') }}" />
@endpush

@push('scripts')

<script type="text/javascript" src="{{ asset('template/list-js/jquery.basictable.min.js') }}"></script>
 <script type="text/javascript">
    $(document).ready(function() {
      $('#table').basictable();
      $('#table-breakpoint').basictable({
        breakpoint: 768
      });
    });
  </script>
@endpush

@section('content')

<div class="container">
  <br />
  <!-- /w3l-medile-movies-grids -->
    <div class="agileits-single-top">
      <ol class="breadcrumb">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('movies') }}">Movies</a></li>
        <li class="active">{{ $film->title }}</li>
      </ol>
    </div>
    <div class="single-page-agile-info">
                 <!-- /movie-browse-agile -->
                         <div class="show-top-grids-w3lagile">
      <div class="col-sm-8 single-left">
        <div class="song">
          <div class="single-right-grids">

            <div class="col-md-4 single-right-grid-left">
              <a href="{{ route('movies.show', $film->id) }}"><img src="/{{ $film->poster }}" alt="" /></a>
            </div>
            <div class="col-md-8 single-right-grid-right">
              <div class="song-info">
                <h2>{{ $film->title }}</h2>	
                <p class="author"><a href="#" class="author">{{ $film->year }}</a></p>
                <p class="views">{{ $film->sinopsis }}</p>
              </div>
              <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab">
                  <div class="agile-news-table">
                    <table id="table-breakpoint">
                      <thead>
                        <tr>
                        <th>Cast</th>
                        <th>Peran</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($perans as $peran)
                        <tr>
                          <td class="w3-list-info">{{ $peran->cast->name ?? '-' }}</td>
                          <td class="w3-list-info">{{ $peran->actor }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"> </div>
          </div>
        </div>
        <div class="song-grid-right">
          <div class="share">
            <h5>Share this</h5>
            <div class="single-agile-shar-buttons">
            <ul>
              <li>
                <div class="fb-like" data-href="https://www.facebook.com/w3layouts" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>
                <script>(function(d, s, id) {
                  var js, fjs = d.getElementsByTagName(s)[0];
                  if (d.getElementById(id)) return;
                  js = d.createElement(s); js.id = id;
                  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.7";
                  fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));</script>
              </li>
              <li>
                <div class="fb-share-button" data-href="https://www.facebook.com/w3layouts" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.facebook.com%2Fw3layouts&amp;src=sdkpreparse">Share</a></div>
              </li>
              <li class="news-twitter">
                <a href="https://twitter.com/w3layouts" class="twitter-follow-button" data-show-count="false">Follow @w3layouts</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
              </li>
              <li>
                <a href="https://twitter.com/intent/tweet?screen_name=w3layouts" class="twitter-mention-button" data-show-count="false">Tweet to @w3layouts</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
              </li>
              <li>
                <!-- Place this tag where you want the +1 button to render. -->
                <div class="g-plusone" data-size="medium"></div>

                <!-- Place this tag after the last +1 button tag. -->
                <script type="text/javascript">
                  (function() {
                  var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                  po.src = 'https://apis.google.com/js/platform.js';
                  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                  })();
                </script>
              </li>
            </ul>
          </div>
          </div>
        </div>
        <div class="clearfix"> </div>
        <div class="all-comments">
          <div class="all-comments-info">
            <a href="#">Comments</a>

            @if (session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="agile-info-wthree-box">
              @auth
              @if ($errors->any())
                <div class="alert alert-danger">
                  <ul style="margin:0;">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
              <form action="{{ route('comments.store', $film->id) }}" method="post">
                @csrf
                <textarea name="comment" class="comment-input" placeholder="Tulis komentar..." required>{{ old('comment') }}</textarea>
                <div class="comment-rating-row">
                  <span class="rating-label">Rating:</span>
                  <div class="star-rating" data-rating-value="{{ old('rating', 5) }}">
                    <input type="hidden" name="rating" value="{{ old('rating', 5) }}">
                    @for ($i = 1; $i <= 5; $i++)
                      <span class="star" data-value="{{ $i }}">&#9733;</span>
                    @endfor
                  </div>
                </div>			           					   
                <input type="submit" value="SEND">
                <div class="clearfix"> </div>
              </form>
              @else
                <p>Silakan <a href="#" data-toggle="modal" data-target="#myModal">login</a> untuk menulis komentar.</p>
              @endauth
            </div>
          </div>
          <div class="media-grids">
            @foreach ($comments as $comment)
              <div class="media">
                @if (auth()->check() && auth()->id() === $comment->user_id)
                  <div class="comment-menu">
                    <button type="button" class="comment-menu-toggle" aria-haspopup="true" aria-expanded="false" title="Opsi">
                      <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                    </button>
                    <div class="comment-menu-dropdown">
                      <button type="button" class="comment-menu-item comment-menu-edit" data-toggle="collapse" data-target="#edit-comment-{{ $comment->id }}">
                        <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                      </button>
                      <form action="{{ route('comments.destroy', $comment->id) }}" method="post" class="comment-delete-form" onsubmit="return confirm('Yakin ingin menghapus komentar ini? Tindakan ini tidak dapat dibatalkan.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="comment-menu-item comment-menu-delete">
                          <i class="fa fa-trash-o" aria-hidden="true"></i> Hapus
                        </button>
                      </form>
                    </div>
                  </div>
                @endif
                <h5>{{ $comment->user->name ?? 'User' }}</h5>
                <div class="media-left">
                  <a href="#">
                    <img src="{{ asset('storage/images/user.jpg') }}" title="One movies" alt=" " />
                  </a>
                </div>
                <div class="media-body">
                  <p>{{ $comment->comment }}</p>
                  <small>Rating: {{ $comment->rating }}/5</small>

                  @if (auth()->check() && auth()->id() === $comment->user_id)
                    <div class="collapse" id="edit-comment-{{ $comment->id }}" style="margin-top:8px;">
                      <form action="{{ route('comments.update', $comment->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <textarea name="comment" class="form-control comment-input" required>{{ $comment->comment }}</textarea>
                        <div class="comment-rating-row" style="margin-top:6px;">
                          <span class="rating-label">Rating:</span>
                          <div class="star-rating" data-rating-value="{{ $comment->rating }}">
                            <input type="hidden" name="rating" value="{{ $comment->rating }}">
                            @for ($i = 1; $i <= 5; $i++)
                              <span class="star" data-value="{{ $i }}">&#9733;</span>
                            @endfor
                          </div>
                        </div>
                        <button type="submit" class="btn btn-xs btn-primary" style="margin-top:6px;">Simpan</button>
                      </form>
                    </div>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
      <div class="col-md-4 single-right">
        <h3>Similar Film By Genre</h3>
        @foreach ($filmByGenre as $film)
          <div class="single-grid-right">
            <div class="single-right-grids">
              <div class="col-md-4 single-right-grid-left">
<a href="{{ route('movies.show', $film->id) }}"><img src="{{ asset($film->poster) }}" alt="" /></a>
              </div>
              <div class="col-md-8 single-right-grid-right">
                <a href="{{ route('movies.show', $film->id) }}" class="title">{{ $film->title }}</a>
                <p class="author"><a href="#" class="author">{{ $film->year }}</a></p>
                <p class="views" style="text-align: justify; margin-right: 10px">{{ $film->sinopsis }}</p>
              </div>
              <div class="clearfix"> </div>
            </div>
          </div>
        @endforeach
      </div>
      <div class="clearfix"> </div>
    </div>
      <!-- //movie-browse-agile -->
      <!--body wrapper start-->
    <div class="w3_agile_banner_bottom_grid">
      <div id="owl-demo" class="owl-carousel owl-theme">
        @foreach ($filmByRelease as $filmRelease)
          <div class="item">
            <div class="w3l-movie-gride-agile w3l-movie-gride-agile1">
              <a href="{{ route('movies.show', $filmRelease->id) }}" class="hvr-shutter-out-horizontal"><img src="/{{ $filmRelease->poster }}" title="{{ $filmRelease->title }}" class="img-responsive" alt=" " />
                <div class="w3l-action-icon"><i class="fa fa-play-circle" aria-hidden="true"></i></div>
              </a>
              <div class="mid-1 agileits_w3layouts_mid_1_home">
                <div class="w3l-movie-text">
                  <h6><a href="{{ route('movies.show', $filmRelease->id) }}">{{ $filmRelease->title }}</a></h6>							
                </div>
                <div class="mid-2 agile_mid_2_home">
                  <p>{{ $filmRelease->year }}</p>
                  <div class="block-stars">
                    <ul class="w3l-ratings">
                      <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                      <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                      <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                      <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                      <li><a href="#"><i class="fa fa-star-half-o" aria-hidden="true"></i></a></li>
                    </ul>
                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
              @if ($filmRelease->year == now()->year)
                <div class="ribben">
                  <p>NEW</p>
                </div>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>
  <!--body wrapper end-->
          
             
      </div>
      <!-- //w3l-latest-movies-grids -->
    </div>	
  </div>
@endsection

@push('scripts')
<script src="{{ asset('template/js/simplePlayer.js') }}"></script>
<script>
	$("document").ready(function() {
		$("#video").simplePlayer();
	});
</script>
@endpush

@push('style')
<style>
  .comment-input {
    width: 100% !important;
    min-height: 90px;
    border: 1px solid #D4D3D3;
    padding: 10px;
    font-size: 13px;
    outline: none;
    resize: vertical;
  }
  .comment-rating-row {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    gap: 8px;
    margin: 1em 0;
  }
  .comment-rating-row .rating-label {
    font-size: 13px;
    color: #666;
  }
  .star-rating {
    font-size: 24px;
    line-height: 1;
    color: #ccc;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }
  .star-rating .star {
    display: inline-block;
    padding: 0 1px;
    transition: color .15s, transform .15s;
    -webkit-transition: color .15s, transform .15s;
  }
  .star-rating .star.active {
    color: #f5b301;
  }
  .star-rating .star:hover {
    -webkit-transform: scale(1.15);
    -ms-transform: scale(1.15);
    transform: scale(1.15);
  }
  .media {
    position: relative;
    overflow: visible;
  }
  .comment-menu {
    position: absolute;
    top: 0;
    right: 0;
    z-index: 20;
  }
  .comment-menu-toggle {
    border: 0;
    background: transparent;
    color: #9aa0a6;
    padding: 4px 9px;
    font-size: 16px;
    line-height: 1;
    cursor: pointer;
    border-radius: 50%;
    transition: background .2s, color .2s;
    -webkit-transition: background .2s, color .2s;
  }
  .comment-menu-toggle:hover,
  .comment-menu.open .comment-menu-toggle {
    background: #f0f0f0;
    color: #333;
  }
  .comment-menu-dropdown {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: 4px;
    min-width: 130px;
    background: #fff;
    border: 1px solid #e6e6e6;
    border-radius: 6px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, .14);
    padding: 4px;
    z-index: 30;
  }
  .comment-menu.open .comment-menu-dropdown {
    display: block;
  }
  .comment-menu-item {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    gap: 8px;
    width: 100%;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    border: 0;
    background: transparent;
    text-align: left;
    padding: 8px 10px;
    font-size: 13px;
    color: #444;
    cursor: pointer;
    border-radius: 4px;
    text-decoration: none;
    transition: background .15s, color .15s;
    -webkit-transition: background .15s, color .15s;
  }
  .comment-menu-item i {
    width: 14px;
    text-align: center;
  }
  .comment-menu-item:hover {
    background: #f5f5f5;
    color: #222;
  }
  .comment-menu-delete {
    color: #d9534f;
  }
  .comment-menu-delete:hover {
    background: #fdecea;
    color: #c9302c;
  }
  .comment-delete-form {
    margin: 0;
  }
</style>
@endpush

@push('script')
$(function () {
  $('.star-rating').each(function () {
    var $box = $(this);
    var $stars = $box.find('.star');
    var $input = $box.find('input[name="rating"]');
    var paint = function (n) {
      $stars.each(function () {
        $(this).toggleClass('active', parseInt($(this).data('value'), 10) <= n);
      });
    };
    paint(parseInt($input.val(), 10) || 0);
    $stars.on('mouseenter', function () { paint(parseInt($(this).data('value'), 10)); });
    $box.on('mouseleave', function () { paint(parseInt($input.val(), 10) || 0); });
    $stars.on('click', function () {
      var n = parseInt($(this).data('value'), 10);
      $input.val(n);
      paint(n);
    });
  });
});

$(function () {
  $(document).on('click', '.comment-menu-toggle', function (e) {
    e.stopPropagation();
    var $menu = $(this).closest('.comment-menu');
    $('.comment-menu').not($menu).removeClass('open');
    $menu.toggleClass('open');
  });

  $(document).on('click', '.comment-menu-item', function () {
    $(this).closest('.comment-menu').removeClass('open');
  });

  $(document).on('click', function () {
    $('.comment-menu').removeClass('open');
  });
});
@endpush