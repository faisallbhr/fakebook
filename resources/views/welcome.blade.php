<x-guest-layout>
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

                    <button class="w-full bg-primary my-2 rounded font-bold text-white py-2">Kirim</button>
                </form>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-40">
        <div>

        </div>
        <div>
            <form action="{{ route('login') }}" method="POST" class="bg-white rounded-md p-4 w-96">
                @csrf
                <div>
                    <input type="email" name="email" class="my-2 rounded-md px-4 py-2 w-full text-2xl" placeholder="Email">
                </div>
                <div>
                    <input type="password" name="password" class="my-2 rounded-md px-4 py-2 w-full text-2xl" placeholder="Password">
                </div>
                <div class="border-b ">
                    <button type="submit" class="bg-primary text-2xl text-white text-center w-full rounded-md font-semibold px-2 py-1 my-2">Login</button>
                </div>
                <div class="flex my-2">
                    <p data-modal-target="defaultModal" data-modal-toggle="defaultModal" class="bg-green-500 text-2xl w-full px-2 py-1 rounded-md font-semibold text-white text-center cursor-pointer">Buat akun baru</p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>