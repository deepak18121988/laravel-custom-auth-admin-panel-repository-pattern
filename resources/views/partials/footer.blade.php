<footer class="bg-dark text-white mt-auto">
    <div class="container py-4">

        <div class="row">

            <!-- About -->
            <div class="col-md-6">
                <h5>{{ config('app.name', 'ClientPanel') }}</h5>
                <p class="small">
                    A Laravel-based custom authentication system with role-based access,
                    repository pattern, and AJAX CRUD operations.
                </p>
            </div>

            <!-- Links -->
            <div class="col-md-6 text-md-end">

                <h6>Connect</h6>

                <a href="https://github.com/deepak18121988"
                   target="_blank"
                   class="text-white d-block">
                    GitHub Profile
                </a>

                <a href="https://github.com/deepak18121988/laravel-custom-auth-admin-panel-repository-pattern"
                   target="_blank"
                   class="text-white d-block">
                    Project Repository
                </a>

            </div>

        </div>

        <hr>

        <div class="text-center small">
            © {{ date('Y') }} {{ config('app.name') }} |
            Developed by Deepak Lohani
        </div>

    </div>
</footer>