<x-app-layout>
<div id="modal" class="bg-black w-full h-[100vh] absolute z-50 hidden">
    <form action="{{ url('posts') }}" method="post" class="bg-white p-4 rounded shadow absolute w-full max-w-2xl top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" enctype="multipart/form-data">
        @csrf
        <div class="flex items-center gap-2">
            <div class="flex items-center justify-center border-2 border-primary w-12 h-12 rounded-full px-4">
                <i class="fa-solid fa-user text-primary scale-150"></i>
            </div>
            <p class="font-bold text-xl">{{ auth()->user()->name }}</p>
        </div>
        <textarea name="description" id="description" class="w-full border-none " placeholder="Apa yang sedang kamu pikirkan, {{ auth()->user()->name }}?"></textarea>
        @error("description")
            <small>{{ $message }}</small>
        @enderror
        <div>
            <input name="photo" type="file">
        </div>
        <button class="w-full bg-primary my-2 rounded font-bold text-white py-2">Kirim</button>
    </form>
</div>

<div class="max-w-5xl mx-auto my-4">
    {{-- HEADER --}}
    <div class="bg-white flex gap-4 p-4">
        <div class="flex items-center justify-center border-2 border-primary w-20 h-20 rounded-full px-4">
            <i class="fa-solid fa-user text-primary scale-150 px-8"></i>
        </div>
        <div class="flex items-center justify-between w-full">
            <h3 class="text-4xl">{{ $user->name }}</h3>
            <div class="flex gap-8">
                <div>
                    <p>Followers</p>
                    <p class="text-center">{{ $followers }}</p>
                </div>
                <div>
                    <p>Followings</p>
                    <p class="text-center">{{ $followings }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- UPDATE POST --}}
    <div class="bg-white rounded shadow my-4">
        <div class="flex w-full p-4 gap-2 items-center">
            <div class="flex items-center justify-center border-2 border-primary w-12 h-12 rounded-full px-4">
                <i class="fa-solid fa-user text-primary scale-150"></i>
            </div>
            <div class="w-full">
                <button id="btn" class="w-full text-left bg-gray-100 hover:bg-gray-200 px-4 py-4 rounded-full">Apa yang sedang kamu pikirkan, {{ auth()->user()->name }}?</button>
            </div>
        </div>
    </div>

    {{-- MY POST --}}
    @foreach ($posts as $post)
        <div class="bg-white rounded shadow my-4 p-4">
            <div class="flex gap-2">
                <div class="flex items-center justify-center border-2 border-primary w-12 h-12 rounded-full px-4">
                    <i class="fa-solid fa-user text-primary scale-150"></i>
                </div>
                <div>
                    <p class="font-bold text-xl">{{ $post->user->name }}</p>
                    <small class="text-secondary">{{ $post->created_at->format('d-m-Y') }}</small>
                </div>
            </div>
            <div>
                <p class="px-4">{{ $post->description }}</p>
                @if ($post->photo!=null)
                <div>
                    <img src="{{ 'storage/'.$post->photo }}" alt="photo" class="object-contain h-80 mx-auto border rounded-md">
                </div>
                @endif
                <form action="">
                    <button class="w-full py-2 border-b hover:text-primary "><i class="fa-regular fa-thumbs-up mx-1"></i>Like</button>
                </form>
            </div>
        </div>
    @endforeach
</div>


<script>
    const btn = document.querySelector('#btn');
    const modal = document.querySelector('#modal');

    btn.addEventListener('click', function(){
        modal.classList.toggle('hidden')
        modal.classList.toggle('flex')
    })
</script>
</x-app-layout>