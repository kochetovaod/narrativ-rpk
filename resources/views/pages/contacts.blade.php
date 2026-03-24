@extends('layouts.app')

@section('title', 'Контакты — Нарратив')

@section('content')
    <!-- Page Hero -->
    <x-sections.hero
        :current="$page->title"
        itemtype="ContactPage"
        :image="$page->preview->url"
        :label="setting('contacts.hero.label')"
        :title="setting('contacts.hero.title')"
        :subtitle="setting('contacts.hero.subtitle')" />

    <!-- Map + Info -->
    <!-- Map + Info -->
    <section class="section section--dark">
        <div class="container">
            <div class="contacts-layout">
                <!-- Info cards -->
                <div>
                    <div class="contacts-cards">
                        <div class="contact-info-card">
                            <div class="contact-info-card__icon">
                                <x-icon name="social_locate" width="24" height="24" />
                            </div>
                            <div>
                                <div class="contact-info-card__label">Адрес производства</div>
                                <div class="contact-info-card__value">{{ setting('contact_address') }}</div>
                                @if (setting('contact_address_note'))
                                    <div class="contact-info-card__note">{{ setting('contact_address_note') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="contact-info-card">
                            <div class="contact-info-card__icon">
                                <x-icon name="social_phone" width="24" height="24" />
                            </div>
                            <div>
                                <div class="contact-info-card__label">Телефон</div>
                                <div class="contact-info-card__value">
                                    <a href="tel:{{ preg_replace('/[^0-9]/', '', setting('contact_phone')) }}">
                                        {{ setting('contact_phone') }}
                                    </a>
                                </div>
                                @if (setting('contact_phone_2'))
                                    <div class="contact-info-card__value" style="margin-top: 4px;">
                                        <a href="tel:{{ preg_replace('/[^0-9]/', '', setting('contact_phone_2')) }}">
                                            {{ setting('contact_phone_2') }}
                                        </a>
                                    </div>
                                @endif
                                @if (setting('contact_phone_note'))
                                    <div class="contact-info-card__note">{{ setting('contact_phone_note') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="contact-info-card">
                            <div class="contact-info-card__icon">
                                <x-icon name="social_email" width="24" height="24" />
                            </div>
                            <div>
                                <div class="contact-info-card__label">E-mail</div>
                                <div class="contact-info-card__value">
                                    <a href="mailto:{{ setting('contact_email') }}">{{ setting('contact_email') }}</a>
                                </div>
                                @if (setting('contact_email_note'))
                                    <div class="contact-info-card__note">{{ setting('contact_email_note') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="work-hours" style="margin-top:24px;">
                        <h4>Часы работы</h4>
                        <div class="work-hours__row">
                            <span class="work-hours__day">Понедельник — Пятница</span>
                            <span class="work-hours__time">{{ setting('working_hours_mon_fri', '9:00 — 18:00') }}</span>
                        </div>
                        <div class="work-hours__row">
                            <span class="work-hours__day">Суббота</span>
                            <span
                                class="work-hours__time">{{ setting('working_hours_sat', '10:00 — 15:00 (по записи)') }}</span>
                        </div>
                        <div class="work-hours__row">
                            <span class="work-hours__day">Воскресенье</span>
                            <span class="work-hours__closed">{{ setting('working_hours_sun', 'Выходной') }}</span>
                        </div>
                    </div>

                    @if (setting('social_whatsapp') || setting('social_telegram'))
                        <div class="messenger-btns">
                            @if (setting('social_whatsapp'))
                                <a href="{{ setting('social_whatsapp') }}" class="messenger-btn messenger-btn--whatsapp"
                                    target="_blank" rel="noopener noreferrer">
                                    <x-icon name="social_whatsapp" width="20" height="20" />
                                    WhatsApp
                                </a>
                            @endif

                            @if (setting('social_telegram'))
                                <a href="{{ setting('social_telegram') }}" class="messenger-btn messenger-btn--telegram"
                                    target="_blank" rel="noopener noreferrer">
                                    <x-icon name="social_telegram" width="20" height="20" />
                                    Telegram
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Map -->
                <div>
                    <div class="contacts-map">
                        <x-map.iframe
                            :latitude="setting('map_latitude', 55.7558)"
                            :longitude="setting('map_longitude', 37.6176)"
                            :address="setting('contact_address')"
                            :placemark-title="setting('map_placemark_title')"
                            :zoom="setting('map_zoom', 17)"
                            height="400px" />
                    </div>

                    @if (setting('how_to_get_text'))
                        <div
                            style="margin-top:16px; padding:20px; background:rgba(255,255,255,0.02); border:1px solid rgba(184,134,11,0.15); border-radius:8px;">
                            <h4 style="font-size:14px; font-weight:600; color:#fff; margin-bottom:12px;">Как добраться</h4>
                            <p style="font-size:14px; color:var(--color-text-dim); line-height:1.7;">{!! setting('how_to_get_text') !!}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>


    <!-- Contact form -->
    <section class="section section--gray">
        <div class="section__decor section__decor--bottom-left">
            <img src="@image('decor1')"
                alt=""
                aria-hidden="true"
                loading="lazy">
        </div>

        <div class="section__decor section__decor--top-right">
            <img src="@image('decor2')"
                alt=""
                aria-hidden="true"
                loading="lazy">
        </div>
        <div class="container">
            <div class="contact-form-block">
                <h2>Написать нам</h2>
                <p>Опишите вашу задачу — мы свяжемся в течение рабочего часа и подготовим предложение.</p>
                <form class="form" onsubmit="submitContactForm(event)">
                    <div class="form__group">
                        <input type="text" class="form__input" placeholder="Ваше имя" required>
                    </div>
                    <div class="form__group">
                        <input type="tel" class="form__input" placeholder="+7 (___) ___-__-__" required>
                    </div>
                    <div class="form__group">
                        <input type="email" class="form__input" placeholder="E-mail">
                    </div>
                    <div class="form__group">
                        <textarea class="form__textarea" placeholder="Опишите вашу задачу (тип вывески, размеры, материалы, сроки)"
                            rows="4"></textarea>
                    </div>
                    <div class="form__checkbox">
                        <input type="checkbox" id="agree-contact" required>
                        <label for="agree-contact">Согласен на обработку персональных данных в соответствии с <a
                                href="{{ route('privacy') }}" style="color:var(--color-primary)">политикой
                                конфиденциальности</a></label>
                    </div>
                    <button type="submit" class="btn btn--primary btn--large">Отправить сообщение</button>
                </form>
            </div>
        </div>
    </section>
    <!-- Requisites -->
    @if (setting('company_name') || setting('company_inn') || setting('company_ogrn') || setting('company_bank_account'))
        <section class="section section--dark">
            <div class="container">
                <div class="contacts-requisites">
                    <h3>Реквизиты компании</h3>
                    <div class="requisites-grid">
                        @if (setting('company_name'))
                            <div class="requisite-item">
                                <div class="requisite-item__label">Полное наименование</div>
                                <div class="requisite-item__value">{{ setting('company_name') }}</div>
                            </div>
                        @endif

                        @if (setting('company_inn'))
                            <div class="requisite-item">
                                <div class="requisite-item__label">ИНН</div>
                                <div class="requisite-item__value">{{ setting('company_inn') }}</div>
                            </div>
                        @endif

                        @if (setting('company_kpp'))
                            <div class="requisite-item">
                                <div class="requisite-item__label">КПП</div>
                                <div class="requisite-item__value">{{ setting('company_kpp') }}</div>
                            </div>
                        @endif

                        @if (setting('company_ogrn'))
                            <div class="requisite-item">
                                <div class="requisite-item__label">ОГРН</div>
                                <div class="requisite-item__value">{{ setting('company_ogrn') }}</div>
                            </div>
                        @endif

                        @if (setting('company_bank_account'))
                            <div class="requisite-item">
                                <div class="requisite-item__label">Расчётный счёт</div>
                                <div class="requisite-item__value">{{ setting('company_bank_account') }}</div>
                            </div>
                        @endif

                        @if (setting('company_bank_name'))
                            <div class="requisite-item">
                                <div class="requisite-item__label">Банк</div>
                                <div class="requisite-item__value">{{ setting('company_bank_name') }}</div>
                            </div>
                        @endif

                        @if (setting('company_bank_bik'))
                            <div class="requisite-item">
                                <div class="requisite-item__label">БИК</div>
                                <div class="requisite-item__value">{{ setting('company_bank_bik') }}</div>
                            </div>
                        @endif

                        @if (setting('company_correspondent_account'))
                            <div class="requisite-item">
                                <div class="requisite-item__label">Корр. счёт</div>
                                <div class="requisite-item__value">{{ setting('company_correspondent_account') }}</div>
                            </div>
                        @endif
                    </div>

                    @if (setting('company_card_file') || setting('company_requisites_file'))
                        <div class="contacts-download">
                            @if (setting('company_card_file'))
                                @php
                                    $cardFile = \Orchid\Attachment\Models\Attachment::find(
                                        setting('company_card_file'),
                                    );
                                @endphp
                                @if ($cardFile)
                                    <a href="{{ $cardFile->url() }}" class="btn btn--outline btn--small" download>Скачать
                                        карточку компании (.vcf)</a>
                                @endif
                            @endif

                            @if (setting('company_requisites_file'))
                                @php
                                    $requisitesFile = \Orchid\Attachment\Models\Attachment::find(
                                        setting('company_requisites_file'),
                                    );
                                @endphp
                                @if ($requisitesFile)
                                    <a href="{{ $requisitesFile->url() }}" class="btn btn--outline btn--small"
                                        download>Скачать реквизиты (.pdf)</a>
                                @endif
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif
@endsection
