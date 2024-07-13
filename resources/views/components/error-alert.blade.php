@if ($errors->any())
    <div class="alert alert-danger d-flex flex-column gap-2 fw-bold fs-5">
        @foreach ($errors->all() as $error)
            <div>
                <i class="ri-close-circle-fill fs-4"></i>
                {{ $error }}
            </div>
        @endforeach
    </div>
@endif