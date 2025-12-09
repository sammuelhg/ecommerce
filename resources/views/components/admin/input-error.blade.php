@props(['for'])

@error($for)
    <div class="invalid-feedback d-block">
        {{ $message }}
    </div>
@enderror
