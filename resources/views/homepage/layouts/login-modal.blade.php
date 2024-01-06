<div id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modalLabel" aria-hidden="true" class="modal fade">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="login-modalLabel" class="modal-title">Member Login</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('register-login.login') }}">
                    @csrf
                    <div class="form-group">
                        <input id="email_modal" type="text" placeholder="Email"
                            class="form-control  @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" value="{{ old('email') }}"
                            autofocus />

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input id="password_modal" type="password" placeholder="Password"
                            class="form-control @error('password') is-invalid @enderror" name="password"
                            value="{{ old('password') }}" required autocomplete="current-password" />

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="checkbox" class="text-secondary" id="showpassword" onclick="showPasswordLogin()">
                        <label for="showpassword">show password</label>
                    </div>
                    <p class="text-center">
                        <button type="submit" class="btn btn-template-outlined">
                            <i class="fa fa-sign-in"></i> Log in
                        </button>
                    </p>
                </form>
                <p class="text-center text-muted">Belum Daftar?</p>
                <p class="text-center text-muted">
                    <a href="{{ route('register-login') }}"><strong>Daftar sekarang!</strong></a> Mudah dan selesai
                    dalam 1 menit serta anda bisa mengakses fitur yang ada!
                </p>
            </div>
        </div>
    </div>
</div>
