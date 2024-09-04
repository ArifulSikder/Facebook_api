  <!-- Modal register -->
  <div class="modal fade" id="registerUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Register User</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form action="{{ route('register-user') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="card-body">
                          <div class="form-group row">
                              <label class="col-md-3" for="name">Name</label>
                              <input type="text" name="name" id="name" required class="form-control col-md-9"
                                  placeholder="Enter User Name" value="{{ old('name') }}">
                              @error('name')
                                  <span class="text-danger">{{ $message }}</span>
                              @enderror
                          </div>
                          <div class="form-group row">
                              <label class="col-md-3" for="email">Email</label>
                              <input type="text" name="email" id="email" required class="form-control col-md-9"
                                  placeholder="Enter User Email" value="{{ old('email') }}">
                              @error('email')
                                  <span class="text-danger">{{ $message }}</span>
                              @enderror
                          </div>

                          <div class="form-group row">
                              <label class="col-md-3" for="photo">Photo</label>
                              <input type="file" name="photo" id="photoUpload" required
                                  class="form-control col-md-9" placeholder="Enter User Name"
                                  value="{{ old('photo') }}">
                              @error('photo')
                                  <span class="text-danger">{{ $message }}</span>
                              @enderror
                          </div>
                          <div class="col-md-3 offset-3">
                              <img class="previewHolder" src="" alt="">
                          </div>
                          <div class="form-group row">
                              <label class="col-md-3">User Type</label>
                              <div class="col-md-9 px-0">
                                  <select name="user_type" required class="form-control select2" style="width: 100%;">
                                      <option label="Choose Type" selected disabled>Select One</option>
                                      @foreach ($roles as $role)
                                          <option value="{{ $role->name }}">{{ $role->name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                              @error('type')
                                  <span class="text-danger">{{ $message }}</span>
                              @enderror
                          </div>
                          <div class="form-group row">
                              <label class="col-md-3" for="password">Password</label>
                              <div class="col-md-9 px-0">
                                  <input type="password" name="password" id="password" required class="form-control"
                                      placeholder="Enter User Password" value="{{ old('password') }}">
                                  @error('password')
                                      <span class="text-danger">{{ $message }}</span>
                                  @enderror
                                  <span id="password_alert" class="text-danger mb-1"></span>
                              </div>

                          </div>
                          <div class="form-group row">
                              <label class="col-md-3" for="password_confirmation">Confirm Password</label>
                              <input type="password" name="password_confirmation" id="password_confirmation" required
                                  class="form-control col-md-9" placeholder="Enter Confirmation Password"
                                  value="{{ old('password_confirmation') }}">
                              @error('password_confirmation')
                                  <span class="text-danger">{{ $message }}</span>
                              @enderror
                          </div>
                          <div class="pt-2">
                              <button type="submit" class="btn btn-block btn-primary">
                                  Register</button>
                          </div>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>
