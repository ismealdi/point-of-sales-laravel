<li class="m-t-30">
    <a class="{{ (Request::is('admin/beranda*')) ? 'active' : ''}}" href="{{ url('admin/beranda') }}"><span class="title">Beranda</span></a> <span class=" {{ (Request::is('admin/beranda*')) ? 'bg-success' : ''}} icon-thumbnail"><i class="pg-home"></i></span>
</li>

<li>
    <a class="{{ (Request::is('admin/toko*')) ? 'active' : ''}}" href="{{ url('admin/toko') }}"><span class="title">Toko</span></a> <span class=" {{ (Request::is('admin/toko*')) ? 'bg-success' : ''}} icon-thumbnail"><i class="fa fa-map-pin"></i></span>
</li>

<li>
    <a class="{{ (Request::is('admin/pemilik*')) ? 'active' : ''}}" href="{{ url('admin/pemilik') }}"><span class="title">Pemilik</span></a> <span class=" {{ (Request::is('admin/pemilik*')) ? 'bg-success' : ''}} icon-thumbnail"><i class="fa fa-user"></i></span>
</li>


<li class="{{ (Request::is('admin/satuan*') ||
Request::is('admin/tipe-pelanggan*') ||
Request::is('admin/pelanggan*') ||
Request::is('admin/tipe-pemasok*') ||
Request::is('admin/pemasok*')) ? 'open active' : ''}}">
    <a href="javascript:;"><span class="title">Master Data</span>
        <span class="arrow {{
        (Request::is('admin/satuan*') ||
        Request::is('admin/tipe-pelanggan*') ||
        Request::is('admin/pelanggan*') ||
        Request::is('admin/tipe-pemasok*') ||
        Request::is('admin/pemasok*')) ? 'open active' : ''}}"></span>
    </a>
    <span class="{{ (Request::is('admin/satuan*') ||
    Request::is('admin/tipe-pelanggan*') ||
    Request::is('admin/pelanggan*')||
    Request::is('admin/tipe-pemasok*') ||
    Request::is('admin/pemasok*')) ? 'bg-success' : ''}} icon-thumbnail">
        <i class="fa fa-database"></i>
    </span>

    <ul class="sub-menu">
        <li class="{{ (Request::is('admin/satuan*')) ? 'active' : '' }}">
            <a href="{{url('admin/satuan')}}">Satuan</a>
            <span class="{{ (Request::is('admin/satuan*')) ? 'bg-success' : '' }} icon-thumbnail">SA</span>
        </li>
        <li class="{{ (Request::is('admin/tipe-pelanggan*')) ? 'active' : '' }}">
            <a href="{{url('admin/tipe-pelanggan')}}">Tipe Pelanggan</a>
            <span class="{{ (Request::is('admin/tipe-pelanggan*')) ? 'bg-success' : '' }} icon-thumbnail">TA</span>
        </li>
        <li class="{{ (Request::is('admin/pelanggan*')) ? 'active' : '' }}">
            <a href="{{url('admin/pelanggan')}}">Pelanggan</a>
            <span class="{{ (Request::is('admin/pelanggan*')) ? 'bg-success' : '' }} icon-thumbnail">PL</span>
        </li>
        <li class="{{ (Request::is('admin/tipe-pemasok*')) ? 'active' : '' }}">
            <a href="{{url('admin/tipe-pemasok')}}">Tipe Pemasok</a>
            <span class="{{ (Request::is('admin/tipe-pemasok*')) ? 'bg-success' : '' }} icon-thumbnail">TE</span>
        </li>
        <li class="{{ (Request::is('admin/pemasok*')) ? 'active' : '' }}">
            <a href="{{url('admin/pemasok')}}">Pemasok</a>
            <span class="{{ (Request::is('admin/pemasok*')) ? 'bg-success' : '' }} icon-thumbnail">PM</span>
        </li>
    </ul>
</li>


<li class="{{ (Request::is('admin/jenis*') ||
Request::is('admin/grup*') ||
Request::is('admin/produk*') ||
Request::is('admin/paket-produk*') ||
Request::is('admin/barcode*')) ? 'open active' : ''}}">
    <a href="javascript:;"><span class="title">Katalog Data</span>
        <span class="arrow {{
        (Request::is('admin/jenis*') ||
        Request::is('admin/grup*') ||
        Request::is('admin/produk*') ||
        Request::is('admin/paket-produk*') ||
        Request::is('admin/barcode*')) ? 'open active' : ''}}"></span>
    </a>
    <span class="{{ (Request::is('admin/jenis*') ||
    Request::is('admin/grup*') ||
    Request::is('admin/produk*') ||
    Request::is('admin/paket-produk*') ||
    Request::is('admin/barcode*')) ? 'bg-success' : ''}} icon-thumbnail">
        <i class="fa fa-tasks"></i>
    </span>

    <ul class="sub-menu">
        <li class="{{ (Request::is('admin/jenis*')) ? 'active' : '' }}">
            <a href="{{url('admin/jenis')}}">Jenis</a>
            <span class="{{ (Request::is('admin/jenis*')) ? 'bg-success' : '' }} icon-thumbnail">JE</span>
        </li>
        <li class="{{ (Request::is('admin/grup*')) ? 'active' : '' }}">
            <a href="{{url('admin/grup')}}">Grup</a>
            <span class="{{ (Request::is('admin/grup*')) ? 'bg-success' : '' }} icon-thumbnail">GR</span>
        </li>
        <li class="{{ (Request::is('admin/produk*')) ? 'active' : '' }}">
            <a href="{{url('admin/produk')}}">Produk</a>
            <span class="{{ (Request::is('admin/produk*')) ? 'bg-success' : '' }} icon-thumbnail">PR</span>
        </li>
        <li class="{{ (Request::is('admin/paket-produk*')) ? 'active' : '' }} hidden">
            <a href="{{url('admin/paket-produk')}}">Paket Produk</a>
            <span class="{{ (Request::is('admin/paket-produk*')) ? 'bg-success' : '' }} icon-thumbnail">PP</span>
        </li>
        <li class="{{ (Request::is('admin/barcode*')) ? 'active' : '' }}">
            <a href="{{url('admin/barcode')}}">Barcode</a>
            <span class="{{ (Request::is('admin/barcode*')) ? 'bg-success' : '' }} icon-thumbnail">BR</span>
        </li>
    </ul>
</li>


<li class="{{ (Request::is('admin/masuk*') ||
Request::is('admin/keluar*') ||
Request::is('admin/retur*') ||
Request::is('admin/sirkulasi*') ||
Request::is('admin/koreksi*')) ? 'open active' : ''}}">
    <a href="javascript:;"><span class="title">Inventori Data</span>
        <span class="arrow {{
        (Request::is('admin/masuk*') ||
        Request::is('admin/keluar*') ||
        Request::is('admin/retur*') ||
        Request::is('admin/sirkulasi*') ||
        Request::is('admin/koreksi*')) ? 'open active' : ''}}"></span>
    </a>
    <span class="{{ (Request::is('admin/masuk*') ||
        Request::is('admin/keluar*') ||
        Request::is('admin/retur*') ||
        Request::is('admin/sirkulasi*') ||
        Request::is('admin/koreksi*')) ? 'bg-success' : ''}} icon-thumbnail">
        <i class="fa fa-clone"></i>
    </span>

    <ul class="sub-menu">
        <li class="{{ (Request::is('admin/masuk*')) ? 'active' : '' }}">
            <a href="{{url('admin/masuk')}}">Stok Masuk</a>
            <span class="{{ (Request::is('admin/masuk*')) ? 'bg-success' : '' }} icon-thumbnail">SM</span>
        </li>
        <li class="{{ (Request::is('admin/keluar*')) ? 'active' : '' }}">
            <a href="{{url('admin/keluar')}}">Stok Keluar</a>
            <span class="{{ (Request::is('admin/keluar*')) ? 'bg-success' : '' }} icon-thumbnail">SK</span>
        </li>
        {{--<li class="{{ (Request::is('admin/sirkulasi*')) ? 'active' : '' }}">
            <a href="{{url('admin/sirkulasi')}}">Stok Sirkulasi</a>
            <span class="{{ (Request::is('admin/sirkulasi*')) ? 'bg-success' : '' }} icon-thumbnail">SS</span>
        </li>
        <li class="{{ (Request::is('admin/koreksi*')) ? 'active' : '' }}">
            <a href="{{url('admin/koreksi')}}">Stok Koreksi</a>
            <span class="{{ (Request::is('admin/koreksi*')) ? 'bg-success' : '' }} icon-thumbnail">SO</span>
        </li>--}}
        <li class="{{ (Request::is('admin/retur*')) ? 'active' : '' }}">
            <a href="{{url('admin/retur')}}">Retur Barang</a>
            <span class="{{ (Request::is('admin/retur*')) ? 'bg-success' : '' }} icon-thumbnail">RB</span>
        </li>
    </ul>
</li>