            @props(['src', 'title'])
            <div class="about-intro__image" itemprop="primaryImageOfPage" itemscope
                itemtype="https://schema.org/ImageObject">
                <img src="{{ $src }}" alt="{{ $title }}" itemprop="contentUrl"
                    onerror="this.style='background:#111;height:400px;border-radius:8px;display:block;'">
                <meta itemprop="name" content="{{ $title }}">
                <meta itemprop="description" content="Изображение компании {{ $title }}">
                <meta itemprop="representativeOfPage" content="true">
            </div>
