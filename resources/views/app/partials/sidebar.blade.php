<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <ul class="sidebar-nav content">
            <li class="sidebar-header">
                Menu
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{Route('dashboard')}}">
                <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="index.html">
                <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Slider</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="index.html">
                <i class="align-middle" data-feather="tv"></i> <span class="align-middle">News</span>
                </a>
            </li>

            @if (Auth::user()->role==11)
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{Route('stores')}}">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">Store</span>
                    </a>
                </li>                
            @endif

          
            @if (Auth::user()->IN_STORE())
                <li class="sidebar-item">
                    <a class="sidebar-link" href="pages-sign-in.html">
                    <i class="align-middle" data-feather="shopping-bag"></i> <span class="align-middle">Order</span>
                    </a>
                </li>
            
                <li class="sidebar-header">
                    Products
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{Route('category')}}">
                    <i class="align-middle" data-feather="box"></i> <span class="align-middle">Category</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{Route('product')}}">
                    <i class="align-middle" data-feather="coffee"></i> <span class="align-middle">Products</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="pages-sign-in.html">
                    <i class="align-middle" data-feather="percent"></i> <span class="align-middle">Promo Product</span>
                    </a>
                </li>
            @endif
       

            <li class="sidebar-header">
               Master & Sistem
            </li>

            @if (Auth::user()->role==11)
                {{-- <li class="sidebar-item" >
                    <a class="sidebar-link" href="ui-buttons.html">
                    <i class="align-middle" data-feather="map"></i> <span class="align-middle">Region</span>
                    </a>
                </li> --}}
            @endif

            @if (in_array(Auth::user()->role,[11,12]))
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{Route('user')}}">
                    <i class="align-middle" data-feather="users"></i> <span class="align-middle">User</span>
                    </a>
                </li>
            @endif

            <li class="sidebar-item">
                <a class="sidebar-link" href="ui-typography.html">
                <i class="align-middle" data-feather="align-left"></i> <span class="align-middle">Setting</span>
                </a>
            </li>

        </ul>
    </div>
</nav>