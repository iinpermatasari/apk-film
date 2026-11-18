<div class="modal video-modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Sign In & Sign Up
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
      </div>
      <section>
        <div class="modal-body">
          <div class="w3_login_module">
            <div class="module form-module">
              <div class="toggle"><i class="fa fa-times fa-pencil"></i>
              <div class="tooltip">Click Me</div>
              </div>
              <div class="form">
              <h3>Login to your account</h3>
              <form action="{{ route('login.submit') }}" method="post">
                @csrf
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required="">
                @error('email', 'login')<span style="display:block;color:#a94442;font-size:13px;">{{ $message }}</span>@enderror
                <input type="password" name="password" placeholder="Password" required="">
                @error('password', 'login')<span style="display:block;color:#a94442;font-size:13px;">{{ $message }}</span>@enderror
                <input type="submit" value="Login">
              </form>
              </div>
              <div class="form">
              <h3>Create an account</h3>
              <form action="{{ route('register') }}" method="post">
                @csrf
                <input type="text" name="name" value="{{ $errors->register->any() ? old('name') : '' }}" placeholder="Username" required="">
                @error('name', 'register')<span style="display:block;color:#a94442;font-size:13px;">{{ $message }}</span>@enderror
                <input type="password" name="password" placeholder="Password" required="">
                @error('password', 'register')<span style="display:block;color:#a94442;font-size:13px;">{{ $message }}</span>@enderror
                <input type="email" name="email" value="{{ $errors->register->any() ? old('email') : '' }}" placeholder="Email Address" required="">
                @error('email', 'register')<span style="display:block;color:#a94442;font-size:13px;">{{ $message }}</span>@enderror
                <input type="text" name="phone" value="{{ $errors->register->any() ? old('phone') : '' }}" placeholder="Phone Number" required="">
                @error('phone', 'register')<span style="display:block;color:#a94442;font-size:13px;">{{ $message }}</span>@enderror
                <input type="submit" value="Register">
              </form>
              </div>
              <div class="cta"><a href="#">Forgot your password?</a></div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
<script>
  $('.toggle').click(function(){
    // Switches the Icon
    $(this).children('i').toggleClass('fa-pencil');
    // Switches the forms  
    $('.form').animate({
    height: "toggle",
    'padding-top': 'toggle',
    'padding-bottom': 'toggle',
    opacity: "toggle"
    }, "slow");
  });

  @if (! auth()->check() && $errors->register->any())
    $(function () {
      $('#myModal').modal('show');
      $('#myModal .toggle').trigger('click');
    });
  @elseif (! auth()->check() && $errors->login->any())
    $(function () { $('#myModal').modal('show'); });
  @endif
</script>
