<!-- 不使用。リサイズ。2025-06-16 -->
<style>
  .__kxra2__ {
    transform-origin: 0 0;
    display: inline-block;
  }
</style>
<script>
  function resizePage() {
    const baseWidth = 1920;

    const viewportWidth = window.innerWidth;
    const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
    const availableWidth = viewportWidth - scrollbarWidth -220;
    const scale = availableWidth / baseWidth;

    const wrapper = document.querySelector('.__kxra2__');
    if (wrapper) {
      wrapper.style.transform = 'scale(' + scale + ')';
      wrapper.style.width = baseWidth + 'px';
      wrapper.style.height = wrapper.scrollHeight + 'px';
    }
  }

  window.addEventListener('load', resizePage);
  window.addEventListener('resize', resizePage);
</script>
