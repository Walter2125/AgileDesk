<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Información de perfil
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Actualiza la información de tu perfil y tu dirección de correo electrónico.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="'Nombre'" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="'Correo electrónico'" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        Tu correo electrónico no está verificado.
                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Haz clic aquí para reenviar el correo de verificación.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            Se ha enviado un nuevo enlace de verificación a tu correo electrónico.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="photo" :value="'Foto de perfil'" />
            <div class="flex items-center gap-4 mt-2">
                <span id="photo-preview-wrapper">
                    @if ($user->photo)
                        <img id="photo-preview" src="{{ asset('storage/' . $user->photo) }}" alt="Foto de perfil" class="rounded-circle" style="width: 64px; height: 64px; object-fit: cover; border: 2px solid #ddd;">
                    @else
                        <div id="photo-preview" class="user-avatar" style="width:64px;height:64px;display:flex;align-items:center;justify-content:center;font-size:2rem;background:linear-gradient(135deg,#0d6efd 60%,#6c63ff 100%);color:#fff;border-radius:50%;">
                            {{ substr($user->name,0,1) }}
                        </div>
                    @endif
                </span>
                <input id="photo" name="photo" type="file" accept="image/*" class="form-control-file" style="max-width:220px; display:none;">
                <label for="photo" class="btn btn-outline-primary" style="margin-left: 0.5rem; cursor:pointer;">Seleccionar imagen...</label>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('photo')" />
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('photo');
            const previewWrapper = document.getElementById('photo-preview-wrapper');
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        let img = document.getElementById('photo-preview');
                        if (!img || img.tagName !== 'IMG') {
                            img = document.createElement('img');
                            img.id = 'photo-preview';
                            img.className = 'rounded-circle';
                            img.style.width = '64px';
                            img.style.height = '64px';
                            img.style.objectFit = 'cover';
                            img.style.border = '2px solid #ddd';
                            // Eliminar avatar inicial si existe
                            const old = document.getElementById('photo-preview');
                            if (old) old.remove();
                            previewWrapper.appendChild(img);
                        }
                        img.src = ev.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
        </script>
        <div class="flex items-center gap-4 mt-4">
            <x-primary-button>Guardar</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >Guardado.</p>
            @endif
        </div>
    </form>
</section>