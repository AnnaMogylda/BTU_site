<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{$settings->site_name}</title>
    <link rel="stylesheet" href="design/def/css/lato_font.css">
    <link rel="stylesheet" href="design/def/css/roboto_font.css">
    <link rel="stylesheet" href="design/def/css/normalize.min.css">
    <link rel="stylesheet" href="design/def/css/swiper.min.css">
    <link rel="stylesheet" href="design/def/css/header.css">
    <link rel="stylesheet" href="design/def/css/slider_top.css">
    <link rel="stylesheet" href="design/def/css/contact_form.css">
    <link rel="stylesheet" href="design/def/css/gallery.css">
    <link rel="stylesheet" href="design/def/css/trucks_slider.css">
    <link rel="stylesheet" href="design/def/css/footer.css">
    <link rel="stylesheet" href="design/def/css/main.css">
    <link rel="stylesheet" href="design/def/css/media.css">
    <link rel="stylesheet" href="design/def/css/animate.css"> 
    <script src="design/def/js/wow.min.js"></script>
    <script>
{literal}
       var wow = new WOW(
      {
        boxClass:     'wow',      // animated element css class (default is wow)
        animateClass: 'animated', // animation css class (default is animated)
        offset:       0,          // distance to the element when triggering the animation (default is 0)
        mobile:       true,       // trigger animations on mobile devices (default is true)
        live:         true,       // act on asynchronously loaded content (default is true)
        callback:     function(box) {
          // the callback is fired every time an animation is started
          // the argument that is passed in is the DOM node being animated
        },
        scrollContainer: null // optional scroll container selector, otherwise use window
      }
    );
    wow.init();
{/literal}
    </script>
    <script>
{literal}
!function(e){"undefined"==typeof module?this.charming=e:module.exports=e}(function(e,n){"use strict";n=n||{};var t=n.tagName||"span",o=null!=n.classPrefix?n.classPrefix:"char",r=1,a=function(e){for(var n=e.parentNode,a=e.nodeValue,c=a.length,l=-1;++l<c;){var d=document.createElement(t);o&&(d.className=o+r,r++),d.appendChild(document.createTextNode(a[l])),n.insertBefore(d,e)}n.removeChild(e)};return function c(e){for(var n=[].slice.call(e.childNodes),t=n.length,o=-1;++o<t;)c(n[o]);e.nodeType===Node.TEXT_NODE&&a(e)}(e),e});
{/literal}
</script>
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="design/def/images/logo.png" alt="BTU">
        </div>
        <div class="header_phone">
            <img src="design/def/images/icons_benefits/7_icon_benefit.png" alt="">
            <p> 
               <a href="tel:+38067406-46-16">+38 (067) 406-46-16 </a>
           </p>
        </div>
    </header>
    <main>
        {$content}       
    </main>  
    <script src="design/def/js/swiper.min.js"></script>
    <script src="design/def/js/TweenMax.min.js"></script>
    <script  src="design/def/js/slider_top.js"></script>
    <script src="design/def/js/jquery-3.4.1.min.js"></script>
    <script src="design/def/js/scroll.js"> </script>
    <script  src="design/def/js/truck_slider.js"></script>
    <script src="design/def/js/main.js"></script>  
</body>
</html>