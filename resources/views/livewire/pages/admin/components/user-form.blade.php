<?php

use App\Models\User;
use App\Models\RefUniversitasList;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component {
    // Form inputs
    public $name = '';
    public $email = '';
    public $username = '';
    public $password = '';
    public $password_confirmation = '';
    public $phone_number = '+62';
    public $universitas_id = '';
    public $role = '';

    // Validation states
    public bool $isNameValid = false;
    public bool $isUsernameValid = false;
    public bool $isPhoneValid = false;
    public bool $isEmailValid = false;
    public ?string $usernameError = null;
    public ?string $emailError = null;
    public ?string $phoneError = null;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:19'],
            'username' => ['required', 'string', 'max:13', 'unique:'.User::class],
            'phone_number' => ['required', 'string', 'regex:/^\+62[0-9]{8,12}$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'universitas_id' => ['required_if:role,user'],
            'role' => ['required', 'string'],
        ];
    }

    public function updatedName()
    {
        $this->isNameValid = strlen($this->name) <= 19 && strlen($this->name) > 0;
    }

    public function updatedUsername()
    {
        $this->validateUsername();
    }

    public function updatedEmail()
    {
        $this->validateEmail();
    }

    public function updatedPhoneNumber()
    {
        $this->validatePhoneNumber();
    }

    private function validateUsername()
    {
        $this->usernameError = null;

        if (strlen($this->username) > 13) {
            $this->isUsernameValid = false;
            $this->usernameError = 'Username tidak boleh lebih dari 13 karakter';
            return;
        }

        if (strlen($this->username) === 0) {
            $this->isUsernameValid = false;
            return;
        }

        if (User::where('username', $this->username)->exists()) {
            $this->isUsernameValid = false;
            $this->usernameError = 'Username sudah digunakan';
            return;
        }

        $this->isUsernameValid = true;
    }

    private function validateEmail()
    {
        $this->emailError = null;

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->isEmailValid = false;
            $this->emailError = 'Format email tidak valid';
            return;
        }

        if (User::where('email', strtolower($this->email))->exists()) {
            $this->isEmailValid = false;
            $this->emailError = 'Email sudah digunakan';
            return;
        }

        $this->isEmailValid = true;
    }

    private function validatePhoneNumber()
    {
        $this->phoneError = null;

        if (!str_starts_with($this->phone_number, '+62')) {
            if (str_starts_with($this->phone_number, '0')) {
                $this->phone_number = '+62' . substr($this->phone_number, 1);
            } elseif (str_starts_with($this->phone_number, '62')) {
                $this->phone_number = '+' . $this->phone_number;
            } else {
                $this->phone_number = '+62' . $this->phone_number;
            }
        }

        $digits = substr($this->phone_number, 3);
        if (strlen($digits) < 8) {
            $this->isPhoneValid = false;
            $this->phoneError = 'Nomor telepon terlalu pendek';
            return;
        }

        if (strlen($digits) > 12) {
            $this->isPhoneValid = false;
            $this->phoneError = 'Nomor telepon terlalu panjang';
            return;
        }


        if(User::where('phone_number', $this->phone_number)->exists()){
            $this->isPhoneValid = false;
            $this->phoneError = 'Nomor telepon sudah digunakan';
            return;
        }

        $this->isPhoneValid = true;
    }

    private function generateReferralCode(): string
    {
        do {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $code = '';
            for ($i = 0; $i < 6; $i++) {
                $code .= $characters[rand(0, strlen($characters) - 1)];
            }
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }

    public function save()
    {
        $validated = $this->validate();

        try {
            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => strtolower($validated['email']),
                'phone_number' => $validated['phone_number'],
                'password' => Hash::make($validated['password']),
                'universitas_id' => $validated['universitas_id'] ?? null,
                'role' => $validated['role'],
                'referral_code' => $this->generateReferralCode(),
                'active_status' => true
            ]);

            session()->flash('alert', [
                'type' => 'success',
                'title' => 'Registrasi Berhasil!',
                'message' => "User berhasil ditambahkan!"
            ]);
            return redirect()->route('admin.users');

        } catch (\Exception $e) {
            $this->dispatch('error', 'Terjadi kesalahan saat menambahkan user.' . $e->getMessage());
        }
    }

    public function render(): mixed
    {
        return view('livewire.pages.admin.components.user-form');
    }
}; ?>

<div>
    <div class="container-xl px-4">
        <div class="row">
            <!-- Account Details Card -->
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Detail Akun</span>
                            <span class="badge bg-success">User Baru</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <form wire:submit="save">
                            <!-- Name -->
                            <div class="mb-3">
                                <label class="small mb-1" for="name">Nama</label>
                                <input wire:model.live="name"
                                    class="form-control {{ strlen($name) > 0 ? ($isNameValid ? 'is-valid' : 'is-invalid') : '' }}"
                                    type="text"
                                    maxlength="19"
                                    placeholder="Masukkan nama" />
                                @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <!-- Username and Email -->
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="username">Username</label>
                                    <input wire:model.live.debounce.500ms="username"
                                        class="form-control @if($username) {{ $isUsernameValid ? 'is-valid' : 'is-invalid' }} @endif"
                                        type="text"
                                        maxlength="13"
                                        placeholder="Masukkan username" />
                                    @if($usernameError)
                                        <div class="small text-danger">{{ $usernameError }}</div>
                                    @endif
                                    @error('username') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="email">Email</label>
                                    <input wire:model.live.debounce.500ms="email"
                                        class="form-control @if($email) {{ $isEmailValid ? 'is-valid' : 'is-invalid' }} @endif"
                                        type="email"
                                        placeholder="Masukkan email" />
                                    @if($emailError)
                                        <div class="small text-danger">{{ $emailError }}</div>
                                    @endif
                                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Phone Number and Role -->
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="phone_number">No Telp</label>
                                    <input wire:model.live="phone_number"
                                        class="form-control @if($phone_number != '+62') {{ $isPhoneValid ? 'is-valid' : 'is-invalid' }} @endif"
                                        type="tel"
                                        placeholder="+62" />
                                    @if($phoneError)
                                        <div class="small text-danger">{{ $phoneError }}</div>
                                    @endif
                                    @error('phone_number') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="role">Role</label>
                                    <select wire:model="role" class="form-control" id="role">
                                        <option value="">Pilih Role</option>
                                        @foreach(['admin', 'tutor', 'user'] as $r)
                                            <option value="{{ $r }}">{{ ucfirst($r) }}</option>
                                        @endforeach
                                    </select>
                                    @error('role') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="password">Password</label>
                                    <input wire:model="password"
                                        class="form-control"
                                        type="password"
                                        placeholder="Masukkan password" />
                                    @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="password_confirmation">Konfirmasi Password</label>
                                    <input wire:model="password_confirmation"
                                        class="form-control"
                                        type="password"
                                        placeholder="Konfirmasi password" />
                                </div>
                            </div>

                            <!-- University -->
                            <div class="mb-3">
                                <label class="small mb-1" for="universitas_id">Universitas</label>
                                <select wire:model="universitas_id" class="form-control" id="universitas_id">
                                    <option value="">Pilih Universitas</option>
                                    @foreach(\App\Models\RefUniversitasList::all() as $univ)
                                        <option value="{{ $univ->id }}">
                                            {{ $univ->universitas_name }} ({{ $univ->singkatan }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('universitas_id') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <!-- Submit Buttons -->
                            <div class="d-flex mt-4">
                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#confirmModal">
                                    Tambah User
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Modal -->
    <div class="modal fade" id="confirmModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Tambah User</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Apakah anda yakin ingin menambahkan user baru?</div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success" type="button" wire:click="save" data-bs-dismiss="modal">Tambah</button>
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        $wire.on('error', (message) => {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message,
            });
        });
    </script>
    @endscript
</div>
