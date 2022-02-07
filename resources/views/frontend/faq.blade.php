@extends('frontend.layouts.app')

@section('content')

<section class="pt-4">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-7 col-md mx-auto">
                <ul class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item opacity-50">
                        <a class="text-reset text-breadcrumb text-secondary-color" href="{{ route('home') }}">{{ translate('Home')}}</a>
                    </li>
                    <li class="text-dark fw-600 breadcrumb-item">
                        <a class="text-reset text-breadcrumb text-secondary-color" href="{{ route('home.section.faq') }}">{{ translate('Frequently Asked Questions') }}</a>
                    </li>
                </ul>
            </div>
        </div>
            <div class="row">
                <div class="col-lg-7 col-md mx-auto text-lg-left mt-2">
                    <h1 class="h4 text-header-title text-header-blue text-left">Frequently Asked Questions</h1>
                </div>
            </div>
    </div>
</section>

<div class="position-absolute">
    <div class="img-17 d-none"></div>
    <div class="img-18 d-none"></div>
</div>

<div class="container mb-5">
    <div class="Accordions">
        <div class="Accordion_item mt-3 mb-3">
            <div class="title_tab">
                <span class="title header-subtitle">1. Where is your store located? Do you have other branches?</span>
            </div>
            <div class="inner_content">
                <p class="text-title-thin">Our headquarters is located in Calderon Building, EDSA, Quezon City. 
                    We have multiple pick-up points in Luzon. We also have an office Cebu and Davao. Being an e-commerce retail company, and having multiple physical stores, you may choose the best location where you can check availability of our products and pick-up our items. Addresses of pick-up points are indicated in the website.</p>
            </div>
        </div>
        <div class="Accordion_item mt-3 mb-3">
            <div class="title_tab">
                <span class="title header-subtitle">2. Are you open to Tie-Ups, Distributorship, Dealership and Resellers?</span>
            </div>
            <div class="inner_content">
                <p class="text-title-thin">Yes! Just send us the complete details at reseller@worldcraft.com.ph and we'll get back to you as soon as possible. You can also send messages in <a href="http://www.facebook.com/worldcraftphilippines/">http://www.facebook.com/worldcraftphilippines/</a></p>
            </div>
        </div>
        <div class="Accordion_item mt-3 mb-3">
            <div class="title_tab">
                <span class="title header-subtitle">3. What time are you open?</span>
            </div>
            <div class="inner_content">
                <p class="text-title-thin">The pick-up points are open from 8am to 5pm, everyday from Monday to Friday and 8am to 12nn on Saturdays. You can still place your orders at www.worldcraft.com.ph open 24/7. We announce our operating hours on holidays our official social networking sites like Facebook page <a href="http://www.facebook.com/worldcraftphilippines/">http://www.facebook.com/worldcraftphilippines/</a></p>
            </div>
        </div>
        <div class="Accordion_item mt-3 mb-3">
            <div class="title_tab">
                <span class="title header-subtitle">4. How do I get in touch with you?</span>
            </div>
            <div class="inner_content">
                <p class="text-title-thin">You can call/text us at 09190743727. We' can also attend your needs via our official social media channels Facebook <a href="http://www.facebook.com/worldcraftphilippines/">http://www.facebook.com/worldcraftphilippines/</a></p>
            </div>
        </div>
        <div class="Accordion_item mt-3 mb-3">
            <div class="title_tab">
                <span class="title header-subtitle">5. Are all your items brand new and original?</span>
            </div>
            <div class="inner_content">
                <p class="text-title-thin">Yes, products sold at WorldCraft are brand new, sealed and inspected, and original. We take this aspect of our business with high regards, too! We are the direct supplier and WorldCraft is our own brand.  Quality inspection prior to release of products is required.</p>
            </div>
        </div>
        <div class="Accordion_item mt-3 mb-3">
            <div class="title_tab">
                <span class="title header-subtitle">6. I found a scratch on my furniture. Can I Have It Exchanged?</span>
            </div>
            <div class="inner_content">
                <p class="text-title-thin">Yes, if it has a factory defect, we can have it replaced. You should advise us within 7 days after the purchase. Send us a photo and video of the defect, whichever best presents the defect, describe the defect so we can easily find it. 
                    <br><br>
                    Change of mind is not part of allowable replacements. Best to make up your mind before finally buying your furniture.
                    </p>
            </div>
        </div>
        <div class="Accordion_item mt-3 mb-3">
            <div class="title_tab">
                <span class="title header-subtitle">7. In what currency are your products denominated?</span>
            </div>
            <div class="inner_content">
                <p class="text-title-thin">Our products are denominated in Philippine Peso (PhP).</p>
            </div>
        </div>
        <div class="Accordion_item mt-3 mb-3">
            <div class="title_tab">
                <span class="title header-subtitle">8. Can I bargain for the prices?</span>
            </div>
            <div class="inner_content">
                <p class="text-title-thin">All prices posted on our website are final at SRP or Suggested Retail Price. However, if you are buying in bulk, you may opt to apply as a reseller, where you can get a lower price. Inquire at <a href="http://www.facebook.com/worldcraftphilippines/">http://www.facebook.com/worldcraftphilippines/</a></p>
            </div>
        </div>
        <div class="Accordion_item mt-3 mb-3">
            <div class="title_tab">
                <span class="title header-subtitle">9. How To Order?</span>
            </div>
            <div class="inner_content">
                <p class="text-title-thin">You can order at WorldCraft as easy as 1-2-3! Place your order through these methods:<br>
                    a. Walk-in our physical stores nationwide and fill-up an order form<br>
                    b. You can call/text us at 09190743727<br>
                    c. Place your order via our website www.worldcraft.com.ph<br>
                    d. We also have an e-store in Lazada as WorldCraft Ph<br>
                    e. You may also contact us and place your order through our Facebook page <a href="http://www.facebook.com/worldcraftphilippines/">http://www.facebook.com/worldcraftphilippines/</a><br>
                </p>
            </div>
        </div>
        <div class="Accordion_item mt-3 mb-3">
            <div class="title_tab">
                <span class="title header-subtitle">10. How Do I Pay?</span>
            </div>
            <div class="inner_content">
                <p class="text-title-thin">Paying for your furniture has never been this easy! At WorldCraft, we accept a host of hassle-free payment options for everyone!<br>
                    <strong>Cash for all branches</strong><br><br>
                    <strong>Bank Deposits, list of banks:</strong><br>
                        a. China Bank<br>
                        b. BPI<br>
                        c. Metrobank<br>
                        d. BDO<br><br>
                    <strong>Credit Card and Debit Card Payments</strong><br>
                    Not yet available<br><br>
                    <strong>Non-Bank Payments</strong><br>
                    For Non-bank payments options, we will accept transactions via 7eleven, Cebuana Lhuillier, GCash and the like very soon<br><br>
                    <strong>Cash-on-Delivery (COD)</strong><br>
                    Not yet available. You may talk to some resellers who may have this type of option.<br>
            </p>
            </div>
        </div>
        <div class="Accordion_item mt-3 mb-3">
            <div class="title_tab">
                <span class="title header-subtitle">11. Do you deliver or ship items? How much is the shipping fee?</span>
            </div>
            <div class="inner_content">
                <p class="text-title-thin">
                    <strong>Pick-up item options for all WorldCraft branches.</strong><br><br>
                    <strong>Shipping/ delivery is arranged through employee sellers and resellers.</strong> Rates vary from 3rd party/ external courier partners of employee sellers and resellers.<br><br>
                    <strong>The shipping fee</strong> varies depending on your location and the size of the item you bought. Upon ordering online, you will receive a confirmation email with a detailed breakdown of your orders placed on the website.<br><br>
                    Depending on the quantity or size, sellers may need to book from Grab, Lalamove, Transportify and the like. <strong>Shipping arrangements with employee resellers and resellers are shouldered by the Customer.</strong>
                </p>
            </div>
        </div>
        <div class="Accordion_item mt-3 mb-3">
            <div class="title_tab">
                <span class="title header-subtitle">12. I just paid. When will can I pick up my furniture?</span>
            </div>
            <div class="inner_content">
                <p class="text-title-thin">
                    <strong>Walk-in purchases-</strong> if the items are available in the branch you visited. You could buy the items, do quality inspection for each item and bring home the furniture right away.<br><br>
                    <strong>Online purchase-</strong> if the items are available in the pick-up point, <strong>Pay for the items. Wait for verification</strong> of payments, and <strong>wait for an email or SMS notification</strong> if your items are ready for pick up right away.<br><br>
                    The notification will indicate if your items can be released on the same day or within 1 to 2 days.<br><br>
                    <strong>Please wait for payment verification before sending your courier to pick-up your items.</strong><br><br>
                    <strong>Take note that cut-off for payment verification:</strong><br>
                    8:00 AM - 4:30 PM - Monday to Friday<br>
                    8:00-11:45 AM - Saturday<br>

                </p>
            </div>
        </div>
        <div class="Accordion_item mt-3 mb-3">
            <div class="title_tab">
                <span class="title header-subtitle">13. What Are Pick-Up Points?</span>
            </div>
            <div class="inner_content">
                <p class="text-title-thin">WorldCraft pick-up points are subsidiaries of WorldCraft or partners where you can do shop, and pick-up items you purchased. Check availability of stock/items via website before going to pick-up points.</p>
            </div>
        </div>
        <div class="Accordion_item mt-3 mb-3">
            <div class="title_tab">
                <span class="title header-subtitle">14. Do you have meet-up points in provinces?</span>
            </div>
            <div class="inner_content">
                <p class="text-title-thin">We don't, but sellers can ship the furniture to you instead. We can ship nationwide! Tell us where you are and inquire at <a href="http://www.facebook.com/worldcraftphilippines/">http://www.facebook.com/worldcraftphilippines/</a></p>
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('script')
<script>
    var $titleTab = $('.title_tab');
    var i;
	$('.Accordion_item:eq(0)').find('.title_tab').addClass('active').next().stop().slideDown(300);
	$('.Accordion_item:eq(0)').find('.inner_content').find('p').addClass('show');
	$titleTab.on('click', function(e) {
    $('title').toggleClass('active');
	e.preventDefault();
		if ( $(this).hasClass('active') ) {
            $('title').removeClass('active');
			$(this).removeClass('active');
			$(this).next().stop().slideUp(300);
			$(this).next().find('p').removeClass('show');
    
		} else {
			$(this).addClass('active');
			$(this).next().stop().slideDown(300);
			$(this).parent().siblings().children('.title_tab').removeClass('active');
            $(this).next().find('h3').addClass('active');
			$(this).parent().siblings().children('.inner_content').slideUp(500);
			$(this).parent().siblings().children('.inner_content').find('p').removeClass('show');
			$(this).next().find('p').addClass('show');
		}
	});
</script>
@endsection