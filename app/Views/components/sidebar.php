<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == '') ? "" : "collapsed" ?>" href="/">
                <i class="bi bi-grid"></i>
                <span>Home</span>
            </a>
        </li>
        <!-- End Dashboard Nav -->

        <!-- Keranjang -->
        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == 'keranjang') ? "" : "collapsed" ?>" href="keranjang">
                <i class="bi bi-cart-check"></i>
                <span>Keranjang</span>
            </a>
        </li>
        <!-- End keranjang Nav -->

        <?php
        if (session()->get('role') == 'admin') {
        ?>

        <!-- Produk  -->
        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == 'produk') ? "" : "collapsed" ?>" href="produk">
                <i class="bi bi-receipt"></i>
                <span>Produk</span>
            </a>
        </li>
        <!-- End Produk -->
        <?php
        }
        ?>

        <!-- Product Category  -->
        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == 'productcategory') ? "" : "collapsed" ?>"
                href="productcategory">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Kategori Produk</span>
            </a>
        </li>
        <!-- end Product Category  -->

        <!-- Profile  -->
        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == 'profile') ? "" : "collapsed" ?>" href="profile">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li>
        <!-- End Profile Nav -->

        <!-- FAQ  -->
        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == 'faq') ? "" : "collapsed" ?>" href="faq">
                <i class="bi bi-question-circle"></i>
                <span>F.A.Q</span>
            </a>
        </li>
        <!-- end FAQ  -->

        <!-- Contact  -->
        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == 'contact') ? "" : "collapsed" ?>" href="contact">
                <i class="bi bi-telephone"></i>
                <span>Contact</span>
            </a>
        </li>
        <!-- end Contact  -->
    </ul>
</aside>
<!-- End Sidebar-->