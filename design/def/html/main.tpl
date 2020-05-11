{* Главная страница *}

{get_banner var="banner" group="home"}
{if $banner->items}
    <section class="slider">
        <div class="swiper-container slideshow">
            <div class="swiper-wrapper">
                {foreach $banner->items as $bi}
                    <div class="swiper-slide slide">
                        <div class="slide-image bg{$bi@iterarion}" style="background: url('{$bi->image|resize:1920:1920:false:$config->resized_banners_images_dir}') no-repeat center {if $bi@last}bottom{else}center{/if} / cover"></div>
                        <span class="slide-title"></span>
                        <div class="slide-text">
                            <h3>{$bi->name}</h3>
                            <p>{$bi->title}</p>
                        </div>
                    </div>
                {/foreach}
            </div>
            <div class="slideshow-navigation">
                <div class="slideshow-navigation-button prev"><span class="trucks_slider_control trucks_slider_control_left trucks_slider_control_show"></span></div>
                <div class="slideshow-navigation-button next"><span class="trucks_slider_control trucks_slider_control_right trucks_slider_control_show"></span></div>
            </div>
        </div>
    </section>
{/if}
<section class="wrapper_form" id="gotoform">
    {if $message_sent}
        <!--hidden - to be shown when success-->
        <div class="formSuccssess" id="formSuccssess">
            <p> Дякуємо! </p>
            <p> Ми зателефонуемо вам найближчим часом! </p>
        </div>
    {else}
        <form method="POST" class="contact_form" id="contact_form">
            {if $error}
                <div class="message_error">
                    {if $error == 'captcha'}
                        <span data-language="form_error_captcha">{$lang->form_error_captcha}</span>
                    {elseif $error == 'empty_name'}
                        <span data-language="form_enter_name">{$lang->form_enter_name}</span>
                    {elseif $error == 'empty_email'}
                        <span data-language="form_enter_email">{$lang->form_enter_email}</span>
                    {elseif $error == 'empty_phone'}
                        <span data-language="form_enter_phone">{$lang->form_enter_phone}</span>
                    {elseif $error == 'empty_from'}
                        <span data-language="form_enter_from">{$lang->form_enter_from}</span>
                    {elseif $error == 'empty_text'}
                        <span data-language="form_enter_message">{$lang->form_enter_message}</span>
                    {elseif $error == 'empty_date'}
                        <span data-language="form_enter_date">{$lang->form_enter_date}</span>
                    {elseif $error == 'empty_passengers'}
                        <span data-language="form_enter_passengers">{$lang->form_enter_passengers}</span>
                    {/if}
                </div>
            {/if}
            <div class="inner_form" >
                <div class="contactForm_header">
                    Залиште заявку
                </div>
                <!-- name -->
                <div class="contactForm_line_element">
                    <label for="name"></label>
                    <input type="text" id="name" name="name" placeholder="Ваше ім'я *" value="{$name|escape}" /> 
                </div>
                <!-- surname -->
                <div class="contactForm_line_element">
                    <label for="surname"></label>
                    <input type="text" id="surname" name="lastname" placeholder="Ваше прізвище" value="{$lastname|escape}" /> 
                </div>
                <!--from-->
                <div class="contactForm_line_element">
                    <label for="from"></label>
                    <input type="text" id="from" name="place" placeholder="Звідки" value="{$place|escape}" />
                </div>
                <!-- to -->
                <div class="contactForm_line_element">
                    <label for="to"></label>
                    <input type="text" id="to" name="destination" placeholder="Куди" value="{$destination|escape}" />
                </div>
                <!--dates-->
                <div class="contactForm_line_element date">
                    <label for="from"></label>
                    <input type="text" id="date" name="date" placeholder="дд / мм / рррр" value="{$date|escape}" />
                </div>
                <!-- quantity of Passangares -->
                <div class="contactForm_line_element">
                    <label for="quantityPass"></label>
                    <input type="text" id="quantityPass" name="passengers" placeholder="Кількість пассажирів" value="{$passengers|escape}" />
                </div>
                    <!-- phone number -->
                <div class="contactForm_line_element"> 
                    <label for="phone"></label>
                    <div class="phone"> 
                        <span id="phoneCode"> +38 </span>  
                        <input type="text" id="phone" name="phone" placeholder="Телефон *" value="{$phone|escape}" /> 
                    </div>
                </div>
                <!-- email -->
                <div class="contactForm_line_element">
                    <label for="email"></label>
                    <input type="text" id="email" name="email" placeholder="E-mail *" value="{$email|escape}" />
                </div>
            </div>
            <div class="btn_order">
                <input type="hidden" name="feedback" value="1" />
                <input type="submit" name="feedback" class="btn_cost" id="btn_form" value="ВІДПРАВИТИ" />
            </div>
        </form>
    {/if}
</section>
{get_banner var="banner" group="benefits"}
{if $banner->items}
    <section class="benefits">
        {foreach $banner->items as $bi}
            <div class="benefit_item wow zoomIn" data-wow-offset="160">
                <img class="benefits_icons benefits_icon_{$bi@iteration}" src="{$bi->image|resize:100:100:false:$config->resized_banners_images_dir}" >
                <p>{$bi->name}</p>
            </div>
        {/foreach}
    </section>
{/if}
{get_banner var="banner" group="services"}
{if $banner->items}
    <section>
        <div class="sub_headers">
            <h2 class="services">НАШІ ПОСЛУГИ</h2>
            <div class="yellow_underline"></div>
        </div>
        <div class="galery">
            {foreach $banner->items as $bi}
                <div class="galery_item bus_{$bi@iteration} wow animated fast zoomInCustom" data-wow-offset="70" style="background-image: url('{$bi->image|resize:460:200:false:$config->resized_banners_images_dir}')">
                    <div class="text_galery">
                        <p>{$bi->name}</p> 
                    </div>
                    <div class="layer_galery"></div>
                </div>
            {/foreach}
        </div>
    </section>
{/if}
{get_banner var="banner" group="benefits_list"}
{if $banner->items}
    <section class="benefits_list">
        <div class="sub_headers">
            <h2 class="benefits_list_header">{$banner->name}</h2>
            <div class="yellow_underline"></div>
        </div>
        <div class="benefits_list_items">
            {foreach $banner->items as $bi}
                <div class="benefits_list_item wow fadeInUp" id="benefit_description_{$bi@iteration}" data-wow-offset="125">
                    <img src="{$bi->image|resize:100:100:false:$config->resized_banners_images_dir}" alt="">
                    <div>
                        <h4>{$bi->name}</h4>
                        <p>{$bi->description}</p>
                    </div>
                </div>
            {/foreach}
        </div>
    </section>
{/if}
<section class='truck_fleet'>
    <article>
        <div class="sub_headers">
            <h2>НАШ АВТОПАРК</h2>
            <div class="yellow_underline"></div>
        </div>
        <div class="truck_fleet_items">
            <div class="truck_fleet_item wow fadeInUp" data-wow-offset="190">
                <h3>MAN Lion‘s Coach, 2012</h3>
                <p> кількість місць: 56</p>
                <p> 
                    Відкидні спинки,    ТВ и видео система, клімат-контроль, туалет
                </p>
            </div>
            <div class="truck_fleet_item wow fadeInUp" data-wow-offset="190">
                <h3>Mercedes Travego SHD 15, 2013</h3>
                <p> кількість місць: 50 </p>
                <p> 
                    VIP салон, телевізор для кожного пасажира, відкидні спинки, клімат-контроль, ТВ та відео система, вбиральня, кухня
                </p>
            </div>
            <div  class="truck_fleet_item wow fadeInUp" data-wow-offset="190">
                <h3>Temsa Safari HD12, 2010</h3>
                <p> кількість місць: 50 </p>
                <p> 
                    Дуже велика відстань між рядами, спинки відкидні та розсуваються в сторону,клімат-контроль,ТВ и видео система,туалет
                </p>
            </div>
            <div class="truck_fleet_item wow fadeInUp" data-wow-offset="190">
                <h3>Ford Transit, 2016</h3>
                <p> кількість місць: 14 </p>
                <p> 
                    Відкидні спинки,ТВ и видео система, клімат-контроль
                </p>
            </div>
        </div>
    </article>
    {get_banner var="banner" group="truck_fleet_galery"}
    {if $banner->items}
    <article>
        <div class="sub_headers">
            <h2 class="services">ГАЛЕРЕЯ</h2>
            <div class="yellow_underline"></div>
        </div>
        <div class="trucks_outer_wrapper">
            <div class="trucks_slider">
                <div class="trucks_slider_wrapper">
                 {foreach $banner->items as $bi}
                    <div class="trucks_slider_item">
                        <div class="trucks_slides trucks_{$bi@iteration}" style="background: url('{$bi->image|resize:1920:1920:false:$config->resized_banners_images_dir}') no-repeat {if $bi@first}right  {else if $bi@index==2}left {else if $bi@index==6} left {else if $bi@index==8} right {else if $bi@index==9} left{else}center{/if} {if $bi@last}top{else}center{/if} / cover">
                            <div class="trucks_slides_text">
                                <p> {$bi->name}</p>
                            </div>
                        </div>
                    </div>
                {/foreach}
                </div>
                <a class="trucks_slider_control trucks_slider_control_left trucks_slider_control_show" href="#" role="button"></a>
                <a class="trucks_slider_control trucks_slider_control_right trucks_slider_control_show" href="#" role="button"></a>
            </div>
            </div>
    </article>
    {/if}
</section>
{get_new_products var='products'}
{if $products}
    <section class="tariffs">
        <div class="sub_headers">
            <h2>Наші тарифи</h2>
            <div class="yellow_underline"></div>
        </div>
        <div class="tariff_items">
            {foreach $products as $product}
                <div class="tariff_item wow fadeInUp" data-wow-offset="190">
                    <h3>{$product->name}</h3>
                    <ul class="tariff_item_list">
                        {foreach $product->variants as $variant}
                            <li>{$variant->name}: <span class="carElem">{$variant->price|convert}</span> {$currency->sign}</li>
                        {/foreach}
                    </ul>
                </div>
            {/foreach}
        </div>
    </section>
{/if}

<section class="contactUs">
    <div>
        <p>Маєте запитання? Телефонуйте!</p>
        <p>
              <a tel:"+380674064616"> Тел. +38 (067) 406-46-16 </a>
        </p>
    </div>
    <a href="#gotoform" class="btn_contactUs"> 
        <span>Залишити заявку</span>
    </a>
</section>