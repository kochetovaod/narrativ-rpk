        @props(['label', 'title', 'subtitle' => null])
        <style>
            .section-label {
                font-size: 12px;
                font-weight: 600;
                letter-spacing: 3px;
                text-transform: uppercase;
                color: var(--color-primary);
                margin-bottom: 12px;
            }

            .section-title {
                font-size: 42px;
                font-weight: 700;
                text-align: center;
                margin-bottom: 50px;
                color: var(--color-primary);
                letter-spacing: 2px;
                text-transform: uppercase;
            }

            .section-subtitle {
                font-size: 16px;
                color: var(--color-text-dim);
                max-width: 600px;
                margin: 0 auto 60px;
                text-align: center;
                line-height: 1.7;
            }

            @media (max-width: 1024px) {
                .section-title {
                    font-size: 32px;
                }
            }

            @media (max-width: 768px) {
                .section-title {
                    font-size: 32px;
                    margin-bottom: 40px;
                }
            }
        </style>
        <div class="section-label" itemprop="alternativeHeadline">{{ $label }}</div>
        <h2 class="section-title" itemprop="name headline">{{ $title }}</h2>
        @if ($subtitle !== null)
            <p class="section-subtitle" itemprop="description">{{ $subtitle }}</p>
        @endif
