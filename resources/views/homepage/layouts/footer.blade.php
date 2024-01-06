<footer class="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <h4 class="h6">Tentang Kami</h4>
                <p>
                    Sidocoding adalah situs web untuk belajar pemrograman lengkap
                    dari dasar untuk pemula sampai mahir
                </p>
                <hr />

            </div>
            <div class="col-lg-3">
                <h4 class="h6">Blog</h4>
                <ul class="list-unstyled footer-blog-list">
                    @php
                        $posts = \App\Models\Post::where('status', 'Publish')
                            ->orderBy('id', 'DESC')
                            ->limit(2)
                            ->get();
                    @endphp
                    @foreach ($posts as $post)
                        <li class="d-flex align-items-center">
                            <div class="text">
                                <h5 class="mb-0"><a
                                        href="{{ route('postingan.detail', ['id' => $post->id, 'slug' => $post->slug]) }}">{{ $post->title }}</a>
                                </h5>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <hr class="d-block d-lg-none" />
            </div>
            <div class="col-lg-3">
                <h4 class="h6">Contact</h4>
                <p class="text-uppercase">
                    <strong>sidocoding2022@gmail.com</strong><br />
                </p>
                <a href="https://wa.me/6285735621003" class="btn btn-success rounded">Go to
                    WhatsApp</a>
                <hr class="d-block d-lg-none" />
            </div>
            <div class="col-lg-3">
                <ul class="list-inline photo-stream">
                    <li class="list-inline-item">
                        <a href="#"><img src="{{ asset('/visitor/img/my-image/html-color.png') }}" alt="..."
                                class="img-fluid" /></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#"><img src="{{ asset('/visitor/img/my-image/css-color.png') }}" alt="..."
                                class="img-fluid" /></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#"><img src="{{ asset('/visitor/img/my-image/js-color.png') }}" alt="..."
                                class="img-fluid" /></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="copyrights">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 text-center-md">
                    <p>&copy; 2023. Sidocoding</p>
                </div>
                <div class="col-lg-8 text-right text-center-md">
                    <p>
                        Template design by
                        <a href="https://bootstrapious.com/free-templates">Bootstrapious Templates
                        </a>
                    </p>
                    <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                </div>
            </div>
        </div>
    </div>
</footer>
