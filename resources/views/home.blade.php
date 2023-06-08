<x-app-layout>
<div class="mx-auto">
    <div class="text-center">
    @if (session('success'))
        {{ session('success') }}
    @else
        {{ session('error') }}  
    @endif
    </div>
    @foreach ($users as $user)
    <div class="grid grid-cols-2 max-w-5xl mx-auto">
        {{-- {{ $user->follows }} --}}
        <p>{{ $user->name }}</p>
        <form action="{{ url('follow/'.$user->id) }}" method="post">
            @csrf
            <button>follow</button>
        </form>
    </div>
    @endforeach
</div>
</x-app-layout>
