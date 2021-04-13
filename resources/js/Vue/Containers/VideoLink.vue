<template>
  	<div class="content">
		<select v-model="src" @change="changeSrc">
			<option value="0">video 1</option>
			<option value="1">video 2</option>
			<option value="2">video 3</option>
		</select>
		<video ref="videoPlayer" class="video-js main-player">asdasd</video>
	</div>
</template>

<script>
import videojs from 'video.js'
export default {
	data() {
		return {
			videoOptions: {
				autoplay: true,
				controls: true,
				sources: [
					{
						src: "http://localhost:8000/videos/video_1.mp4",
						type: "video/mp4"
					},
					{
						src: "http://localhost:8000/videos/video_2.mp4",
						type: "video/mp4"
					},
					{
						src: "http://localhost:8000/videos/video_3.mp4",
						type: "video/mp4"
					},
					
				]
			},
			player: null,
			src: 0,
		};
	},
	methods:{
		changeSrc(){
			this.player.src(this.videoOptions.sources[this.src]);
		}
	},
	created(){
		const token = localStorage.getItem('token');
        if(token){
            axios.get('http://localhost:8000/api/check-token',{
                headers:{
                    "Authorization": `Bearer ${token}`,
                    "Accept": 'application/json',
                    "Content-type": 'application/json',
                }
            })
            .then(response => {
                if(!response.status === 200){
                    router.push('/');
                    localStorage.removeItem('token');
                }
            })
            .catch(err => {
                if(err.response.status === 401)
                {
                    this.$router.push('/')
                }
            });
        }
	},
	mounted() {
        this.player = videojs(this.$refs.videoPlayer, this.videoOptions, function onPlayerReady() {
            console.log('onPlayerReady', this);
        })

		this.player.volume(0.5);
    },
};
</script>
<style>
.main-player{
	border: 1px solid black;
	border-radius: 5px;
	width: 80vw;
}
</style>