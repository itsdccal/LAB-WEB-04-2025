<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <img src="{{ asset('images/' . $image) }}" alt="{{ $title }}" class="w-full h-48 object-cover">
    <div class="p-4">
        <h2 class="text-xl font-semibold mb-2">{{ $title }}</h2>
        <p>{{ $slot }}</p>
    </div>
</div>
