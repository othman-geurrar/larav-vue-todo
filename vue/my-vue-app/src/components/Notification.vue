<template>
  <div class="p-6">
    <h2 class="text-xl font-bold mb-4">Notifications</h2>
    <ul>
      <li v-for="(notif, index) in notifications" :key="index" class="mb-2 p-3 border rounded bg-gray-100">
        ✅ Nouvelle tâche créée : <strong>{{ notif.name }}</strong>
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">

</script>
  