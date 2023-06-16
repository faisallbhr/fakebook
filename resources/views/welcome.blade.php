<x-guest-layout>
    <div id="defaultModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full max-h-full bg-black bg-opacity-90">
        <div class="relative w-full max-w-xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-start justify-between mx-4 py-4 border-b rounded-t">
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-900 ">
                            Sign Up
                        </h3>
                        <small>It's quick and easy.</small>
                    </div>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-hide="defaultModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="register" action="{{ route('register') }}" method="post" class="p-4 w-full" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col my-2">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="rounded ">
                        @error('name')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="flex flex-col my-2">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="rounded ">
                        @error('email')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="flex flex-col my-2">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="rounded ">
                        @error('password')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="flex flex-col my-2">
                        <label for="password_confirmation">Password confirmation</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="rounded ">
                        @error('password_confirmation')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="py-2 flex justify-center">
                        <button form="register" class="bg-green-600 rounded font-bold text-white py-2 px-10">Sign Up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-2 items-center gap-40">
        <div>
            <h1 class="text-center text-primary font-bold text-5xl -mb-4 drop-shadow-xl">FakeBook</h1>
            <img src="{{ url('assets/logo.svg') }}" alt="FakeBook" class="max-w-lg drop-shadow-2xl">
        </div>
        <div>
            <form id="login" action="{{ route('login') }}" method="POST" class="bg-white rounded-md p-4 shadow mx-auto w-96">
                @csrf
                <div class="my-4">
                    <input type="email" name="email" class="rounded-md px-4 py-2 w-full text-lg" placeholder="Email">
                    @error('email')
                        <small class="text-red-500 ml-2">{{ $message }}</small>
                    @enderror
                </div>
                <div class="my-4">
                    <input type="password" name="password" class="rounded-md px-4 py-2 w-full text-lg" placeholder="Password">
                    @error('password')
                        <small class="text-red-500 ml-2">{{ $message }}</small>
                    @enderror
                </div>
                <div class="border-b py-2 pb-4">
                    <button form="login" type="submit" class="bg-primary text-2xl text-white text-center w-full rounded-md font-semibold px-2 py-1 pb-2">Log in</button>
                </div>
                <div class="my-2 flex justify-center">
                    <p data-modal-target="defaultModal" data-modal-toggle="defaultModal" class="bg-green-600 text-2xl my-4 px-4 py-1 rounded-md font-semibold text-white cursor-pointer pb-2">Create new account</p>
                </div>
            </form>
            <div>
                <p class="my-4 text-center"><a href="#" class="font-bold">Create a Page</a> for a celebrity, brand or business.</p>
            </div>
        </div>
    </div>

    <script>
        function submitRegister(){
            document.getElementById('register').submit()
        }
    </script>
</x-guest-layout>