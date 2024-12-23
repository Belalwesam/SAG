<footer class="content-footer footer bg-footer-theme">
    <div class="container-fluid d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
        <div class="mb-2 mb-md-0">
            @if (app()->getLocale() == 'ar')
                جميع الحقوق محفوظة شركة ساج التقنية
                @else
                All rights reserved SAG Tech
            @endif
            @
            <script>
                document.write(new Date().getFullYear());
            </script>

        </div>
    </div>
</footer>
