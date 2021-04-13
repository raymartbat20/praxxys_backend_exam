<template>
    <div>
        <navbar-header />
        <sidebar />
        <router-view></router-view>
    </div>
</template>

<script>
import Sidebar from '../Components/Layouts/Sidebar.vue';
import Header from '../Components/Layouts/Header.vue';

export default {
    name: "Dashboard",
    components: {
        sidebar: Sidebar,
        'navbar-header': Header,
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
        else{
            this.$router.push('/');
        }
    },
}
</script>