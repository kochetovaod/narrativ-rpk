<section class="section section--dark" itemscope itemtype="https://schema.org/ContactPage">
    <div class="container">
        <div class="cta-block" itemscope itemtype="https://schema.org/ContactPoint">
            <meta itemprop="contactType" content="customer support">
            <meta itemprop="availableLanguage" content="Russian">

            <div class="cta-block__label" itemprop="description">Готовы к сотрудничеству</div>
            <h2 class="cta-block__title" itemprop="name">Обсудим ваш проект?</h2>
            <p class="cta-block__subtitle" itemprop="description">Расскажите нам о вашем бизнесе и задачах — мы
                предложим лучшее решение и просчитаем смету.</p>

            <div class="cta-block__btns" itemprop="potentialAction" itemscope itemtype="https://schema.org/Action">
                <meta itemprop="name" content="Заказать звонок">
                <meta itemprop="description" content="Оставить заявку на обратный звонок">
                <button class="btn btn--primary btn--large" style="width:auto;" onclick="openCallbackModal()"
                    itemprop="url" content="modal:callback">Заказать звонок</button>

                <a href="{{ route('contacts') }}" class="btn btn--outline btn--large" style="width:auto;"
                    itemprop="url">Написать нам</a>
            </div>
        </div>
    </div>
</section>
