<template>
  <div id="your-component">
    <notification-bell
    :size="50"
    :count="2"
    :upperLimit="50"
    :counterLocation="upperRight"
    :counterStyle="round"
    
/>
  </div>
</template>
<script>
// Importing Component
import NotificationBell from 'vue-notification-bell'

export default {
  name: 'YourComponentName',
  // ...
  components: {
    NotificationBell  // Registering Component
  }
  // ...
}
</script>