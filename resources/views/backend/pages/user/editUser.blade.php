     <!-- Modal edit -->
     <div class="modal fade editUser" id="editUser{{ $user->id }}" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <form action="{{ route('update-user') }}" method="POST" enctype="multipart/form-data">
                         @csrf
                         <input type="hidden" name="id" value="{{ $user->id }}">
                         <div class="card-body">
                             <div class="form-group row">
                                 <label class="col-md-3" for="name">Name</label>
                                 <input type="text" name="name" data-validation='required'
                                     class="form-control col-md-9 name" placeholder="Enter User Name"
                                     value="{{ $user->name }}" required>
                                 @error('name')
                                     <span class="text-danger">{{ $message }}</span>
                                 @enderror
                             </div>
                             <div class="form-group row">
                                 <label class="col-md-3" for="email">Email</label>
                                 <input type="email" name="email" data-validation='required'
                                     class="form-control col-md-9 email" placeholder="Enter User Email"
                                     value="{{ $user->email }}">
                                 @error('email')
                                     <span class="text-danger">{{ $message }}</span>
                                 @enderror
                             </div>

                             <div class="form-group row">
                                 <label class="col-md-3" for="photo">Photo</label>
                                 <input type="file" name="photo" data-validation='required'
                                     class="form-control col-md-9 photoUpdate" value="{{ $user->photo }}">
                                 @error('photo')
                                     <span class="text-danger">{{ $message }}</span>
                                 @enderror
                             </div>

                             <div class="col-md-3 offset-3">
                                 <img width="100px" class="previewUpdate" src="{{ asset($user->photo) }}"
                                     alt="">
                             </div>

                             <div class="form-group row">
                                 <label class="col-md-3">User Type</label>
                                 <div class="col-md-9 px-0">
                                     <select name="user_type" required class="form-control select2"
                                         style="width: 100%;">
                                         <option label="Choose Type" selected disabled>Select One</option>
                                         @foreach ($roles as $role)
                                             <option value="{{ $role->id }}"
                                                 {{ $role->id == role_check($user->id)->role_id ? 'selected' : '' }}>
                                                 {{ $role->name }}
                                             </option>
                                         @endforeach
                                     </select>
                                 </div>
                                 @error('user_type')
                                     <span class="text-danger">{{ $message }}</span>
                                 @enderror
                             </div>
                             <div class="pt-2">
                                 <button type="submit" class="btn btn-block btn-primary">
                                     Update</button>
                             </div>
                         </div>
                     </form>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-danger rounded-pill" data-dismiss="modal">Close</button>
                 </div>
             </div>
         </div>
     </div>
