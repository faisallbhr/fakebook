<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="shortcut icon" href="{{ asset('assets/logo.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Font Awesome --}}
        <script src="https://kit.fontawesome.com/516b6a89c8.js" crossorigin="anonymous"></script>

        {{-- CSS --}}
        <style>
            body{
                font-family: 'Nunito', sans-serif;
            }
            .dropdown:hover .dropdown-menu {
                display: block;
            }
            textarea:focus {
                box-shadow: none;
            }
        </style>
    </head>
    <body class="antialiased text-[#050505]">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            <footer class="text-center bg-secondary py-4 text-white">
                <p>©Copyright <span class="text-primary font-bold">FakeBook</span> | Made With ❤️</p>
            </footer>
        </div>

        {{-- JQuery --}}
        <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

        {{-- FlowBite --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
        <script>
            const btnNotif = document.querySelector('#btn-notifications');
            const notif = document.querySelector('#notifications');

            btnNotif.addEventListener('click', function(){
                notif.classList.toggle('hidden');
            })

            function read(id){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type:"patch",
                    url: "{{ url('notifications') }}"+"/"+id,
                    data: "read_at = now()",
                    success: function(response){
                        $('#not_read').text(response.not_read)
                    },
                    error: function(xhr, status, error){
                        alert(xhr.responseText);
                    }
                })
            }

            // image preview add post
            document.getElementById('image').addEventListener('change', function(event) {
                let input = event.target;
                let reader = new FileReader();

                reader.onload = function() {
                    var imagePreview = document.getElementById('image-preview');
                    imagePreview.src = reader.result;
                };

                reader.readAsDataURL(input.files[0]);
            });
            
            // image preview edit post
            function imgEdit(id){
                let img = $('#imgEdit'+id)
                img.on('change', function(){
                    let $input = $(this);
                    let reader = new FileReader(); 
                    reader.onload = function(){
                            $("#imgPreview"+id).attr("src", reader.result);
                    } 
                    reader.readAsDataURL($input[0].files[0]);
                })
            }

            function like(id){
                // set token csrf
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
                        alert(xhr.responseText);
                    }
                })
            }
        </script>
    </body>
</html>
