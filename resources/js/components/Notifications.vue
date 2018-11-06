<template>
	<!-- <li class="dropdown" @click="markasread"> -->
	<li class="nav-item dropdown mr-2">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <span class="glyphicon glyphicon-globe"></span> Notifications <span
                class="badge alert-danger">{{notifications.length}}</span>
        </a>
        <div class="dropdown-menu">
			<div class="dropdown-divider"></div>
  			<a class="dropdown-item" href="#">Mark all as read</a>
			<a :href="'/api/notifications/'+notification.id+'/'+notification.data.follower.username"  class="dropdown-item" v-for="notification in notifications">
				@{{notification.data.follower.username}} te ha seguido
			</a>
		</div>
    </li>
</template>

<script>
	export default {
		props: ['user'],
		data() {
			return {
				notifications: []
			}
		},
		mounted() {
			axios.get('/api/notifications')
				.then(response => {
					this.notifications = response.data;
					Echo.private(`App.User.${this.user}`)
						.notification(notification => {
							this.notifications.unshift(notification);
						});
				});
		}
	}
</script>