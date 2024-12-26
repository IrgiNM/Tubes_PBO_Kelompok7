<x-app>
    <p class="text-[20px] font-bold">saya {{ $nama }}</p>
    <a class="text-[13px] py-2 px-[20px] rounded-[5px] bg-[#ff2b6e] m-auto mt-6 text-white" href="{{ route('logout') }}">Log Out</a>
    <div class="w-full h-auto p-[20px] flex flex-col items-center mt-5">
        <p class="text-[20px] font-bold w-full text-center">Daftar Produk</p>
        <div class="w-[700px] h-[300px] m-auto mb-7 flex flex-row overflow-x-scroll items-center">
           @isset($products)
            @foreach ($products as $pro)
            <div class="w-[150px] h-[250px] me-3 flex flex-col items-center px-3 py-2 rounded-[5px] border-[2px] border-b-[5px] border-blue-900">
                <form action="{{ route('beli') }}" method="post">
                    @csrf
                    <img src="{{ asset('storage/'.$pro->gambar_produk) }}" alt="" class="rounded-[5px] w-[130px] h-[130px] object-cover border-[2px] border-blue-900">
                    <p class="text-[13px] w-full mt-7">{{ $pro->nama_produk }}</p>
                    <p class="text-[10px] w-full font-bold">Rp.{{ $pro->harga }}</p>
                
                    <input type="text" name="id" id="id" value="{{ $pro->id }}" class="hidden">
                    <input type="number" name="jumlah" id="jumlah" value="1" class="hidden">
                    <input type="number" name="harga" id="harga" value="{{ $pro->harga }}" class="hidden">
                    <button type="submit" class="text-[13px] border-[2px] hover:border-b-[4px] border-blue-900 w-full py-1 mt-1 rounded-[5px] bg-[#2aff7c] text-blue-900 font-bold">Beli</button>
                </form>
            </div>
            @endforeach
            @endisset
        </div>

        <p class="w-full text-center text-[13px] font-bold mt-2">Table Order :</p>
        <table class="border-[2px] border-b-[5px] border-blue-900 mb-[100px] w-[800px] mt-5">
            <tr>
                <th class="py-2 bg-blue-500 text-white px-5 border-x-[2px] border-blue-900 text-[13px]">No</th>
                <th class="py-2 bg-blue-500 text-white px-5 border-x-[2px] border-blue-900 text-[13px]">Produk</th>
                <th class="py-2 bg-blue-500 text-white px-5 border-x-[2px] border-blue-900 text-[13px]">Harga</th>
                <th class="py-2 bg-blue-500 text-white px-5 border-x-[2px] border-blue-900 text-[13px]">Waktu</th>
            </tr>
            <?php $i=1; ?>
            @isset($orders)
            @foreach ($orders as $or)
            <tr>
                <td class="text-[13px] text-center border-[2px] py-3 border-blue-900">{{ $i }}</td>
                <td class="text-[13px] text-center border-[2px] py-3 border-blue-900">{{ $or->produk }}</td>
                <td class="text-[13px] text-center border-[2px] py-3 border-blue-900">{{ $or->total_harga }}</td>
                <td class="text-[13px] text-center border-[2px] py-3 border-blue-900">{{ $or->created_at }}</td>
            </tr>
            <?php $i++ ?>
            @endforeach
            @endisset
        </table>
    </div>
</x-app>