<x-app-layout>
{{-- POST MODAL --}}
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
<div class="mx-auto py-6 relative">
    <div class="text-center">
    @if (session('success'))
        {{ session('success') }}
    @elseif(session('error'))
        {{ session('error') }}  
    @endif
    </div>
    <div class="flex mx-4">
        {{-- SARAN FOLLOWING --}}
        <div class="bg-blue-500 w-1/4 text-center h-fit">
            @foreach ($users as $user)
                <div class="grid grid-cols-2 max-w-5xl mx-auto">
                    <p>{{ $user->name }}</p>
                    <form action="{{ url('follow/'.$user->id) }}" method="post">
                        @csrf
                        @if (in_array(auth()->user()->id,$user->followings->pluck('id')->toArray()))
                            <button>follow back</button>
                        @else
                            <button>follow</button>
                        @endif
                    </form>
                </div>
            @endforeach
        </div>

        {{-- POSTINGAN --}}
        <div class="w-full rounded mx-60">
            {{-- CREATE POST --}}
            <div class="bg-white rounded shadow">
                <div class="flex w-full p-4 gap-2 items-center">
                    <div class="flex items-center justify-center border-2 border-primary w-12 h-12 rounded-full px-4">
                        <i class="fa-solid fa-user text-primary scale-150"></i>
                    </div>
                    <div class="w-full">
                        <button id="btn" class="w-full text-left bg-gray-100 hover:bg-gray-200 px-4 py-4 rounded-full">Apa yang sedang kamu pikirkan, {{ auth()->user()->name }}?</button>
                    </div>
                </div>
            </div>

            {{-- ALL POST --}}
            <div class="my-10 bg-blue-400">
                <div>
                @foreach ($posts as $post)
                    <div>{{ $post->user->name }}</div>
                    <div>{{ $post->description }}</div>
                @endforeach
                </div>
            </div>
            
        </div>
        
        {{-- FOLLOWING --}}
        <div class="bg-red-500 w-1/4 text-center h-fit">
            <h4>Following ({{ $followings->count() }})</h4>
            @foreach ($followings as $user)
                    <p>{{ $user->name }}</p>
            @endforeach
        </div>
    </div>
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
