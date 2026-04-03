<section class="contact-form">
    <div class="container">
        <div class="contact-form__wrapper">
            <div class="contact-form__content">
                <h2 class="contact-form__title">Рассчитайте стоимость вашего проекта прямо сейчас</h2>
                <p class="contact-form__subtitle">Оставьте заявку, и наш менеджер свяжется с вами в течение 15 минут</p>
            </div>
            <form class="form" id="contactForm" onsubmit="submitForm(event)">
                <div class="form__group">
                    <input type="text" class="form__input" placeholder="Ваше имя" required>
                </div>
                <div class="form__group">
                    <input type="tel" class="form__input" placeholder="+7 (___) ___-__-__" required>
                </div>
                <div class="form__group">
                    <textarea class="form__textarea" placeholder="Комментарий (необязательно)" rows="3"></textarea>
                </div>
                <div class="form__checkbox">
                    <input type="checkbox" id="agree" required>
                    <label for="agree">Согласен на обработку персональных данных.</label>
                </div>
                <button type="submit" class="btn btn--primary btn--large">Получить расчет</button>
            </form>
        </div>
    </div>
</section>
