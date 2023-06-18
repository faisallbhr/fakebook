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

        {{-- Apex Chart --}}
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

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
    <body class="antialiased text-[#050505] relative">
        <div class="min-h-screen bg-[#f0f2f5]">
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
            <div id="to-top" class="sticky bottom-4 left-[95%] bg-primary rounded-full w-10 h-10 animate-bounce flex justify-center items-center drop-shadow cursor-pointer">
                <i class="fa-solid fa-up-long flex scale-150 text-white drop-shadow"></i>
            </div>
            <footer class="text-center bg-gray-600 py-4 text-white">
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
            const btnInsight = document.querySelector('#btn-insight');
            const insight = document.querySelector('#insight');

            btnNotif.addEventListener('click', function(){
                notif.classList.toggle('hidden');
                btnNotif.classList.toggle('text-primary');
                if(! insight.classList.contains('hidden')){
                    insight.classList.toggle('hidden');
                    btnInsight.classList.toggle('text-primary');
                }
            })
            
            btnInsight.addEventListener('click', function(){
                insight.classList.toggle('hidden');
                btnInsight.classList.toggle('text-primary');
                if(! notif.classList.contains('hidden')){
                    notif.classList.toggle('hidden');
                    btnNotif.classList.toggle('text-primary');
                }
            })

            //scroll to top
            $(document).ready(function() {
                // Saat tombol scroll to top diklik
                $('#to-top').click(function() {
                    $('html, body').animate({ scrollTop: 0 }, '');
                });
            });

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

        {{-- chart --}}
        <script>
            var options = {
                series: [{
                name: 'Like',
                data: [{{ $likes1 }}, {{ $likes2 }}, {{ $likes3 }}, {{ $likes4 }}, {{ $likes5 }}, {{ $likes6 }}, {{ $likes7 }}, {{ $likes8 }}, {{ $likes9 }}, {{ $likes10 }}, {{ $likes11 }}, {{ $likes12 }}]
                }, {
                name: 'Comment',
                data: [{{ $comments1 }}, {{ $comments2 }}, {{ $comments3 }}, {{ $comments4 }}, {{ $comments5 }}, {{ $comments6 }}, {{ $comments7 }}, {{ $comments8 }}, {{ $comments9 }}, {{ $comments10 }}, {{ $comments11 }}, {{ $comments12 }}]
                }],
                chart: {
                type: 'bar',
                height: 350
                },
                plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
                },
                dataLabels: {
                enabled: false
                },
                stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
                },
                xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                },
                yaxis: {
                title: {
                    text: 'Jumlah'
                }
                },
                fill: {
                opacity: 1
                },
                tooltip: {
                y: {
                    formatter: function (val) {
                    return val 
                    }
                }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        </script>
    </body>
</html>
