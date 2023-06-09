<x-app-layout>
<div class="mx-auto">
    <div class="text-center">
    @if (session('success'))
        {{ session('success') }}
    @else
        {{ session('error') }}  
    @endif
    </div>
    <div class="flex mx-40 gap-4">
        <div class="bg-blue-500 w-1/4 text-center">
            @foreach ($users as $user)
                <div class="grid grid-cols-2 max-w-5xl mx-auto">
                    <p>{{ $user->name }}</p>
                    <form action="{{ url('follow/'.$user->id) }}" method="post">
                        @csrf
                        @if (auth()->user()->followers->contains($user->id))
                            <button>follow back</button>
                        @else
                            <button>follow</button>
                        @endif
                    </form>
                </div>
            @endforeach
        </div>
        <div class="bg-green-500 w-full">
            
        </div>
        <div class="bg-red-500 w-1/4 text-center">
            <h4>Followers ({{ $followers->count() }})</h4>
            @foreach ($followers as $user)
                    <p>{{ $user->name }}</p>
            @endforeach
        </div>
    </div>
</div>
</x-app-layout>
