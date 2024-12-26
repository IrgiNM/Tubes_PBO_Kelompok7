<x-app>
    <div class="w-[500px] h-auto p-[20px] rounded-[10px] flex flex-col items-center border-[2px] border-b-[5px] m-auto mt-[100px] border-blue-900">
    <form action="{{ route('login.user') }}" method="post">
        @csrf
        <p class="w-full text-[20px] font-bold text-blue-900 text-left">Log In</p>
        <input type="text" name="username" id="username" placeholder="Username" class="w-full text-[13px] rounded-[5px] border-[1px] p-3 mt-3">
        <input type="password" name="password" id="password" placeholder="Password" class="w-full text-[13px] rounded-[5px] border-[1px] p-3 mt-2">
        <button type="submit" class="text-[15px] py-3 w-full rounded-[5px] mt-5 bg-blue-500 text-white hover:bg-blue-900">Daftar</button>
    </form>
    </div>
    <div class="flex flex-row gap-2 w-full justify-center mt-3">
        <a class="text-[10px] text-[#ff2b6e]" href="{{ route('signup') }}">Register </a>
        <p class="text-[10px]">jika belum punya akun</p>
    </div>
</x-app>