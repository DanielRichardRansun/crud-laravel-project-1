{{-- Memberikan notifikasi berhasil input data di template --}}
@if (Session::has('success'))
<div class="pt-3">
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
</div>
@endif

{{-- Memberikan notifikasi error input data di create --}}
@if ($errors->any())
    <div class="pt-3">
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>    
    </div>    
@endif
