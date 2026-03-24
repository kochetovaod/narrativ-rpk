<div class="modal" id="callbackModal">
    <div class="modal__overlay" onclick="closeCallbackModal()"></div>
    <div class="modal__content">
        <button class="modal__close" onclick="closeCallbackModal()">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
        </button>
        <h3 class="modal__title">Заказать звонок</h3>
        <p class="modal__subtitle">Оставьте свой номер, и мы перезвоним вам в течение 15 минут</p>
        <form class="form" onsubmit="submitCallback(event)">
            <div class="form__group">
                <input type="tel" class="form__input" placeholder="+7 (___) ___-__-__" required>
            </div>
            <div class="form__checkbox">
                <input type="checkbox" id="agree-modal" required>
                <label for="agree-modal">Согласен на обработку персональных данных</label>
            </div>
            <button type="submit" class="btn btn--primary btn--large">Заказать звонок</button>
        </form>
    </div>
</div>
