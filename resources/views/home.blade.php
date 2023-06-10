<x-app-layout>
<div class="mx-auto my-6">
    <div class="text-center">
    @if (session('success'))
        {{ session('success') }}
    @else
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
        <div class="bg-green-500 w-full rounded shadow mx-60">
            <div class="h-40 bg-white rounded">
                <form action="{{ url('posts') }}" method="post" class="p-4" enctype="multipart/form-data">
                    @csrf
                    <textarea name="description" id="description" class="w-full"></textarea>
                    @error("description")
                        <small>{{ $message }}</small>
                    @enderror
                    <br>
                    <input name="image" id="image" type="file">
                    <br>
                    <button>kirim</button>
                </form>
            </div>
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
</x-app-layout>
