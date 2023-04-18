@if (app()->environment() === 'production')

    <!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-PF1V9HLYEB"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-PF1V9HLYEB');
</script>

@endif