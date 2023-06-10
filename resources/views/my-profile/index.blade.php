{{-- <div id="modal" class="bg-black w-full h-full fixed z-50 hidden bg-opacity-90 shadow-xl">
    <form action="{{ url('posts') }}" method="post" class="bg-white p-4 rounded shadow absolute w-full max-w-2xl top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" enctype="multipart/form-data">
        @csrf
        <div class="flex items-center gap-2">
            <div class="flex items-center justify-center border-2 border-primary w-12 h-12 rounded-full px-4">
                <i class="fa-solid fa-user text-primary scale-150"></i>
            </div>
            <p class="font-bold text-xl">{{ auth()->user()->name }}</p>
        </div>
        <textarea name="description" id="description" class="w-full border-none " placeholder="Apa yang sedang kamu pikirkan, {{ auth()->user()->name }}?"></textarea>
        <div>
            <input name="photo" type="file">
        </div>
        <button class="w-full bg-primary my-2 rounded font-bold text-white py-2">Kirim</button>
    </form>
</div> --}}

<div id="defaultModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full max-h-full bg-black bg-opacity-90">
    <div class="relative w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-start justify-between mx-4 py-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900 ">
                    Buat postingan
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-hide="defaultModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ url('posts/') }}" method="post" class="p-4" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="flex items-center gap-2">
                    <div class="flex items-center justify-center border-2 border-primary w-12 h-12 rounded-full px-4">
                        <i class="fa-solid fa-user text-primary scale-150"></i>
                    </div>
                    <p class="font-bold text-xl">{{ auth()->user()->name }}</p>
                </div>
                <textarea name="description" id="description" class="w-full border-none" placeholder="Apa yang sedang kamu pikirkan, {{ auth()->user()->name }}"></textarea>
                <div>
                    <input name="photo" type="file">
                </div>
                <button class="w-full bg-primary my-2 rounded font-bold text-white py-2">Kirim</button>
            </form>
        </div>
    </div>
</div>


<x-app-layout>

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

    {{-- BUAT POST --}}
    <div class="bg-white rounded shadow my-4">
        <div class="flex w-full p-4 gap-2 items-center">
            <div class="flex items-center justify-center border-2 border-primary w-12 h-12 rounded-full px-4">
                <i class="fa-solid fa-user text-primary scale-150"></i>
            </div>
            <div class="w-full">
                <button data-modal-target="defaultModal" data-modal-toggle="defaultModal" class="w-full text-left bg-gray-100 hover:bg-gray-200 px-4 py-4 rounded-full">Apa yang sedang kamu pikirkan, {{ auth()->user()->name }}?</button>
            </div>
        </div>
    </div>

    {{-- MY POST --}}
    @foreach ($posts as $post)
    
<!-- Modal toggle -->

  
    <!-- Main modal -->
    <div id="defaultModal{{ $post->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full max-h-full bg-black bg-opacity-90">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-start justify-between mx-4 py-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900 ">
                        Edit postingan
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-hide="defaultModal{{ $post->id }}">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ url('my-profile/posts/'.$post->id) }}" method="post" class="p-4" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="flex items-center gap-2">
                        <div class="flex items-center justify-center border-2 border-primary w-12 h-12 rounded-full px-4">
                            <i class="fa-solid fa-user text-primary scale-150"></i>
                        </div>
                        <p class="font-bold text-xl">{{ auth()->user()->name }}</p>
                    </div>
                    <textarea name="description" id="description" class="w-full border-none ">{{ $post->description }}</textarea>
                    <div>
                        <input name="photo" type="file">
                    </div>
                    <button class="w-full bg-primary my-2 rounded font-bold text-white py-2">Ubah postingan</button>
                </form>
            </div>
        </div>
    </div>
  
    
    {{-- POST --}}
        <div class="bg-white rounded shadow my-4 p-4 relative ">
            <div class="dropdown">
                <i class="fa-solid fa-ellipsis absolute top-4 right-4 cursor-pointer dropdown"></i>
                <ul class="dropdown-menu hidden bg-white absolute top-7 right-7 pr-8 pl-4 py-2 text-secondary rounded-md" 
                    style="box-shadow: rgba(0, 0, 0, 0.2) 0px 12px 28px 0px, rgba(0, 0, 0, 0.1) 0px 2px 4px 0px, rgba(255, 255, 255, 0.05) 0px 0px 0px 1px inset;">
                    <li class="hover:text-black text-sm my-2"><button data-modal-target="defaultModal{{ $post->id }}" data-modal-toggle="defaultModal{{ $post->id }}" class="" type="button">Edit</button></li>
                    <li class="hover:text-black text-sm my-2 -mb-2">
                        <form action="{{ url('my-profile/posts/'.$post->id) }}" method="post">
                            @method('delete')
                            @csrf
                            <button>Hapus</button>
                        </form>
                    </li>
                </ul>
            </div>
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
                <p class="px-1 py-2">{{ $post->description }}</p>
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
        modal.classList.toggle('hidden');
    })

    const btnEdit = document.querySelectorAll('.btn-edit');
    const modalEdit = document.querySelector('#modal-edit');

    for(let i=0;i<btnEdit.length;i++){
        btnEdit[i].addEventListener('click', function(){
            modalEdit.classList.toggle('hidden');
        })
    }
</script>
</x-app-layout>