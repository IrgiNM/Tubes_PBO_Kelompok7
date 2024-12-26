<x-app>
    <a class="text-[13px] py-2 px-[20px] rounded-[5px] bg-[#ff2b6e] m-auto mt-6 text-white" href="{{ route('logout') }}">Log Out</a>
    <p class="text-[20px] font-bold mt-5 w-full text-center">Admin Page</p>
    <div class="w-[500px] h-auto p-[20px] rounded-[10px] flex flex-col items-center border-[2px] border-b-[5px] m-auto mt-5 border-blue-900">
        <form action="{{ route('create.produk') }}" method="post" enctype="multipart/form-data">
            @csrf
            <p class="w-full text-[20px] font-bold text-blue-900 text-left">Create Produk</p>
            <label for="gambar" class="text-[13px] flex flex-row justify-center items-center w-full rounded-[5px] text-white bg-blue-500 hover:bg-blue-900 py-3 mt-5"><i class="fa-solid fa-plus text-[13px] text-white me-3"></i> gambar produk</label>
            <p id="textgambar" class="w-full text-center text-[10px] mt-2">gambar.jpg</p>
            <input type="file" name="gambar" id="gambar" class="hidden">
            <input type="text" name="nama" id="nama" placeholder="nama" class="w-full text-[13px] rounded-[5px] border-[1px] p-3 mt-2">
            <input type="number" name="harga" id="harga" placeholder="harga" class="w-full text-[13px] rounded-[5px] border-[1px] p-3 mt-2">
            <button type="submit" class="text-[15px] py-3 w-full rounded-[5px] mt-5 bg-blue-500 text-white hover:bg-blue-900">Create</button>
        </form>
    </div>

        <p class="w-full text-center text-[13px] font-bold mt-9">Daftar Produk :</p>
        <div class="w-[700px] h-[300px] m-auto mb-7 flex flex-row overflow-x-scroll items-center">
            @isset($products)
            @foreach ($products as $pro)
            <div class="w-[150px] h-auto me-3 flex flex-col items-center px-3 py-2 rounded-[5px] border-[2px] border-b-[5px] border-blue-900 bg-white">
                    <img src="{{ asset('storage/'.$pro->gambar_produk) }}" alt="" class="rounded-[5px] w-[130px] h-[130px] object-cover border-[2px] border-blue-900">
                    <p class="text-[13px] w-full mt-7">{{ $pro->nama_produk }}</p>
                    <p class="text-[10px] w-full font-bold mb-3">Rp.{{ $pro->harga }}</p>
                    
                    <form action="{{ route('delete.produk', $pro->id) }}" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-[13px] border-[2px] hover:border-b-[4px] border-blue-900 w-[130px] py-1 mt-1 rounded-[5px] bg-[#ff2a7c] text-blue-900 font-bold text-center"><i class="text-[15px] text-white fa-solid fa-trash"></i></button>
                    </form>
            </div>
            @endforeach
            @endisset
        </div>

        <p class="w-full text-center text-[13px] font-bold mt-2">Table Order :</p>
        <table class="border-[2px] border-b-[5px] border-blue-900 mb-[100px] w-[800px] mt-5">
            <tr>
                <th class="py-2 bg-blue-500 text-white px-5 border-x-[2px] border-blue-900 text-[13px]">No</th>
                <th class="py-2 bg-blue-500 text-white px-5 border-x-[2px] border-blue-900 text-[13px]">Customer</th>
                <th class="py-2 bg-blue-500 text-white px-5 border-x-[2px] border-blue-900 text-[13px]">status</th>
                <th class="py-2 bg-blue-500 text-white px-5 border-x-[2px] border-blue-900 text-[13px]">Produk</th>
                <th class="py-2 bg-blue-500 text-white px-5 border-x-[2px] border-blue-900 text-[13px]">Harga</th>
                <th class="py-2 bg-blue-500 text-white px-5 border-x-[2px] border-blue-900 text-[13px]">Waktu</th>
            </tr>
            <?php $i=1; ?>
            @isset($orders)
            @foreach ($orders as $or)
            <tr>
                <td class="text-[13px] text-center border-[2px] py-3 border-blue-900">{{ $i }}</td>
                <td class="text-[13px] text-center border-[2px] py-3 border-blue-900">{{ $or->nama }}</td>
                <td class="text-[13px] text-center border-[2px] py-3 border-blue-900">{{ $or->status }}</td>
                <td class="text-[13px] text-center border-[2px] py-3 border-blue-900">{{ $or->produk }}</td>
                <td class="text-[13px] text-center border-[2px] py-3 border-blue-900">{{ $or->total_harga }}</td>
                <td class="text-[13px] text-center border-[2px] py-3 border-blue-900">{{ $or->created_at }}</td>
            </tr>
            <?php $i++ ?>
            @endforeach
            @endisset
        </table>

        <script>
            document.getElementById('gambar').addEventListener('change', function() {
                var fileName = this.files[0] ? this.files[0].name : 'Tidak ada file yang dipilih';
                document.getElementById('textgambar').textContent = fileName;
            });
        </script>
</x-app>