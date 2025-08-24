<?php

use App\Models\User;
use App\Models\RefUniversitasList;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    // Add active_status property
    public bool $active_status = false;

    // Existing properties...
    public string $name = '';
    public string $email = '';
    public string $username = '';
    public int $universitas_id;
    public string $universitas_name = '';
    public string $phone_number = '';
    public $universitas_list;
    public string $joined_date = '';
    public string $role = '';
    public array $available_roles = [];
    public bool $isAdmin = false;
    public User $editUser;
    public bool $isNameValid = false;
    public bool $isPhoneValid = false;
    public ?string $phoneError = null;
    public bool $nameModified = false;
    public bool $phoneModified = false;

    public function with(): array
    {
        return [
            'userId' => request()->route('userId'),
        ];
    }

    public function mount(): void
    {
        $userId = request()->route('userId');
        $this->editUser = User::findOrFail($userId);

        // Add active_status initialization
        $this->active_status = $this->editUser->active_status;

        // Existing initializations...
        $this->name = $this->editUser->name;
        $this->email = $this->editUser->email;
        $this->username = $this->editUser->username;
        $this->phone_number = $this->editUser->phone_number;
        if (!str_starts_with($this->phone_number, '+62')) {
            $this->phone_number = '+62' . $this->phone_number;
        }
        if(isset($this->editUser->universitas_id)){
            $this->universitas_id = $this->editUser->universitas_id;
            $this->universitas_name = $this->editUser->universitas->universitas_name;
        }

        $this->universitas_list = RefUniversitasList::all();

        $this->joined_date = $this->editUser->created_at->format('d F Y');
        $this->role = $this->editUser->role;
        $this->available_roles = User::roles();
        $this->isAdmin = $this->editUser->role === User::ROLE_ADMIN;
    }

    // Add method to toggle user status
    public function toggleUserStatus(): void
    {
        $this->editUser->active_status = !$this->editUser->active_status;
        $this->editUser->save();
        $this->active_status = $this->editUser->active_status;

        $status = $this->active_status ? 'diaktifkan' : 'dinonaktifkan';

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'Berhasil!',
            'text' => "User berhasil {$status}.",
        ]);
    }

   public function updatedName()
   {
       $this->nameModified = true;
       $this->validateName();
   }

   public function updatedPhoneNumber()
   {
       $this->phoneModified = true;
       $this->validatePhoneNumber();
   }

   protected function validateName()
   {
       $this->isNameValid = strlen($this->name) <= 19 && strlen($this->name) > 0;
   }

   protected function validatePhoneNumber()
   {
       $this->phoneError = null;

       if (!str_starts_with($this->phone_number, '+62')) {
           $this->phone_number = '+62' . substr($this->phone_number, 3);
       }

       if (strlen($this->phone_number) > 20) {
           $this->isPhoneValid = false;
           $this->phoneError = 'Nomor telepon terlalu panjang';
           return;
       }

       if (strlen($this->phone_number) < 5) {
           $this->isPhoneValid = false;
           return;
       }

       $existingUser = User::where('phone_number', $this->phone_number)
           ->where('id', '!=', $this->editUser->id)
           ->first();

       if ($existingUser) {
           $this->isPhoneValid = false;
           $this->phoneError = 'Nomor telepon sudah digunakan';
           return;
       }

       $this->isPhoneValid = true;
   }

   public function updateProfileInformation(): void
   {
       $validated = $this->validate([
           'name' => ['required', 'string', 'max:19'],
           'universitas_id' => ['required', 'exists:ref_universitas_list,id'],
           'role' => ['required', Rule::in(User::roles())],
           'phone_number' => [
               'required',
               'string',
               'max:20',
               'regex:/^\+62\d+$/',
               Rule::unique('users', 'phone_number')->ignore($this->editUser->id)
           ],
       ]);

       $this->editUser->fill($validated);
       $this->editUser->save();

       $universitas_singkatan = $this->editUser->universitas->singkatan ?? 'Unknown';

       $this->dispatch('profile-updated', name: $this->editUser->name, universitas_singkatan: $universitas_singkatan);

       $this->dispatch('swal:modal', [
           'type' => 'success',
           'title' => 'Berhasil!',
           'text' => 'Profil berhasil diperbarui.',
       ]);
   }
};

?>

<div>
    <!-- Main Content -->
    <div class="container-xl px-4">
        <div class="row">
            <!-- Profile picture card-->
            <div class="col-xl-4">
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Foto Profil</div>
                    <div class="card-body text-center">
                        <img id="avatar-image" class="img-account-profile rounded-circle mb-2"
                            src="{{ asset('assets/img/avatar/' . $editUser->avatar) }}"
                            alt="{{ $editUser->name }}"
                            style="width: 150px; height: 150px; overflow: hidden; position: relative; justify-content: center; align-items: center;" />

                        <div class="small font-italic text-muted mb-4">JPG atau PNG tidak lebih dari 1 MB</div>
                        <form id="avatar-form" method="POST" enctype="multipart/form-data" action="{{ route('profile.updateAvatar') }}">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $editUser->id }}">
                            <input type="file" name="avatar" id="avatar" accept="image/*" class="form-control mb-3" />
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateAvatarModal">
                                Upload foto baru
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <span>Detail Akun</span>
                            @if($role === 'admin')
                                <span class="badge bg-danger ms-2">Administrator</span>
                            @elseif($role === 'tutor')
                                <span class="badge bg-purple ms-2">Tutor</span>
                            @elseif($role === 'user')
                                <span class="badge bg-blue ms-2">User</span>
                            @endif
                            <span class="ms-2 badge {{ $active_status ? 'bg-success' : 'bg-danger' }}">
                                {{ $active_status ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>

                     </div>
                    <div class="card-body">
                        <form id="profile-form" wire:submit.prevent="updateProfileInformation">
                            <!-- Name -->
                            <div class="mb-3">
                                <label class="small mb-1" for="name">Nama</label>
                                <input
                                    wire:model.live="name"
                                    class="form-control {{ $nameModified ? ($isNameValid ? 'is-valid' : 'is-invalid') : '' }}"
                                    id="name"
                                    type="text"
                                    maxlength="19"
                                    placeholder="Masukkan nama anda"
                                />
                                <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
                            </div>

                            <!-- Username and Phone -->
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="username">Username</label>
                                    <input
                                        disabled
                                        class="form-control"
                                        id="username"
                                        type="text"
                                        wire:model="username"
                                    />
                                </div>

                                <div class="col-md-6">
                                    <label class="small mb-1" for="phone_number">No Telpon</label>
                                    <input
                                        wire:model.live="phone_number"
                                        class="form-control {{ $phoneModified ? ($isPhoneValid ? 'is-valid' : 'is-invalid') : '' }}"
                                        id="phone_number"
                                        type="tel"
                                        maxlength="20"
                                        placeholder="+62"
                                    />
                                    @if($phoneModified && $phoneError)
                                        <div class="small text-danger">{{ $phoneError }}</div>
                                    @endif
                                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2 text-danger" />
                                </div>
                            </div>

                            <!-- Email and Joined Date -->
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="email">Email</label>
                                    <input
                                        disabled
                                        class="form-control"
                                        id="email"
                                        type="email"
                                        wire:model="email"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="joined_date">Tanggal Bergabung</label>
                                    <input
                                        disabled
                                        class="form-control bg-light"
                                        id="joined_date"
                                        type="text"
                                        wire:model="joined_date"
                                    />
                                </div>
                            </div>

                            <!-- University and Role -->
                            <div class="row gx-3 mb-3">
                                @if(!$isAdmin && $role !== 'tutor')
                                <div class="col-md-6">
                                    <label class="small mb-1" for="universitas">Universitas</label>
                                    <select
                                        class="form-control"
                                        id="universitas"
                                        wire:model="universitas_id"
                                        @disabled($isAdmin || $role === 'tutor')>
                                        <option value="" disabled>Pilih Universitas</option>
                                        @foreach($universitas_list as $universitas)
                                            <option value="{{ $universitas->id }}">
                                                {{ $universitas->universitas_name." (".$universitas->singkatan.")" }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('universitas_id')" class="mt-2 text-danger" />
                                </div>
                                @endif
                                <div class="col-md-{{ (!$isAdmin && $role !== 'tutor') ? '6' : '12' }}">
                                    <label class="small mb-1" for="role">Role</label>
                                    <select
                                        class="form-control"
                                        id="role"
                                        wire:model="role"
                                        @disabled($isAdmin)>
                                        <option value="" disabled>Pilih Peran</option>
                                        @foreach($available_roles as $available_role)
                                            <option value="{{ $available_role }}">
                                                {{ ucfirst($available_role) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('role')" class="mt-2 text-danger" />
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="mt-4">
                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#updateProfileModal">
                                    Simpan Perubahan
                                </button>
                                <a href="#" class="btn btn-danger me-2">Reset Password</a>
                                @if(!$isAdmin)
                                    <button type="button" class="btn {{ $active_status ? 'btn-warning' : 'btn-success' }}" data-bs-toggle="modal" data-bs-target="#toggleStatusModal">
                                        {{ $active_status ? 'Nonaktifkan User' : 'Aktifkan User' }}
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Update Confirmation Modal -->
    <div class="modal fade" id="updateProfileModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateProfileModalLabel">Konfirmasi Perubahan</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin menyimpan perubahan pada profil user ini?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success" type="button" wire:click="updateProfileInformation" data-bs-dismiss="modal">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Avatar Update Confirmation Modal -->
    <div class="modal fade" id="updateAvatarModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="updateAvatarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateAvatarModalLabel">Konfirmasi Upload Foto</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin mengupload foto profil baru untuk user?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success" type="submit" form="avatar-form">Upload</button>
                </div>
            </div>
        </div>
    </div>

     <!-- Toggle Status Modal -->
     <div class="modal fade" id="toggleStatusModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="toggleStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="toggleStatusModalLabel">
                        Konfirmasi Status User
                    </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin {{ $active_status ? 'menonaktifkan' : 'mengaktifkan' }} user ini?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success" type="button" wire:click="toggleUserStatus" data-bs-dismiss="modal">
                        {{ $active_status ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if(session('swal:modal'))
        <script>
            const swalData = @json(session('swal:modal'));
            Swal.fire({
                icon: swalData.type,
                title: swalData.title,
                text: swalData.text,
            });
        </script>
    @endif

    <script>
    document.addEventListener('DOMContentLoaded', function() {
    // Handle modals
    const updateProfileModal = document.getElementById('updateProfileModal');
    const updateAvatarModal = document.getElementById('updateAvatarModal');

    // For profile update
    updateProfileModal.addEventListener('shown.bs.modal', function() {
        updateProfileModal.querySelector('.btn-primary').focus();
    });

    // Listen for Livewire profile update event
    window.addEventListener('profile-updated', event => {
        const modal = bootstrap.Modal.getInstance(updateProfileModal);
        if (modal) {
            modal.hide();
            // Remove modal backdrop if still present
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
            document.body.classList.remove('modal-open');
        }
    });

    // For avatar update - modify your avatar form to use AJAX
    const avatarForm = document.getElementById('avatar-form');
    avatarForm.addEventListener('submit', function(e) {
        e.preventDefault();

        fetch(this.action, {
            method: 'POST',
            body: new FormData(this)
        }).then(response => {
            const modal = bootstrap.Modal.getInstance(updateAvatarModal);
            if (modal) {
                modal.hide();
                // Remove modal backdrop if still present
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
                document.body.classList.remove('modal-open');
            }
            // You can handle the response here and show your success message
        }).catch(error => {
            console.error('Error:', error);
        });
    });

    // Remove duplicate avatarForm declaration and submit handler
    const avatarForm = document.getElementById('avatar-form');
    const avatarInput = document.getElementById('avatar');
    const avatarButton = document.querySelector('[data-bs-target="#updateAvatarModal"]');
    const avatarImage = document.getElementById('avatar-image');

    avatarInput.addEventListener('change', function() {
        avatarButton.disabled = this.files.length === 0;
    });

    avatarButton.disabled = avatarInput.files.length === 0;

    // Single submit handler for avatar form
    avatarForm.addEventListener('submit', function(e) {
        e.preventDefault();

        fetch(this.action, {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Hide modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('updateAvatarModal'));
            modal.hide();

            // Remove backdrop
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
            document.body.classList.remove('modal-open');

            // Show SweetAlert
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Foto profil berhasil diperbarui.'
            });

            // Reload the image with cache-busting
            const timestamp = new Date().getTime();
            avatarImage.src = avatarImage.src.split('?')[0] + '?t=' + timestamp;

            // Reset form
            avatarForm.reset();
            avatarButton.disabled = true;
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terjadi kesalahan saat mengupload foto.'
            });
        });
    });
});
    </script>
</div>
