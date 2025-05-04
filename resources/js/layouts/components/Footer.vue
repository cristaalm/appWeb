<template>
  <div class="justify-center h-100 d-flex align-center justify-md-space-between">
    <!-- 👉 Footer: left content -->
    <span class="d-flex align-center">
      &copy;
      {{ new Date().getFullYear() }}
      Hecho con
      <VIcon
        icon="bx-heart"
        color="error"
        size="1.25rem"
        class="mx-1"
      />
      Por <a
        href="https://velor.mx"
        target="_blank"
        rel="noopener noreferrer"
        class="text-primary ms-1"
      >Velor MX</a>
    </span>
    <!-- 👉 Footer: right content -->
    <span class="d-md-flex gap-x-4 text-primary d-none">
      <a
        href="https://velor.mx/license"
        target="noopener noreferrer"
      >License</a>
      <a
        href="https://velor.mx"
        target="noopener noreferrer"
      >More Themes</a>
      <a
        href="https://velor.mx/documentation"
        target="noopener noreferrer"
      >Documentation</a>
      <a
        href="https://velor.mx/support"
        target="noopener noreferrer"
      >Support</a>
    </span>
  </div>
</template>
