<template>
  <div class="justify-center h-100 d-flex align-center justify-md-space-between">
    <!-- 👉 Footer: left content -->
    <span class="d-flex align-center">
      &copy;
      {{ new Date().getFullYear() }}
      Hecho con
      <VIcon
        icon="bx-heart"
        color="#6eb8b7"
        size="1.25rem"
        class="mx-1 !text-[#6eb8b7]"
      />
      Por <span
        class="text-[#6eb8b7] ms-1"
      >AQUANOVA</span>
    </span>
  </div>
</template>
