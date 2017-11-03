<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>SaveGram</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.0/css/bulma.min.css">
      <link rel="stylesheet" href="/unslider/dist/css/unslider.css">
      <link rel="stylesheet" href="/unslider/dist/css/unslider-dots.css">
      <link rel="stylesheet" href="/css/main.css">
   </head>
   <body>
      <nav class="navbar" role="navigation" aria-label="main navigation">
         <div class="container">
            <div class="navbar-brand">
               <a class="navbar-item">SaveGram</a>
               <button class="button navbar-burger">
               <span></span>
               <span></span>
               <span></span>
               </button>
            </div>
         </div>
      </nav>
      <section class="section">
         @yield('main-content')
      </section>

      <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
      <script src="/unslider/dist/js/unslider-min.js"></script>
      <script src="/js/videoplayer.js"></script>
      <script>
         jQuery(document).ready(function($) {
           $('.my-slider').unslider();
         });
      </script>
   </body>
</html>