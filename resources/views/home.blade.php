<x-app-layout>
    {{-- Modal --}}
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
                    @csrf
                    <div class="flex items-center gap-2">
                        <div class="flex items-center justify-center w-12 h-12">
                            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&rounded=true&color=1b74e4" alt="Profile image" class="border-2 border-primary rounded-full">
                        </div>
                        <p class="font-bold text-xl">{{ auth()->user()->name }}</p>
                    </div>
                    <textarea name="description" id="description" class="w-full border-none" placeholder="Apa yang sedang kamu pikirkan, {{ auth()->user()->name }}"></textarea>
                    <div>
                        <img id="image-preview" class="max-w-[200px] my-2">
                        <input name="photo" type="file" id="image">
                    </div>
                    <button class="w-full bg-primary my-2 rounded font-bold text-white py-2">Kirim</button>
                </form>
            </div>
        </div>
    </div>
    <div class="flex min-h-screen">
        <div class="w-1/4 my-4 px-20">
            <div class="flex gap-2 items-center border-b">
                <div class="border-2  border-primary rounded-full w-8 h-8 flex justify-center items-center -ml-10">
                    <i class="fa-solid fa-person-circle-plus text-primary"></i>
                </div>
                <p class="font-semibold">Saran ikuti:</p>
            </div>
            <div class="my-2">
                @foreach ($users as $user)
                <div class="grid grid-cols-2">
                    <p class=" my-2">{{ $user->name }}</p>
                    <form action="{{ url('follow/'.$user->id) }}" method="post" class="flex justify-center my-auto ">
                        @csrf
                        @if (in_array(auth()->user()->id,$user->followings->pluck('id')->toArray()))
                            <button class="bg-primary text-white px-2 py-1 rounded font-medium">Ikuti balik</button>
                        @else
                            <button class="bg-primary text-white px-2 py-1 rounded font-medium">Ikuti</button>
                        @endif
                    </form>
                </div>
                @endforeach
            </div>
        </div>
        <div class="max-w-5xl w-full mx-auto">
            {{-- BUAT POST --}}
            <div class="bg-white rounded shadow my-4">
                <div class="flex w-full p-4 gap-2 items-center">
                    <div class="flex items-center justify-center w-16 h-16">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&rounded=true&color=1b74e4" alt="Profile image" class="border-2 border-primary rounded-full">
                    </div>
                    <div class="w-full">
                        <button data-modal-target="defaultModal" data-modal-toggle="defaultModal" class="w-full text-left bg-gray-100 hover:bg-gray-200 px-4 py-4 rounded-full">Apa yang sedang kamu pikirkan, {{ auth()->user()->name }}?</button>
                    </div>
                </div>
            </div>
    
            {{-- MY POST --}}
            @foreach ($posts as $post)
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
                <div class="flex gap-2">
                    <div class="flex items-center justify-center w-12 h-12">
                        <img src="https://ui-avatars.com/api/?name={{ $post->user->name }}&rounded=true&color=1b74e4" alt="Profile image" class="border-2 border-primary rounded-full">
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
                    <div class="flex justify-center items-center gap-1 border-b">
                        <p id="like{{ $post->id }}">{{ $post->likers->count() }}</p>
                        <input id="post-id" type="text" value="{{ $post->id  }}" class="hidden">
                        <button id="btnLike{{ $post->id }}" onclick="like({{ $post->id }})" class="py-2 hover:text-primary @if(in_array(auth()->user()->id, $post->likers->pluck('id')->toArray())) text-primary @endif">
                            <i class="fa-regular fa-thumbs-up mx-1"></i>Suka
                        </button>
                    </div>
                    <div class="flex items-center gap-2 mt-2 mb-4">
                        <div class="flex items-center justify-center w-10 h-10">
                            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&rounded=true&color=1b74e4" alt="Profile image" class="border-2 border-primary rounded-full">
                        </div>
                        <form action="{{ url('comment/'.$post->id) }}" method="POST" class="flex items-center gap-2 w-full">
                        @csrf
                            <input type="text" name="comment" class="w-full rounded-full bg-gray-100 border-none" style="text-decoration: none; box-shadow: none" placeholder="Tulis komentar...">
                            <button class="rounded-full bg-primary text-white px-2 py-1 shadow"><i class="fa-solid fa-arrow-right"></i></button>
                        </form>
                    </div>
                    <div class=" my-2">
                        @if (in_array($post->id, $post->comment->pluck('post_id')->toArray()))
                        @foreach ($post->comment as $comment)
                        <div class="flex items-center gap-2 py-2 border-b ">
                            <div class="flex items-center justify-center w-10 h-10">
                                <img src="https://ui-avatars.com/api/?name={{ $comment->user->name }}&rounded=true&color=1b74e4" alt="Profile image" class="border-2 border-primary rounded-full">
                            </div>
                            <div class="flex gap-2 items-center justify-between w-full">
                                <div>
                                    <p class="font-semibold">{{ $comment->user->name }}</p>
                                    <p class="w-full rounded-full bg-gray-100 px-3 py-2">{{ $comment->comment }}</p>
                                </div>
                                <div>
                                    @if ($comment->user_id==auth()->user()->id)
                                    <form action="{{ url('comment/'.$comment->id) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <input type="text" class="hidden" name="post_id" value="{{ $post->id }}">
                                        <button onclick="return confirm('Apakah anda yakin akan menghapus komentar?')"><i class="fa-regular fa-trash-can hover:text-primary"></i></button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="w-1/4 my-4 px-20">
            <div class="flex gap-2 items-center border-b">
                <div class="border-2 border-primary rounded-full w-8 h-8 flex justify-center items-center -ml-10">
                    <i class="fa-solid fa-users-line text-primary"></i>
                </div>
                <h4 class="font-semibold">Following <span class="font-normal">({{ $followings->count() }})</span></h4>
            </div>
            <div class="my-2">
                @foreach ($followings as $user)
                        <p>{{ $user->name }}</p>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        // image preview
        document.getElementById('image').addEventListener('change', function(event) {
            var input = event.target;
            var reader = new FileReader();

            reader.onload = function() {
                var imagePreview = document.getElementById('image-preview');
                imagePreview.src = reader.result;
            };

            reader.readAsDataURL(input.files[0]);
        });
        
        // like post
        function like(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let postid = $('#post-id').val();
            $.ajax({
                type:"post",
                url: "{{ url('like') }}"+"/"+id,
                data: "id="+postid,
                success: function(response){
                    $('#like'+id).text(response.likes)
                    if($('#btnLike'+id).hasClass('text-primary')){
                        $('#btnLike'+id).removeClass('text-primary')
                    }else{
                        $('#btnLike'+id).addClass('text-primary')
                    }
                },
                error: function(xhr, status, error){
                    console.log(xhr.responseText);
                }
            })
        }
    </script>
</x-app-layout>
