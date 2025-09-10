@extends('admin.layouts.header')
@section('title', "Gallery")

@section('content')
    <h2>
        @if(isset($galleryFolder))
            Images in Folder: {{ $galleryFolder->name }}
        @else
            All Images
        @endif
    </h2>

    <a href="{{ route('admin.gallery.create') }}">+ Add Image</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Preview</th>
                <th>Link</th>
                <th>Folder</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($galleries as $gallery)
                <tr>
                    <td>{{ $gallery->id }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $gallery->image) }}" 
                            width="80" 
                            alt="{{ $gallery->alt ?? 'Gallery Image' }}">
                    </td>
                    <td>
                        <input type="text" 
                            id="link-{{ $gallery->id }}" 
                            value="{{ asset('storage/' . ltrim($gallery->image, '/')) }}" 
                            readonly 
                            style="width:250px;">

                        <button type="button" onclick="copyToClipboard('link-{{ $gallery->id }}')">
                            Copy
                        </button>
                    </td>
                    <td>{{ $gallery->folder?->name ?? 'No Folder' }}</td>
                    <td>
                        <a href="{{ route('admin.gallery.edit', $gallery->id) }}">Edit</a>
                        <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No images found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Show pagination only if $galleries is paginated --}}
    @if(method_exists($galleries, 'links'))
        {{ $galleries->links() }}
    @endif
    <script>
function copyToClipboard(inputId) {
    const input = document.getElementById(inputId);

    if (navigator.clipboard) {
        // Modern way (async + supported on most modern browsers)
        navigator.clipboard.writeText(input.value)
            .then(() => {
                alert("Copied: " + input.value);
            })
            .catch(err => {
                console.error("Clipboard copy failed: ", err);
                fallbackCopy(input);
            });
    } else {
        // Fallback for older browsers
        fallbackCopy(input);
    }
}

function fallbackCopy(input) {
    input.select();
    input.setSelectionRange(0, 99999); // For mobile
    try {
        const successful = document.execCommand('copy');
        alert(successful ? "Copied: " + input.value : "Copy failed");
    } catch (err) {
        console.error('Fallback copy failed:', err);
        alert("Copy not supported in this browser.");
    }
}
</script>
@endsection

