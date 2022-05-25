<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <form action="{{ route('backend.localization') }}" method="GET" id="form-change-language">
            <div style="width: 100px">
                <select name="lang" class="form-control" onchange="this.form.submit()">
                    @foreach(config('const.lang') as $key => $lang)
                        <img src="{{ asset('image/'.$key) }}" alt="">
                        <option value="{{ $key }}" {{ (session()->get('locale') == $lang) ? 'selected' : '' }}>{{ $lang }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </ul>
</nav>
<!-- /.navbar -->
